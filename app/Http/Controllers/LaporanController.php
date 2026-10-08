<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Kategori;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with('kasir');

        if ($request->dari) $query->whereDate('tanggal_transaksi', '>=', $request->dari);
        if ($request->sampai) $query->whereDate('tanggal_transaksi', '<=', $request->sampai);
        if ($request->kasir_id) $query->where('kasir_id', $request->kasir_id);

        $transaksis = $query->latest()->get();
        $total_pendapatan = $transaksis->sum('total');

        return view('laporan.index', compact('transaksis', 'total_pendapatan'));
    }

    public function pdf(Request $request)
    {
        $query = Transaksi::with('kasir');
        if ($request->dari) $query->whereDate('tanggal_transaksi', '>=', $request->dari);
        if ($request->sampai) $query->whereDate('tanggal_transaksi', '<=', $request->sampai);

        $transaksis = $query->latest()->get();
        $total_pendapatan = $transaksis->sum('total');

        $pdf = Pdf::loadView('laporan.pdf', compact('transaksis', 'total_pendapatan'));
        return $pdf->download('laporan-penjualan-' . date('Y-m-d') . '.pdf');
    }
}