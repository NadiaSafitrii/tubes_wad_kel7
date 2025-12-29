<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Tampilkan Form Login
    public function showLoginForm()
    {
        return view('login');
    }

    // 2. Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // LOGIKA PEMBAGIAN ARAH:
            $role = Auth::user()->role;

            if ($role === 'admin') {
                // Jika Admin -> Ke Halaman Kelola Barang
                return redirect()->intended('/ketersediaan');
            } else {
                // Jika Mahasiswa -> Ke Dashboard Mahasiswa
                return redirect()->intended('/mahasiswa/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // 3. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}