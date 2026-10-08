<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;

class ShopController extends Controller
{
    public function index()
    {
        $query = Produk::with('kategori')->where('stok', '>', 0);

        if (request('q')) {
            $query->where(function ($q) {
                $q->where('nama_produk', 'like', '%' . request('q') . '%')
                  ->orWhere('kode_produk', 'like', '%' . request('q') . '%');
            });
        }

        if (request('kategori')) {
            $query->where('kategori_id', request('kategori'));
        }

        $produks = $query->latest()->paginate(12);
        $kategoris = Kategori::all();
        $cart_count = collect(session('cart', []))->sum('jumlah');

        return view('shop.index', compact('produks', 'kategoris', 'cart_count'));
    }

    public function show(Produk $produk)
    {
        $produks_lain = Produk::where('kategori_id', $produk->kategori_id)
                            ->where('id', '!=', $produk->id)
                            ->where('stok', '>', 0)
                            ->take(4)->get();
        $cart_count = collect(session('cart', []))->sum('jumlah');

        return view('shop.show', compact('produk', 'produks_lain', 'cart_count'));
    }

    public function track()
    {
        $transaksi = null;
        if (request('kode')) {
            $transaksi = \App\Models\Transaksi::with('details.produk')
                        ->where('kode_transaksi', request('kode'))
                        ->where('type', 'online')
                        ->first();
        }
        $cart_count = collect(session('cart', []))->sum('jumlah');

        return view('shop.track', compact('transaksi', 'cart_count'));
    }
}