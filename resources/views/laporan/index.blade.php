@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Laporan Penjualan</h1>
        <p class="page-subtitle">Analisis dan rekap penjualan toko</p>
    </div>
</div>

<div class="card-custom" style="margin-bottom:20px;">
    <form action="{{ route('laporan.index') }}" method="GET">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label-custom">Dari Tanggal</label>
                <input type="date" name="dari" class="form-control-custom" value="{{ request('dari') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label-custom">Sampai Tanggal</label>
                <input type="date" name="sampai" class="form-control-custom" value="{{ request('sampai') }}">
            </div>
            <div class="col-md-6 d-flex align-items-end gap-2">
                <button class="btn-primary-custom"><i class="bi bi-filter"></i> Tampilkan</button>
                <a href="{{ route('laporan.index') }}" class="btn-secondary-custom"><i class="bi bi-arrow-clockwise"></i> Reset</a>
                <a href="{{ route('laporan.pdf', request()->all()) }}" target="_blank" class="btn-primary-custom" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); box-shadow: 0 4px 12px rgba(239,68,68,0.3);">
                    <i class="bi bi-file-pdf"></i> Cetak PDF
                </a>
            </div>
        </div>
    </form>
</div>

<div class="card-custom" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color:white; border:none; margin-bottom:20px;">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
        <div>
            <div style="opacity:0.9; font-size:0.85rem; font-weight:600; text-transform:uppercase; letter-spacing:0.05em;">Total Pendapatan</div>
            <div style="font-size:2.4rem; font-weight:800; letter-spacing:-0.03em; line-height:1.1; margin-top:6px;">
                Rp {{ number_format($total_pendapatan, 0, ',', '.') }}
            </div>
        </div>
        <div style="text-align:right;">
            <div style="opacity:0.9; font-size:0.85rem; font-weight:600; text-transform:uppercase; letter-spacing:0.05em;">Total Transaksi</div>
            <div style="font-size:2.4rem; font-weight:800; letter-spacing:-0.03em; line-height:1.1; margin-top:6px;">
                {{ $transaksis->count() }}
            </div>
        </div>
    </div>
</div>

@if($transaksis->count() > 0)
    <div class="table-wrapper">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Kasir</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Kembalian</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $i => $t)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td><span style="font-family:'Courier New', monospace; font-weight:700; color:#059669;">{{ $t->kode_transaksi }}</span></td>
                    <td>{{ $t->kasir->nama ?? '-' }}</td>
                    <td><strong>Rp {{ number_format($t->total, 0, ',', '.') }}</strong></td>
                    <td>Rp {{ number_format($t->bayar, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($t->kembalian, 0, ',', '.') }}</td>
                    <td style="font-size:0.85rem; color:#64748b;">{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y, H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="card-custom">
        <div class="empty-state">
            <i class="bi bi-bar-chart"></i>
            <p>Tidak ada data pada periode ini</p>
        </div>
    </div>
@endif

@endsection