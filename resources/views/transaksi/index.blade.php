@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Riwayat Transaksi</h1>
        <p class="page-subtitle">Daftar semua transaksi penjualan</p>
    </div>
    @if(in_array(Auth::user()->role, ['admin','kasir']))
        <a href="{{ route('transaksi.create') }}" class="btn-primary-custom">
            <i class="bi bi-cart-plus-fill"></i> Transaksi Baru
        </a>
    @endif
</div>

@if($transaksis->count() > 0)
    <div class="table-wrapper">
        <table class="table-custom">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Kode</th>
                    <th>Kasir</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Kembalian</th>
                    <th>Tanggal</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $i => $t)
                <tr>
                    <td>{{ $transaksis->firstItem() + $i }}</td>
                    <td>
                        <span style="font-family: 'Courier New', monospace; font-weight:700; color:#059669;">
                            {{ $t->kode_transaksi }}
                        </span>
                    </td>
                    <td>{{ $t->kasir->nama ?? '-' }}</td>
                    <td><strong>Rp {{ number_format($t->total, 0, ',', '.') }}</strong></td>
                    <td>Rp {{ number_format($t->bayar, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($t->kembalian, 0, ',', '.') }}</td>
                    <td style="font-size:0.85rem; color:#64748b;">
                        {{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y, H:i') }}
                    </td>
                    <td>
                        <a href="{{ route('transaksi.show', $t->id) }}" class="btn-sm-custom btn-view">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                        <a href="{{ route('transaksi.struk', $t->id) }}" target="_blank" class="btn-sm-custom btn-reset">
                            <i class="bi bi-printer"></i> Struk
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">{{ $transaksis->links() }}</div>
@else
    <div class="card-custom">
        <div class="empty-state">
            <i class="bi bi-receipt"></i>
            <p>Belum ada transaksi</p>
        </div>
    </div>
@endif

@endsection