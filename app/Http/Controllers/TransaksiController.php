<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'kasir') {
            $transaksis = Transaksi::with('kasir')
                            ->where('kasir_id', $user->id)
                            ->latest()->paginate(10);
        } else {
            $transaksis = Transaksi::with('kasir')->latest()->paginate(10);
        }
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $produks = Produk::where('stok', '>', 0)->with('kategori')->get();
        return view('transaksi.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|array|min:1',
            'produk_id.*' => 'exists:produks,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
            'bayar' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            $items = [];

            foreach ($request->produk_id as $i => $pid) {
                $produk = Produk::findOrFail($pid);
                $jumlah = $request->jumlah[$i];

                if ($produk->stok < $jumlah) {
                    return back()->with('error', "Stok {$produk->nama_produk} tidak cukup!");
                }

                $subtotal = $produk->harga * $jumlah;
                $total += $subtotal;

                $items[] = [
                    'produk_id' => $pid,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $produk->harga,
                    'subtotal' => $subtotal,
                ];
            }

            if ($request->bayar < $total) {
                return back()->with('error', 'Uang bayar kurang!');
            }

            $transaksi = Transaksi::create([
                'kode_transaksi' => 'TRX-' . date('YmdHis'),
                'kasir_id' => Auth::id(),
                'total' => $total,
                'bayar' => $request->bayar,
                'kembalian' => $request->bayar - $total,
                'tanggal_transaksi' => now(),
            ]);

            foreach ($items as $item) {
                $item['transaksi_id'] = $transaksi->id;
                DetailTransaksi::create($item);
                Produk::where('id', $item['produk_id'])->decrement('stok', $item['jumlah']);
            }

            LogAktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Transaksi baru: ' . $transaksi->kode_transaksi,
            ]);

            DB::commit();
            return redirect()->route('transaksi.show', $transaksi->id)
                ->with('success', 'Transaksi berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load('kasir', 'details.produk');
        return view('transaksi.show', compact('transaksi'));
    }

    public function struk(Transaksi $transaksi)
    {
        $transaksi->load('kasir', 'details.produk');
        return view('transaksi.struk', compact('transaksi'));
    }
        // ============ ORDER ONLINE (Admin/Kasir) ============
    public function orders()
    {
        $orders = Transaksi::with('details.produk')
                    ->where('type', 'online')
                    ->latest()
                    ->paginate(15);

        $total_pending = Transaksi::where('type', 'online')->where('order_status', 'pending')->count();
        $total_diproses = Transaksi::where('type', 'online')->where('order_status', 'diproses')->count();
        $total_dikirim = Transaksi::where('type', 'online')->where('order_status', 'dikirim')->count();
        $total_selesai = Transaksi::where('type', 'online')->where('order_status', 'selesai')->count();

        return view('transaksi.orders', compact('orders', 'total_pending', 'total_diproses', 'total_dikirim', 'total_selesai'));
    }

    public function updateOrderStatus(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'order_status' => 'required|in:pending,diproses,dikirim,selesai,dibatalkan',
        ]);

        $transaksi->update(['order_status' => $request->order_status]);

        LogAktivitas::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'aktivitas' => 'Update status order ' . $transaksi->kode_transaksi . ' → ' . $request->order_status,
        ]);

        return back()->with('success', 'Status pesanan diperbarui!');
    }

    public function orderDetail(Transaksi $transaksi)
    {
        $transaksi->load('details.produk');
        return view('transaksi.order_detail', compact('transaksi'));
    }
}