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
        // 0. SECURITY: Rate limiting untuk prevent brute force
        $maxAttempts = 5;
        $decayMinutes = 15;
        $throttleKey = 'login_attempts:' . $request->ip();
        
        if (cache()->get($throttleKey, 0) >= $maxAttempts) {
            return back()->withErrors([
                'username' => "Terlalu banyak attempt login gagal. Silakan coba lagi dalam {$decayMinutes} menit.",
            ])->withInput($request->except('password'));
        }
        
        // 1. Validasi input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // 1.5. SECURITY: Regenerate session SEBELUM login attempt (prevent session fixation)
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 2. Coba Login
        if (Auth::attempt($credentials)) {
            // SECURITY: Regenerate session SESUDAH successful login
            $request->session()->regenerate();
            
            // Clear rate limit counter on successful login
            cache()->forget($throttleKey);

            // 3. Pengalihan Berdasarkan Role
            $user = Auth::user();
            
            if ($user->role === 'superadmin') {
                return redirect()->intended('/dashboard-admin');
            } elseif ($user->role === 'provinsi') {
                return redirect()->intended('/dashboard-provinsi');
            } elseif ($user->role === 'daerah') {
                return redirect()->intended('/dashboard-kakot');
            }
        }

        // Increment failed attempt counter
        cache()->increment($throttleKey, 1, $decayMinutes * 60);

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