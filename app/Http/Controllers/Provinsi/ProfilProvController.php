<?php

namespace App\Http\Controllers\Provinsi;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfilProvController extends Controller
{
    public function index()
    {
        return view('provinsi.profil_prov', [
            'title' => 'Profil Instansi',
            'user' => Auth::user(), 
        ]);
    }
}