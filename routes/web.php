<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Kota\DashboardKotaController;
use App\Http\Controllers\Kota\PermohonanController;
use App\Http\Controllers\Kota\BalasanController;    
use App\Http\Controllers\Kota\PenerbitanController;
use App\Http\Controllers\Kota\ProfilController;
use App\Http\Controllers\Provinsi\DashboardProvController;
use App\Http\Controllers\Provinsi\VerifikasiController;
use App\Http\Controllers\Provinsi\PenerbitanProv;
use App\Http\Controllers\Provinsi\PermohonanProvController;
use App\Http\Controllers\Provinsi\ProfilProvController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- GUEST ROUTES (Hanya bisa diakses jika BELUM login) ---
Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'showLogin']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    
    // SECURITY: Rate limit login attempts (5 per 15 minutes per IP)
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,15');
});

// --- AUTH ROUTES (Hanya bisa diakses jika SUDAH login) ---
Route::middleware(['auth'])->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::middleware(['checkrole:daerah'])->group(function () 
    {  
        // 1. LEVEL KOTA/KABUPATEN
        Route::get('/dashboard_kakot', [DashboardKotaController::class, 'index'])->name('dashboard.kakot');

        // Route Permohonan
        Route::get('/permohonan_kakot', [PermohonanController::class, 'index'])->name('permohonan.index');
        Route::get('/permohonan_kakot/create', [PermohonanController::class, 'create'])->name('permohonan.create');
        Route::post('/permohonan_kakot', [PermohonanController::class, 'store'])->name('permohonan.store');
        Route::get('/detail_permohonan/{id}', [PermohonanController::class, 'show'])->name('permohonan.show');
        Route::get('/download_permohonan/{id}', [PermohonanController::class, 'downloadFile'])->name('permohonan.download');

        // Route Penerbitan
        Route::get('/penerbitan_kakot', [PenerbitanController::class, 'index'])->name('penerbitan.index');
        Route::get('/detail_permohonan_penerbitan/{id}', [PenerbitanController::class, 'detailPermohonan'])->name('penerbitan.detailPermohonan');
        Route::get('/detail_penerbitan_kakot/{id}', [PenerbitanController::class, 'show'])->name('penerbitan.show');
        Route::get('/unggah_penerbitan_kakot/proses/{id}', [PenerbitanController::class, 'create'])->name('penerbitan.create');
        Route::post('/unggah_penerbitan_kakot/proses', [PenerbitanController::class, 'store'])->name('penerbitan.store');
        Route::get('/download_penerbitan/{id}', [PenerbitanController::class, 'downloadPenerbitanFile'])->name('penerbitan.download');
        Route::get('/download_permohonan_from_penerbitan/{id}', [PenerbitanController::class, 'downloadPermohonanFile'])->name('penerbitan.download_permohonan');
        

        // Route Balasan
        Route::get('/balasan_kakot', [BalasanController::class, 'index'])->name('balasan.index');
        Route::get('/detail_balasan_kakot/{id}', [BalasanController::class, 'show'])->name('balasan.show');
         // Route Profil Instansi
        Route::get('/profil_kakot', [ProfilController::class, 'index'])->name('profil.index');
    

    });



    //---USER PROVINSI---
    Route::middleware(['checkrole:provinsi'])->group(function () 
    {  
        
        // 2. LEVEL PROVINSI (Admin Jateng)
        Route::get('/dashboard_provinsi', [DashboardProvController::class, 'index'])->name('provinsi.dashboard');
        
        // Route Verifikasi (NEW - Menu baru)
        Route::get('/verifikasi', [VerifikasiController::class, 'index'])->name('provinsi.verifikasi.index');
        Route::post('/verifikasi/{id}', [VerifikasiController::class, 'verifikasi'])->name('provinsi.verifikasi.submit');
        Route::post('/verifikasi/tolak/{id}', [VerifikasiController::class, 'tolak'])->name('provinsi.tolak');
        
        // Old routes (backward compatibility)
        Route::post('/provinsi/verifikasi/{id}', [DashboardProvController::class, 'verifikasi'])->name('provinsi.verifikasi.old');
        Route::post('/provinsi/tolak/{id}', [DashboardProvController::class, 'tolak'])->name('provinsi.tolak.old');
        Route::get('/detail_permohonan_dashboard/{id}', [DashboardProvController::class, 'show'])->name('provinsi.detail');

        // Route Penerbitan
        Route::get('/penerbitan_provinsi', [PenerbitanProv::class, 'index'])->name('penerbitanprov.index');
        Route::get('/detail_penerbitan_prov/{id}', [PenerbitanProv::class, 'show'])->name('penerbitanprov.show');
        Route::get('/detail_permohonan_prov/{id}', [PermohonanProvController::class, 'show'])->name('permohonan.show');
        Route::get('/unggah_penerbitan_prov/proses/{id}', [PenerbitanProv::class, 'create'])->name('penerbitanprov.create');
        Route::post('/unggah_penerbitan_prov/proses', [PenerbitanProv::class, 'store'])->name('penerbitanprov.store');
        Route::get('/download_penerbitan_prov/{id}', [PenerbitanProv::class, 'downloadPenerbitanFile'])->name('penerbitanprov.download');
        Route::get('/download_permohonan_prov/{id}', [PenerbitanProv::class, 'downloadPermohonanFile'])->name('penerbitanprov.download_permohonan');

        //Route Profil
        Route::get('/profil_provinsi', [ProfilProvController::class, 'index'])->name('profilprov.index');


        


        // Route::get('/balasan-provinsi', function () {
        //     return view('provinsi.balasan_prov', ['title' => 'Balasan']);
        // });
        // Route::get('/detail-balasan-prov', function () {
        //     return view('provinsi.detail_balasan_prov', ['title' => 'Detail balasan']);
        // });

        // Route::get('/profil-provinsi', function () {
        //     return view('provinsi.profil_prov', ['title' => 'Profil']);
        // });
    });

    //---USER SUPERADMIN---
    Route::middleware(['checkrole:superadmin'])->group(function () 
    {
        // 3. LEVEL SUPERADMIN - Tambahkan controller nanti


    });

});