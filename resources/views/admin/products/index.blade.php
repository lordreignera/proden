@extends('layouts.admin')

@section('title', 'Products - Pruden Admin')
@section('page-title', 'Products Management')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <span><i class="fas fa-bottle-water"></i> All Products</span>
            <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Add New Product
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
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
                        <td>
                            <strong class="text-success">₦{{ number_format($product->price, 0) }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-{{ $product->stock > 20 ? 'success' : ($product->stock > 10 ? 'warning' : 'danger') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
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
@endsection
