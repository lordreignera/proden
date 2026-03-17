@extends('layouts.admin')

@section('title', 'Inventory - Pruden Admin')
@section('page-title', 'Inventory Management')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <span><i class="fas fa-boxes"></i> Product Inventory</span>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-bottle-water"></i> Manage Products
                </a>
                <a href="{{ route('admin.inventory.report') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-chart-line"></i> Reports
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Unit</th>
                    <th class="text-center">Current Stock</th>
                    <th class="text-center">Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            <strong>{{ $product->name }}</strong>
                            <br>
                            <small class="text-muted">{{ $product->slug }}</small>
                        </td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $product->unit)) }}</td>
                        <td class="text-center">
                            <span class="badge bg-{{ $product->stock > 20 ? 'success' : ($product->stock > 10 ? 'warning' : 'danger') }}">
                                {{ $product->stock }} units
                            </span>
                        </td>
                        <td class="text-center">
                            @if($product->stock > 20)
                                <span class="badge bg-success">Good</span>
                            @elseif($product->stock > 10)
                                <span class="badge bg-warning">Low</span>
                            @else
                                <span class="badge bg-danger">Critical</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.inventory.production', $product->id) }}" class="btn btn-outline-success" title="Add production">
                                    <i class="fas fa-plus"></i> Add
                                </a>
                                <a href="{{ route('admin.inventory.adjustment', $product->id) }}" class="btn btn-outline-warning" title="Adjust stock">
                                    <i class="fas fa-edit"></i> Adjust
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox"></i> No products found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-light">
        <div class="d-flex justify-content-center">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Stock Alert -->
<div class="mt-4">
    <div class="card border-warning">
        <div class="card-header bg-warning text-dark">
            <i class="fas fa-exclamation-triangle"></i> Low Stock Alert
        </div>
        <div class="card-body">
            @php
                $lowStockProducts = $products->filter(function($p) { return $p->stock < 15; });
            @endphp
            @if($lowStockProducts->count() > 0)
                <ul class="mb-0">
                    @foreach($lowStockProducts as $product)
                        <li class="mb-2">
                            <strong>{{ $product->name }}</strong> - 
                            <span class="badge bg-danger">{{ $product->stock }} units</span>
                            <a href="{{ route('admin.inventory.production', $product->id) }}" class="ms-2">Add stock</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-success mb-0"><i class="fas fa-check-circle"></i> All products have sufficient stock.</p>
            @endif
        </div>
    </div>
</div>
@endsection
