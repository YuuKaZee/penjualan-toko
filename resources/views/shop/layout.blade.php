<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Online')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .shop-navbar {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            padding: 14px 28px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 12px rgba(6, 95, 70, 0.15);
        }
        .shop-navbar .container-shop {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 24px;
        }
        .shop-logo {
            color: white;
            font-weight: 800;
            font-size: 1.2rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }
        .shop-logo-icon {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        .shop-search {
            flex: 1;
            max-width: 500px;
            position: relative;
        }
        .shop-search input {
            width: 100%;
            padding: 10px 16px 10px 44px;
            border: none;
            border-radius: 11px;
            font-size: 0.85rem;
            background: rgba(255,255,255,0.95);
            font-family: inherit;
        }
        .shop-search input:focus { outline: 2px solid rgba(255,255,255,0.5); }
        .shop-search i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }
        .shop-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
        }
        .shop-icon-btn {
            color: white;
            text-decoration: none;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            background: rgba(255,255,255,0.1);
            transition: all 0.2s;
            position: relative;
        }
        .shop-icon-btn:hover { background: rgba(255,255,255,0.2); color: white; }
        .shop-cart-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #fbbf24;
            color: #78350f;
            font-size: 0.68rem;
            font-weight: 800;
            min-width: 20px;
            height: 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
            border: 2px solid #047857;
        }
        .shop-hero {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            padding: 56px 28px;
            text-align: center;
        }
        .shop-hero h1 {
            font-weight: 800;
            font-size: 2.4rem;
            color: #064e3b;
            margin-bottom: 12px;
            letter-spacing: -0.03em;
        }
        .shop-hero p {
            color: #047857;
            font-size: 1.05rem;
            margin-bottom: 0;
        }
        .shop-body {
            max-width: 1280px;
            margin: 0 auto;
            padding: 40px 28px;
        }
        .product-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            transition: all 0.25s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(15,23,42,0.1);
            border-color: #cbd5e1;
        }
        .product-img-wrap {
            aspect-ratio: 1;
            background: #f8fafc;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .product-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }
        .product-card:hover .product-img-wrap img { transform: scale(1.05); }
        .product-no-img {
            color: #cbd5e1;
            font-size: 3rem;
        }
        .product-info { padding: 16px; flex: 1; display: flex; flex-direction: column; }
        .product-name {
            font-weight: 700;
            font-size: 0.92rem;
            color: #0f172a;
            margin-bottom: 8px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 2.6em;
        }
        .product-price {
            font-weight: 800;
            color: #059669;
            font-size: 1.1rem;
            margin-top: auto;
            letter-spacing: -0.02em;
        }
        .product-stock {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 4px;
        }
        .shop-footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 30px 28px;
            text-align: center;
            font-size: 0.85rem;
            margin-top: 60px;
        }
    </style>
</head>
<body style="background:#f1f5f9;">

<nav class="shop-navbar">
    <div class="container-shop">
        <a href="{{ route('shop.index') }}" class="shop-logo">
            <div class="shop-logo-icon">🛒</div>
            <div style="line-height:1.1;">
                <div>Toko Online</div>
                <small style="font-weight:500; font-size:0.68rem; opacity:0.85;">Belanja Mudah & Cepat</small>
            </div>
        </a>

        <form action="{{ route('shop.index') }}" method="GET" class="shop-search">
            <i class="bi bi-search"></i>
            <input type="text" name="q" placeholder="Cari produk..." value="{{ request('q') }}">
        </form>

        <div class="shop-actions">
            <a href="{{ route('shop.track') }}" class="shop-icon-btn" title="Lacak Pesanan">
                <i class="bi bi-geo-alt"></i>
            </a>
            <a href="{{ route('shop.cart') }}" class="shop-icon-btn" title="Keranjang">
                <i class="bi bi-cart3"></i>
                @if(($cart_count ?? 0) > 0)
                    <span class="shop-cart-badge">{{ $cart_count }}</span>
                @endif
            </a>
            <a href="{{ route('login') }}" class="shop-icon-btn" title="Login Staf">
                <i class="bi bi-person"></i>
            </a>
        </div>
    </div>
</nav>

@yield('content')

<footer class="shop-footer">
    <div>© {{ date('Y') }} Toko Online — Sistem Penjualan Terintegrasi</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>