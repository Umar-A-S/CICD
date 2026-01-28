<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Kota\DashboardKotaController;
use App\Http\Controllers\Kota\PermohonanController;
use App\Http\Controllers\Kota\BalasanController;    
use App\Http\Controllers\Kota\PenerbitanController;
use App\Http\Controllers\Kota\ProfilController;

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

    //---USER DAERAH---
    
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

    // --Fitur Balasan
    Route::get('/balasan_kakot', [BalasanController::class, 'index'])->name('balasan.index');
    Route::get('/detail_balasan_kakot/{id}', [BalasanController::class, 'show'])->name('balasan.show');

    //-- Fitur Penerbitan
    Route::get('/penerbitan_kakot', [PenerbitanController::class, 'index'])->name('penerbitan.index');
    Route::get('/penerbitan_kakot/proses/{id}', [PenerbitanController::class, 'create'])->name('penerbitan.create');
    Route::post('/penerbitan_kakot/simpan', [PenerbitanController::class, 'store'])->name('penerbitan.store');
    Route::get('/detail_penerbitan_kakot/{id}', [PenerbitanController::class, 'show'])->name('penerbitan.show');


    Route::get('/detail_penerbitan_kakot', function () {
        return view('kota.detail_penerbitan_kakot', ['title' => 'Detail Penerbitan']);
    });

    // Route Profil (Cuma satu baris cukup)
        Route::get('/profil_kakot', [ProfilController::class, 'index'])->name('profil.index');
    
    //---USER PROVINSI---
    // 2. LEVEL PROVINSI (Admin Jateng) - Tambahkan controller nanti
    Route::get('/dashboard_provinsi', function () {
        return view('provinsi.dashboard_prov', ['title' => 'Dashboard']);
    });
    Route::get('/detail_permohonan_prov/{id}', [PermohonanController::class, 'show']);

    Route::get('/penerbitan-provinsi', function () {
        return view('provinsi.penerbitan_prov', ['title' => 'Penerbitan']);
    });
    Route::get('/detail-penerbitan-prov', function () {
        return view('provinsi.detail_penerbitan_prov', ['title' => 'Detail Penerbitan']);
    });
    Route::get('/unggah-penerbitan-prov', function () {
        return view('provinsi.unggah_penerbitan_prov', ['title' => 'Unggah Penerbitan']);
    });

    Route::get('/balasan-provinsi', function () {
        return view('provinsi.balasan_prov', ['title' => 'Balasan']);
    });
    Route::get('/detail-balasan-prov', function () {
        return view('provinsi.detail_balasan_prov', ['title' => 'Detail balasan']);
    });

    Route::get('/profil-provinsi', function () {
        return view('provinsi.profil_prov', ['title' => 'Profil']);
    });

    // 3. LEVEL SUPERADMIN - Tambahkan controller nanti
    Route::get('/dashboard-admin', function () {
        return "Halaman Dashboard Superadmin (Sedang dikembangkan)";
    })->name('dashboard.admin');

});
