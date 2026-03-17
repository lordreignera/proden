@extends('layouts.admin')

@section('title', 'Orders - Proden Admin')
@section('page-title', 'Orders Management')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <span><i class="fas fa-receipt"></i> All Orders</span>
            <div class="order-search-wrap">
                <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search orders...">
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Order Number</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Amount</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <strong>{{ $order->order_number }}</strong>
                        </td>
                        <td>{{ $order->customer_name }}</td>
                        <td>
                            <a href="tel:{{ $order->customer_phone }}" class="text-decoration-none">
                                {{ $order->customer_phone }}
                            </a>
                        </td>
                        <td>
                            <strong class="text-success">UGX {{ number_format($order->total_amount, 0) }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-{{ $order->payment_status === 'completed' ? 'success' : ($order->payment_status === 'failed' ? 'danger' : 'warning') }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $order->order_status === 'completed' ? 'success' : ($order->order_status === 'cancelled' ? 'danger' : 'info') }}">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </td>
                        <td>
                            <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            <a href="{{ route('admin.order.detail', $order->id) }}" class="btn btn-sm btn-outline-primary" title="View details">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox"></i> No orders found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-light">
        <div class="d-flex justify-content-center">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<style>
.order-search-wrap {
    width: 100%;
}

@media (min-width: 768px) {
    .order-search-wrap {
        width: 220px;
    }
}
</style>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('table tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endsection

