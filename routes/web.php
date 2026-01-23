<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login', ['title' => 'Login']);
});

Route::get('/dashboard-kota', function () {
    return view('kota/dashboard_kakot', ['title' => 'DASHBOARD']);
});

Route::get('/detail_permohonan-kota/{id}', function ($id) {
    return view('kota/detail_permohonan_kakot', [
        'title' => 'DETAIL PERMOHONAN',
        'id' => $id
    ]);
});

Route::get('/penerbitan-kota', function () {
    return view('kota/penerbitan_kakot', ['title' => 'PENERBITAN']);
});

Route::get('/unggah_penerbitan-kota/{id}', function ($id) {
    return view('kota/unggah_penerbitan_kakot', [
        'title' => 'UNGGAH PENERBITAN',
        'id' => $id
    ]);
});


Route::get('/detail_penerbitan-kota/{id}', function ($id) {
    return view('kota/detail_penerbitan_kakot', [
        'title' => 'DETAIL PENERBITAN',
        'id' => $id
    ]);
});

Route::get('/permohonan-kota', function () {
    return view('kota/permohonan_kakot', ['title' => 'PERMOHONAN']);
});

use App\Http\Controllers\PermohonanController;
Route::post('/permohonan/store', [PermohonanController::class, 'store']);

Route::get('/balasan-kota', function () {
    return view('kota/balasan_kakot', ['title' => 'BALASAN']);
});

Route::get('/detail_balasan-kota/{id}', function ($id) {
    return view('kota/detail_balasan_kakot', [
        'title' => 'DETAIL BALASAN',
        'id' => $id
    ]);
});

Route::get('/profil-kota', function () {
    return view('kota/profil_kakot', ['title' => 'PROFIL']);
});