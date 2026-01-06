<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login', ['title' => 'Login']);
});

Route::get('/dashboard-kota-Kabupaten', function () {
    return view('dashboard', ['title' => 'Dashboard-kota-Kabupaten']);
});