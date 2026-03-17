@extends('layouts.admin')

@section('title', 'Create Product - Pruden Admin')
@section('page-title', 'Create New Product')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-plus"></i> Create New Product
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Category *</label>
                            <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if(old('category_id') == $category->id) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="name" class="form-label">Product Name *</label>
                            <input type="text" id="name" name="name" 
                                   class="form-control @error('name') is-invalid @enderror"
                                   required value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price (₦) *</label>
                            <input type="number" id="price" name="price" 
                                   class="form-control @error('price') is-invalid @enderror"
                                   min="0" step="0.01" required value="{{ old('price') }}">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="unit" class="form-label">Unit Type *</label>
                            <select id="unit" name="unit" class="form-select @error('unit') is-invalid @enderror" required>
                                <option value="">-- Select Unit --</option>
                                <option value="liter" @if(old('unit') === 'liter') selected @endif>Liter</option>
                                <option value="jerry_can" @if(old('unit') === 'jerry_can') selected @endif>Jerry Can</option>
                                <option value="carton" @if(old('unit') === 'carton') selected @endif>Carton</option>
                            </select>
                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="stock" class="form-label">Initial Stock *</label>
                        <input type="number" id="stock" name="stock" 
                               class="form-control @error('stock') is-invalid @enderror"
                               min="0" required value="{{ old('stock', 0) }}">
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Create Product
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
