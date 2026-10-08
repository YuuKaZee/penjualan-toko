@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Detail Transaksi</h1>
        <p class="page-subtitle">Informasi lengkap transaksi</p>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('transaksi.struk', $transaksi->id) }}" target="_blank" class="btn-primary-custom">
            <i class="bi bi-printer"></i> Cetak Struk
        </a>
        <a href="{{ route('transaksi.index') }}" class="btn-secondary-custom">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card-custom" style="margin-bottom:20px;">
    <div class="row g-3">
        <div class="col-md-4">
            <div class="stat-label">Kode Transaksi</div>
            <div style="font-family:'Courier New', monospace; font-weight:800; font-size:1.1rem; color:#059669;">
                {{ $transaksi->kode_transaksi }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-label">Kasir</div>
            <div style="font-weight:700;">{{ $transaksi->kasir->nama ?? '-' }}</div>
        </div>
        <div class="col-md-4">
            <div class="stat-label">Tanggal</div>
            <div style="font-weight:700;">{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y, H:i:s') }}</div>
        </div>
    </div>
</div>

<div class="table-wrapper" style="margin-bottom:20px;">
    <table class="table-custom">
        <thead>
            <tr>
                <th width="60">No</th>
                <th>Produk</th>
                <th>Harga Satuan</th>
                <th width="100">Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->details as $i => $d)
            <tr>
                <td>{{ $i+1 }}</td>
                <td><strong>{{ $d->produk->nama_produk ?? '-' }}</strong></td>
                <td>Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                <td>{{ $d->jumlah }}</td>
                <td><strong>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="card-custom" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color:white; border:none;">
    <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0;">
        <span style="font-weight:600; opacity:0.9;">Total</span>
        <span style="font-size:1.8rem; font-weight:800;">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
    </div>
    <div style="display:flex; justify-content:space-between; padding:8px 0; border-top:1px solid rgba(255,255,255,0.2);">
        <span>Bayar</span>
        <span style="font-weight:700;">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
    </div>
    <div style="display:flex; justify-content:space-between; padding:8px 0;">
        <span>Kembalian</span>
        <span style="font-weight:700;">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
    </div>
</div>

@endsection