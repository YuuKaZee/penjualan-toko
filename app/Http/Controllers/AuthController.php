<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLogin()
    {
        // Kalau sudah login, langsung ke dashboard
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username wajib diisi!',
            'password.required' => 'Password wajib diisi!',
        ]);

        // Coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek status aktif
            if (Auth::user()->status !== 'aktif') {
                Auth::logout();
                return back()->with('error', 'Akun Anda nonaktif. Hubungi Admin.');
            }

            // Catat log aktivitas
            \App\Models\LogAktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Login ke sistem',
            ]);

            return redirect()->intended('/dashboard')
                ->with('success', 'Selamat datang, ' . Auth::user()->nama . '!');
        }

        // Login gagal
        return back()
            ->withInput($request->only('username'))
            ->with('error', 'Username atau password salah!');
    }

    /**
     * Logout dari sistem.
     */
    public function logout(Request $request)
    {
        // Catat log sebelum logout
        if (Auth::check()) {
            \App\Models\LogAktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Logout dari sistem',
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}