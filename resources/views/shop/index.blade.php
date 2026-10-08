@extends('shop.layout')

@section('content')

<section class="shop-hero">
    <h1>Belanja Mudah, Harga Terjangkau 🛍️</h1>
    <p>Temukan produk favoritmu dengan harga terbaik</p>
</section>

<div class="shop-body">

    {{-- Kategori Filter --}}
    <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:28px;">
        <a href="{{ route('shop.index') }}" class="badge-custom {{ !request('kategori') ? 'badge-success' : 'badge-gray' }}" style="padding:8px 16px; font-size:0.82rem; text-decoration:none;">
            <i class="bi bi-grid"></i> Semua
        </a>
        @foreach($kategoris as $k)
            <a href="{{ route('shop.index', ['kategori' => $k->id]) }}" class="badge-custom {{ request('kategori') == $k->id ? 'badge-success' : 'badge-gray' }}" style="padding:8px 16px; font-size:0.82rem; text-decoration:none;">
                {{ $k->nama_kategori }}
            </a>
        @endforeach
    </div>

    @if(request('q'))
        <div style="margin-bottom:20px; color:#64748b; font-size:0.9rem;">
            Hasil pencarian: <strong>"{{ request('q') }}"</strong> — {{ $produks->total() }} produk
        </div>
    @endif

    @if($produks->count() > 0)
        <div class="row g-3">
            @foreach($produks as $p)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('shop.product', $p->id) }}" style="text-decoration:none;">
                    <div class="product-card">
                        <div class="product-img-wrap">
                            @if($p->gambar)
                                <img src="{{ asset('produk_images/' . $p->gambar) }}" alt="{{ $p->nama_produk }}">
                            @else
                                <i class="bi bi-image product-no-img"></i>
                            @endif
                        </div>
                        <div class="product-info">
                            <div style="font-size:0.72rem; color:#94a3b8; margin-bottom:4px;">{{ $p->kategori->nama_kategori ?? '-' }}</div>
                            <div class="product-name">{{ $p->nama_produk }}</div>
                            <div class="product-price">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
                            <div class="product-stock"><i class="bi bi-box-seam"></i> Stok: {{ $p->stok }}</div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <div style="margin-top:32px; display:flex; justify-content:center;">
            {{ $produks->appends(request()->all())->links() }}
        </div>
    @else
        <div class="card-custom">
            <div class="empty-state">
                <i class="bi bi-bag-x"></i>
                <p>Produk tidak ditemukan</p>
            </div>
        </div>
    @endif
</div>

@endsection