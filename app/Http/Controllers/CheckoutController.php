<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Keranjang masih kosong.');
        }

        $items = [];
        $total = 0;
        foreach ($cart as $id => $item) {
            $produk = Produk::find($id);
            if ($produk) {
                $subtotal = $produk->harga * $item['jumlah'];
                $items[] = ['produk' => $produk, 'jumlah' => $item['jumlah'], 'subtotal' => $subtotal];
                $total += $subtotal;
            }
        }

        $cart_count = collect($cart)->sum('jumlah');
        return view('shop.checkout', compact('items', 'total', 'cart_count'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|max:100',
            'customer_phone' => 'required|max:20',
            'customer_address' => 'required|max:500',
            'customer_note' => 'nullable|max:500',
        ], [
            'customer_name.required' => 'Nama wajib diisi!',
            'customer_phone.required' => 'No. HP wajib diisi!',
            'customer_address.required' => 'Alamat wajib diisi!',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Keranjang kosong.');
        }

        DB::beginTransaction();
        try {
            $total = 0;
            $items = [];

            foreach ($cart as $id => $item) {
                $produk = Produk::findOrFail($id);
                if ($produk->stok < $item['jumlah']) {
                    throw new \Exception("Stok {$produk->nama_produk} tidak cukup!");
                }
                $subtotal = $produk->harga * $item['jumlah'];
                $total += $subtotal;
                $items[] = [
                    'produk_id' => $id,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $produk->harga,
                    'subtotal' => $subtotal,
                ];
            }

            $transaksi = Transaksi::create([
                'kode_transaksi' => 'ONL-' . date('YmdHis'),
                'type' => 'online',
                'kasir_id' => null,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'customer_note' => $request->customer_note,
                'order_status' => 'pending',
                'total' => $total,
                'bayar' => $total,
                'kembalian' => 0,
                'tanggal_transaksi' => now(),
            ]);

            foreach ($items as $item) {
                $item['transaksi_id'] = $transaksi->id;
                DetailTransaksi::create($item);
                Produk::where('id', $item['produk_id'])->decrement('stok', $item['jumlah']);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('shop.success', $transaksi->kode_transaksi);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function success($kode)
    {
        $transaksi = Transaksi::with('details.produk')
                    ->where('kode_transaksi', $kode)
                    ->where('type', 'online')
                    ->firstOrFail();
        $cart_count = 0;

        return view('shop.success', compact('transaksi', 'cart_count'));
    }
}