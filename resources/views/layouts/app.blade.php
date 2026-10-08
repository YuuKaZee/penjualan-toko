<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Penjualan Toko')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

{{-- ============ TOP NAVBAR ============ --}}
<nav class="top-navbar">
    <a href="/dashboard" class="brand">
        <div class="brand-icon">🛒</div>
        <div>
            <div style="line-height:1.1;">Penjualan Toko</div>
            <small style="font-weight:500; font-size:0.7rem; opacity:0.9;">Point of Sale System</small>
        </div>
    </a>

    <div class="user-info">
        <div style="text-align:right;">
            <div class="user-name">{{ Auth::user()->nama ?? '' }}</div>
            <div class="user-role">{{ ucfirst(Auth::user()->role ?? '') }}</div>
        </div>
        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->nama ?? 'A', 0, 1)) }}</div>
        <form action="/logout" method="POST" style="margin:0;">
            @csrf
            <button class="btn-logout">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</nav>

{{-- ============ LAYOUT ============ --}}
<div class="app-wrapper">
    <aside class="sidebar" id="sidebar">
        @include('layouts.sidebar')
    </aside>

    <main class="main-content">
        @if(session('success'))
            <div class="alert-custom alert-success-custom">
                <i class="bi bi-check-circle-fill" style="font-size:1.2rem;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-custom alert-danger-custom">
                <i class="bi bi-exclamation-triangle-fill" style="font-size:1.2rem;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>