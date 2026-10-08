@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Edit Kategori</h1>
        <p class="page-subtitle">Perbarui data kategori</p>
    </div>
    <a href="{{ route('kategori.index') }}" class="btn-secondary-custom">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card-custom" style="max-width:640px;">
    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
        @csrf @method('PUT')

        <div style="margin-bottom:20px;">
            <label class="form-label-custom">Nama Kategori <span style="color:#ef4444;">*</span></label>
            <input type="text" name="nama_kategori"
                   class="form-control-custom @error('nama_kategori') is-invalid @enderror"
                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
            @error('nama_kategori')
                <div style="color:#ef4444; font-size:0.8rem; margin-top:6px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom:24px;">
            <label class="form-label-custom">Keterangan</label>
            <textarea name="keterangan" class="form-control-custom" rows="3">{{ old('keterangan', $kategori->keterangan) }}</textarea>
        </div>

        <div style="display:flex; gap:10px;">
            <button type="submit" class="btn-primary-custom">
                <i class="bi bi-check-circle-fill"></i> Update
            </button>
            <a href="{{ route('kategori.index') }}" class="btn-secondary-custom">Batal</a>
        </div>
    </form>
</div>

@endsection