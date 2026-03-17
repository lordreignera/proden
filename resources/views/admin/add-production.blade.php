@extends('layouts.admin')

@section('title', 'Add Production - Pruden Admin')
@section('page-title', 'Add Production')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-plus"></i> Record Production - {{ $product->name }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.inventory.store-production', $product->id) }}" method="POST">
                    @csrf
                    @php
                        $unitLabels = [
                            'carton' => 'Carton',
                            'jerry_can' => 'Jerrycan',
                            'liter' => 'Liter',
                        ];
                        $unitLabel = $unitLabels[$product->unit] ?? ucfirst(str_replace('_', ' ', $product->unit));
                    @endphp
                    
                    <div class="alert alert-info mb-4">
                        <strong>Current Stock:</strong> {{ $product->stock }} {{ strtolower($unitLabel) }}{{ $product->stock != 1 ? 's' : '' }}
                    </div>

                    <div class="mb-4">
                        <label for="unit_type" class="form-label">Unit Type *</label>
                        <select id="unit_type" name="unit_type" class="form-select form-select-lg @error('unit_type') is-invalid @enderror" required>
                            @foreach($unitLabels as $value => $label)
                                <option value="{{ $value }}" @selected(old('unit_type', $product->unit) === $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Select the packaging unit being added for this product.</small>
                        @error('unit_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="production_date" class="form-label">Date of Production *</label>
                        <input type="date" id="production_date" name="production_date"
                               class="form-control form-control-lg @error('production_date') is-invalid @enderror"
                               required value="{{ old('production_date', date('Y-m-d')) }}">
                        @error('production_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="quantity" class="form-label">Quantity Produced *</label>
                        <input type="number" id="quantity" name="quantity" 
                               class="form-control form-control-lg @error('quantity') is-invalid @enderror"
                               min="1" required value="{{ old('quantity') }}">
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="form-label">Production Notes (Optional)</label>
                        <textarea id="notes" name="notes" class="form-control @error('notes') is-invalid @enderror" 
                                  rows="3" placeholder="e.g., Date of production, batch number, etc.">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 alert alert-light">
                        <strong>After submission:</strong>
                        <ul class="mb-0">
                            <li>Stock will be increased by the quantity entered in {{ strtolower($unitLabel) }}s</li>
                            <li>An inventory record will be created</li>
                        </ul>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-check"></i> Record Production
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
