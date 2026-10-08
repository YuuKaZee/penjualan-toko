@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Transaksi Baru</h1>
        <p class="page-subtitle">Buat transaksi penjualan baru</p>
    </div>
    <a href="{{ route('transaksi.index') }}" class="btn-secondary-custom">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<form action="{{ route('transaksi.store') }}" method="POST" id="formTransaksi">
    @csrf

    <div class="card-custom" style="margin-bottom:20px;">
        <h5 style="font-weight:800; margin-bottom:16px;">
            <i class="bi bi-cart3"></i> Pilih Produk
        </h5>

        <div class="row g-2" style="margin-bottom:20px;">
            <div class="col-md-6">
                <select id="pilihProduk" class="form-select-custom">
                    <option value="">-- Pilih Produk --</option>
                    @foreach($produks as $p)
                        <option value="{{ $p->id }}"
                                data-nama="{{ $p->nama_produk }}"
                                data-harga="{{ $p->harga }}"
                                data-stok="{{ $p->stok }}">
                            {{ $p->kode_produk }} — {{ $p->nama_produk }} (Rp {{ number_format($p->harga, 0, ',', '.') }} | Stok: {{ $p->stok }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" id="jumlahProduk" class="form-control-custom" placeholder="Qty" min="1" value="1">
            </div>
            <div class="col-md-3">
                <button type="button" class="btn-primary-custom w-100" onclick="tambahItem()" style="justify-content:center;">
                    <i class="bi bi-plus-circle"></i> Tambah Item
                </button>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th width="100">Qty</th>
                        <th width="150">Harga</th>
                        <th width="150">Subtotal</th>
                        <th width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody id="bodyItem">
                    <tr id="rowKosong">
                        <td colspan="5" style="text-align:center; color:#94a3b8; padding:30px;">
                            <i class="bi bi-cart-x" style="font-size:2rem; display:block; margin-bottom:8px;"></i>
                            Belum ada item
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr style="background:#f8fafc;">
                        <th colspan="3" style="text-align:right; padding:16px 18px; font-size:0.9rem;">TOTAL</th>
                        <th id="totalDisplay" style="padding:16px 18px; font-size:1.2rem; color:#059669;">Rp 0</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="card-custom" style="margin-bottom:20px;">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label-custom">Uang Bayar <span style="color:#ef4444;">*</span></label>
                <input type="number" name="bayar" id="inputBayar" class="form-control-custom"
                       min="0" placeholder="0" required style="font-size:1.1rem; font-weight:700;">
            </div>
            <div class="col-md-6">
                <label class="form-label-custom">Kembalian</label>
                <input type="text" id="kembalianDisplay" class="form-control-custom" readonly
                       value="Rp 0" style="font-size:1.1rem; font-weight:700; background:#f8fafc;">
            </div>
        </div>
    </div>

    <div style="display:flex; gap:10px;">
        <button type="submit" class="btn-primary-custom" id="btnSimpan" disabled>
            <i class="bi bi-check-circle-fill"></i> Simpan Transaksi
        </button>
        <a href="{{ route('transaksi.index') }}" class="btn-secondary-custom">Batal</a>
    </div>
</form>

@push('scripts')
<script>
let items = [];

function formatRp(n) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(n);
}

function tambahItem() {
    const sel = document.getElementById('pilihProduk');
    const qty = parseInt(document.getElementById('jumlahProduk').value) || 0;
    const opt = sel.options[sel.selectedIndex];

    if (!sel.value) return alert('Pilih produk dulu!');
    if (qty < 1) return alert('Jumlah minimal 1!');

    const stok = parseInt(opt.dataset.stok);
    if (qty > stok) return alert('Stok tidak cukup! Tersedia: ' + stok);

    const produkId = sel.value;
    const existing = items.find(i => i.produk_id == produkId);
    if (existing) {
        existing.jumlah += qty;
        if (existing.jumlah > stok) return alert('Total qty melebihi stok!');
    } else {
        items.push({
            produk_id: produkId,
            nama: opt.dataset.nama,
            harga: parseFloat(opt.dataset.harga),
            jumlah: qty
        });
    }

    renderTabel();
    sel.value = '';
    document.getElementById('jumlahProduk').value = 1;
}

function hapusItem(idx) {
    items.splice(idx, 1);
    renderTabel();
}

function renderTabel() {
    const tbody = document.getElementById('bodyItem');
    tbody.innerHTML = '';

    if (items.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; color:#94a3b8; padding:30px;"><i class="bi bi-cart-x" style="font-size:2rem; display:block; margin-bottom:8px;"></i>Belum ada item</td></tr>';
    } else {
        items.forEach((item, idx) => {
            const subtotal = item.harga * item.jumlah;
            tbody.innerHTML += `
                <tr>
                    <td><strong>${item.nama}</strong>
                        <input type="hidden" name="produk_id[]" value="${item.produk_id}">
                        <input type="hidden" name="jumlah[]" value="${item.jumlah}">
                    </td>
                    <td>${item.jumlah}</td>
                    <td>${formatRp(item.harga)}</td>
                    <td><strong style="color:#059669;">${formatRp(subtotal)}</strong></td>
                    <td>
                        <button type="button" class="btn-sm-custom btn-delete" onclick="hapusItem(${idx})">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </td>
                </tr>`;
        });
    }

    const total = items.reduce((s, i) => s + (i.harga * i.jumlah), 0);
    document.getElementById('totalDisplay').innerText = formatRp(total);
    document.getElementById('btnSimpan').disabled = items.length === 0;
    hitungKembalian();
}

function hitungKembalian() {
    const total = items.reduce((s, i) => s + (i.harga * i.jumlah), 0);
    const bayar = parseFloat(document.getElementById('inputBayar').value) || 0;
    const kembalian = bayar - total;
    document.getElementById('kembalianDisplay').value = formatRp(kembalian >= 0 ? kembalian : 0);
}

document.getElementById('inputBayar').addEventListener('input', hitungKembalian);

document.getElementById('formTransaksi').addEventListener('submit', function(e) {
    const total = items.reduce((s, i) => s + (i.harga * i.jumlah), 0);
    const bayar = parseFloat(document.getElementById('inputBayar').value) || 0;
    if (bayar < total) {
        e.preventDefault();
        alert('Uang bayar kurang! Total: ' + formatRp(total));
    }
});
</script>
@endpush

@endsection