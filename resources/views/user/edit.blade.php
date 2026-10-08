@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Edit User</h1>
        <p class="page-subtitle">Perbarui data akun pengguna</p>
    </div>
    <a href="{{ route('user.index') }}" class="btn-secondary-custom">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card-custom" style="max-width:800px;">
    <form action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label-custom">Nama Lengkap <span style="color:#ef4444;">*</span></label>
                <input type="text" name="nama" class="form-control-custom"
                       value="{{ old('nama', $user->nama) }}" required>
                @error('nama') <div style="color:#ef4444; font-size:0.8rem; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Username <span style="color:#ef4444;">*</span></label>
                <input type="text" name="username" class="form-control-custom"
                       value="{{ old('username', $user->username) }}" required>
                @error('username') <div style="color:#ef4444; font-size:0.8rem; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Password Baru <small style="color:#64748b; font-weight:400;">(kosongkan jika tidak diubah)</small></label>
                <input type="password" name="password" class="form-control-custom" placeholder="Kosongkan jika tidak diubah">
                @error('password') <div style="color:#ef4444; font-size:0.8rem; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control-custom" placeholder="Ulangi password baru">
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Role <span style="color:#ef4444;">*</span></label>
                <select name="role" class="form-select-custom" required>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="kasir" {{ old('role', $user->role) == 'kasir' ? 'selected' : '' }}>Kasir</option>
                    <option value="pemilik" {{ old('role', $user->role) == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Status <span style="color:#ef4444;">*</span></label>
                <select name="status" class="form-select-custom" required>
                    <option value="aktif" {{ old('status', $user->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status', $user->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
        </div>

        <div style="display:flex; gap:10px; margin-top:24px;">
            <button type="submit" class="btn-primary-custom">
                <i class="bi bi-check-circle-fill"></i> Update User
            </button>
            <a href="{{ route('user.index') }}" class="btn-secondary-custom">Batal</a>
        </div>
    </form>
</div>

@endsection