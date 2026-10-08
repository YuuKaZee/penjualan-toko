@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Data Pengguna</h1>
        <p class="page-subtitle">Kelola akun pengguna sistem</p>
    </div>
    <a href="{{ route('user.create') }}" class="btn-primary-custom">
        <i class="bi bi-person-plus-fill"></i> Tambah User
    </a>
</div>

<div class="row g-3" style="margin-bottom:24px;">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="bi bi-shield-lock"></i></div>
            <div>
                <div class="stat-label">Admin</div>
                <div class="stat-value">{{ $total_admin }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon info"><i class="bi bi-person-badge"></i></div>
            <div>
                <div class="stat-label">Kasir</div>
                <div class="stat-value">{{ $total_kasir }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="bi bi-person-vcard"></i></div>
            <div>
                <div class="stat-label">Pemilik</div>
                <div class="stat-value">{{ $total_pemilik }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon warning"><i class="bi bi-check-circle"></i></div>
            <div>
                <div class="stat-label">Aktif</div>
                <div class="stat-value">{{ $total_aktif }}</div>
            </div>
        </div>
    </div>
</div>

<div class="table-wrapper">
    <table class="table-custom">
        <thead>
            <tr>
                <th width="60">No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Role</th>
                <th>Status</th>
                <th width="320">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $i => $u)
            <tr>
                <td>{{ $users->firstItem() + $i }}</td>
                <td><strong>{{ $u->nama }}</strong></td>
                <td><span style="font-family:'Courier New', monospace; color:#64748b;">{{ $u->username }}</span></td>
                <td>
                    @if($u->role === 'admin')
                        <span class="badge-custom badge-success"><i class="bi bi-shield-lock"></i> Admin</span>
                    @elseif($u->role === 'kasir')
                        <span class="badge-custom badge-info"><i class="bi bi-person-badge"></i> Kasir</span>
                    @else
                        <span class="badge-custom badge-purple"><i class="bi bi-person-vcard"></i> Pemilik</span>
                    @endif
                </td>
                <td>
                    @if($u->status === 'aktif')
                        <span class="badge-custom badge-success"><i class="bi bi-check-circle-fill"></i> Aktif</span>
                    @else
                        <span class="badge-custom badge-danger"><i class="bi bi-x-circle-fill"></i> Nonaktif</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('user.show', $u->id) }}" class="btn-sm-custom btn-view">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('user.edit', $u->id) }}" class="btn-sm-custom btn-edit">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form action="{{ route('user.reset-password', $u->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn-sm-custom btn-reset" onclick="return confirm('Reset password ke default?')">
                            <i class="bi bi-key"></i>
                        </button>
                    </form>
                    <form action="{{ route('user.destroy', $u->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn-sm-custom btn-delete" onclick="return confirm('Hapus user ini?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">{{ $users->links() }}</div>

@endsection