@extends('layouts.app')

@section('title', 'Shop - Pruden Drinks')

@section('content')
<section class="shop-hero">
    <div class="hero-ornament hero-ornament-one"></div>
    <div class="hero-ornament hero-ornament-two"></div>
    <div class="container position-relative">
        <div class="row align-items-end g-4">
            <div class="col-lg-8">
                <span class="shop-kicker">
                    <i class="fas fa-leaf me-2"></i>Proden Shop
                </span>
                <h1 class="shop-title mt-3 mb-2">Our Product Collection</h1>
                <p class="shop-subtitle mb-0">Browse and order your favorite natural drinks and concentrates.</p>
            </div>
            <div class="col-lg-4">
                <div class="shop-pill-grid">
                    <div class="shop-pill">
                        <span class="pill-value">{{ $products->total() }}</span>
                        <span class="pill-label">Products</span>
                    </div>
                    <div class="shop-pill">
                        <span class="pill-value">24/7</span>
                        <span class="pill-label">Ordering</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="shop-body py-5">
<div class="container">
    <div class="row g-4">
        <!-- Sidebar Filters -->
        <aside class="col-lg-3">
            <div class="shop-filters card border-0 shadow-sm">
                <div class="card-header filter-header">
                    <h5 class="mb-0"><i class="fas fa-sliders-h me-2"></i>Filters</h5>
                </div>
                <div class="card-body">
                    <h6 class="filter-label mb-3">Categories</h6>
                    <div class="list-group list-group-flush">
                        @foreach($categories as $category)
                            <a href="{{ route('products.filter', $category->slug) }}" class="list-group-item list-group-item-action filter-item">
                                <i class="fas fa-tag me-2"></i> {{ $category->name }}
                            </a>
                        @endforeach
                    </div>

                    <h6 class="filter-label mt-4 mb-3">Unit Type</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="liter" value="liter">
                        <label class="form-check-label" for="liter">Liters</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="jerry_can" value="jerry_can">
                        <label class="form-check-label" for="jerry_can">Jerry Cans</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="carton" value="carton">
                        <label class="form-check-label" for="carton">Cartons</label>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <h6 class="mb-0 text-muted fw-semibold">Showing {{ $products->count() }} of {{ $products->total() }} products</h6>
                <span class="result-chip"><i class="fas fa-truck-fast me-1"></i>Fast delivery across Kampala</span>
            </div>
            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-sm-6 col-xl-4">
                        @php
                            $unitLabel = ucfirst(str_replace('_', ' ', $product->unit));
                            $priceSuffix = $product->unit === 'carton' ? '/ carton' : ($product->unit === 'jerry_can' ? '/ jerrycan' : '/ litre');
                            $qtyLabel = $product->unit === 'carton' ? 'cartons' : ($product->unit === 'jerry_can' ? 'jerrycans' : 'litres');
                        @endphp
                        <div class="card product-card h-100">
                            <div class="product-image">
                                @if(!empty($product->image))
                                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="product-photo">
                                @else
                                    <span class="product-emoji">🥤</span>
                                @endif
                                <span class="stock-chip bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title flex-grow-1 mb-2">{{ $product->name }}</h5>
                                <p class="card-text text-muted small mb-3 product-desc">{{ Str::limit($product->description, 85) }}</p>
                                <p class="mb-2 d-flex flex-wrap gap-2">
                                    <span class="badge unit-badge text-dark">
                                        {{ $unitLabel }}
                                    </span>
                                    <span class="badge qty-badge bg-light text-secondary border">
                                        {{ $product->stock }} {{ $qtyLabel }}
                                    </span>
                                </p>
                                <div class="product-price">UGX {{ number_format($product->price, 0) }} <span class="price-suffix">{{ $priceSuffix }}</span></div>
                                <div class="mt-3 d-grid gap-2">
                                    <a href="{{ route('product.show', $product->slug) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @if($product->stock > 0)
                                        <form action="{{ route('cart.add', $product) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-cart-plus"></i> Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled>Out of Stock</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state text-center">
                            <i class="fas fa-box-open mb-3"></i>
                            <h5 class="mb-2">No products found</h5>
                            <p class="mb-0 text-muted">Try a different category or check back soon for new stock.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
</section>

<script>
document.querySelectorAll('.form-check-input').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        // Filter functionality can be added here
        console.log('Filter by:', this.value);
    });
});
</script>

@push('styles')
<style>
    .shop-hero {
        background: linear-gradient(135deg, #8b0000 0%, #c41e3a 55%, #e13451 100%);
        color: #fff;
        padding: 4.2rem 0 3.3rem;
        position: relative;
        overflow: hidden;
    }

    .hero-ornament {
        position: absolute;
        border-radius: 50%;
        filter: blur(2px);
        opacity: .2;
        pointer-events: none;
    }

    .hero-ornament-one {
        width: 280px;
        height: 280px;
        right: -80px;
        top: -70px;
        background: radial-gradient(circle, #ffd166 0%, transparent 70%);
    }

    .hero-ornament-two {
        width: 220px;
        height: 220px;
        left: -70px;
        bottom: -90px;
        background: radial-gradient(circle, #1b5e20 0%, transparent 75%);
    }

    .shop-kicker {
        display: inline-flex;
        align-items: center;
        border: 1px solid rgba(255, 255, 255, .45);
        background: rgba(255, 255, 255, .14);
        padding: .32rem .8rem;
        border-radius: 999px;
        font-size: .83rem;
        font-weight: 600;
        letter-spacing: .2px;
    }

    .shop-title {
        font-size: clamp(1.9rem, 5vw, 3.1rem);
        font-weight: 800;
        line-height: 1.1;
    }

    .shop-subtitle {
        max-width: 620px;
        color: rgba(255,255,255,.9);
    }

    .shop-pill-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .8rem;
    }

    .shop-pill {
        background: rgba(255,255,255,.16);
        border: 1px solid rgba(255,255,255,.35);
        border-radius: 14px;
        padding: .85rem;
        text-align: center;
        backdrop-filter: blur(6px);
    }

    .pill-value {
        display: block;
        font-size: 1.15rem;
        font-weight: 800;
        line-height: 1;
    }

    .pill-label {
        font-size: .76rem;
        opacity: .9;
    }

    .shop-body {
        background: linear-gradient(180deg, #fff 0%, #f7f8fc 100%);
    }

    .shop-filters {
        position: sticky;
        top: 90px;
        border-radius: 14px;
        overflow: hidden;
    }

    .filter-header {
        background: linear-gradient(135deg, #0d6efd 0%, #2666d8 100%);
        color: #fff;
        border: 0;
    }

    .filter-label {
        font-weight: 700;
        letter-spacing: .2px;
    }

    .filter-item {
        border-left: 0;
        border-right: 0;
        border-radius: 0;
        font-weight: 500;
    }

    .result-chip {
        display: inline-flex;
        align-items: center;
        background: #fff;
        border: 1px solid #e9edf4;
        border-radius: 999px;
        padding: .35rem .8rem;
        font-size: .82rem;
        color: #576176;
    }

    .product-card {
        border-radius: 16px;
        border: 1px solid #edf1f7;
        box-shadow: 0 6px 20px rgba(12, 23, 44, .06);
        transition: transform .24s ease, box-shadow .24s ease;
        overflow: hidden;
        background: #fff;
    }

    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 34px rgba(12, 23, 44, .12);
    }

    .product-image {
        height: 230px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid #eef2f8;
    }

    .product-photo {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        padding: .65rem;
        background: linear-gradient(140deg, #f8fafe 0%, #f0f4fb 100%);
    }

    .product-emoji {
        font-size: 3.6rem;
        line-height: 1;
    }

    .stock-chip {
        position: absolute;
        top: 12px;
        right: 12px;
        font-size: .72rem;
        font-weight: 700;
        padding: .3rem .55rem;
        border-radius: 999px;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: .3px;
    }

    .unit-badge {
        background: #22c4dd;
        font-weight: 700;
    }

    .qty-badge {
        font-weight: 600;
    }

    .product-price {
        font-size: 1.8rem;
        font-weight: 800;
        line-height: 1.15;
        color: #8b0000;
        letter-spacing: -.4px;
    }

    .price-suffix {
        font-size: .82rem;
        color: #6f7b90;
        font-weight: 600;
    }

    .product-desc {
        min-height: 2.8rem;
    }

    .empty-state {
        background: #fff;
        border: 1px dashed #d8deea;
        border-radius: 16px;
        padding: 2.3rem 1.2rem;
    }

    .empty-state i {
        font-size: 2.1rem;
        color: #9ba7bd;
    }

    @media (max-width: 991.98px) {
        .shop-filters {
            position: static;
        }
    }

    @media (max-width: 767.98px) {
        .shop-hero {
            padding: 3.2rem 0 2.7rem;
        }

        .shop-pill-grid {
            grid-template-columns: 1fr 1fr;
        }

        .product-image {
            height: 200px;
        }

        .product-emoji {
            font-size: 3rem;
        }

        .product-price {
            font-size: 1.55rem;
        }
    }
</style>
@endpush
@endsection
