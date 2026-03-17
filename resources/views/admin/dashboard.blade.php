@extends('layouts.admin')

@section('title', 'Dashboard - Pruden Admin')
@section('page-title', 'Dashboard')

@section('styles')
<style>
    .sales-chart-wrap {
        position: relative;
        height: 300px;
    }

    .mobile-order-card {
        border: 1px solid #f0dce2;
        border-left: 4px solid #8B0000;
        border-radius: 12px;
        background: #fff;
        padding: .9rem;
    }

    .mobile-order-card .meta {
        font-size: .8rem;
        color: #6b7280;
    }

    @media (max-width: 767.98px) {
        .sales-chart-wrap {
            height: 230px;
        }

        .stat-card {
            margin-bottom: 12px;
            padding: 14px;
        }

        .stat-card .stat-icon {
            font-size: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="fas fa-receipt"></i></div>
            <h6>Total Orders</h6>
            <h3>{{ $totalOrders }}</h3>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="stat-card success">
            <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
            <h6>Total Revenue</h6>
            <h3>UGX {{ number_format($totalRevenue, 0) }}</h3>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="stat-card warning">
            <div class="stat-icon"><i class="fas fa-bottle-water"></i></div>
            <h6>Total Products</h6>
            <h3>{{ $totalProducts }}</h3>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="stat-card danger">
            <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <h6>Low Stock Items</h6>
            <h3>{{ $lowStockProducts }}</h3>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-line"></i> Monthly Sales
            </div>
            <div class="card-body">
                <div class="sales-chart-wrap">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Quick Stats
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">This Month Sales</small>
                    <h5 class="text-success mb-0">UGX {{ number_format($monthlySales, 0) }}</h5>
                </div>
                <hr>
                <div class="mb-3">
                    <small class="text-muted">Orders This Month</small>
                    <h5 class="mb-0">{{ $monthlyOrders }}</h5>
                </div>
                <hr>
                <div>
                    <small class="text-muted">Average Order Value</small>
                    <h5 class="mb-0">
                        @if($totalOrders > 0)
                            UGX {{ number_format($totalRevenue / $totalOrders, 0) }}
                        @else
                            N/A
                        @endif
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <span><i class="fas fa-recent"></i> Recent Orders</span>
            <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-outline-light">View All</a>
        </div>
    </div>
    <div class="table-responsive d-none d-md-block">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Order Number</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Payment Status</th>
                    <th>Order Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                    <tr>
                        <td>
                            <strong>{{ $order->order_number }}</strong>
                        </td>
                        <td>{{ $order->customer_name }}</td>
                        <td>
                            <strong>UGX {{ number_format($order->total_amount, 0) }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-{{ $order->payment_status === 'completed' ? 'success' : 'warning' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-info">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </td>
                        <td>
                            <small>{{ $order->created_at->format('d M Y') }}</small>
                        </td>
                        <td>
                            <a href="{{ route('admin.order.detail', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox"></i> No orders yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-md-none p-3">
        @forelse($recentOrders as $order)
            <div class="mobile-order-card mb-3">
                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                    <strong>{{ $order->order_number }}</strong>
                    <a href="{{ route('admin.order.detail', $order->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
                <div class="mb-1">{{ $order->customer_name }}</div>
                <div class="fw-semibold text-danger mb-2">UGX {{ number_format($order->total_amount, 0) }}</div>
                <div class="d-flex flex-wrap gap-2 mb-2">
                    <span class="badge bg-{{ $order->payment_status === 'completed' ? 'success' : 'warning' }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                    <span class="badge bg-info">
                        {{ ucfirst($order->order_status) }}
                    </span>
                </div>
                <div class="meta">{{ $order->created_at->format('d M Y') }}</div>
            </div>
        @empty
            <div class="text-center py-4 text-muted">
                <i class="fas fa-inbox"></i> No orders yet
            </div>
        @endforelse
    </div>
</div>

<script>
// Sales Chart
const salesCtx = document.getElementById('salesChart').getContext('2d');
new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'This Week'],
        datasets: [{
            label: 'Sales (UGX)',
            data: [
                {{ $monthlySales * 0.2 }},
                {{ $monthlySales * 0.25 }},
                {{ $monthlySales * 0.3 }},
                {{ $monthlySales * 0.15 }},
                {{ $monthlySales * 0.1 }}
            ],
            borderColor: '#6A1B9A',
            backgroundColor: 'rgba(106, 27, 154, 0.14)',
            borderWidth: 2,
            fill: true,
            tension: 0.4,
            pointRadius: 5,
            pointBackgroundColor: '#8B0000',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'UGX ' + value.toLocaleString();
                    }
                }
            }
        }
    }
});
</script>
@endsection
