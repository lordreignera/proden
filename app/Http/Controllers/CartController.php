<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getSessionId()
    {
        return session('cart_session_id') ?? session()->getId();
    }

    public function index()
    {
        $sessionId = $this->getSessionId();
        $cartItems = Cart::where('session_id', $sessionId)->with('product')->get();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        
        return view('shop.cart', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $sessionId = $this->getSessionId();
        $quantity = $request->input('quantity', 1);

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
        $sessionId = $this->getSessionId();
        Cart::where('session_id', $sessionId)->delete();
        
        return redirect()->back()->with('success', 'Cart cleared!');
    }
}
