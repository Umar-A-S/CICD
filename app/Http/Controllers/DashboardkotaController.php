<?php

namespace App\Http\Controllers\Kota;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Balasan;
use Illuminate\View\View;

class DashboardKotaController extends Controller
{
    public function index(): View
    {
        $notiTerbit = Permohonan::where('status', 'siap diterbitkan')->count();
        $notiBalasan = Balasan::where('is_read', false)->count();

        $totalPermohonan = Permohonan::count();
        $totalTerbit = Permohonan::where('status', 'diterbitkan')->count();

        return view('kota.dashboard', compact(
            'notiTerbit',
            'notiBalasan',
            'totalPermohonan',
            'totalTerbit'
        ));
    }
}