<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::withCount('produks')->latest()->paginate(10);
        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100|unique:kategoris,nama_kategori',
            'keterangan' => 'nullable|max:255',
        ]);

        Kategori::create($request->all());

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Tambah kategori: ' . $request->nama_kategori,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100|unique:kategoris,nama_kategori,' . $kategori->id,
            'keterangan' => 'nullable|max:255',
        ]);

        $kategori->update($request->all());

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Edit kategori: ' . $kategori->nama_kategori,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->produks()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki produk!');
        }

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Hapus kategori: ' . $kategori->nama_kategori,
        ]);

        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}