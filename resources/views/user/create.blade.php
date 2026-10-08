@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Tambah User</h1>
        <p class="page-subtitle">Buat akun pengguna baru</p>
    </div>
    <a href="{{ route('user.index') }}" class="btn-secondary-custom">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card-custom" style="max-width:800px;">
    <form action="{{ route('user.store') }}" method="POST">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label-custom">Nama Lengkap <span style="color:#ef4444;">*</span></label>
                <input type="text" name="nama" class="form-control-custom"
                       value="{{ old('nama') }}" placeholder="Contoh: Budi Santoso" required>
                @error('nama') <div style="color:#ef4444; font-size:0.8rem; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Username <span style="color:#ef4444;">*</span></label>
                <input type="text" name="username" class="form-control-custom"
                       value="{{ old('username') }}" placeholder="Contoh: budi123" required>
                @error('username') <div style="color:#ef4444; font-size:0.8rem; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Password <span style="color:#ef4444;">*</span></label>
                <input type="password" name="password" class="form-control-custom" placeholder="Minimal 6 karakter" required>
                @error('password') <div style="color:#ef4444; font-size:0.8rem; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Konfirmasi Password <span style="color:#ef4444;">*</span></label>
                <input type="password" name="password_confirmation" class="form-control-custom" placeholder="Ulangi password" required>
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Role <span style="color:#ef4444;">*</span></label>
                <select name="role" class="form-select-custom" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                    <option value="pemilik" {{ old('role') == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Status <span style="color:#ef4444;">*</span></label>
                <select name="status" class="form-select-custom" required>
                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
        </div>

        <div style="display:flex; gap:10px; margin-top:24px;">
            <button type="submit" class="btn-primary-custom">
                <i class="bi bi-check-circle-fill"></i> Simpan User
            </button>
            <a href="{{ route('user.index') }}" class="btn-secondary-custom">Batal</a>
        </div>
    </form>
</div>

@endsection