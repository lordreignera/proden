@extends('layouts.app')

@section('title', 'Order Receipt - Pruden')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Receipt -->
            <div class="card border-0 shadow-sm" id="receipt">
                <div class="card-body p-5">
                    <!-- Header -->
                    <div class="text-center mb-5">
                        <h2 style="font-size: 2rem; color: #2c3e50;">
                            <i class="fas fa-droplet" style="color: #3498db;"></i> PRUDEN
                        </h2>
                        <p class="text-muted mb-0">Drinks Distribution</p>
                        <h5 class="mt-4 mb-1">ORDER RECEIPT</h5>
                    </div>

                    <hr>

                    <!-- Order Info -->
                    <div class="row mb-4">
                        <div class="col-6">
                            <small class="text-muted">Order Number</small>
                            <h6 style="font-family: monospace;">{{ $order->order_number }}</h6>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Order Date</small>
                            <h6>{{ $order->created_at->format('d M Y, H:i') }}</h6>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <h6 class="mb-3">Customer Information</h6>
                            <p class="mb-2">
                                <strong>Name:</strong> {{ $order->customer_name }}
                            </p>
                            <p class="mb-2">
                                <strong>Phone:</strong> {{ $order->customer_phone }}
                            </p>
                            <p class="mb-0">
                                <strong>Address:</strong><br>
                                {{ $order->customer_address }}
                            </p>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="mb-4">
                        <h6 class="mb-3">Order Items</h6>
                        <table class="table table-sm">
                            <thead>
                                <tr style="border-bottom: 2px solid #ddd;">
                                    <th>Product</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Unit Price</th>
                                    <th class="text-end">Amount</th>
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
                                        <td class="text-center">UGX {{ number_format($item->unit_price, 0) }}</td>
                                        <td class="text-end">UGX {{ number_format($item->total_price, 0) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Totals -->
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-6">
                                    <span class="text-muted">Subtotal:</span>
                                </div>
                                <div class="col-6 text-end">
                                    <strong>UGX {{ number_format($order->total_amount, 0) }}</strong>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <span class="text-muted">Shipping:</span>
                                </div>
                                <div class="col-6 text-end">
                                    <strong class="text-success">Free</strong>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <h6 class="mb-0">Total:</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <h5 class="text-primary mb-0">UGX {{ number_format($order->total_amount, 0) }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <div class="row text-center">
                            <div class="col-6">
                                <small class="text-muted">Payment Status</small>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $order->payment_status === 'completed' ? 'success' : 'warning' }} text-dark">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Order Status</small>
                                <p class="mb-0">
                                    <span class="badge bg-info">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($order->notes)
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h6 class="mb-3">Special Instructions</h6>
                                <p class="mb-0">{{ $order->notes }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Footer -->
                    <hr>
                    <div class="text-center text-muted small">
                        <p class="mb-2">Thank you for your order!</p>
                        <p class="mb-0">For inquiries, please contact us at info@pruden.com | +234 XXX XXX XXXX</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 d-flex gap-2">
                <button onclick="window.print()" class="btn btn-primary flex-grow-1">
                    <i class="fas fa-print"></i> Print Receipt
                </button>
                <a href="{{ route('shop.products') }}" class="btn btn-outline-secondary flex-grow-1">
                    <i class="fas fa-shopping-bags"></i> Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body, .container {
        background: white;
    }
    .btn, nav, footer {
        display: none;
    }
    .card {
        border: 1px solid #ddd;
        box-shadow: none;
    }
}
</style>
@endsection
