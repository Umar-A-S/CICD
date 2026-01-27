<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Kota\DashboardKotaController;
use App\Http\Controllers\Kota\PermohonanController;
use App\Http\Controllers\Kota\BalasanController;    


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
    Route::get('/permohonan_kakot', [PermohonanController::class, 'index'])->name('permohonan.index');
    Route::post('/permohonan_kakot', [PermohonanController::class, 'store'])->name('permohonan.store');
    Route::get('/detail_permohonan_kakot/{id}', [PermohonanController::class, 'show']); // Fitur detail yang baru

    // Menu Balasan
    Route::get('/balasan_kakot', [BalasanController::class, 'index'])->name('balasan.index');
    Route::get('/detail_balasan_kakot/{id}', [BalasanController::class, 'show'])->name('balasan.show');

    Route::get('/penerbitan_kakot', function () {
        return view('kota.penerbitan_kakot', ['title' => 'Penerbitan']);
    });

    Route::get('/unggah_penerbitan_kakot', function () {
        return view('kota.unggah_penerbitan_kakot', ['title' => 'Unggah Penerbitan']);
    });

    Route::get('/detail_penerbitan_kakot', function () {
        return view('kota.detail_penerbitan_kakot', ['title' => 'Detail Penerbitan']);
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
