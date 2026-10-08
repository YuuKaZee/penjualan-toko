@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Pesanan Online</h1>
        <p class="page-subtitle">
            @if(Auth::user()->role === 'pemilik')
                Pantau pesanan dari toko online
            @else
                Kelola pesanan dari toko online
            @endif
        </p>
    </div>
    <a href="{{ route('shop.index') }}" target="_blank" class="btn-secondary-custom">
        <i class="bi bi-box-arrow-up-right"></i> Lihat Toko
    </a>
</div>

<div class="row g-3" style="margin-bottom:24px;">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon warning"><i class="bi bi-hourglass-split"></i></div>
            <div>
                <div class="stat-label">Pending</div>
                <div class="stat-value">{{ $total_pending }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon info"><i class="bi bi-box-seam"></i></div>
            <div>
                <div class="stat-label">Diproses</div>
                <div class="stat-value">{{ $total_diproses }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="bi bi-truck"></i></div>
            <div>
                <div class="stat-label">Dikirim</div>
                <div class="stat-value">{{ $total_dikirim }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="bi bi-check-circle"></i></div>
            <div>
                <div class="stat-label">Selesai</div>
                <div class="stat-value">{{ $total_selesai }}</div>
            </div>
        </div>
    </div>
</div>

@if($orders->count() > 0)
    <div class="table-wrapper">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th width="220">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $o)
                <tr>
                    <td>
                        <span style="font-family:'Courier New', monospace; font-weight:700; color:#059669;">
                            {{ $o->kode_transaksi }}
                        </span>
                    </td>
                    <td>
                        <strong>{{ $o->customer_name }}</strong>
                        <div style="font-size:0.78rem; color:#94a3b8;">{{ $o->customer_phone }}</div>
                    </td>
                    <td><strong>Rp {{ number_format($o->total, 0, ',', '.') }}</strong></td>
                    <td>
                        @php
                            $sc = [
                                'pending' => 'badge-warning',
                                'diproses' => 'badge-info',
                                'dikirim' => 'badge-purple',
                                'selesai' => 'badge-success',
                                'dibatalkan' => 'badge-danger',
                            ];
                        @endphp
                        <span class="badge-custom {{ $sc[$o->order_status] ?? 'badge-gray' }}">
                            {{ ucfirst($o->order_status) }}
                        </span>
                    </td>
                    <td style="font-size:0.82rem; color:#64748b;">
                        {{ \Carbon\Carbon::parse($o->tanggal_transaksi)->format('d M Y, H:i') }}
                    </td>
                    <td>
                        <a href="{{ route('transaksi.order_detail', $o->id) }}" class="btn-sm-custom btn-view">
                            <i class="bi bi-eye"></i> Detail
                        </a>

                        @if(Auth::user()->role !== 'pemilik')
                            {{-- Admin & Kasir: boleh ubah status --}}
                            <form action="{{ route('transaksi.update_status', $o->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <select name="order_status" onchange="this.form.submit()"
                                        style="padding:5px 8px; border-radius:8px; border:1px solid #e2e8f0; font-size:0.78rem; font-weight:600; background:white; cursor:pointer;">
                                    <option value="pending" {{ $o->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="diproses" {{ $o->order_status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="dikirim" {{ $o->order_status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                    <option value="selesai" {{ $o->order_status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="dibatalkan" {{ $o->order_status == 'dibatalkan' ? 'selected' : '' }}>Batalkan</option>
                                </select>
                            </form>
                        @else
                            {{-- Pemilik: view-only --}}
                            <span class="badge-custom badge-gray" style="margin-left:6px;">
                                <i class="bi bi-eye"></i> View Only
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">{{ $orders->links() }}</div>
@else
    <div class="card-custom">
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>Belum ada pesanan online</p>
        </div>
    </div>
@endif

@endsection