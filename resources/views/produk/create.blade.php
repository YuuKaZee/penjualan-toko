@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Produk</h1>
        <p class="page-subtitle">Tambahkan produk baru ke katalog</p>
    </div>
    <a href="{{ route('produk.index') }}" class="btn-secondary-custom">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card-custom">
    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label-custom">Kode Produk <span style="color:#ef4444;">*</span></label>
                <input type="text" name="kode_produk" class="form-control-custom @error('kode_produk') is-invalid @enderror"
                       value="{{ old('kode_produk') }}" placeholder="Contoh: PRD-001" required>
                @error('kode_produk') <div style="color:#ef4444; font-size:0.8rem; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Kategori <span style="color:#ef4444;">*</span></label>
                <select name="kategori_id" class="form-select-custom" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
                @error('kategori_id') <div style="color:#ef4444; font-size:0.8rem; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label class="form-label-custom">Nama Produk <span style="color:#ef4444;">*</span></label>
                <input type="text" name="nama_produk" class="form-control-custom"
                       value="{{ old('nama_produk') }}" placeholder="Contoh: Kopi Arabica 250gr" required>
                @error('nama_produk') <div style="color:#ef4444; font-size:0.8rem; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Harga (Rp) <span style="color:#ef4444;">*</span></label>
                <input type="number" name="harga" class="form-control-custom"
                       value="{{ old('harga') }}" placeholder="0" min="0" required>
                @error('harga') <div style="color:#ef4444; font-size:0.8rem; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Stok Awal <span style="color:#ef4444;">*</span></label>
                <input type="number" name="stok" class="form-control-custom"
                       value="{{ old('stok', 0) }}" min="0" required>
                @error('stok') <div style="color:#ef4444; font-size:0.8rem; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label class="form-label-custom">Gambar Produk <small style="color:#64748b; font-weight:400;">(JPG/PNG, maks 2MB)</small></label>
                <input type="file" name="gambar" class="form-control-custom" accept="image/*">
                @error('gambar') <div style="color:#ef4444; font-size:0.8rem; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label class="form-label-custom">Deskripsi</label>
                <textarea name="deskripsi" class="form-control-custom" rows="3"
                          placeholder="Deskripsi produk...">{{ old('deskripsi') }}</textarea>
            </div>
        </div>

        <div style="display:flex; gap:10px; margin-top:24px;">
            <button type="submit" class="btn-primary-custom">
                <i class="bi bi-check-circle-fill"></i> Simpan Produk
            </button>
            <a href="{{ route('produk.index') }}" class="btn-secondary-custom">Batal</a>
        </div>
    </form>
</div>

@endsection