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
        
        // // DEBUG
        // dd($user);
        
        // Filter permohonan berdasarkan role
        if ($user->role === 'daerah') {

            // Menampilkan SEMUA STATUS (BELUM, DIPROSES, SELESAI, DITOLAK)
            $permohonans = Permohonan::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($user->role === 'provinsi') {
            // Admin provinsi: tetap lihat permohonan status BELUM untuk divalidasi
            $permohonans = Permohonan::where('status', 'BELUM')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Superadmin: lihat semua tanpa filter
            $permohonans = Permohonan::orderBy('created_at', 'desc')->get();
        }

        // // DEBUG
        // dd($permohonans);
        
         // Hitung statistik berdasarkan hasil filter 
        $stat = [
            'total'   => $permohonans->count(),
            'belum'   => $permohonans->where('status', 'BELUM')->count(),
            'proses'  => $permohonans->where('status', 'DIPROSES')->count(),
            'selesai' => $permohonans->where('status', 'SELESAI')->count(),
            'tolak'   => $permohonans->where('status', 'DITOLAK')->count(),
        ];
        return view('kota.dashboard-kakot', [
                'title' => 'Dashboard Kota',
                'permohonans' => $permohonans,
                'stat' => $stat
            ]);
    }
}
