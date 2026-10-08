@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Detail Produk</h1>
        <p class="page-subtitle">Informasi lengkap produk</p>
    </div>
    <a href="{{ route('produk.index') }}" class="btn-secondary-custom">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card-custom">
    <div class="row g-4">
        <div class="col-md-4">
            @if($produk->gambar)
                <img src="{{ asset('produk_images/' . $produk->gambar) }}"
                     style="width:100%; border-radius:16px; box-shadow: 0 8px 24px rgba(0,0,0,0.08);">
            @else
                <div style="height:280px; background:#f1f5f9; border-radius:16px; display:flex; align-items:center; justify-content:center; flex-direction:column; gap:8px; color:#94a3b8;">
                    <i class="bi bi-image" style="font-size:3rem;"></i>
                    <span style="font-size:0.85rem;">Tidak ada gambar</span>
                </div>
            @endif
        </div>

        <div class="col-md-8">
            <span class="badge-custom badge-info" style="margin-bottom:12px;">
                {{ $produk->kategori->nama_kategori ?? '-' }}
            </span>

            <h2 style="font-weight:800; margin-bottom:16px; letter-spacing:-0.02em;">{{ $produk->nama_produk }}</h2>

            <div style="font-family:'Courier New', monospace; color:#64748b; font-size:0.85rem; margin-bottom:20px;">
                Kode: {{ $produk->kode_produk }}
            </div>

            <div style="background:#f8fafc; padding:20px; border-radius:14px; margin-bottom:20px;">
                <div style="display:flex; justify-content:space-between; margin-bottom:14px;">
                    <span style="color:#64748b; font-weight:600;">Harga</span>
                    <span style="font-weight:800; font-size:1.3rem; color:#059669;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span style="color:#64748b; font-weight:600;">Stok Tersedia</span>
                    <span>
                        @if($produk->stok < 10)
                            <span class="badge-custom badge-danger"><i class="bi bi-exclamation-triangle-fill"></i> {{ $produk->stok }} (rendah)</span>
                        @else
                            <span class="badge-custom badge-success"><i class="bi bi-check-circle-fill"></i> {{ $produk->stok }} unit</span>
                        @endif
                    </span>
                </div>
            </div>

            <div>
                <div style="font-weight:700; margin-bottom:8px; color:#334155;">Deskripsi</div>
                <p style="color:#64748b; line-height:1.6;">{{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
            </div>
        </div>
    </div>
</div>

@endsection