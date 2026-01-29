<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Menangani permintaan yang datang.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  (Parameter role dari web.php)
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek apakah role user saat ini sesuai dengan yang diminta rute
        if (Auth::user()->role !== $role) {
            // Jika tidak sesuai, tampilkan error 403 (Forbidden)
            abort(403, 'Maaf, Anda tidak memiliki akses ke halaman ini.');
        }

        // Jika lolos pengecekan, lanjut ke rute berikutnya
        return $next($request);
    }
}