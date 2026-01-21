<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login', ['title' => 'Login']);
});

Route::get('/dashboard-kota', function () {
    return view('kota/dashboard_kakot', ['title' => 'Dashboard']);
});

Route::get('/detail_permohonan-kota/{id}', function ($id) {
    return view('kota/detail_permohonan_kakot', [
        'title' => 'Permohonan',
        'id' => $id
    ]);
});

Route::get('/penerbitan-kota', function () {
    return view('kota/penerbitan_kakot', ['title' => 'Penerbitan']);
});

Route::get('/unggah_penerbitan-kota/{id}', function ($id) {
    return view('kota/unggah_penerbitan_kakot', [
        'title' => 'Unggah Penerbitan',
        'id' => $id
    ]);
});


Route::get('/detail_penerbitan-kota/{id}', function ($id) {
    return view('kota/detail_penerbitan_kakot', [
        'title' => 'Penerbitan',
        'id' => $id
    ]);
});

Route::get('/permohonan-kota', function () {
    return view('kota/permohonan_kakot', ['title' => 'Permohonan']);
});

Route::post('/permohonan/store', [PermohonanController::class, 'store']);

Route::get('/balasan-kota', function () {
    return view('kota/balasan_kakot', ['title' => 'Balasan']);
});

Route::get('/pengaturan-kota', function () {
    return view('kota/pengaturan_kakot', ['title' => 'Pengaturan']);
});