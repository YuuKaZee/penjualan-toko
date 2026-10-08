@extends('shop.layout')

@section('content')
<div class="shop-body">

    <h2 style="font-weight:800; letter-spacing:-0.03em; margin-bottom:24px;">
        <i class="bi bi-cart3" style="color:#059669;"></i> Keranjang Belanja
    </h2>

    @if(session('success'))
        <div class="alert-custom alert-success-custom"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-custom alert-danger-custom"><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</div>
    @endif

    @if(count($items) > 0)
        <div class="row g-4">
            <div class="col-md-8">
                <div class="card-custom" style="padding:0;">
                    @foreach($items as $item)
                    <div style="padding:20px; display:flex; gap:16px; border-bottom:1px solid #e2e8f0; align-items:center;">
                        <div style="width:80px; height:80px; border-radius:12px; background:#f8fafc; overflow:hidden; flex-shrink:0;">
                            @if($item['produk']->gambar)
                                <img src="{{ asset('produk_images/' . $item['produk']->gambar) }}" style="width:100%; height:100%; object-fit:cover;">
                            @else
                                <div style="height:100%; display:flex; align-items:center; justify-content:center;">
                                    <i class="bi bi-image" style="color:#cbd5e1; font-size:1.8rem;"></i>
                                </div>
                            @endif
                        </div>

                        <div style="flex:1;">
                            <div style="font-weight:700; font-size:0.92rem; margin-bottom:4px;">{{ $item['produk']->nama_produk }}</div>
                            <div style="color:#059669; font-weight:800;">Rp {{ number_format($item['produk']->harga, 0, ',', '.') }}</div>
                        </div>

                        <form action="{{ route('shop.cart.update') }}" method="POST" style="display:flex; gap:6px; align-items:center;">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $item['produk']->id }}">
                            <input type="number" name="jumlah" value="{{ $item['jumlah'] }}" min="1" max="{{ $item['produk']->stok }}"
                                   class="form-control-custom" style="width:80px; padding:6px 10px; text-align:center;">
                            <button class="btn-sm-custom btn-edit" title="Update"><i class="bi bi-arrow-clockwise"></i></button>
                        </form>

                        <div style="width:130px; text-align:right; font-weight:800; color:#0f172a;">
                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                        </div>

                        <form action="{{ route('shop.cart.remove') }}" method="POST" style="margin:0;">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $item['produk']->id }}">
                            <button class="btn-sm-custom btn-delete" title="Hapus"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-custom" style="position:sticky; top:100px;">
                    <h5 style="font-weight:800; margin-bottom:20px;">Ringkasan Pesanan</h5>

                    <div style="display:flex; justify-content:space-between; margin-bottom:12px; color:#64748b; font-size:0.9rem;">
                        <span>Subtotal</span>
                        <span style="font-weight:700; color:#0f172a;">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <div style="display:flex; justify-content:space-between; padding:16px 0; border-top:2px solid #e2e8f0; margin-bottom:20px;">
                        <span style="font-weight:700;">Total</span>
                        <span style="font-weight:800; font-size:1.3rem; color:#059669;">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('shop.checkout') }}" class="btn-primary-custom w-100" style="justify-content:center; padding:14px;">
                        <i class="bi bi-bag-check-fill"></i> Checkout Sekarang
                    </a>

                    <a href="{{ route('shop.index') }}" class="btn-secondary-custom w-100" style="justify-content:center; margin-top:10px;">
                        <i class="bi bi-arrow-left"></i> Lanjut Belanja
                    </a>

                    <form action="{{ route('shop.cart.clear') }}" method="POST" style="margin-top:10px;">
                        @csrf
                        <button class="btn-secondary-custom w-100" style="justify-content:center; color:#dc2626; border-color:#fecaca;" onclick="return confirm('Kosongkan keranjang?')">
                            <i class="bi bi-x-circle"></i> Kosongkan Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="card-custom">
            <div class="empty-state">
                <i class="bi bi-cart-x"></i>
                <p>Keranjang masih kosong</p>
                <a href="{{ route('shop.index') }}" class="btn-primary-custom" style="margin-top:16px;">
                    <i class="bi bi-shop"></i> Mulai Belanja
                </a>
            </div>
        </div>
    @endif
</div>
@endsection