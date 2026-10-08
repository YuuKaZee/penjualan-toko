@php $role = Auth::user()->role ?? ''; @endphp

{{-- ==================== ADMIN ==================== --}}
@if($role === 'admin')
    <div class="sidebar-title">Utama</div>
    <a href="/dashboard" class="nav-item-custom {{ request()->is('dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="sidebar-title">Master Data</div>
    <a href="/user" class="nav-item-custom {{ request()->is('user*') ? 'active' : '' }}">
        <i class="bi bi-people"></i> Data Pengguna
    </a>
    <a href="/kategori" class="nav-item-custom {{ request()->is('kategori*') ? 'active' : '' }}">
        <i class="bi bi-tags"></i> Data Kategori
    </a>
    <a href="/produk" class="nav-item-custom {{ request()->is('produk*') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i> Data Produk
    </a>

    <div class="sidebar-title">Transaksi</div>
    <a href="/transaksi" class="nav-item-custom {{ request()->is('transaksi') || request()->is('transaksi/*') && !request()->is('transaksi/create') ? 'active' : '' }}">
        <i class="bi bi-receipt"></i> Data Transaksi
    </a>
    <a href="/orders" class="nav-item-custom {{ request()->is('orders*') ? 'active' : '' }}">
        <i class="bi bi-bag-check"></i> Pesanan Online
    </a>

    <div class="sidebar-title">Lainnya</div>
    <a href="/laporan" class="nav-item-custom {{ request()->is('laporan*') ? 'active' : '' }}">
        <i class="bi bi-bar-chart"></i> Laporan
    </a>
    <a href="/log" class="nav-item-custom {{ request()->is('log*') ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i> Log Aktivitas
    </a>
@endif

{{-- ==================== KASIR ==================== --}}
@if($role === 'kasir')
    <div class="sidebar-title">Utama</div>
    <a href="/dashboard" class="nav-item-custom {{ request()->is('dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="sidebar-title">Kasir</div>
    <a href="/transaksi/create" class="nav-item-custom {{ request()->is('transaksi/create') ? 'active' : '' }}">
        <i class="bi bi-cart-plus"></i> Transaksi Baru
    </a>
    <a href="/transaksi" class="nav-item-custom {{ request()->is('transaksi') ? 'active' : '' }}">
        <i class="bi bi-receipt"></i> Riwayat Transaksi
    </a>
    <a href="/orders" class="nav-item-custom {{ request()->is('orders*') ? 'active' : '' }}">
        <i class="bi bi-bag-check"></i> Pesanan Online
    </a>

    <div class="sidebar-title">Katalog</div>
    <a href="/produk" class="nav-item-custom {{ request()->is('produk*') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i> Data Produk
    </a>

    <div class="sidebar-title">Lainnya</div>
    <a href="/laporan" class="nav-item-custom {{ request()->is('laporan*') ? 'active' : '' }}">
        <i class="bi bi-bar-chart"></i> Laporan
    </a>
@endif

{{-- ==================== PEMILIK ==================== --}}
@if($role === 'pemilik')
    <div class="sidebar-title">Utama</div>
    <a href="/dashboard" class="nav-item-custom {{ request()->is('dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="sidebar-title">Monitoring</div>
    <a href="/produk" class="nav-item-custom {{ request()->is('produk*') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i> Data Produk
    </a>
    <a href="/transaksi" class="nav-item-custom {{ request()->is('transaksi*') ? 'active' : '' }}">
        <i class="bi bi-receipt"></i> Data Transaksi
    </a>
    <a href="/orders" class="nav-item-custom {{ request()->is('orders*') ? 'active' : '' }}">
        <i class="bi bi-bag-check"></i> Pesanan Online
    </a>

    <div class="sidebar-title">Lainnya</div>
    <a href="/laporan" class="nav-item-custom {{ request()->is('laporan*') ? 'active' : '' }}">
        <i class="bi bi-bar-chart"></i> Laporan
    </a>
@endif