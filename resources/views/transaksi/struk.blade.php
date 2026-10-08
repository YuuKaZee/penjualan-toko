<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk - {{ $transaksi->kode_transaksi }}</title>
    <style>
        body { font-family: 'Courier New', monospace; font-size: 12px; width: 280px; margin: 10px auto; }
        h2 { text-align: center; margin: 5px 0; }
        .center { text-align: center; }
        hr { border: none; border-top: 1px dashed #000; margin: 8px 0; }
        table { width: 100%; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <h2>🛒 TOKO SAYA</h2>
    <div class="center">
        Jl. Contoh No. 123<br>
        Telp: 0812-3456-7890
    </div>
    <hr>
    <table>
        <tr><td>Kode</td><td class="right">{{ $transaksi->kode_transaksi }}</td></tr>
        <tr><td>Tanggal</td><td class="right">{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d-m-Y H:i') }}</td></tr>
        <tr><td>Kasir</td><td class="right">{{ $transaksi->kasir->nama ?? '-' }}</td></tr>
    </table>
    <hr>
    @foreach($transaksi->details as $d)
        <div>{{ $d->produk->nama_produk ?? '-' }}</div>
        <table>
            <tr>
                <td>{{ $d->jumlah }} x {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                <td class="right">{{ number_format($d->subtotal, 0, ',', '.') }}</td>
            </tr>
        </table>
    @endforeach
    <hr>
    <table>
        <tr><td class="bold">TOTAL</td><td class="right bold">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td></tr>
        <tr><td>BAYAR</td><td class="right">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td></tr>
        <tr><td>KEMBALI</td><td class="right">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td></tr>
    </table>
    <hr>
    <div class="center">
        ~~~ Terima Kasih ~~~<br>
        Selamat berbelanja kembali!
    </div>
    <div class="center no-print" style="margin-top:20px;">
        <button onclick="window.print()">🖨️ Cetak</button>
        <button onclick="window.close()">✖ Tutup</button>
    </div>
</body>
</html>