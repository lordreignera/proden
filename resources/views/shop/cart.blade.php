@extends('layouts.app')

@section('title', 'Shopping Cart - Pruden')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="fas fa-shopping-cart"></i> Shopping Cart
            </h1>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="mb-3"><i class="fas fa-phone me-2"></i>Continue with your phone number</h5>
                    <form method="GET" action="{{ route('cart.index') }}" class="row g-2 align-items-end">
                        <div class="col-md-8">
                            <label for="lookup_phone" class="form-label">Enter your phone number</label>
                            <input type="text" id="lookup_phone" name="lookup_phone" value="{{ $lookupPhone ?? '' }}" class="form-control" placeholder="e.g. +256 772 494618">
                        </div>
                        <div class="col-md-4 d-grid">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-search me-1"></i> Find My Orders
                            </button>
                        </div>
                    </form>

                    @if(!empty($lookupPhone))
                        <hr>
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <h6 class="mb-2">Pending Orders</h6>
                                @forelse($pendingLookupOrders as $order)
                                    <div class="border rounded p-2 mb-2">
                                        <div class="d-flex justify-content-between flex-wrap gap-2">
                                            <strong>{{ $order->order_number }}</strong>
                                            <span class="badge bg-warning text-dark">Pending Payment</span>
                                        </div>
                                        <small class="text-muted d-block mb-2">{{ $order->created_at->format('d M Y, H:i') }}</small>
                                        <a href="{{ route('order.success', ['orderId' => $order->id, 'resume' => 1]) }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-mobile-alt me-1"></i> Continue Payment
                                        </a>
                                    </div>
                                @empty
                                    <div class="text-muted small">No pending orders found for this number.</div>
                                @endforelse
                            </div>
                            <div class="col-lg-6">
                                <h6 class="mb-2">Delivered / Completed Orders</h6>
                                @forelse($deliveredLookupOrders as $order)
                                    <div class="border rounded p-2 mb-2">
                                        <div class="d-flex justify-content-between flex-wrap gap-2">
                                            <strong>{{ $order->order_number }}</strong>
                                            <span class="badge bg-success">Delivered</span>
                                        </div>
                                        <small class="text-muted d-block mb-2">{{ $order->created_at->format('d M Y, H:i') }}</small>
                                        <a href="{{ route('order.receipt', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-receipt me-1"></i> View Receipt
                                        </a>
                                    </div>
                                @empty
                                    <div class="text-muted small">No delivered orders found for this number.</div>
                                @endforelse
                            </div>
                        </div>
                    @endif
                </div>
            </div>
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
                        @if(!empty($activePendingOrder))
                            <button type="button" class="btn btn-outline-secondary" disabled title="Complete payment and delivery confirmation first">
                                <i class="fas fa-lock"></i> Clear Cart Locked
                            </button>
                        @else
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Clear entire cart?')">
                                <i class="fas fa-trash"></i> Clear Cart
                            </button>
                        @endif
                    </form>
                </div>

                @if(!empty($activePendingOrder))
                    <div class="alert alert-warning mt-3 mb-0">
                        <i class="fas fa-info-circle"></i>
                        You have an unpaid order ({{ $activePendingOrder->order_number }}). Cart clearing is disabled until payment is completed and delivery is confirmed.
                    </div>
                @endif
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
