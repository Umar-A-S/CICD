<?php

namespace App\Http\Controllers\Provinsi;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
// Model BalasanProvinsi sudah tidak perlu diimport jika tidak digunakan lagi
use Illuminate\Http\Request;

class DashboardProvController extends Controller
{
    public function index()
    {
        // 1. Ambil data permohonan masuk untuk tabel
        $permohonanMasuk = Permohonan::where('status', 'BELUM')
                                    ->orderBy('created_at', 'asc')
                                    ->get();
        
        // 2. Hitung statistik untuk status card (Variabel $stat yang dicari Blade)
        $stat = [
            'total'    => Permohonan::where('status', 'BELUM')->count()
        ];

        // 3. Kirim $stat ke view
        return view('provinsi.dashboard_prov', [
            'title' => 'Dashboard Provinsi',
            'permohonanMasuk' => $permohonanMasuk,
            'stat' => $stat // Tambahkan ini agar tidak undefined!
        ]);
    }

    // --- AKSI 1: VERIFIKASI ---
    public function verifikasi($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        
        $permohonan->update([
            'status' => 'DIPROSES',
            'catatan' => null 
        ]);

        return redirect()->back()->with('success', 'Permohonan valid! Berkas diteruskan ke daerah tujuan.');
    }

    // --- AKSI 2: TOLAK ---
    public function tolak(Request $request, $id)
    {
        
        $request->validate([
            'alasan_tolak' => 'required|string|min:5'
        ]);

        $permohonan = Permohonan::findOrFail($id);

        $permohonan->update([
            'status'  => 'DITOLAK',
            'catatan' => $request->alasan_tolak
        ]);

        return redirect()->back()->with('success', 'Permohonan dikembalikan ke pemohon (Ditolak).');
    }

    public function show($id)
    {
        $permohonan = Permohonan::findOrFail($id);

        return view('provinsi.detail_permohonan_prov', [
            'title' => 'Detail Permohonan Masuk',
            'permohonan' => $permohonan
        ]);
    }
}