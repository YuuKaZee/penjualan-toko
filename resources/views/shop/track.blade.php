@extends('shop.layout')

@section('content')
<div class="shop-body" style="max-width:680px;">
    <h2 style="font-weight:800; letter-spacing:-0.03em; margin-bottom:8px;">🔍 Lacak Pesanan</h2>
    <p style="color:#64748b; margin-bottom:24px;">Masukkan kode pesanan untuk melihat status</p>

    <form method="GET" action="{{ route('shop.track') }}" style="margin-bottom:24px;">
        <div style="display:flex; gap:10px;">
            <input type="text" name="kode" class="form-control-custom" placeholder="Contoh: ONL-20260101120000" value="{{ request('kode') }}" required>
            <button class="btn-primary-custom" style="white-space:nowrap;"><i class="bi bi-search"></i> Lacak</button>
        </div>
    </form>

    @if(request('kode'))
        @if($transaksi)
            <div class="card-custom">
                <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:20px;">
                    <div>
                        <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; font-weight:700;">Kode Pesanan</div>
                        <div style="font-family:'Courier New', monospace; font-weight:800; font-size:1.05rem; color:#059669;">{{ $transaksi->kode_transaksi }}</div>
                    </div>
                    @php
                        $statusColors = [
                            'pending' => 'badge-warning',
                            'diproses' => 'badge-info',
                            'dikirim' => 'badge-purple',
                            'selesai' => 'badge-success',
                            'dibatalkan' => 'badge-danger',
                        ];
                    @endphp
                    <span class="badge-custom {{ $statusColors[$transaksi->order_status] ?? 'badge-gray' }}" style="padding:8px 16px; font-size:0.82rem;">
                        {{ ucfirst($transaksi->order_status) }}
                    </span>
                </div>

                <div style="border-top:1px solid #e2e8f0; padding-top:16px;">
                    <div style="margin-bottom:12px;"><strong>Penerima:</strong> {{ $transaksi->customer_name }}</div>
                    <div style="margin-bottom:12px; color:#64748b; font-size:0.88rem;"><i class="bi bi-telephone"></i> {{ $transaksi->customer_phone }}</div>
                    <div style="margin-bottom:16px; color:#64748b; font-size:0.88rem;"><i class="bi bi-geo-alt"></i> {{ $transaksi->customer_address }}</div>
                </div>

                <div style="border-top:1px solid #e2e8f0; padding-top:16px;">
                    <div style="font-weight:700; margin-bottom:12px;">Item Pesanan</div>
                    @foreach($transaksi->details as $d)
                    <div style="display:flex; justify-content:space-between; padding:8px 0; font-size:0.88rem;">
                        <span>{{ $d->produk->nama_produk ?? '-' }} × {{ $d->jumlah }}</span>
                        <strong>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</strong>
                    </div>
                    @endforeach

                    <div style="display:flex; justify-content:space-between; padding-top:12px; border-top:2px solid #e2e8f0; margin-top:12px;">
                        <strong>Total</strong>
                        <strong style="font-size:1.2rem; color:#059669;">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        @else
            <div class="card-custom">
                <div class="empty-state">
                    <i class="bi bi-search"></i>
                    <p>Pesanan tidak ditemukan. Periksa kembali kode pesanan.</p>
                </div>
            </div>
        @endif
    @endif
</div>
@endsection