<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login', ['title' => 'Login']);
});

Route::get('/dashboard-kota', function () {
    return view('kota/dashboard', ['title' => 'Dashboard']);
});

Route::get('/arsipdata-kota', function () {
    return view('kota/arsipdata', ['title' => 'Arsip Data']);
});

Route::get('/penerbitan-kota', function () {
    return view('kota/penerbitan', ['title' => 'Penerbitan']);
});

Route::get('/permohonan-kota', function () {
    return view('kota/permohonan', ['title' => 'Permohonan']);
});

Route::get('/pengaturan-kota', function () {
    return view('kota/pengaturan', ['title' => 'Pengaturan']);
});