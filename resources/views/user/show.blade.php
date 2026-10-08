@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Detail User</h1>
        <p class="page-subtitle">Informasi lengkap akun pengguna</p>
    </div>
    <a href="{{ route('user.index') }}" class="btn-secondary-custom">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card-custom" style="margin-bottom:20px;">
    <div class="row g-4">
        <div class="col-md-3 text-center">
            <div style="width:100px; height:100px; border-radius:50%; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color:white; display:flex; align-items:center; justify-content:center; font-size:2.5rem; font-weight:800; margin: 0 auto; box-shadow: 0 12px 32px rgba(16,185,129,0.3);">
                {{ strtoupper(substr($user->nama, 0, 1)) }}
            </div>
        </div>
        <div class="col-md-9">
            <h2 style="font-weight:800; letter-spacing:-0.02em; margin-bottom:8px;">{{ $user->nama }}</h2>
            <div style="font-family:'Courier New', monospace; color:#64748b; margin-bottom:16px;">@{{ $user->username }}</div>

            <div style="display:flex; gap:10px; margin-bottom:20px;">
                @if($user->role === 'admin')
                    <span class="badge-custom badge-success"><i class="bi bi-shield-lock"></i> Admin</span>
                @elseif($user->role === 'kasir')
                    <span class="badge-custom badge-info"><i class="bi bi-person-badge"></i> Kasir</span>
                @else
                    <span class="badge-custom badge-purple"><i class="bi bi-person-vcard"></i> Pemilik</span>
                @endif

                @if($user->status === 'aktif')
                    <span class="badge-custom badge-success"><i class="bi bi-check-circle-fill"></i> Aktif</span>
                @else
                    <span class="badge-custom badge-danger"><i class="bi bi-x-circle-fill"></i> Nonaktif</span>
                @endif
            </div>

            <div style="color:#64748b; font-size:0.85rem;">
                <i class="bi bi-calendar3"></i> Terdaftar {{ $user->created_at->format('d F Y') }}
            </div>
        </div>
    </div>
</div>

@if($user->role === 'kasir')
<div class="row g-3">
    <div class="col-md-6">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="bi bi-receipt"></i></div>
            <div>
                <div class="stat-label">Total Transaksi</div>
                <div class="stat-value">{{ $total_transaksi }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="stat-card">
            <div class="stat-icon warning"><i class="bi bi-cash-stack"></i></div>
            <div>
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-value small">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection