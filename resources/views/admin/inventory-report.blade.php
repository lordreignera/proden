@extends('layouts.admin')

@section('title', 'Inventory Report - Pruden Admin')
@section('page-title', 'Inventory Report (Last 30 Days)')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <span><i class="fas fa-chart-bar"></i> Production & Sales Summary</span>
            <a href="{{ route('admin.inventory') }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-backward"></i> Back to Inventory
            </a>
        </div>
    </div>
    <div class="card-body">
        @forelse($report as $productId => $transactions)
            @php
                $product = $transactions->first()->product;
                $produced = $transactions->where('transaction_type', 'production')->sum('quantity_produced');
                $sold = $transactions->where('transaction_type', 'sale')->sum('quantity_sold');
            @endphp
            <div class="row mb-4 pb-4 border-bottom">
                <div class="col-md-4">
                    <h6 class="mb-2">{{ $product->name }}</h6>
                    <small class="text-muted">{{ $product->category->name }} | {{ ucfirst(str_replace('_', ' ', $product->unit)) }}</small>
                </div>
                <div class="col-md-2">
                    <span class="text-muted">Produced:</span>
                    <h6 class="text-success">{{ $produced }} units</h6>
                </div>
                <div class="col-md-2">
                    <span class="text-muted">Sold:</span>
                    <h6 class="text-danger">{{ $sold }} units</h6>
                </div>
                <div class="col-md-2">
                    <span class="text-muted">Net:</span>
                    <h6 class="text-primary">{{ $produced - $sold }} units</h6>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#product{{ $productId }}">
                        <i class="fas fa-details"></i> Details
                    </button>
                </div>
            </div>

            <!-- Transaction Details -->
            <div class="collapse mb-4" id="product{{ $productId }}">
                <div class="card bg-light">
                    <div class="card-body">
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Produced</th>
                                    <th>Sold</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions->sortByDesc('created_at') as $transaction)
                                    <tr>
                                        <td>{{ $transaction->transaction_date->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $transaction->transaction_type === 'production' ? 'success' : ($transaction->transaction_type === 'sale' ? 'danger' : 'secondary') }}">
                                                {{ ucfirst($transaction->transaction_type) }}
                                            </span>
                                        </td>
                                        <td>{{ $transaction->quantity_produced ?? '-' }}</td>
                                        <td>{{ $transaction->quantity_sold ?? '-' }}</td>
                                        <td><small>{{ $transaction->notes }}</small></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                <i class="fas fa-inbox"></i> No inventory transactions found in the last 30 days.
            </div>
        @endforelse
    </div>
</div>

<!-- Summary Statistics -->
<div class="row">
    <div class="col-md-4">
        <div class="stat-card success">
            <div class="stat-icon"><i class="fas fa-box"></i></div>
            <h6>Total Produced</h6>
            <h3>
                @php
                    $totalProduced = $report->values()->flatten()->where('transaction_type', 'production')->sum('quantity_produced');
                @endphp
                {{ $totalProduced }}
            </h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card danger">
            <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
            <h6>Total Sold</h6>
            <h3>
                @php
                    $totalSold = $report->values()->flatten()->where('transaction_type', 'sale')->sum('quantity_sold');
                @endphp
                {{ $totalSold }}
            </h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="fas fa-chart-pie"></i></div>
            <h6>Overall Balance</h6>
            <h3>{{ $totalProduced - $totalSold }}</h3>
        </div>
    </div>
</div>
@endsection
