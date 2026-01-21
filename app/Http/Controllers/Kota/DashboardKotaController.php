<?php

namespace App\Http\Controllers\Kota;

use App\Http\Controllers\Controller;
use App\Models\Permohonan; // Gunakan model baru
use Illuminate\View\View;

class DashboardKotaController extends Controller
{
    public function index(): View
    {
        // Ambil semua data permohonan
        $permohonans = Permohonan::all();

        // Hitung statistik untuk dashboard
        // Nilai status disesuaikan dengan migrasi: BELUM, DIPROSES, DITOLAK, SELESAI
        $totalPermohonan = $permohonans->count();
        $totalBelum = $permohonans->where('status', 'BELUM')->count();
        $totalProses = $permohonans->where('status', 'DIPROSES')->count();
        $totalSelesai = $permohonans->where('status', 'SELESAI')->count();

        return view('kota.dashboard_kakot', [
            'title' => 'Dashboard Kota',
            'permohonans' => $permohonans,
            'stat' => [
                'total' => $totalPermohonan,
                'belum' => $totalBelum,
                'proses' => $totalProses,
                'selesai' => $totalSelesai
            ]
        ]);
    }
}
