@extends('layouts.admin')

@section('title', 'Order Details - Proden Admin')
@section('page-title', 'Order Details')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ $order->order_number }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Customer Information</h6>
                        <p class="mb-2">
                            <strong>Name:</strong> {{ $order->customer_name }}
                        </p>
                        <p class="mb-2">
                            <strong>Phone:</strong> 
                            <a href="tel:{{ $order->customer_phone }}">{{ $order->customer_phone }}</a>
                        </p>
                        <p class="mb-0">
                            <strong>Address:</strong><br>
                            {{ $order->customer_address }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Order Information</h6>
                        <p class="mb-2">
                            <strong>Order Date:</strong> {{ $order->created_at->format('d M Y, H:i') }}
                        </p>
                        <p class="mb-2">
                            <strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                        </p>
                        <p class="mb-0">
                            <strong>Order ID:</strong> {{ $order->id }}
                        </p>
                    </div>
                </div>

                <hr>

                <h6 class="text-muted mb-3">Order Items</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Unit Price</th>
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
                                <th class="text-end"><h6 class="text-success mb-0">UGX {{ number_format($order->total_amount, 0) }}</h6></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($order->notes)
                    <hr>
                    <h6 class="text-muted">Notes</h6>
                    <p class="mb-0">{{ $order->notes }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Order Status</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.order.status', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="order_status" class="form-label">Update Order Status</label>
                        <select name="order_status" id="order_status" class="form-select">
                            <option value="pending" @if($order->order_status === 'pending') selected @endif>Pending</option>
                            <option value="processing" @if($order->order_status === 'processing') selected @endif>Processing</option>
                            <option value="completed" @if($order->order_status === 'completed') selected @endif>Completed</option>
                            <option value="cancelled" @if($order->order_status === 'cancelled') selected @endif>Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Update Status
                    </button>
                </form>

                <hr>

                <div class="mb-3">
                    <h6 class="text-muted mb-2">Payment Status</h6>
                    <span class="badge bg-{{ $order->payment_status === 'completed' ? 'success' : 'warning' }} fs-6">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>

                <div class="mb-3">
                    <h6 class="text-muted mb-2">Current Order Status</h6>
                    <span class="badge bg-info fs-6">
                        {{ ucfirst($order->order_status) }}
                    </span>
                </div>

                @if($order->paid_at)
                    <div>
                        <h6 class="text-muted mb-2">Payment Received</h6>
                        <p class="mb-0">{{ $order->paid_at->format('d M Y, H:i') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Actions</h6>
            </div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('order.receipt', $order->id) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                    <i class="fas fa-print"></i> View Receipt
                </a>
                <button class="btn btn-outline-secondary btn-sm" onclick="printOrder()">
                    <i class="fas fa-print"></i> Print Order
                </button>
                <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function printOrder() {
    window.print();
}
</script>
@endsection

