@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Data Kategori</h1>
        <p class="page-subtitle">Kelola kategori produk toko</p>
    </div>
    <a href="{{ route('kategori.create') }}" class="btn-primary-custom">
        <i class="bi bi-plus-circle-fill"></i> Tambah Kategori
    </a>
</div>

@if($kategoris->count() > 0)
    <div class="table-wrapper">
        <table class="table-custom">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Nama Kategori</th>
                    <th>Keterangan</th>
                    <th width="150">Jumlah Produk</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kategoris as $i => $k)
                <tr>
                    <td>{{ $kategoris->firstItem() + $i }}</td>
                    <td><strong>{{ $k->nama_kategori }}</strong></td>
                    <td style="color:#64748b;">{{ $k->keterangan ?? '-' }}</td>
                    <td>
                        <span class="badge-custom badge-info">
                            <i class="bi bi-box-seam"></i> {{ $k->produks_count }} produk
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('kategori.edit', $k->id) }}" class="btn-sm-custom btn-edit">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('kategori.destroy', $k->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn-sm-custom btn-delete" onclick="return confirm('Hapus kategori ini?')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">{{ $kategoris->links() }}</div>
@else
    <div class="card-custom">
        <div class="empty-state">
            <i class="bi bi-tags"></i>
            <p>Belum ada kategori. Tambahkan kategori pertama!</p>
        </div>
    </div>
@endif

@endsection