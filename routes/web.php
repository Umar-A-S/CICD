<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArsipKotaController;
use App\Http\Controllers\UnggahBaprController;

Route::get('/arsip-kota', [ArsipKotaController::class, 'index']);
Route::get('/detailarsip-kota/{id}', [ArsipKotaController::class, 'detail']);

Route::get('/', function () {
    return view('login', ['title' => 'Login']);
});

Route::get('/dashboard-kota', function () {
    return view('kota/dashboard', ['title' => 'Dashboard']);
});

Route::get('/arsipdata-kota', function () {
    return view('kota/arsipdata', ['title' => 'Arsip Data']);
});

Route::get('/detailarsip-kota', function () {
    return view('kota/detailarsipkota', ['title' => 'Detail Arsip Data']);
});

Route::get('/penerbitan-kota', function () {
    return view('kota/penerbitan', ['title' => 'Penerbitan']);
});

Route::get('/permohonan-kota', function () {
    return view('kota/permohonan', ['title' => 'Permohonan']);
});

use App\Http\Controllers\PermohonanController;
Route::post('/permohonan/store', [PermohonanController::class, 'store']);

Route::get('/unggah_BAPR/{id}', function ($id) {
    return view('kota/unggah_BAPR', ['title' => 'Unggah BAPR', 'id' => $id]);
});

Route::get('/balasan-kota', function () {
    return view('kota/balasan', ['title' => 'Balasan']);
});

Route::get('/pengaturan-kota', function () {
    return view('kota/pengaturan', ['title' => 'Pengaturan']);
});

// API for upload/delete files (simple handlers)
Route::post('/unggah-bapr/upload/{id?}', [UnggahBaprController::class, 'upload']);
Route::delete('/unggah-bapr/delete', [UnggahBaprController::class, 'destroy']);
Route::get('/unggah-bapr/files/{id?}', [UnggahBaprController::class, 'files']);