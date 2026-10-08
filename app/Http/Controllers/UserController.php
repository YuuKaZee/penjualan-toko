<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Tampilkan daftar semua user.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);

        // Statistik kecil untuk header
        $total_admin = User::where('role', 'admin')->count();
        $total_kasir = User::where('role', 'kasir')->count();
        $total_pemilik = User::where('role', 'pemilik')->count();
        $total_aktif = User::where('status', 'aktif')->count();

        return view('user.index', compact(
            'users',
            'total_admin',
            'total_kasir',
            'total_pemilik',
            'total_aktif'
        ));
    }

    /**
     * Form tambah user baru.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Simpan user baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'username' => 'required|max:50|unique:users,username|alpha_dash',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,kasir,pemilik',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'nama.required' => 'Nama wajib diisi!',
            'username.required' => 'Username wajib diisi!',
            'username.unique' => 'Username sudah dipakai!',
            'username.alpha_dash' => 'Username hanya boleh huruf, angka, tanda - dan _',
            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Password minimal 6 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
            'role.required' => 'Role wajib dipilih!',
            'status.required' => 'Status wajib dipilih!',
        ]);

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Tambah user: ' . $request->username . ' (' . $request->role . ')',
        ]);

        return redirect()->route('user.index')
            ->with('success', 'User "' . $request->nama . '" berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail user (opsional).
     */
    public function show(User $user)
    {
        // Hitung statistik user
        $total_transaksi = $user->transaksis()->count();
        $total_pendapatan = $user->transaksis()->sum('total');

        return view('user.show', compact('user', 'total_transaksi', 'total_pendapatan'));
    }

    /**
     * Form edit user.
     */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update data user.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'username' => 'required|max:50|alpha_dash|unique:users,username,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|in:admin,kasir,pemilik',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'nama.required' => 'Nama wajib diisi!',
            'username.required' => 'Username wajib diisi!',
            'username.unique' => 'Username sudah dipakai user lain!',
            'username.alpha_dash' => 'Username hanya boleh huruf, angka, tanda - dan _',
            'password.min' => 'Password minimal 6 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
            'role.required' => 'Role wajib dipilih!',
            'status.required' => 'Status wajib dipilih!',
        ]);

        // Cegah admin mengubah dirinya menjadi nonaktif
        if ($user->id === Auth::id() && $request->status === 'nonaktif') {
            return back()->with('error', 'Anda tidak bisa menonaktifkan akun sendiri!');
        }

        // Cegah admin mengubah role dirinya sendiri (biar tidak terkunci)
        if ($user->id === Auth::id() && $request->role !== 'admin') {
            return back()->with('error', 'Anda tidak bisa mengubah role akun sendiri!');
        }

        $data = [
            'nama' => $request->nama,
            'username' => $request->username,
            'role' => $request->role,
            'status' => $request->status,
        ];

        // Update password kalau diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Edit user: ' . $user->username,
        ]);

        return redirect()->route('user.index')
            ->with('success', 'User "' . $user->nama . '" berhasil diperbarui!');
    }

    /**
     * Hapus user.
     */
    public function destroy(User $user)
    {
        // Cegah hapus akun sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        // Cegah hapus admin terakhir
        if ($user->role === 'admin') {
            $total_admin = User::where('role', 'admin')->count();
            if ($total_admin <= 1) {
                return back()->with('error', 'Tidak bisa menghapus admin terakhir!');
            }
        }

        // Cek apakah user punya transaksi
        if ($user->transaksis()->count() > 0) {
            return back()->with('error', 'User tidak bisa dihapus karena memiliki ' . $user->transaksis()->count() . ' transaksi. Nonaktifkan saja akunnya.');
        }

        $nama = $user->nama;
        $username = $user->username;

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Hapus user: ' . $username,
        ]);

        $user->delete();

        return redirect()->route('user.index')
            ->with('success', 'User "' . $nama . '" berhasil dihapus!');
    }

    /**
     * Reset password user (bonus).
     */
    public function resetPassword(User $user)
    {
        $user->update([
            'password' => Hash::make('password123'),
        ]);

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Reset password user: ' . $user->username,
        ]);

        return back()->with('success', 'Password user ' . $user->username . ' direset ke "password123".');
    }
}