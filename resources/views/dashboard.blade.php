@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Halo, {{ $user->nama }} 👋</h1>
        <p class="page-subtitle">Selamat datang di Dashboard {{ ucfirst($user->role) }}</p>
    </div>
    <div style="font-size:0.85rem; color:#64748b;">
        <i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
    </div>
</div>

{{-- ==================== DASHBOARD ADMIN ==================== --}}
@if($user->role === 'admin')
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="bi bi-box-seam"></i></div>
            <div>
                <div class="stat-label">Total Produk</div>
                <div class="stat-value">{{ $total_produk }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon info"><i class="bi bi-receipt"></i></div>
            <div>
                <div class="stat-label">Total Transaksi</div>
                <div class="stat-value">{{ $total_transaksi }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon warning"><i class="bi bi-tags"></i></div>
            <div>
                <div class="stat-label">Kategori</div>
                <div class="stat-value">{{ $total_kategori }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="bi bi-people"></i></div>
            <div>
                <div class="stat-label">Pengguna</div>
                <div class="stat-value">{{ $total_user }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="bi bi-cash-stack"></i></div>
            <div>
                <div class="stat-label">Pendapatan Total</div>
                <div class="stat-value small">Rp {{ number_format($pendapatan_total, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="stat-card">
            <div class="stat-icon info"><i class="bi bi-graph-up-arrow"></i></div>
            <div>
                <div class="stat-label">Pendapatan Hari Ini</div>
                <div class="stat-value small">Rp {{ number_format($pendapatan_hari_ini, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ==================== DASHBOARD KASIR ==================== --}}
@if($user->role === 'kasir')
<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="bi bi-receipt-cutoff"></i></div>
            <div>
                <div class="stat-label">Transaksi Saya</div>
                <div class="stat-value">{{ $transaksi_saya }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon warning"><i class="bi bi-cash-stack"></i></div>
            <div>
                <div class="stat-label">Pendapatan Saya</div>
                <div class="stat-value small">Rp {{ number_format($pendapatan_saya, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon info"><i class="bi bi-calendar-check"></i></div>
            <div>
                <div class="stat-label">Transaksi Hari Ini</div>
                <div class="stat-value">{{ $transaksi_hari_ini }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card-custom text-center" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none;">
    <i class="bi bi-cart-plus" style="font-size: 3rem;"></i>
    <h4 style="margin: 16px 0 8px; font-weight: 800;">Siap Melayani Pelanggan?</h4>
    <p style="opacity: 0.9; margin-bottom: 20px;">Mulai transaksi baru sekarang</p>
    <a href="/transaksi/create" style="background: white; color: #059669; padding: 12px 28px; border-radius: 12px; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
        <i class="bi bi-plus-circle-fill"></i> Transaksi Baru
    </a>
</div>
@endif

{{-- ==================== DASHBOARD PEMILIK ==================== --}}
@if($user->role === 'pemilik')
<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="bi bi-cash-stack"></i></div>
            <div>
                <div class="stat-label">Pendapatan Hari Ini</div>
                <div class="stat-value small">Rp {{ number_format($pendapatan_hari_ini, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon info"><i class="bi bi-receipt"></i></div>
            <div>
                <div class="stat-label">Total Transaksi</div>
                <div class="stat-value">{{ $total_transaksi }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon danger"><i class="bi bi-exclamation-triangle"></i></div>
            <div>
                <div class="stat-label">Stok Rendah</div>
                <div class="stat-value">{{ $produk_stok_rendah }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card-custom">
    <h5 style="font-weight:800; margin-bottom:16px;"><i class="bi bi-trophy-fill" style="color:#f59e0b;"></i> Produk Terlaris</h5>
    @forelse($produk_terlaris as $i => $p)
        <div style="display:flex; align-items:center; gap:12px; padding:12px; border-bottom:1px solid #f1f5f9;">
            <div style="width:32px; height:32px; background: linear-gradient(135deg,#10b981,#059669); color:white; border-radius:10px; display:flex; align-items:center; justify-content:center; font-weight:800;">
                {{ $i+1 }}
            </div>
            <div style="flex:1;">
                <div style="font-weight:700;">{{ $p->nama_produk }}</div>
                <div style="font-size:0.8rem; color:#64748b;">{{ $p->detail_transaksis_count }}x terjual</div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>Belum ada penjualan</p>
        </div>
    @endforelse
</div>
@endif

{{-- ==================== TRANSAKSI TERBARU ==================== --}}
<div style="margin-top: 24px;">
    <h5 style="font-weight:800; margin-bottom:16px;"><i class="bi bi-clock-history"></i> 5 Transaksi Terbaru</h5>

    @if($transaksi_terbaru->count() > 0)
        <div class="table-wrapper">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi_terbaru as $i => $t)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>
                            <span style="font-family: 'Courier New', monospace; font-weight:700; color:#059669;">
                                {{ $t->kode_transaksi }}
                            </span>
                        </td>
                        <td>{{ $t->kasir->nama ?? '-' }}</td>
                        <td><strong>Rp {{ number_format($t->total, 0, ',', '.') }}</strong></td>
                        <td>{{ $t->tanggal_transaksi ? \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="card-custom">
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <p>Belum ada transaksi</p>
            </div>
        </div>
    @endif
</div>

@endsection