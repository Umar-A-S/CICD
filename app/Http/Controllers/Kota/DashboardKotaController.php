<?php

namespace App\Http\Controllers\Kota;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardKotaController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        
        // Filter permohonan berdasarkan user yang login
        if ($user->role === 'daerah') {
            // User daerah: lihat permohonan miliknya + yang status DIPROSES untuk daerahnya
            $permohonans = Permohonan::where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere(function ($q) use ($user) {
                          $q->where('status', 'DIPROSES')
                            ->where('daerah_tujuan', $user->kode_wilayah);
                      });
            })
            ->orderBy('created_at', 'desc')
            ->get();
        } elseif ($user->role === 'provinsi') {
            // Admin provinsi: lihat semua permohonan status BELUM (menunggu verifikasi)
            $permohonans = Permohonan::where('status', 'BELUM')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Superadmin: lihat semua
            $permohonans = Permohonan::orderBy('created_at', 'desc')->get();
        }

        // Hitung statistik
        $totalPermohonan = $permohonans->count();
        $totalBelum = $permohonans->where('status', 'BELUM')->count();
        $totalProses = $permohonans->where('status', 'DIPROSES')->count();
        $totalSelesai = $permohonans->where('status', 'SELESAI')->count();
        $totalTolak = $permohonans->where('status', 'DITOLAK')->count();

        return view('kota.dashboard_kakot', [
            'title' => 'Dashboard Kota',
            'permohonans' => $permohonans,
            'stat' => [
                'total' => $totalPermohonan,
                'belum' => $totalBelum,
                'proses' => $totalProses,
                'selesai' => $totalSelesai,
                'tolak' => $totalTolak
            ]
        ]);
    }
}
