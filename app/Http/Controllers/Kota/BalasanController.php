<?php

namespace App\Http\Controllers\Kota;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BalasanController extends Controller
{
    /**
     * Menampilkan daftar permohonan yang sudah selesai (sudah ada balasan).
     */
    public function index(): View
    {
        $user = Auth::user();

        // Tabel 1: Permohonan yang sedang diproses (BELUM, DIPROSES)
        $permohonanDiproses = Permohonan::where('user_id', $user->id)
            ->whereIn('status', ['BELUM', 'DIPROSES'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Tabel 2: Riwayat balasan (SELESAI, DITOLAK)
        $permohonanSelesai = Permohonan::with('penerbitan')
            ->where('user_id', $user->id)
            ->whereIn('status', ['SELESAI', 'DITOLAK'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('kota.balasan_kakot', [
            'title' => 'Daftar Balasan Permohonan',
            'permohonanDiproses' => $permohonanDiproses,
            'permohonanSelesai' => $permohonanSelesai
        ]);
    }

    /**
     * Menampilkan detail balasan untuk satu permohonan tertentu.
     */
    public function show($id): View
    {
        // Ambil data permohonan beserta relasi penerbitannya
        $permohonan = Permohonan::with('penerbitan')->findOrFail($id);

        // Keamanan: Pastikan hanya pemilik permohonan yang bisa melihat balasannya
        if ($permohonan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke data balasan ini.');
        }

        return view('kota.detail_balasan_kakot', [
            'title' => 'Detail Balasan Dokumen',
            'permohonan' => $permohonan
        ]);
    }
}