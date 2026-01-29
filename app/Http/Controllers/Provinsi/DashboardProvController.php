<?php

namespace App\Http\Controllers\Provinsi;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\BalasanProvinsi; // Panggil Model ini
use Illuminate\Http\Request;

class DashboardProvController extends Controller
{
    public function index()
    {
        // Gatekeeper hanya melihat yang statusnya 'BELUM'
        $permohonanMasuk = Permohonan::where('status', 'BELUM')
                                     ->orderBy('created_at', 'asc') // FIFO (First In First Out)
                                     ->get();

        return view('provinsi.dashboard_prov', [
            'title' => 'Dashboard Provinsi',
            'permohonanMasuk' => $permohonanMasuk
        ]);
    }

    // --- AKSI 1: VERIFIKASI (LANJUT KE DAERAH TUJUAN) ---
    public function verifikasi($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        
        // Ubah status jadi DIPROSES agar muncul di dashboard Kota Tujuan
        $permohonan->update([
            'status' => 'DIPROSES'
        ]);

        return redirect()->back()->with('success', 'Permohonan valid! Berkas diteruskan ke daerah tujuan.');
    }

    // --- AKSI 2: TOLAK (SIMPAN ALASAN DI TABEL KHUSUS) ---
    public function tolak(Request $request, $id)
    {
        // 1. Validasi Alasan Wajib Diisi
        $request->validate([
            'alasan_tolak' => 'required|string|min:5'
        ]);

        $permohonan = Permohonan::findOrFail($id);

        // 2. Ubah Status Utama jadi DITOLAK
        $permohonan->update([
            'status' => 'DITOLAK'
        ]);

        // 3. Simpan Alasan ke Tabel balasan_provinsi
        BalasanProvinsi::create([
            'permohonan_id'    => $id,
            'alasan_penolakan' => $request->alasan_tolak
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