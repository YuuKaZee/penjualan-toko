@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Edit Produk</h1>
        <p class="page-subtitle">Perbarui data produk</p>
    </div>
    <a href="{{ route('produk.index') }}" class="btn-secondary-custom">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card-custom">
    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label-custom">Kode Produk <span style="color:#ef4444;">*</span></label>
                <input type="text" name="kode_produk" class="form-control-custom"
                       value="{{ old('kode_produk', $produk->kode_produk) }}" required>
                @error('kode_produk') <div style="color:#ef4444; font-size:0.8rem; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Kategori <span style="color:#ef4444;">*</span></label>
                <select name="kategori_id" class="form-select-custom" required>
                    <option value="">-- Pilih --</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_id', $produk->kategori_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12">
                <label class="form-label-custom">Nama Produk <span style="color:#ef4444;">*</span></label>
                <input type="text" name="nama_produk" class="form-control-custom"
                       value="{{ old('nama_produk', $produk->nama_produk) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Harga (Rp) <span style="color:#ef4444;">*</span></label>
                <input type="number" name="harga" class="form-control-custom"
                       value="{{ old('harga', $produk->harga) }}" min="0" required>
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Stok <span style="color:#ef4444;">*</span></label>
                <input type="number" name="stok" class="form-control-custom"
                       value="{{ old('stok', $produk->stok) }}" min="0" required>
            </div>

            <div class="col-12">
                <label class="form-label-custom">Gambar Produk <small style="color:#64748b; font-weight:400;">(kosongkan jika tidak diubah)</small></label>
                @if($produk->gambar)
                    <div style="margin-bottom:12px;">
                        <img src="{{ asset('produk_images/' . $produk->gambar) }}"
                             style="max-height:120px; border-radius:12px; border:1px solid #e2e8f0;">
                    </div>
                @endif
                <input type="file" name="gambar" class="form-control-custom" accept="image/*">
            </div>

            <div class="col-12">
                <label class="form-label-custom">Deskripsi</label>
                <textarea name="deskripsi" class="form-control-custom" rows="3">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
            </div>
        </div>

        <div style="display:flex; gap:10px; margin-top:24px;">
            <button type="submit" class="btn-primary-custom">
                <i class="bi bi-check-circle-fill"></i> Update Produk
            </button>
            <a href="{{ route('produk.index') }}" class="btn-secondary-custom">Batal</a>
        </div>
    </form>
</div>

@endsection