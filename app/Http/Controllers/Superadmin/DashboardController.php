<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Permohonan;
use App\Models\Penerbitan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display superadmin dashboard with statistics
     */
    public function index()
    {
        // Total Users by Role (exclude superadmin)
        $totalUsers = User::where('role', '!=', 'superadmin')->count();
        $userDaerah = User::where('role', 'daerah')->count();
        $userProvinsi = User::where('role', 'provinsi')->count();

        // Total Permohonan by Status
        $totalPermohonan = Permohonan::count();
        $permohonanMenunggu = Permohonan::where('status', 'BELUM')->count();
        $permohonanDiproses = Permohonan::where('status', 'DIPROSES')->count();
        $permohonanSelesai = Permohonan::where('status', 'SELESAI')->count();
        $permohonanDitolak = Permohonan::where('status', 'DITOLAK')->count();

        // Total Penerbitan
        $totalPenerbitan = Penerbitan::count();

        // Permohonan by Wilayah (dalam/luar)
        $permohonanDalam = Permohonan::where('wilayah', 'dalam')->count();
        $permohonanLuar = Permohonan::where('wilayah', 'luar')->count();

        // Recent Permohonan (last 10)
        $recentPermohonan = Permohonan::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Top 5 Daerah dengan Permohonan Terbanyak
        $topDaerah = Permohonan::select('daerah_asal', DB::raw('count(*) as total'))
            ->groupBy('daerah_asal')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // Monthly Permohonan Trend (last 6 months)
        $monthlyTrend = Permohonan::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        return view('superadmin.dashboard', [
            'title' => 'Dashboard Superadmin',
            'totalUsers' => $totalUsers,
            'userDaerah' => $userDaerah,
            'userProvinsi' => $userProvinsi,
            'totalPermohonan' => $totalPermohonan,
            'permohonanMenunggu' => $permohonanMenunggu,
            'permohonanDiproses' => $permohonanDiproses,
            'permohonanSelesai' => $permohonanSelesai,
            'permohonanDitolak' => $permohonanDitolak,
            'totalPenerbitan' => $totalPenerbitan,
            'permohonanDalam' => $permohonanDalam,
            'permohonanLuar' => $permohonanLuar,
            'recentPermohonan' => $recentPermohonan,
            'topDaerah' => $topDaerah,
            'monthlyTrend' => $monthlyTrend,
        ]);
    }
}
