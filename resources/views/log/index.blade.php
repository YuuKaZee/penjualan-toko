@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Log Aktivitas</h1>
        <p class="page-subtitle">Riwayat semua aktivitas sistem</p>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('log.backup') }}" class="btn-primary-custom">
            <i class="bi bi-download"></i> Backup Log
        </a>
        <form action="{{ route('log.bersihkan') }}" method="POST" style="margin:0;">
            @csrf
            <button class="btn-secondary-custom" onclick="return confirm('Hapus log lebih dari 30 hari?')">
                <i class="bi bi-eraser"></i> Bersihkan Lama
            </button>
        </form>
    </div>
</div>

<div class="row g-3" style="margin-bottom:24px;">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="bi bi-list-ul"></i></div>
            <div>
                <div class="stat-label">Total Log</div>
                <div class="stat-value">{{ $total_log }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon info"><i class="bi bi-calendar-day"></i></div>
            <div>
                <div class="stat-label">Hari Ini</div>
                <div class="stat-value">{{ $log_hari_ini }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon warning"><i class="bi bi-calendar-week"></i></div>
            <div>
                <div class="stat-label">Minggu Ini</div>
                <div class="stat-value">{{ $log_minggu_ini }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card-custom" style="margin-bottom:20px;">
    <form action="{{ route('log.index') }}" method="GET">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label-custom">User</label>
                <select name="user_id" class="form-select-custom">
                    <option value="">-- Semua User --</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                            {{ $u->nama }} ({{ $u->role }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label-custom">Kata Kunci</label>
                <input type="text" name="q" class="form-control-custom" value="{{ request('q') }}" placeholder="Cari aktivitas...">
            </div>
            <div class="col-md-2">
                <label class="form-label-custom">Dari</label>
                <input type="date" name="dari" class="form-control-custom" value="{{ request('dari') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label-custom">Sampai</label>
                <input type="date" name="sampai" class="form-control-custom" value="{{ request('sampai') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end gap-2">
                <button class="btn-primary-custom" style="padding:11px 16px;"><i class="bi bi-search"></i></button>
                <a href="{{ route('log.index') }}" class="btn-secondary-custom" style="padding:11px 16px;"><i class="bi bi-arrow-clockwise"></i></a>
            </div>
        </div>
    </form>
</div>

@if($logs->count() > 0)
    <div class="table-wrapper">
        <table class="table-custom">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th width="150">Waktu</th>
                    <th>User</th>
                    <th width="120">Role</th>
                    <th>Aktivitas</th>
                    <th width="70">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $i => $log)
                <tr>
                    <td>{{ $logs->firstItem() + $i }}</td>
                    <td>
                        <div style="font-weight:600; font-size:0.85rem;">{{ $log->created_at->format('d M Y') }}</div>
                        <div style="color:#94a3b8; font-size:0.75rem;">{{ $log->created_at->format('H:i:s') }}</div>
                    </td>
                    <td><strong>{{ $log->user->nama ?? 'User dihapus' }}</strong></td>
                    <td>
                        @if($log->user)
                            @if($log->user->role === 'admin') <span class="badge-custom badge-success">Admin</span>
                            @elseif($log->user->role === 'kasir') <span class="badge-custom badge-info">Kasir</span>
                            @else <span class="badge-custom badge-purple">Pemilik</span>
                            @endif
                        @else
                            <span class="badge-custom badge-gray">-</span>
                        @endif
                    </td>
                    <td style="color:#475569;">{{ $log->aktivitas }}</td>
                    <td>
                        <form action="{{ route('log.destroy', $log->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn-sm-custom btn-delete" onclick="return confirm('Hapus log ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">{{ $logs->links() }}</div>
@else
    <div class="card-custom">
        <div class="empty-state">
            <i class="bi bi-clock-history"></i>
            <p>Tidak ada log aktivitas</p>
        </div>
    </div>
@endif

@endsection