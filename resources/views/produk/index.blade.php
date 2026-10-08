@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Data Produk</h1>
        <p class="page-subtitle">Kelola katalog produk toko</p>
    </div>
    @if(Auth::user()->role === 'admin')
        <a href="{{ route('produk.create') }}" class="btn-primary-custom">
            <i class="bi bi-plus-circle-fill"></i> Tambah Produk
        </a>
    @endif
</div>

<form action="{{ route('produk.cari') }}" method="GET" style="margin-bottom:20px;">
    <div style="display:flex; gap:10px; max-width:500px;">
        <input type="text" name="q" class="form-control-custom"
               placeholder="🔍 Cari kode atau nama produk..." value="{{ $keyword ?? '' }}">
        <button class="btn-primary-custom" style="white-space:nowrap;">
            <i class="bi bi-search"></i> Cari
        </button>
    </div>
</form>

@if($produks->count() > 0)
    <div class="table-wrapper">
        <table class="table-custom">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th width="120">Kode</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th width="100">Stok</th>
                    <th width="230">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produks as $i => $p)
                <tr>
                    <td>{{ $produks->firstItem() + $i }}</td>
                    <td>
                        <span style="font-family: 'Courier New', monospace; font-weight:700; color:#059669;">
                            {{ $p->kode_produk }}
                        </span>
                    </td>
                    <td><strong>{{ $p->nama_produk }}</strong></td>
                    <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>
                    <td><strong style="color:#059669;">Rp {{ number_format($p->harga, 0, ',', '.') }}</strong></td>
                    <td>
                        @if($p->stok < 10)
                            <span class="badge-custom badge-danger">
                                <i class="bi bi-exclamation-triangle-fill"></i> {{ $p->stok }}
                            </span>
                        @else
                            <span class="badge-custom badge-success">
                                <i class="bi bi-check-circle-fill"></i> {{ $p->stok }}
                            </span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('produk.show', $p->id) }}" class="btn-sm-custom btn-view">
                            <i class="bi bi-eye"></i> Lihat
                        </a>
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('produk.edit', $p->id) }}" class="btn-sm-custom btn-edit">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('produk.destroy', $p->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn-sm-custom btn-delete" onclick="return confirm('Hapus produk ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">{{ $produks->links() }}</div>
@else
    <div class="card-custom">
        <div class="empty-state">
            <i class="bi bi-box-seam"></i>
            <p>Belum ada produk. Tambahkan produk pertama!</p>
        </div>
    </div>
@endif

@endsection