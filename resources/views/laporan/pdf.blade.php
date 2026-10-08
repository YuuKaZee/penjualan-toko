<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        h2 { text-align: center; margin-bottom: 5px; }
        p.sub { text-align: center; margin-top: 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 5px; text-align: left; }
        th { background-color: #f0f0f0; }
        .footer { margin-top: 30px; text-align: right; }
        .total { background-color: #e7f3ff; font-weight: bold; }
    </style>
</head>
<body>
    <h2>TOKO SAYA</h2>
    <p class="sub">Laporan Penjualan</p>
    <hr>
    <p>Tanggal Cetak: {{ date('d-m-Y H:i') }}</p>
    @if(request('dari'))
        <p>Periode: {{ request('dari') }} s/d {{ request('sampai') ?? date('Y-m-d') }}</p>
    @endif
    <p>Total Transaksi: {{ $transaksis->count() }}</p>
    <p><strong>Total Pendapatan: Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</strong></p>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Kode</th>
                <th>Kasir</th>
                <th>Total</th>
                <th>Bayar</th>
                <th>Kembalian</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $i => $t)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $t->kode_transaksi }}</td>
                <td>{{ $t->kasir->nama ?? '-' }}</td>
                <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($t->bayar, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($t->kembalian, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d-m-Y H:i') }}</td>
            </tr>
            @endforeach
            <tr class="total">
                <td colspan="3" style="text-align:right;">TOTAL PENDAPATAN</td>
                <td colspan="4">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>{{ date('d-m-Y') }}</p>
        <br><br><br>
        <p><strong>Pemilik Toko</strong></p>
    </div>
</body>
</html>