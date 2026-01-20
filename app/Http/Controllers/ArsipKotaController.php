<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArsipKotaController extends Controller
{
    // halaman tabel arsip
    public function index()
    {
        return view('kota/arsipdata', [
            'title' => 'Arsip Data'
        ]);
    }

    // halaman detail arsip
    public function detail($id)
    {
        return view('kota/detailarsipkota', [
            'title' => ' Arsip Data',
            'id' => $id
        ]);
    }
}