<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with('kategori')->latest()->paginate(10);
        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|unique:produks,kode_produk',
            'nama_produk' => 'required|max:150',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('produk_images'), $filename);
            $data['gambar'] = $filename;
        }

        Produk::create($data);

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Tambah produk: ' . $request->nama_produk,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Produk $produk)
    {
        return view('produk.show', compact('produk'));
    }

    public function edit(Produk $produk)
    {
        $kategoris = Kategori::all();
        return view('produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'kode_produk' => 'required|unique:produks,kode_produk,' . $produk->id,
            'nama_produk' => 'required|max:150',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            if ($produk->gambar && file_exists(public_path('produk_images/' . $produk->gambar))) {
                unlink(public_path('produk_images/' . $produk->gambar));
            }
            $file = $request->file('gambar');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('produk_images'), $filename);
            $data['gambar'] = $filename;
        }

        $produk->update($data);

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Edit produk: ' . $produk->nama_produk,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->gambar && file_exists(public_path('produk_images/' . $produk->gambar))) {
            unlink(public_path('produk_images/' . $produk->gambar));
        }

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Hapus produk: ' . $produk->nama_produk,
        ]);

        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function cari(Request $request)
    {
        $keyword = $request->q;
        $produks = Produk::with('kategori')
                    ->where('nama_produk', 'like', "%$keyword%")
                    ->orWhere('kode_produk', 'like', "%$keyword%")
                    ->latest()->paginate(10);
        return view('produk.index', compact('produks', 'keyword'));
    }
}