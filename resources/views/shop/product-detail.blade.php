@extends('layouts.app')

@section('title', $product->name . ' - Pruden')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm product-hero-card">
                <div class="product-hero-visual">
                    @if(!empty($product->image))
                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="product-hero-image">
                    @else
                        <span class="product-hero-emoji">🥤</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('shop.products') }}">Shop</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('products.filter', $product->category->slug) }}">{{ $product->category->name }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $product->name }}</li>
                </ol>
            </nav>

            <h1 class="mb-3">{{ $product->name }}</h1>

            <div class="mb-4">
                <span class="badge bg-info text-dark fs-6 me-2">
                    <i class="fas fa-cube"></i> {{ ucfirst(str_replace('_', ' ', $product->unit)) }}
                </span>
                <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }} fs-6">
                    {{ $product->stock > 0 ? $product->stock . ' in stock' : 'Out of Stock' }}
                </span>
            </div>

            <div class="card border-0 bg-light mb-4">
                <div class="card-body">
                    <p class="text-muted mb-0">Price per unit:</p>
                        <h2 class="text-primary mb-0">UGX {{ number_format($product->price, 0) }}</h2>
                </div>
            </div>

            <p class="lead">{{ $product->description }}</p>

            @if($product->stock > 0)
                <form action="{{ route('cart.add', $product) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="row g-3 align-items-end mb-4">
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" class="form-control form-control-lg" 
                                   value="1" min="1" max="{{ $product->stock }}" required>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </form>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Available:</strong> {{ $product->stock }} units in stock
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-clock"></i>
                    This product is currently out of stock. Please check back later.
                </div>
            @endif

            <div class="card border-0 bg-light mt-5">
                <div class="card-body">
                    <h5 class="card-title mb-3">Product Details</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Category:</th>
                            <td>
                                <a href="{{ route('products.filter', $product->category->slug) }}">
                                    {{ $product->category->name }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Unit Type:</th>
                            <td>{{ ucfirst(str_replace('_', ' ', $product->unit)) }}</td>
                        </tr>
                        <tr>
                            <th>Price:</th>
                               <td>UGX {{ number_format($product->price, 0) }}</td>
                        </tr>
                        <tr>
                            <th>Stock Level:</th>
                            <td>{{ $product->stock }} units</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">
                <i class="fas fa-related"></i> Related Products
            </h3>
        </div>
        @foreach($product->category->products()->where('id', '!=', $product->id)->limit(6)->get() as $related)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card product-card h-100">
                    <div class="product-image">
                        @if(!empty($related->image))
                            <img src="{{ asset('images/' . $related->image) }}" alt="{{ $related->name }}" class="related-product-image">
                        @else
                            <span class="related-product-emoji">🥤</span>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title flex-grow-1">{{ $related->name }}</h6>
                        <p class="card-text mb-2">
                                <span class="badge bg-success">UGX {{ number_format($related->price, 0) }}</span>
                        </p>
                        <a href="{{ route('product.show', $related->slug) }}" class="btn btn-sm btn-outline-primary">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
const quantityInput = document.getElementById('quantity');
if (quantityInput) {
    quantityInput.addEventListener('change', function() {
        const max = {{ $product->stock }};
        if (this.value > max) {
            this.value = max;
            alert('Maximum quantity available: ' + max);
        }
    });
}
</script>

<style>
.product-hero-card {
    height: 400px;
}

.product-hero-visual {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.product-hero-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-hero-emoji {
    font-size: 8rem;
}

.related-product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-image {
    height: 170px;
    background: #f5f6fa;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.related-product-emoji {
    font-size: 3rem;
}

@media (max-width: 767.98px) {
    .product-hero-card {
        height: 280px;
    }

    .product-hero-emoji {
        font-size: 5.5rem;
    }

    .related-product-emoji {
        font-size: 2.4rem;
    }
}
</style>
@endsection
