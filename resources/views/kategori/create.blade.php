@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Kategori</h1>
        <p class="page-subtitle">Buat kategori baru untuk produk</p>
    </div>
    <a href="{{ route('kategori.index') }}" class="btn-secondary-custom">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card-custom" style="max-width:640px;">
    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf

        <div style="margin-bottom:20px;">
            <label class="form-label-custom">Nama Kategori <span style="color:#ef4444;">*</span></label>
            <input type="text" name="nama_kategori"
                   class="form-control-custom @error('nama_kategori') is-invalid @enderror"
                   value="{{ old('nama_kategori') }}" placeholder="Contoh: Makanan, Minuman..." required>
            @error('nama_kategori')
                <div style="color:#ef4444; font-size:0.8rem; margin-top:6px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom:24px;">
            <label class="form-label-custom">Keterangan</label>
            <textarea name="keterangan" class="form-control-custom" rows="3"
                      placeholder="Deskripsi singkat tentang kategori ini...">{{ old('keterangan') }}</textarea>
        </div>

        <div style="display:flex; gap:10px;">
            <button type="submit" class="btn-primary-custom">
                <i class="bi bi-check-circle-fill"></i> Simpan
            </button>
            <a href="{{ route('kategori.index') }}" class="btn-secondary-custom">Batal</a>
        </div>
    </form>
</div>

@endsection