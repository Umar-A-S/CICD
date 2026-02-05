<?php

namespace App\Http\Controllers\Kota;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        return view('kota.profil-kakot', [
            'title' => 'Profil Instansi',
            'user' => Auth::user(), // Ambil data user yang login
        ]);
    }
}