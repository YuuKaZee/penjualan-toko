@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Detail Pesanan</h1>
        <p class="page-subtitle">{{ $transaksi->kode_transaksi }}</p>
    </div>
    <a href="{{ route('transaksi.orders') }}" class="btn-secondary-custom">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card-custom" style="margin-bottom:20px;">
    <div class="row g-3">
        <div class="col-md-6">
            <div class="stat-label">Nama Penerima</div>
            <div style="font-weight:700; font-size:1rem;">{{ $transaksi->customer_name }}</div>
        </div>
        <div class="col-md-6">
            <div class="stat-label">No. HP</div>
            <div style="font-weight:700; font-size:1rem;">{{ $transaksi->customer_phone }}</div>
        </div>
        <div class="col-12">
            <div class="stat-label">Alamat Pengiriman</div>
            <div style="color:#475569;">{{ $transaksi->customer_address }}</div>
        </div>
        @if($transaksi->customer_note)
        <div class="col-12">
            <div class="stat-label">Catatan</div>
            <div style="color:#475569;">{{ $transaksi->customer_note }}</div>
        </div>
        @endif
    </div>
</div>

<div class="table-wrapper" style="margin-bottom:20px;">
    <table class="table-custom">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->details as $d)
            <tr>
                <td><strong>{{ $d->produk->nama_produk ?? '-' }}</strong></td>
                <td>Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                <td>{{ $d->jumlah }}</td>
                <td><strong>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="card-custom" style="background:linear-gradient(135deg, #047857 0%, #065f46 100%); color:white; border:none;">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <span style="font-weight:600;">Total Pesanan</span>
        <span style="font-size:1.8rem; font-weight:800;">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
    </div>
</div>

@endsection