<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function normalizePhone(?string $phone): string
    {
        return preg_replace('/\D+/', '', (string) $phone) ?? '';
    }

    private function phoneMatches(string $storedPhone, string $inputPhone): bool
    {
        if ($storedPhone === '' || $inputPhone === '') {
            return false;
        }

        if ($storedPhone === $inputPhone) {
            return true;
        }

        return strlen($storedPhone) >= 9 && strlen($inputPhone) >= 9
            && substr($storedPhone, -9) === substr($inputPhone, -9);
    }

    private function findOrdersByPhone(string $phone)
    {
        $normalized = $this->normalizePhone($phone);
        if ($normalized === '') {
            return collect();
        }

        $needle = substr($normalized, -9);

        return Order::with('items.product')
            ->where('customer_phone', 'like', '%' . $needle . '%')
            ->latest()
            ->limit(50)
            ->get()
            ->filter(function ($order) use ($normalized) {
                return $this->phoneMatches($this->normalizePhone($order->customer_phone), $normalized);
            })
            ->values();
    }

    private function findPendingOrderByPhone(string $phone): ?Order
    {
        $normalized = $this->normalizePhone($phone);
        if ($normalized === '') {
            return null;
        }

        $needle = substr($normalized, -9);

        $candidates = Order::where('payment_status', 'pending')
            ->whereIn('order_status', ['pending', 'processing'])
            ->where('customer_phone', 'like', '%' . $needle . '%')
            ->latest('id')
            ->limit(30)
            ->get();

        foreach ($candidates as $candidate) {
            if ($this->phoneMatches($this->normalizePhone($candidate->customer_phone), $normalized)) {
                return $candidate;
            }
        }

        return null;
    }

    private function getSessionId()
    {
        $sessionId = session('cart_session_id');

        if (!$sessionId) {
            $sessionId = session()->getId();
            session(['cart_session_id' => $sessionId]);
        }

        return $sessionId;
    }

    public function index(Request $request)
    {
        $sessionId = $this->getSessionId();
        $cartItems = Cart::where('session_id', $sessionId)->with('product')->get();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        $lookupPhone = trim((string) $request->query('lookup_phone', ''));
        $lookupOrders = collect();
        $pendingLookupOrders = collect();
        $deliveredLookupOrders = collect();

        if ($lookupPhone !== '') {
            $lookupOrders = $this->findOrdersByPhone($lookupPhone);

            $pendingLookupOrders = $lookupOrders->filter(function ($order) {
                return $order->payment_status === 'pending' && in_array($order->order_status, ['pending', 'processing'], true);
            });

            $deliveredLookupOrders = $lookupOrders->filter(function ($order) {
                return $order->order_status === 'completed';
            });
        }

        $lastCustomerPhone = session('last_customer_phone');
        $activePendingOrder = null;
        if (!empty($lastCustomerPhone)) {
            $activePendingOrder = $this->findPendingOrderByPhone($lastCustomerPhone);
        }

        return view('shop.cart', compact(
            'cartItems',
            'total',
            'lookupPhone',
            'lookupOrders',
            'pendingLookupOrders',
            'deliveredLookupOrders',
            'activePendingOrder'
        ));
    }

    public function add(Request $request, Product $product)
    {
        $sessionId = $this->getSessionId();
        $quantity = max(1, (int) $request->input('quantity', 1));

        $cartItem = Cart::where('session_id', $sessionId)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            Cart::create([
                'session_id' => $sessionId,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        $cartCount = Cart::where('session_id', $sessionId)->sum('quantity');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Product added to cart!',
                'cartCount' => $cartCount,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, Cart $cart)
    {
        $quantity = $request->input('quantity', 1);
        
        if ($quantity <= 0) {
            $cart->delete();
        } else {
            $cart->update(['quantity' => $quantity]);
        }

        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function remove(Cart $cart)
    {
        $cart->delete();
        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    public function clear()
    {
        $lastCustomerPhone = session('last_customer_phone');
        if (!empty($lastCustomerPhone)) {
            $pendingOrder = $this->findPendingOrderByPhone($lastCustomerPhone);

            if ($pendingOrder) {
                return redirect()->back()->with('error', 'You have an unpaid order. Complete payment and delivery confirmation before clearing cart.');
            }
        }

        $sessionId = $this->getSessionId();
        Cart::where('session_id', $sessionId)->delete();
        
        return redirect()->back()->with('success', 'Cart cleared!');
    }
}
