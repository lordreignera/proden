@extends('layouts.app')

@section('title', 'Order Confirmation - Pruden')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle" style="font-size: 5rem; color: #27ae60;"></i>
                    </div>

                    @if(!empty($isResumed) && $isResumed)
                        <div class="alert alert-warning text-start">
                            <i class="fas fa-clock me-1"></i>
                            You already have an unpaid order in progress. Please continue payment for this order instead of creating a new one.
                        </div>
                    @endif
                    
                    <h1 class="mb-2">Order Confirmed!</h1>
                    <p class="lead text-muted mb-4">Thank you for your order. We're processing it now.</p>

                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Order Number</h6>
                            <h4 class="mb-0" style="font-family: monospace;">{{ $order->order_number }}</h4>
                        </div>
                    </div>

                    <div class="row text-center mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="card border-light">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Order Total</h6>
                                    <h5 class="text-primary mb-0">UGX {{ number_format($order->total_amount, 0) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-light">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Payment Status</h6>
                                    <span class="badge bg-warning text-dark">{{ ucfirst($order->payment_status) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-credit-card"></i>
                        <strong>Next Step:</strong> You'll be redirected to complete payment via Mobile Money. 
                        If you're not redirected automatically, you can click the button below.
                    </div>

                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body text-start">
                            <h6 class="mb-3">Delivery Information</h6>
                            <p class="mb-2">
                                <strong>Name:</strong> {{ $order->customer_name }}
                            </p>
                            <p class="mb-2">
                                <strong>Phone:</strong> {{ $order->customer_phone }}
                            </p>
                            <p class="mb-0">
                                <strong>Address:</strong> {{ $order->customer_address }}
                            </p>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mb-3">
                        <a href="{{ route('order.receipt', $order->id) }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-print"></i> View Receipt
                        </a>
                        <button type="button" class="btn btn-primary btn-lg" id="proceedPaymentBtn">
                            <i class="fas fa-mobile-alt"></i> Proceed to Payment
                        </button>
                    </div>

                    <a href="{{ route('shop.products') }}" class="btn btn-outline-secondary btn-lg w-100">
                        <i class="fas fa-shopping-bags"></i> Continue Shopping
                    </a>

                    <hr class="my-4">

                    <div class="alert alert-light border">
                        <h6 class="mb-3">What's Next?</h6>
                        <ol class="text-start mb-0">
                            <li>Complete your payment using Mobile Money</li>
                            <li>You'll receive a confirmation SMS</li>
                            <li>Our team will process and prepare your order</li>
                            <li>Delivery will be arranged within 24-48 hours</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Order Details</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->product->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ ucfirst(str_replace('_', ' ', $item->product->unit)) }}</small>
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">UGX {{ number_format($item->unit_price, 0) }}</td>
                                    <td class="text-end"><strong>UGX {{ number_format($item->total_price, 0) }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <th colspan="3" class="text-end">Total:</th>
                                <th class="text-end"><h5 class="text-primary mb-0">UGX {{ number_format($order->total_amount, 0) }}</h5></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('proceedPaymentBtn').addEventListener('click', function() {
    // TODO: Integrate with Swap payment gateway
    alert('Redirecting to payment gateway...\n\nOrder: {{ $order->order_number }}\nAmount: UGX {{ number_format($order->total_amount, 0) }}');
    
    // Swap integration will be implemented here
    // window.location.href = paymentUrl;
});
</script>
@endsection
