@extends('layouts.admin')

@section('title', 'Stock Adjustment - Pruden Admin')
@section('page-title', 'Adjust Stock')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit"></i> Stock Adjustment - {{ $product->name }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.inventory.store-adjustment', $product->id) }}" method="POST">
                    @csrf
                    
                    <div class="alert alert-info mb-4">
                        <strong>Current Stock:</strong> {{ $product->stock }} units
                    </div>

                    <div class="mb-4">
                        <label for="quantity" class="form-label">Quantity Adjustment *</label>
                        <input type="number" id="quantity" name="quantity" 
                               class="form-control form-control-lg @error('quantity') is-invalid @enderror"
                               placeholder="Positive for increase, negative for decrease" 
                               required value="{{ old('quantity') }}">
                        <small class="text-muted">Enter +10 to add 10 units or -5 to remove 5 units</small>
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="reason" class="form-label">Reason for Adjustment *</label>
                        <select id="reason" name="reason" class="form-select form-select-lg @error('reason') is-invalid @enderror" required>
                            <option value="">-- Select Reason --</option>
                            <option value="Damage/Spoilage" @if(old('reason') === 'Damage/Spoilage') selected @endif>Damage/Spoilage</option>
                            <option value="Inventory Count Correction" @if(old('reason') === 'Inventory Count Correction') selected @endif>Inventory Count Correction</option>
                            <option value="Returned Goods" @if(old('reason') === 'Returned Goods') selected @endif>Returned Goods</option>
                            <option value="Stock Transfer" @if(old('reason') === 'Stock Transfer') selected @endif>Stock Transfer</option>
                            <option value="Other" @if(old('reason') === 'Other') selected @endif>Other</option>
                        </select>
                        @error('reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="form-label">Additional Notes (Optional)</label>
                        <textarea id="notes" name="notes" class="form-control @error('notes') is-invalid @enderror" 
                                  rows="3" placeholder="Provide more details...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 alert alert-warning">
                        <strong>⚠️ Important:</strong> This adjustment will modify the inventory. Make sure the quantity is correct before submitting.
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning btn-lg">
                            <i class="fas fa-check"></i> Apply Adjustment
                        </button>
                        <a href="{{ route('admin.inventory') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
