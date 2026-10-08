@extends('shop.layout')

@section('content')
<div class="shop-body">
    <div style="margin-bottom:20px; color:#64748b; font-size:0.85rem;">
        <a href="{{ route('shop.index') }}" style="color:#059669; text-decoration:none;">Home</a>
        <i class="bi bi-chevron-right" style="font-size:0.7rem; margin:0 6px;"></i>
        <a href="{{ route('shop.index', ['kategori' => $produk->kategori_id]) }}" style="color:#059669; text-decoration:none;">{{ $produk->kategori->nama_kategori ?? '-' }}</a>
        <i class="bi bi-chevron-right" style="font-size:0.7rem; margin:0 6px;"></i>
        <span>{{ $produk->nama_produk }}</span>
    </div>

    @if(session('error'))
        <div class="alert-custom alert-danger-custom">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card-custom">
        <div class="row g-4">
            <div class="col-md-5">
                <div style="aspect-ratio:1; background:#f8fafc; border-radius:16px; overflow:hidden; display:flex; align-items:center; justify-content:center;">
                    @if($produk->gambar)
                        <img src="{{ asset('produk_images/' . $produk->gambar) }}" style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <i class="bi bi-image" style="font-size:4rem; color:#cbd5e1;"></i>
                    @endif
                </div>
            </div>

            <div class="col-md-7">
                <span class="badge-custom badge-info" style="margin-bottom:12px;">
                    {{ $produk->kategori->nama_kategori ?? '-' }}
                </span>

                <h2 style="font-weight:800; letter-spacing:-0.02em; margin-bottom:12px;">{{ $produk->nama_produk }}</h2>

                <div style="font-family:'Courier New', monospace; color:#64748b; font-size:0.85rem; margin-bottom:20px;">
                    {{ $produk->kode_produk }}
                </div>

                <div style="background:linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); padding:20px; border-radius:14px; margin-bottom:20px;">
                    <div style="font-size:0.75rem; color:#047857; font-weight:700; text-transform:uppercase; letter-spacing:0.05em;">Harga</div>
                    <div style="font-size:2rem; font-weight:800; color:#065f46; letter-spacing:-0.03em;">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </div>
                    <div style="margin-top:8px; font-size:0.85rem; color:#047857;">
                        <i class="bi bi-box-seam"></i> Stok tersedia: <strong>{{ $produk->stok }}</strong>
                    </div>
                </div>

                @if($produk->deskripsi)
                    <div style="margin-bottom:20px;">
                        <div style="font-weight:700; margin-bottom:8px; font-size:0.85rem;">Deskripsi</div>
                        <p style="color:#64748b; line-height:1.6; margin:0; font-size:0.9rem;">{{ $produk->deskripsi }}</p>
                    </div>
                @endif

                @if($produk->stok > 0)
                    <form action="{{ route('shop.cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">

                        <div style="display:flex; gap:10px; align-items:end;">
                            <div>
                                <label class="form-label-custom">Jumlah</label>
                                <input type="number" name="jumlah" value="1" min="1" max="{{ $produk->stok }}"
                                       class="form-control-custom" style="width:120px;">
                            </div>
                            <button class="btn-primary-custom" style="padding:12px 24px;">
                                <i class="bi bi-cart-plus-fill"></i> Tambah ke Keranjang
                            </button>
                        </div>
                    </form>
                @else
                    <div class="badge-custom badge-danger" style="padding:12px 20px; font-size:0.9rem;">
                        <i class="bi bi-x-circle-fill"></i> Stok Habis
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($produks_lain->count() > 0)
        <h5 style="font-weight:800; margin:40px 0 20px;">Produk Serupa</h5>
        <div class="row g-3">
            @foreach($produks_lain as $p)
            <div class="col-6 col-md-3">
                <a href="{{ route('shop.product', $p->id) }}" style="text-decoration:none;">
                    <div class="product-card">
                        <div class="product-img-wrap">
                            @if($p->gambar)
                                <img src="{{ asset('produk_images/' . $p->gambar) }}">
                            @else
                                <i class="bi bi-image product-no-img"></i>
                            @endif
                        </div>
                        <div class="product-info">
                            <div class="product-name">{{ $p->nama_produk }}</div>
                            <div class="product-price">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection