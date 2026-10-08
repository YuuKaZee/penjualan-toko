@extends('shop.layout')

@section('content')
<div class="shop-body">
    <h2 style="font-weight:800; letter-spacing:-0.03em; margin-bottom:24px;">
        <i class="bi bi-bag-check" style="color:#059669;"></i> Checkout Pesanan
    </h2>

    @if(session('error'))
        <div class="alert-custom alert-danger-custom"><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</div>
    @endif

    <form action="{{ route('shop.checkout.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-md-7">
                <div class="card-custom">
                    <h5 style="font-weight:800; margin-bottom:20px;">📍 Informasi Pengiriman</h5>

                    <div style="margin-bottom:16px;">
                        <label class="form-label-custom">Nama Lengkap <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="customer_name" class="form-control-custom @error('customer_name') is-invalid @enderror" value="{{ old('customer_name') }}" placeholder="Contoh: Budi Santoso" required>
                        @error('customer_name') <div style="color:#ef4444; font-size:0.78rem; margin-top:5px;">{{ $message }}</div> @enderror
                    </div>

                    <div style="margin-bottom:16px;">
                        <label class="form-label-custom">No. HP / WhatsApp <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="customer_phone" class="form-control-custom" value="{{ old('customer_phone') }}" placeholder="Contoh: 08123456789" required>
                    </div>

                    <div style="margin-bottom:16px;">
                        <label class="form-label-custom">Alamat Lengkap <span style="color:#ef4444;">*</span></label>
                        <textarea name="customer_address" class="form-control-custom" rows="3" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota..." required>{{ old('customer_address') }}</textarea>
                    </div>

                    <div>
                        <label class="form-label-custom">Catatan Tambahan</label>
                        <textarea name="customer_note" class="form-control-custom" rows="2" placeholder="Contoh: Tolong dikirim setelah jam 5 sore...">{{ old('customer_note') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card-custom" style="position:sticky; top:100px;">
                    <h5 style="font-weight:800; margin-bottom:20px;">🧾 Ringkasan Pesanan</h5>

                    @foreach($items as $item)
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #f1f5f9; font-size:0.85rem;">
                        <div>
                            <div style="font-weight:600;">{{ $item['produk']->nama_produk }}</div>
                            <div style="color:#94a3b8; font-size:0.78rem;">{{ $item['jumlah'] }} × Rp {{ number_format($item['produk']->harga, 0, ',', '.') }}</div>
                        </div>
                        <div style="font-weight:700;">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</div>
                    </div>
                    @endforeach

                    <div style="display:flex; justify-content:space-between; padding:16px 0; border-top:2px solid #e2e8f0; margin-top:8px;">
                        <span style="font-weight:700;">Total</span>
                        <span style="font-weight:800; font-size:1.3rem; color:#059669;">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <div style="background:#fef3c7; padding:14px; border-radius:12px; font-size:0.82rem; color:#92400e; margin-bottom:16px;">
                        <i class="bi bi-info-circle-fill"></i>
                        Pembayaran dilakukan <strong>COD (Cash on Delivery)</strong> saat barang tiba.
                    </div>

                    <button type="submit" class="btn-primary-custom w-100" style="justify-content:center; padding:14px;">
                        <i class="bi bi-check-circle-fill"></i> Buat Pesanan
                    </button>

                    <a href="{{ route('shop.cart') }}" class="btn-secondary-custom w-100" style="justify-content:center; margin-top:10px;">
                        <i class="bi bi-arrow-left"></i> Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection