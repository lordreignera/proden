@extends('layouts.app')

@section('title', 'Shopping Cart - Pruden')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="fas fa-shopping-cart"></i> Shopping Cart
            </h1>
        </div>
    </div>

    @if($cartItems->isNotEmpty())
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                    <tr>
                                        <td>
                                            <a href="{{ route('product.show', $item->product->slug) }}" class="text-decoration-none">
                                                <strong>{{ $item->product->name }}</strong>
                                            </a>
                                            <br>
                                            <small class="text-muted">{{ ucfirst(str_replace('_', ' ', $item->product->unit)) }}</small>
                                        </td>
                                        <td>UGX {{ number_format($item->product->price, 0) }}</td>
                                        <td>
                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="d-inline-flex cart-qty-form" style="gap: 5px;">
                                                @csrf
                                                @method('PUT')
                                                      <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                                          class="form-control form-control-sm cart-qty-input" 
                                                       min="1" onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td>
                                            <strong>UGX {{ number_format($item->product->price * $item->quantity, 0) }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('cart.remove', $item) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Remove from cart">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-3 d-flex flex-column flex-sm-row gap-2 cart-actions">
                    <a href="{{ route('shop.products') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Clear entire cart?')">
                            <i class="fas fa-trash"></i> Clear Cart
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="checkout-summary">
                    <h5 class="mb-4">Order Summary</h5>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <strong>UGX {{ number_format($total, 0) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <strong class="text-success">Free</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total:</strong>
                            <h5 class="text-primary mb-0">UGX {{ number_format($total, 0) }}</h5>
                        </div>
                    </div>

                    <a href="{{ route('checkout') }}" class="btn btn-primary w-100 btn-lg mb-3">
                        <i class="fas fa-credit-card"></i> Proceed to Checkout
                    </a>

                    <div class="alert alert-info alert-sm" style="font-size: 0.9rem;">
                        <i class="fas fa-lock"></i> Your payment is secure and encrypted.
                    </div>

                    <div class="card border-light">
                        <div class="card-body">
                            <h6 class="card-title mb-3">Payment Methods</h6>
                            <p class="mb-2">
                                <i class="fas fa-mobile-alt text-primary"></i> 
                                <strong>Mobile Money:</strong> MTN & Airtel
                            </p>
                            <p class="mb-0 text-muted small">
                                Pay securely using your mobile money account.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-shopping-cart" style="font-size: 3rem; opacity: 0.5;"></i>
                    <h4 class="mt-3">Your cart is empty</h4>
                    <p class="text-muted mb-3">Start shopping to add items to your cart</p>
                    <a href="{{ route('shop.products') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-bags"></i> Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.alert-sm {
    padding: 0.5rem 1rem;
    margin-bottom: 0;
}

.cart-qty-input {
    width: 80px;
    margin: 0;
}

@media (max-width: 767.98px) {
    .cart-actions .btn,
    .cart-actions form,
    .cart-actions form .btn {
        width: 100%;
    }

    .cart-qty-form {
        width: 100%;
    }

    .cart-qty-input {
        width: 100%;
        min-width: 72px;
    }
}
</style>
@endsection
