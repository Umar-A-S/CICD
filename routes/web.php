<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Kota\DashboardKotaController;
use App\Http\Controllers\PermohonanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- GUEST ROUTES (Hanya bisa diakses jika BELUM login) ---
Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'showLogin']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// --- AUTH ROUTES (Hanya bisa diakses jika SUDAH login) ---
Route::middleware(['auth'])->group(function () {
    
    // Proses Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 1. LEVEL KOTA/KABUPATEN
    Route::get('/dashboard_kakot', [DashboardKotaController::class, 'index'])->name('dashboard.kota');
    
    // Fitur Permohonan
    Route::get('/permohonan_kakot', function () {
        return view('kota.permohonan_kakot', ['title' => 'Permohonan']);
    });
    Route::get('/api/permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
    Route::post('/api/permohonan', [PermohonanController::class, 'store'])->name('permohonan.store');
    Route::get('/api/permohonan/{id}', [PermohonanController::class, 'show'])->name('permohonan.show');
    
    Route::get('/detail_permohonan_kakot/{id}', function ($id) {
        return view('kota.detail_permohonan_kakot', ['title' => 'Detail Permohonan', 'id' => $id]);
    });

    Route::get('/penerbitan_kakot', function () {
        return view('kota.penerbitan_kakot', ['title' => 'Penerbitan']);
    });

    Route::get('/unggah_penerbitan_kakot', function () {
        return view('kota.unggah_penerbitan_kakot', ['title' => 'Unggah Penerbitan']);
    });

    Route::get('/detail_penerbitan_kakot', function () {
        return view('kota.detail_penerbitan_kakot', ['title' => 'Detail Penerbitan']);
    });
    Route::get('/balasan_kakot', function () {
        return view('kota.balasan_kakot', ['title' => 'Balasan']);
    });
    Route::get('/profil_kakot', function () {
        return view('kota.profil_kakot', ['title' => 'Profil']);
    });

    // 2. LEVEL PROVINSI (Admin Jateng) - Tambahkan controller nanti
    Route::get('/dashboard-provinsi', function () {
        return "Halaman Dashboard Provinsi (Sedang dikembangkan)";
    })->name('dashboard.provinsi');

    // 3. LEVEL SUPERADMIN - Tambahkan controller nanti
    Route::get('/dashboard-admin', function () {
        return "Halaman Dashboard Superadmin (Sedang dikembangkan)";
    })->name('dashboard.admin');

});
