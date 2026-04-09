<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proden Distribution Co. Ltd – Natural Hibiscus &amp; Passion Drinks</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/product1.jpeg') }}">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Playfair+Display:wght@600;700&family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --red:   #C41E3A;
            --dark:  #8B0000;
            --green: #1B5E20;
            --purple:#6A1B9A;
            --light: #FFF8F8;
            --font-body: 'Sora', sans-serif;
            --font-display: 'Archivo Black', sans-serif;
            --font-hero-serif: 'Playfair Display', serif;
        }
        * { font-family: var(--font-body); }
        body { background: #fff; overflow-x: hidden; }

        /* ── NAV ── */
        .navbar-proden { background: linear-gradient(135deg, var(--dark) 0%, var(--red) 100%); }
        .nav-link { font-weight: 500; }
        .navbar-brand {
            font-family: var(--font-display);
            font-size: 1.45rem;
            letter-spacing: .4px;
        }

        /* ── HERO ── */
        .hero {
            min-height: 92vh;
            background: #1a0000;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        /* video bg */
        .hero-video {
            position: absolute; inset: 0;
            width: 100%; height: 100%;
            object-fit: cover;
            z-index: 0;
        }
        .hero-overlay {
            position: absolute; inset: 0;
            background: rgba(255,255,255,.55);
            z-index: 1;
        }
        .hero-tagline {
            font-family: var(--font-display);
            font-size: clamp(2.8rem, 7vw, 5.5rem);
            font-weight: 400;
            line-height: 1.05;
            letter-spacing: -.8px;
            color: #1a0000;
        }
        .hero-tagline .leadline {
            font-family: var(--font-hero-serif);
            font-weight: 700;
            font-size: .78em;
            letter-spacing: .2px;
            line-height: 1.15;
            color: #231f25;
        }
        .hero-tagline .accent {
            color: var(--red);
            position: relative;
            display: inline-block;
        }
        .hero-tagline .accent::after {
            content: '';
            position: absolute;
            left: 0; bottom: 4px;
            width: 100%; height: 5px;
            background: var(--purple);
            border-radius: 3px;
        }
        .hero-tagline .subline {
            font-family: var(--font-display);
            font-size: .88em;
            font-weight: 400;
            letter-spacing: -.3px;
            color: #222;
        }
        .hero-sub {
            font-size: 1.12rem;
            font-weight: 500;
            color: #2f2f2f;
            max-width: 620px;
            line-height: 1.8;
        }
        .hero-stat-divider {
            width: 1px;
            height: 50px;
            background: #bbb;
        }
        .btn-hero {
            background: #fff;
            color: var(--red);
            font-weight: 700;
            padding: .8rem 2rem;
            border-radius: 50px;
            font-size: 1rem;
            transition: all .3s;
        }
        .btn-hero:hover { background: var(--purple); color: #fff; transform: translateY(-2px); }
        .btn-hero-outline {
            border: 2px solid var(--red);
            color: var(--red);
            font-weight: 700;
            padding: .8rem 2rem;
            border-radius: 50px;
            background: transparent;
            font-size: 1rem;
            transition: all .3s;
        }
        .btn-hero-outline:hover { background: var(--red); color: #fff; }
        .hero-badge {
            display: inline-block;
            background: rgba(196,30,58,.12);
            border: 1px solid rgba(196,30,58,.35);
            backdrop-filter: blur(8px);
            color: var(--red);
            padding: .35rem 1rem;
            border-radius: 50px;
            font-size: .85rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .hero-img-card {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,.4);
        }
        .hero-img-card img { width: 100%; height: 420px; object-fit: cover; }

        /* ── MARQUEE ── */
        .marquee-bar {
            background: var(--purple);
            color: #fff;
            padding: .6rem 0;
            font-weight: 600;
            font-size: .9rem;
            overflow: hidden;
        }
        .marquee-inner { white-space: nowrap; animation: marquee 25s linear infinite; }
        @keyframes marquee { from { transform: translateX(100%); } to { transform: translateX(-100%); } }

        /* ── SECTIONS ── */
        .section-title {
            font-family: var(--font-display);
            font-size: 1.95rem;
            font-weight: 400;
            letter-spacing: .2px;
            color: var(--dark);
        }
        .section-line { width: 60px; height: 4px; background: var(--red); border-radius: 2px; margin: .5rem 0 1.5rem; }
        .section-subtitle { color: #666; font-size: 1rem; max-width: 600px; }

        /* ── PRODUCT CARDS ── */
        .prod-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,.08);
            overflow: hidden;
            transition: transform .3s, box-shadow .3s;
            height: 100%;
        }
        .prod-card:hover { transform: translateY(-6px); box-shadow: 0 12px 35px rgba(0,0,0,.15); }
        .prod-card .card-img-wrap {
            height: 200px;
            overflow: hidden;
            position: relative;
        }
        .prod-card .card-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
        .prod-card:hover .card-img-wrap img { transform: scale(1.07); }
        .prod-card .img-placeholder {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            font-size: 4rem;
            background: linear-gradient(135deg, #f9e4e6, #fce8e8);
        }
        .prod-type-badge {
            position: absolute; top: 12px; left: 12px;
            font-size: .72rem; font-weight: 700; padding: .3rem .75rem; border-radius: 50px;
        }
        .badge-rtd   { background: #1B5E20; color: #fff; }
        .badge-conc  { background: #8B0000; color: #fff; }
        .badge-tea   { background: #4A148C; color: #fff; }
        .prod-card .card-body { padding: 1.2rem; }
        .prod-card .prod-name { font-size: 1rem; font-weight: 700; color: #222; margin-bottom: .3rem; }
        .prod-card .prod-price {
            font-size: 1.3rem; font-weight: 800; color: var(--red);
        }
        .prod-card .prod-meta { font-size: .82rem; color: #888; }
        .prod-card .dilution-tag {
            display: inline-flex; align-items: center; gap: .3rem;
            background: #FFF3E0; color: #E65100;
            font-size: .75rem; font-weight: 600;
            padding: .25rem .7rem; border-radius: 50px;
            margin-top: .5rem;
        }
        .btn-order {
            background: var(--red); color: #fff;
            border: none; border-radius: 50px;
            padding: .5rem 1.5rem; font-weight: 600; font-size: .9rem;
            transition: all .3s; width: 100%; margin-top: .8rem;
        }
        .btn-order:hover { background: var(--dark); color: #fff; }

        /* ── BENEFITS ── */
        .benefits-section { background: var(--light); }
        .benefit-item {
            background: #fff;
            border-radius: 12px;
            padding: 1.2rem;
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
            transition: transform .2s;
        }
        .benefit-item:hover { transform: translateY(-3px); }
        .benefit-icon { font-size: 2rem; margin-bottom: .5rem; }

        /* ── DILUTION GUIDE ── */
        .dilution-section {
            background: linear-gradient(135deg, #f8d7de 0%, #f3c3cf 100%);
            color: #4b1020;
        }
        .dilution-card {
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 14px;
            padding: 1.5rem;
            text-align: center;
        }
        .dilution-arrow { font-size: 2rem; color: var(--purple); }
        .dilution-num { font-size: 2.5rem; font-weight: 800; color: var(--purple); }
        .dilution-price-badge {
            background: var(--purple);
            color: #fff;
        }

        /* ── GALLERY ── */
        .gallery-img {
            border-radius: 14px; overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,.12);
            height: 260px;
        }
        .gallery-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
        .gallery-img:hover img { transform: scale(1.05); }

        /* ── CTA ── */
        .cta-section {
            background: linear-gradient(135deg, var(--green) 0%, #2E7D32 100%);
            color: #fff;
        }

        .distributor-image-cta {
            display: block;
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            max-width: 680px;
            margin: 0 auto;
            box-shadow: 0 12px 28px rgba(0, 0, 0, .22);
            border: 2px solid rgba(255,255,255,.35);
            text-decoration: none;
        }

        .distributor-image-cta img {
            width: 100%;
            height: 210px;
            object-fit: cover;
            display: block;
            transition: transform .35s ease;
        }

        .distributor-image-cta:hover img {
            transform: scale(1.04);
        }

        .distributor-image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0,0,0,.15) 0%, rgba(0,0,0,.68) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: flex-start;
            padding: 1rem 1.2rem;
            color: #fff;
            text-align: left;
        }

        .distributor-image-title {
            font-weight: 800;
            font-size: 1.2rem;
            margin-bottom: .15rem;
        }

        .distributor-image-sub {
            font-size: .9rem;
            opacity: .95;
        }

        /* ── CONTACT ── */
        .contact-icon {
            width: 48px; height: 48px;
            background: var(--red); color: #fff;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; flex-shrink: 0;
        }

        /* ── FOOTER ── */
        footer { background: #111; color: #aaa; }
        footer a { color: #ccc; text-decoration: none; }
        footer a:hover { color: #fff; }
        .footer-brand { font-size: 1.5rem; font-weight: 800; color: #fff; }

        /* ── SCROLL TOP ── */
        #scrollTop {
            position: fixed; bottom: 24px; right: 24px; z-index: 999;
            background: var(--red); color: #fff;
            width: 44px; height: 44px; border-radius: 50%; border: none;
            font-size: 1.1rem; display: none; align-items: center; justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,.3); cursor: pointer;
        }
        #scrollTop:hover { background: var(--dark); }

        @media (max-width: 991.98px) {
            .hero { min-height: 84vh; }
            .prod-card .card-img-wrap { height: 180px; }
            .gallery-img { height: 220px; }
        }

        @media (max-width: 767.98px) {
            .hero { min-height: auto; padding: 3.5rem 0 2.5rem; }
            .hero-tagline {
                font-size: clamp(2.1rem, 10.5vw, 3.2rem);
                line-height: 1.1;
                letter-spacing: -0.3px;
            }
            .hero-sub {
                font-size: 0.98rem;
                line-height: 1.65;
                max-width: 100%;
            }
            .btn-hero,
            .btn-hero-outline {
                width: 100%;
                max-width: 280px;
                justify-content: center;
            }
            .hero-stat-divider { display: none; }
            .prod-card .card-img-wrap { height: 170px; }
            .gallery-img { height: 200px; }
            .section-title { font-size: 1.55rem; }
        }
    </style>
</head>
<body>

<!-- ── NAVBAR ──────────────────────────────────────────────── -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-proden sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="fas fa-leaf me-2"></i>Proden
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto gap-1">
                <li class="nav-item"><a class="nav-link active" href="#hero">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#products">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('distributor.apply') }}">Become a Distributor</a></li>
                <li class="nav-item"><a class="nav-link" href="#benefits">Benefits</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
            </ul>
            <ul class="navbar-nav align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-cart me-1"></i>Cart
                    </a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-light btn-sm px-3 fw-600 text-danger" href="{{ route('shop.products') }}">
                        <i class="fas fa-store me-1"></i>Shop Now
                    </a>
                </li>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i>Admin
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link text-white p-0">Logout</button>
                        </form>
                    </li>
                @else
                    {{-- <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li> --}}
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- ── HERO ────────────────────────────────────────────────── -->
<section class="hero" id="hero">
    @if(session('success'))
        <div class="container pt-3" style="z-index:3; position:relative;">
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif
    <!-- Background video -->
    <video class="hero-video" autoplay muted loop playsinline poster="{{ asset('images/product1.jpeg') }}">
        <source src="{{ asset('images/advert.mp4') }}" type="video/mp4">
    </video>
    <div class="hero-overlay"></div>
    <div class="container position-relative py-5" style="z-index:2;">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9 text-center">

                <!-- badge -->
                <div class="d-inline-flex align-items-center gap-2 mb-4"
                     style="background:rgba(255,255,255,.8); border:1.5px solid var(--red); border-radius:50px; padding:.4rem 1.3rem; font-size:.85rem; font-weight:600; color:var(--red);">
                    <i class="fas fa-leaf"></i>
                    100% Natural &nbsp;&bull;&nbsp; Made in Uganda
                </div>

                <!-- headline -->
                <h1 class="hero-tagline mb-4">
                    <span class="leadline">Produced from pure</span><br>
                    <span class="accent">Hibiscus &amp; Passion</span><br>
                    <span class="subline">Drinks for Every Occasion</span>
                </h1>

                <!-- sub -->
                <p class="hero-sub mx-auto mb-5">
                    Premium non-carbonated drinks by <strong>Proden Distribution Co. Ltd</strong>.
                    Ready-to-drink bottles and concentrate jerrycans &mdash; straight from Nakawa, Uganda.
                </p>

                <!-- CTA buttons -->
                <div class="d-flex justify-content-center flex-wrap gap-3 mb-5">
                    <a href="{{ route('shop.products') }}" class="btn-hero">
                        <i class="fas fa-shopping-bag me-2"></i>Order Now
                    </a>
                    <a href="#products" class="btn-hero-outline">
                        <i class="fas fa-list me-2"></i>View Products
                    </a>
                </div>

                <!-- stats -->
                <div class="d-flex justify-content-center align-items-center flex-wrap gap-4">
                    <div class="text-center">
                        <div style="font-size:2.2rem; font-weight:900; color:var(--red); line-height:1;">7+</div>
                        <div style="font-size:.8rem; color:#555; font-weight:500; margin-top:.25rem;">Product Variants</div>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div class="text-center">
                        <div style="font-size:2.2rem; font-weight:900; color:var(--red); line-height:1;">100%</div>
                        <div style="font-size:.8rem; color:#555; font-weight:500; margin-top:.25rem;">Natural Ingredients</div>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div class="text-center">
                        <div style="font-size:2.2rem; font-weight:900; color:var(--red); line-height:1;">2</div>
                        <div style="font-size:.8rem; color:#555; font-weight:500; margin-top:.25rem;">Flavour Lines</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- ── MARQUEE ──────────────────────────────────────────────── -->
<div class="marquee-bar">
    <div class="marquee-inner">
        &nbsp;&nbsp;🌺 Hibiscus Ready-to-Drink 300ml &bull;
        🌺 Hibiscus Ready-to-Drink 500ml &bull;
        🥤 Hibiscus Concentrate 1L &bull;
        🥤 Hibiscus Concentrate 5L (With Sugar) &bull;
        ✅ Sugar-Free Hibiscus Concentrate 5L &bull;
        🍈 Passion Concentrate 1L &bull;
        🍵 Hibiscus Petal Tea 200g &bull;
        &nbsp;&nbsp;🌺 Hibiscus Ready-to-Drink 300ml &bull;
        🌺 Hibiscus Ready-to-Drink 500ml &bull;
        🥤 Hibiscus Concentrate 1L &bull;
        🥤 Hibiscus Concentrate 5L (With Sugar) &bull;
        ✅ Sugar-Free Hibiscus Concentrate 5L &bull;
        🍈 Passion Concentrate 1L &bull;
        🍵 Hibiscus Petal Tea 200g &bull;
    </div>
</div>

<!-- ── PRODUCTS ─────────────────────────────────────────────── -->
<section class="py-5" id="products">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-danger fw-600 mb-1 text-uppercase" style="letter-spacing:2px; font-size:.85rem;">Our Range</p>
            <h2 class="section-title">Product Catalogue</h2>
            <div class="section-line mx-auto"></div>
            <p class="section-subtitle mx-auto">
                All our drinks are processed from fresh natural Hibiscus and Passion fruits.
                Available as ready-to-drink and concentrated (dilute to drink).
            </p>
        </div>

        <!-- ── Ready to Drink ── -->
        <h5 class="fw-700 mb-3 text-success"><i class="fas fa-bottle-water me-2"></i>Ready to Drink</h5>
        <div class="row g-4 mb-5">
            @foreach($featuredProducts->get('Ready to Drink', collect()) as $product)
            <div class="col-sm-6 col-lg-4">
                <div class="prod-card card h-100">
                    <div class="card-img-wrap">
                        @if($product->image)
                            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <div class="img-placeholder" style="background:linear-gradient(135deg,#fce4ec,#f8bbd9);">🌺</div>
                        @endif
                        <span class="prod-type-badge badge-rtd">Ready to Drink</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="prod-name">🌺 {{ $product->name }}</div>
                        <div class="prod-meta mb-2">{{ $product->description }}</div>
                        <div class="prod-price">UGX {{ number_format($product->price, 0) }}</div>
                        <a href="{{ route('shop.products') }}" class="btn-order mt-auto">
                            <i class="fas fa-shopping-cart me-1"></i>Order Now
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- ── Concentrates ── -->
        <h5 class="fw-700 mb-3 text-danger"><i class="fas fa-flask me-2"></i>Concentrates <small class="text-muted fw-400 fs-6">(dilute before drinking)</small></h5>
        <div class="row g-4 mb-5">
            @foreach($featuredProducts->get('Concentrates', collect()) as $product)
            <div class="col-sm-6 col-lg-4">
                <div class="prod-card card h-100">
                    <div class="card-img-wrap">
                        @if($product->image)
                            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <div class="img-placeholder" style="background:linear-gradient(135deg,#e8f5e9,#c8e6c9);">🧴</div>
                        @endif
                        <span class="prod-type-badge badge-conc">Concentrate</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="prod-name">{{ $product->name }}</div>
                        <div class="prod-meta mb-2">{{ $product->description }}</div>
                        <div class="prod-price">UGX {{ number_format($product->price, 0) }}</div>
                        <a href="{{ route('shop.products') }}" class="btn-order mt-auto">
                            <i class="fas fa-shopping-cart me-1"></i>Order Now
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- ── Herbal Tea ── -->
            @foreach($featuredProducts->get('Herbal Tea', collect()) as $product)
            <div class="col-sm-6 col-lg-4">
                <div class="prod-card card h-100">
                    <div class="card-img-wrap">
                        @if($product->image)
                            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <div class="img-placeholder" style="background:linear-gradient(135deg,#EDE7F6,#D1C4E9);">🍵</div>
                        @endif
                        <span class="prod-type-badge badge-tea">Hibiscus Tea</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="prod-name">🍵 {{ $product->name }}</div>
                        <div class="prod-meta mb-2">{{ $product->description }}</div>
                        <div class="prod-price">UGX {{ number_format($product->price, 0) }}</div>
                        <a href="{{ route('shop.products') }}" class="btn-order mt-auto">
                            <i class="fas fa-shopping-cart me-1"></i>Order Now
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

<!-- ── DILUTION GUIDE ────────────────────────────────────────── -->
<section class="dilution-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-800 mb-2" style="color:var(--purple)">How to Use Concentrates</h2>
            <p class="opacity-85 mb-0">Our concentrates give you great value — just add water!</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="dilution-card">
                    <div class="dilution-num">1L</div>
                    <div class="mb-2 opacity-80">Hibiscus / Passion Concentrate</div>
                    <div class="dilution-arrow">↓ + 2L water</div>
                    <div class="dilution-num mt-2">3L</div>
                    <div class="opacity-80">Ready to Drink Juice</div>
                    <div class="mt-3 badge dilution-price-badge">Hibiscus 1L · UGX 10,000</div>
                    <div class="mt-1 badge dilution-price-badge">Passion 1L · UGX 20,000</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dilution-card">
                    <div class="dilution-num">5L</div>
                    <div class="mb-2 opacity-80">Hibiscus Concentrate</div>
                    <div class="dilution-arrow">↓ + 10L water</div>
                    <div class="dilution-num mt-2">15L</div>
                    <div class="opacity-80">Ready to Drink Juice</div>
                    <div class="mt-3 badge dilution-price-badge">Hibiscus 5L · UGX 50,000</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dilution-card">
                    <i class="fas fa-info-circle fa-2x mb-3 opacity-80"></i>
                    <h6 class="fw-700">Tip for best taste</h6>
                    <ul class="text-start opacity-85 small ps-3">
                        <li class="mb-2">Chill the water before mixing for a more refreshing drink.</li>
                        <li class="mb-2">You can adjust the dilution ratio to your preferred taste.</li>
                        <li>Concentrates are packed in convenient sealed jerrycans for easy storage.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── BENEFITS ─────────────────────────────────────────────── -->
<section class="benefits-section py-5" id="benefits">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-danger fw-600 mb-1 text-uppercase" style="letter-spacing:2px; font-size:.85rem;">Why Hibiscus?</p>
            <h2 class="section-title">Health Benefits of Hibiscus</h2>
            <div class="section-line mx-auto"></div>
            <p class="section-subtitle mx-auto">
                Hibiscus is packed with nature's goodness — enjoy great taste while doing your body good.
            </p>
        </div>
        <div class="row g-4">
            @php
                $benefits = [
                    ['icon'=>'❤️',  'title'=>'Heart Healthy',      'desc'=>'May help lower blood pressure and improve blood fat levels.'],
                    ['icon'=>'🦠',  'title'=>'Fights Bacteria',    'desc'=>'Could help decrease the growth of bacteria that cause infections.'],
                    ['icon'=>'🛡️',  'title'=>'Boosts Immunity',    'desc'=>'Rich in antioxidants that support a strong immune system.'],
                    ['icon'=>'🍀',  'title'=>'Liver Health',       'desc'=>'May help boost liver health and protect it from damage.'],
                    ['icon'=>'🌸',  'title'=>'Antioxidant Rich',   'desc'=>'Packed with antioxidants that combat free radicals.'],
                    ['icon'=>'🌿',  'title'=>'Menstrual Relief',   'desc'=>'Traditionally used for relief of menstrual cramps.'],
                ];
            @endphp
            @foreach($benefits as $b)
                <div class="col-sm-6 col-lg-4">
                    <div class="benefit-item d-flex gap-3 align-items-start">
                        <div class="benefit-icon">{{ $b['icon'] }}</div>
                        <div>
                            <div class="fw-700 mb-1">{{ $b['title'] }}</div>
                            <div class="text-muted small">{{ $b['desc'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ── GALLERY ───────────────────────────────────────────────── -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Our Products in Pictures</h2>
            <div class="section-line mx-auto"></div>
        </div>
        <div class="row g-3">
            <div class="col-md-6 col-lg">
                <div class="gallery-img"><img src="{{ asset('images/product1.jpeg') }}" alt="Proden Products"></div>
            </div>
            <div class="col-md-6 col-lg">
                <div class="gallery-img"><img src="{{ asset('images/300.jpeg') }}" alt="300ml &amp; 500ml Bottles"></div>
            </div>
            <div class="col-md-6 col-lg">
                <div class="gallery-img"><img src="{{ asset('images/5liters.jpeg') }}" alt="5L Container"></div>
            </div>
            <div class="col-md-6 col-lg">
                <div class="gallery-img"><img src="{{ asset('images/concetrated.jpg') }}" alt="Concentrated Drink"></div>
            </div>
            <div class="col-md-6 col-lg">
                <div class="gallery-img"><img src="{{ asset('images/deliver1.jpg') }}" alt="Proden Delivery Truck"></div>
            </div>
        </div>
    </div>
</section>

<!-- ── CTA ──────────────────────────────────────────────────── -->
<section class="cta-section py-5 text-center">
    <div class="container py-3">
        <h2 class="fw-800 mb-3" style="font-size:clamp(1.6rem,4vw,2.5rem)">
            Ready to Order? We Deliver!
        </h2>
        <p class="opacity-85 mb-4 mx-auto" style="max-width:500px">
            Browse our full range, add to cart, and pay securely via Mobile Money.
            Fast delivery to your door.
        </p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('shop.products') }}" class="btn btn-light btn-lg px-5 fw-700 text-danger shadow">
                <i class="fas fa-shopping-bag me-2"></i>Shop the Full Range
            </a>
        </div>

        <div class="mt-4">
            <a href="{{ route('distributor.apply') }}" class="distributor-image-cta" aria-label="Become a Proden distributor">
                <img src="{{ asset('images/share.jpg') }}" alt="Join Proden distributors">
                <div class="distributor-image-overlay">
                    <div class="distributor-image-title"><i class="fas fa-user-tie me-2"></i>Become a Distributor</div>
                    <div class="distributor-image-sub">Grow with Proden in your area. Tap here to apply.</div>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- ── CONTACT ───────────────────────────────────────────────── -->
<section class="py-5 bg-white" id="contact">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Get in Touch</h2>
            <div class="section-line mx-auto"></div>
        </div>
        <div class="row justify-content-center g-4">
            <div class="col-md-4">
                <div class="d-flex gap-3 align-items-start p-3 rounded-3 bg-light h-100">
                    <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <div class="fw-700 mb-1">Our Location</div>
                        <div class="text-muted small">Plot 42A Mukabya Road,<br>Nakawa Industrial Area, Kampala</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex gap-3 align-items-start p-3 rounded-3 bg-light h-100">
                    <div class="contact-icon"><i class="fas fa-phone"></i></div>
                    <div>
                        <div class="fw-700 mb-1">Call / WhatsApp</div>
                        <div class="text-muted small">
                            +256 772 494618<br>+256 772 163703
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex gap-3 align-items-start p-3 rounded-3 bg-light h-100">
                    <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <div class="fw-700 mb-1">Email</div>
                        <div class="text-muted small">p.nambuya@prodendistribution.com</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex gap-3 align-items-start p-3 rounded-3 bg-light h-100">
                    <div class="contact-icon"><i class="fas fa-clock"></i></div>
                    <div>
                        <div class="fw-700 mb-1">Working Hours</div>
                        <div class="text-muted small">
                            Monday – Friday: 8am – 6pm<br>
                            Saturday: 9am – 4pm
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── FOOTER ────────────────────────────────────────────────── -->
<footer class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="footer-brand mb-2"><i class="fas fa-leaf me-2 text-danger"></i>Proden</div>
                <p class="small">Proden Distribution Co. Ltd — crafting premium natural drinks from Uganda's finest Hibiscus and Passion fruits since day one.</p>
            </div>
            <div class="col-md-4">
                <h6 class="text-white fw-700 mb-3">Products</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('shop.products') }}">🌺 Hibiscus Ready-to-Drink</a></li>
                    <li><a href="{{ route('shop.products') }}">🥤 Hibiscus Concentrate</a></li>
                    <li><a href="{{ route('shop.products') }}">🍈 Passion Concentrate</a></li>
                    <li><a href="{{ route('shop.products') }}">✅ Sugar-Free Hibiscus</a></li>
                    <li><a href="{{ route('shop.products') }}">🍵 Hibiscus Petal Tea</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="text-white fw-700 mb-3">Contact</h6>
                <ul class="list-unstyled small">
                    <li class="mb-1"><i class="fas fa-map-marker-alt me-2 text-danger"></i>Plot 42A Mukabya Road, Nakawa</li>
                    <li class="mb-1"><i class="fas fa-phone me-2 text-danger"></i>+256 772 494618</li>
                    <li><i class="fas fa-phone me-2 text-danger"></i>+256 772 163703</li>
                    <li class="mt-1"><i class="fas fa-envelope me-2 text-danger"></i>p.nambuya@prodendistribution.com</li>
                </ul>
            </div>
        </div>
        <hr style="border-color:#333; margin-top:2rem;">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <p class="mb-0 small">© {{ date('Y') }} Proden Distribution Co. Ltd. All rights reserved.</p>
            <p class="mb-0 small">Quality Natural Drinks from Uganda 🇺🇬</p>
        </div>
    </div>
</footer>

<!-- Scroll to top -->
<button id="scrollTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <i class="fas fa-chevron-up"></i>
</button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); }
        });
    });

    // Scroll-to-top button
    const btn = document.getElementById('scrollTop');
    window.addEventListener('scroll', () => {
        btn.style.display = window.scrollY > 400 ? 'flex' : 'none';
    });
</script>
</body>
</html>
