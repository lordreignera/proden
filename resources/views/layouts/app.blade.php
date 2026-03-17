<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Proden Drinks'))</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
        :root {
            --proden-red: #C41E3A;
            --proden-dark: #8B0000;
            --proden-green: #1B5E20;
        }
        .navbar-proden { background: linear-gradient(135deg, #8B0000 0%, #C41E3A 100%); }
        .btn-proden { background: var(--proden-red); color: #fff; border: none; }
        .btn-proden:hover { background: var(--proden-dark); color: #fff; }
        .hero-section { background: linear-gradient(135deg, #8B0000 0%, #C41E3A 100%); color: white; padding: 60px 0; }
        .hero-section h1 { font-size: 2rem; font-weight: 700; }
        .product-card { border: none; box-shadow: 0 4px 15px rgba(0,0,0,.08); transition: transform .2s, box-shadow .2s; border-radius: 12px; overflow: hidden; }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 8px 25px rgba(0,0,0,.15); }
        .product-card .card-img-top { height: 200px; object-fit: cover; }
        .badge-proden { background: var(--proden-red); }
        footer { background: #1a1a1a; color: #ccc; }
        .cart-count { background: #FFD700; color: #000; font-size: .7rem; padding: 2px 6px; border-radius: 50%; font-weight: 700; }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-proden sticky-top shadow">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="{{ url('/') }}">
                <i class="fas fa-leaf me-2"></i>Proden
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('shop.products') }}">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('distributor.apply') }}">Become a Distributor</a></li>
                </ul>
                <ul class="navbar-nav align-items-center gap-1">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart me-1"></i>Cart
                            <span id="cartCountBadge" class="cart-count ms-1 @if(empty($navCartCount) || $navCartCount <= 0) d-none @endif">{{ (int) ($navCartCount ?? 0) }}</span>
                        </a>
                    </li>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-1"></i>Admin</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link text-white">Logout</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="py-4 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h5 class="text-white mb-1"><i class="fas fa-leaf me-2 text-danger"></i>Proden Distribution Co. Ltd</h5>
                    <p class="mb-1 small"><i class="fas fa-map-marker-alt me-2 text-danger"></i>Plot 42A Mukabya Road, Nakawa Industrial Area</p>
                    <p class="mb-1 small"><i class="fas fa-phone me-2 text-danger"></i>+256 772 494618 / +256 772 163703</p>
                    <p class="mb-0 small"><i class="fas fa-envelope me-2 text-danger"></i>p.nambuya@prodendistribution.com</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-white mb-1">Proden Distribution Co. Ltd &copy; {{ date('Y') }}</p>
                    <p class="small mb-0">Quality Natural Drinks from Uganda</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            const cartBadge = document.getElementById('cartCountBadge');

            function updateCartBadge(count) {
                if (!cartBadge) return;

                const nextCount = Number(count) || 0;
                cartBadge.textContent = String(nextCount);

                if (nextCount > 0) {
                    cartBadge.classList.remove('d-none');
                } else {
                    cartBadge.classList.add('d-none');
                }
            }

            document.addEventListener('submit', async function (event) {
                const form = event.target;
                if (!(form instanceof HTMLFormElement)) return;

                const action = form.getAttribute('action') || '';
                const method = (form.getAttribute('method') || 'GET').toUpperCase();

                if (method !== 'POST' || !action.includes('/cart/add/')) return;

                event.preventDefault();

                const submitButton = form.querySelector('button[type="submit"]');
                const originalButtonHtml = submitButton ? submitButton.innerHTML : '';

                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                }

                try {
                    const response = await fetch(action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: new FormData(form)
                    });

                    if (!response.ok) {
                        throw new Error('Request failed');
                    }

                    const payload = await response.json();
                    updateCartBadge(payload.cartCount);

                    if (submitButton) {
                        submitButton.innerHTML = '<i class="fas fa-check"></i> Added';
                        setTimeout(() => {
                            submitButton.innerHTML = originalButtonHtml;
                            submitButton.disabled = false;
                        }, 900);
                    }
                } catch (err) {
                    if (submitButton) {
                        submitButton.innerHTML = originalButtonHtml;
                        submitButton.disabled = false;
                    }

                    // Fallback to regular submission if AJAX fails.
                    form.submit();
                }
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
