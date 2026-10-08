<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $id => $item) {
            $produk = Produk::find($id);
            if ($produk) {
                $subtotal = $produk->harga * $item['jumlah'];
                $items[] = [
                    'produk' => $produk,
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
            }
        }

        $cart_count = collect($cart)->sum('jumlah');
        return view('shop.cart', compact('items', 'total', 'cart_count'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        if ($produk->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak cukup! Tersedia: ' . $produk->stok);
        }

        $cart = session('cart', []);
        $id = $request->produk_id;

        if (isset($cart[$id])) {
            $cart[$id]['jumlah'] += $request->jumlah;
        } else {
            $cart[$id] = ['jumlah' => $request->jumlah];
        }

        if ($cart[$id]['jumlah'] > $produk->stok) {
            return back()->with('error', 'Total jumlah melebihi stok!');
        }

        session(['cart' => $cart]);

        return redirect()->route('shop.cart')->with('success', $produk->nama_produk . ' berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->produk_id);
        if ($request->jumlah > $produk->stok) {
            return back()->with('error', 'Stok tidak cukup!');
        }

        $cart = session('cart', []);
        if (isset($cart[$request->produk_id])) {
            $cart[$request->produk_id]['jumlah'] = $request->jumlah;
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Request $request)
    {
        $cart = session('cart', []);
        unset($cart[$request->produk_id]);
        session(['cart' => $cart]);

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('shop.index')->with('success', 'Keranjang dikosongkan.');
    }
}