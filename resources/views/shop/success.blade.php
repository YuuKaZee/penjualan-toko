@extends('shop.layout')

@section('content')
<div class="shop-body" style="max-width:680px;">

    <div class="card-custom" style="text-align:center; padding:48px 32px;">

        <div style="width:96px; height:96px; border-radius:50%; background:linear-gradient(135deg,#059669,#047857); color:white; display:flex; align-items:center; justify-content:center; font-size:2.8rem; margin:0 auto 24px; box-shadow:0 12px 32px rgba(5,150,105,0.3);">
            <i class="bi bi-check-lg"></i>
        </div>

        <h2 style="font-weight:800; letter-spacing:-0.03em; margin-bottom:8px;">Pesanan Berhasil! 🎉</h2>
        <p style="color:#64748b; margin-bottom:32px;">Terima kasih sudah berbelanja di toko kami</p>

        <div style="background:#f8fafc; padding:20px; border-radius:14px; margin-bottom:24px; text-align:left;">
            <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #e2e8f0;">
                <span style="color:#64748b; font-size:0.85rem;">Kode Pesanan</span>
                <strong style="font-family:'Courier New', monospace; color:#059669;">{{ $transaksi->kode_transaksi }}</strong>
            </div>
            <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #e2e8f0;">
                <span style="color:#64748b; font-size:0.85rem;">Nama</span>
                <strong>{{ $transaksi->customer_name }}</strong>
            </div>
            <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #e2e8f0;">
                <span style="color:#64748b; font-size:0.85rem;">No. HP</span>
                <strong>{{ $transaksi->customer_phone }}</strong>
            </div>
            <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #e2e8f0;">
                <span style="color:#64748b; font-size:0.85rem;">Status</span>
                <span class="badge-custom badge-warning"><i class="bi bi-clock"></i> Pending</span>
            </div>
            <div style="display:flex; justify-content:space-between; padding:12px 0 0;">
                <span style="color:#64748b; font-size:0.85rem; font-weight:700;">Total</span>
                <strong style="font-size:1.2rem; color:#059669;">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</strong>
            </div>
        </div>

        <div style="background:#dbeafe; padding:14px; border-radius:12px; font-size:0.85rem; color:#1e40af; text-align:left; margin-bottom:24px;">
            <i class="bi bi-info-circle-fill"></i>
            Simpan kode pesanan kamu untuk melacak status. Kami akan menghubungi via WhatsApp.
        </div>

        <div style="display:flex; gap:10px; justify-content:center;">
            <a href="{{ route('shop.track', ['kode' => $transaksi->kode_transaksi]) }}" class="btn-primary-custom">
                <i class="bi bi-geo-alt"></i> Lacak Pesanan
            </a>
            <a href="{{ route('shop.index') }}" class="btn-secondary-custom">
                <i class="bi bi-shop"></i> Belanja Lagi
            </a>
        </div>
    </div>
</div>
@endsection