@extends('layouts.admin')

@section('title', 'Edit Product - Proden Admin')
@section('page-title', 'Edit Product')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit"></i> Edit Product - {{ $product->name }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Category *</label>
                            <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if(old('category_id', $product->category_id) == $category->id) selected @endif>
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
                                   required value="{{ old('name', $product->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="3">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price (UGX) *</label>
                            <input type="number" id="price" name="price" 
                                   class="form-control @error('price') is-invalid @enderror"
                                   min="0" step="0.01" required value="{{ old('price', $product->price) }}">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="unit" class="form-label">Unit Type *</label>
                            <select id="unit" name="unit" class="form-select @error('unit') is-invalid @enderror" required>
                                <option value="">-- Select Unit --</option>
                                <option value="liter" @if(old('unit', $product->unit) === 'liter') selected @endif>Liter</option>
                                <option value="jerry_can" @if(old('unit', $product->unit) === 'jerry_can') selected @endif>Jerry Can</option>
                                <option value="carton" @if(old('unit', $product->unit) === 'carton') selected @endif>Carton</option>
                            </select>
                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">Product Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                   @if(old('is_active', $product->is_active)) checked @endif>
                            <label class="form-check-label" for="is_active">
                                Active (available for sale)
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image</label>
                        @if($product->image)
                            <div class="mb-2">
                                <img src="{{ asset('images/' . $product->image) }}" alt="Current image"
                                     style="height:100px; object-fit:cover; border-radius:6px;">
                                <div class="form-text">Current image. Upload a new one to replace it.</div>
                            </div>
                        @endif
                        <input type="file" id="image" name="image"
                               class="form-control @error('image') is-invalid @enderror"
                               accept="image/jpeg,image/jpg,image/png,image/webp">
                        <div class="form-text">JPEG, JPG, PNG or WEBP. Max 2MB.</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info mb-4">
                        <strong>Current Stock:</strong> {{ $product->stock }} units
                        <br>
                        <small>To modify stock, use the Inventory Management section.</small>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Update Product
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

