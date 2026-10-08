<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $hariIni = now()->toDateString();

        $data = [
            'user' => $user,
            'total_produk' => Produk::count(),
            'total_transaksi' => Transaksi::count(),
            'transaksi_hari_ini' => Transaksi::whereDate('tanggal_transaksi', $hariIni)->count(),
            'pendapatan_hari_ini' => Transaksi::whereDate('tanggal_transaksi', $hariIni)->sum('total'),
            'transaksi_terbaru' => Transaksi::with('kasir')->latest()->take(5)->get(),
        ];

        if ($user->role === 'admin') {
            $data['total_kategori'] = Kategori::count();
            $data['total_user'] = User::count();
            $data['pendapatan_total'] = Transaksi::sum('total');
        }

        if ($user->role === 'kasir') {
            $data['transaksi_saya'] = Transaksi::where('kasir_id', $user->id)->count();
            $data['pendapatan_saya'] = Transaksi::where('kasir_id', $user->id)->sum('total');
        }

        if ($user->role === 'pemilik') {
            $data['produk_stok_rendah'] = Produk::where('stok', '<', 10)->count();
            $data['produk_terlaris'] = Produk::withCount('detailTransaksis')
                                            ->orderByDesc('detail_transaksis_count')
                                            ->take(5)
                                            ->get();
        }

        return view('dashboard', $data);
    }
}