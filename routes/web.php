<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login', ['title' => 'Login']);
});

Route::get('/dashboard-kota', function () {
    return view('kota/dashboard', ['title' => 'Dashboard']);
});