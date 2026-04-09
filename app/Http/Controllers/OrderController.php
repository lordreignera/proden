<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;

class OrderController extends Controller
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

    public function checkout()
    {
        $sessionId = $this->getSessionId();

        $pendingOrderId = session('pending_order_id');
        if ($pendingOrderId) {
            $pendingOrder = Order::where('id', $pendingOrderId)
                ->where('payment_status', 'pending')
                ->whereIn('order_status', ['pending', 'processing'])
                ->first();

            if ($pendingOrder) {
                return redirect()->route('order.success', ['orderId' => $pendingOrder->id, 'resume' => 1]);
            }

            session()->forget('pending_order_id');
        }

        $cartItems = Cart::where('session_id', $sessionId)->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        
        return view('shop.checkout', compact('cartItems', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'payment_method' => 'required|in:mobile_money',
            'payment_network' => 'required|in:mtn,airtel',
        ]);

        $sessionId = $this->getSessionId();
        session(['last_customer_phone' => $validated['customer_phone']]);

        $sessionPendingOrderId = session('pending_order_id');
        if ($sessionPendingOrderId) {
            $sessionPendingOrder = Order::where('id', $sessionPendingOrderId)
                ->where('payment_status', 'pending')
                ->whereIn('order_status', ['pending', 'processing'])
                ->first();

            if ($sessionPendingOrder) {
                return redirect()->route('order.success', ['orderId' => $sessionPendingOrder->id, 'resume' => 1]);
            }

            session()->forget('pending_order_id');
        }

        $existingPendingOrder = $this->findPendingOrderByPhone($validated['customer_phone']);

        if ($existingPendingOrder) {
            session(['last_customer_phone' => $validated['customer_phone']]);
            session(['pending_order_id' => $existingPendingOrder->id]);
            return redirect()->route('order.success', ['orderId' => $existingPendingOrder->id, 'resume' => 1]);
        }

        $cartItems = Cart::where('session_id', $sessionId)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // Create Order
        $order = Order::create([
            'order_number' => 'ORD-' . date('y') . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT),
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_address' => $validated['customer_address'],
            'total_amount' => $total,
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'notes' => $request->input('notes'),
        ]);

        // Create Order Items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->product->price,
                'total_price' => $item->product->price * $item->quantity,
            ]);
        }

        // TODO: Integrate Swap payment gateway here
        // For now, redirect to payment pending page

        session(['pending_order_id' => $order->id]);
        
        Cart::where('session_id', $sessionId)->delete();

        return redirect()->route('order.success', $order->id)->with('success', 'Order created! Proceed to payment.');
    }

    public function success(Request $request, $orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);

        if ($order->payment_status !== 'pending' || $order->order_status === 'cancelled') {
            if ((int) session('pending_order_id') === (int) $order->id) {
                session()->forget('pending_order_id');
            }
        }

        $isResumed = $request->boolean('resume');
        return view('shop.order-success', compact('order', 'isResumed'));
    }

    public function receipt($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);
        return view('shop.receipt', compact('order'));
    }
}
