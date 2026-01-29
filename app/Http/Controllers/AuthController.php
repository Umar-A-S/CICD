<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // 2. Coba Login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Pengalihan Berdasarkan Role
            $user = Auth::user();
            
            if ($user->role === 'superadmin') {
                return redirect()->intended('/dashboard-admin'); // Sesuaikan route-mu
            } elseif ($user->role === 'provinsi') {
                return redirect()->intended('/dashboard_provinsi'); // Sesuaikan route-mu
            } elseif ($user->role === 'daerah') {
                return redirect()->intended('/dashboard_kakot');
            }
        }

        // Jika gagal, balikkan ke login dengan pesan error
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}