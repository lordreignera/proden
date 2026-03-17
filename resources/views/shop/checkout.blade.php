@extends('layouts.app')

@section('title', 'Checkout - Pruden')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">
        <i class="fas fa-clipboard-list"></i> Checkout
    </h1>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('order.process') }}" method="POST">
                @csrf

                <!-- Delivery Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-map-marker-alt"></i> Delivery Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" class="form-label">Full Name *</label>
                                <input type="text" id="customer_name" name="customer_name" class="form-control form-control-lg @error('customer_name') is-invalid @enderror" 
                                       value="{{ old('customer_name') }}" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="customer_phone" class="form-label">Phone Number *</label>
                                <input type="tel" id="customer_phone" name="customer_phone" class="form-control form-control-lg @error('customer_phone') is-invalid @enderror" 
                                       value="{{ old('customer_phone') }}" placeholder="+234..." required>
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="customer_address" class="form-label">Delivery Address *</label>
                            <textarea id="customer_address" name="customer_address" class="form-control form-control-lg @error('customer_address') is-invalid @enderror" 
                                      rows="3" placeholder="Enter your full delivery address" required>{{ old('customer_address') }}</textarea>
                            @error('customer_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-credit-card"></i> Payment Method
                        </h5>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="payment_method" value="mobile_money">
                        
                        <div class="mb-4">
                            <h6 class="mb-3">Select Mobile Money Network:</h6>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_network" id="mtn" value="mtn" required>
                                <label class="form-check-label" for="mtn">
                                    <strong>MTN Mobile Money</strong>
                                    <br>
                                    <small class="text-muted">Pay using your MTN account</small>
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_network" id="airtel" value="airtel" required>
                                <label class="form-check-label" for="airtel">
                                    <strong>Airtel Money</strong>
                                    <br>
                                    <small class="text-muted">Pay using your Airtel account</small>
                                </label>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Payment Flow:</strong> After clicking Complete Order, you'll be redirected to your chosen mobile money provider to complete the payment.
                        </div>
                    </div>
                </div>

                <!-- Order Notes (Optional) -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-sticky-note"></i> Additional Notes (Optional)
                        </h5>
                    </div>
                    <div class="card-body">
                        <textarea name="notes" class="form-control" rows="3" placeholder="Special delivery instructions or notes..."></textarea>
                    </div>
                </div>

                <div class="d-flex gap-2 checkout-actions">
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-arrow-left"></i> Back to Cart
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                        <i class="fas fa-check-circle"></i> Complete Order
                    </button>
                </div>
            </form>
        </div>

        <!-- Order Summary Sidebar -->
        <div class="col-lg-4">
            <div class="checkout-summary sticky-top checkout-summary-sticky" style="top: 80px;">
                <h5 class="mb-4">
                    <i class="fas fa-receipt"></i> Order Summary
                </h5>

                <div class="card border-light mb-3">
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($cartItems as $item)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $item->product->name }}</h6>
                                        <small class="text-muted">{{ $item->quantity }}x @ UGX {{ number_format($item->product->price, 0) }}</small>
                                    </div>
                                    <strong>UGX {{ number_format($item->product->price * $item->quantity, 0) }}</strong>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <strong>UGX {{ number_format($total, 0) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping:</span>
                        <strong class="text-success">Free</strong>
                    </div>
                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between mb-0">
                            <h6 class="mb-0">Total:</h6>
                            <h5 class="text-primary mb-0">UGX {{ number_format($total, 0) }}</h5>
                        </div>
                    </div>
                </div>

                <div class="alert alert-success alert-sm">
                    <i class="fas fa-check-circle"></i> 
                    <small>Free delivery on all orders!</small>
                </div>

                <div class="card border-light">
                    <div class="card-body">
                        <h6 class="card-title mb-2">
                            <i class="fas fa-lock"></i> Secure Checkout
                        </h6>
                        <small class="text-muted">
                            Your payment information is processed securely by {{ config('app.name') }}.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.alert-sm {
    padding: 0.5rem 1rem;
    margin-bottom: 0;
    font-size: 0.9rem;
}

@media (max-width: 991.98px) {
    .checkout-summary-sticky {
        position: static !important;
        top: auto !important;
    }
}

@media (max-width: 767.98px) {
    .checkout-actions {
        flex-direction: column;
    }

    .checkout-actions .btn {
        width: 100%;
    }
}
</style>
@endsection
