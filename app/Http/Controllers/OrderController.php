<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private function getSessionId()
    {
        return session('cart_session_id') ?? session()->getId();
    }

    public function checkout()
    {
        $sessionId = $this->getSessionId();
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
        $cartItems = Cart::where('session_id', $sessionId)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // Create Order
        $order = Order::create([
            'order_number' => 'ORD-' . date('YmdHis') . rand(1000, 9999),
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
        
        Cart::where('session_id', $sessionId)->delete();

        return redirect()->route('order.success', $order->id)->with('success', 'Order created! Proceed to payment.');
    }

    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('shop.order-success', compact('order'));
    }

    public function receipt($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);
        return view('shop.receipt', compact('order'));
    }
}
