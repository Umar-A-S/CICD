<?php

namespace App\Http\Controllers\Provinsi;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikasiController extends Controller
{
    public function index()
    {
        // Tabel 1: Permohonan yang perlu diverifikasi (status = BELUM)
        // Urutkan berdasarkan yang terbaru dulu
        $permohonanBelum = Permohonan::with('penerbitan')->where('status', 'BELUM')
                                    ->orderBy('updated_at', 'desc')
                                    ->get();

        // Tabel 2: Permohonan yang sudah diverifikasi (status = DIPROSES atau DITOLAK)
        // Urutkan berdasarkan status (DIPROSES→DITOLAK→SELESAI) lalu tanggal update terbaru
        $permohonanDiproses = Permohonan::whereIn('status', ['DIPROSES', 'DITOLAK', 'SELESAI'])
                                        ->orderByRaw("CASE 
                                            WHEN status = 'DIPROSES' THEN 1 
                                            WHEN status = 'DITOLAK' THEN 2 
                                            WHEN status = 'SELESAI' THEN 3 
                                        END")
                                        ->orderBy('updated_at', 'desc')
                                        ->get();

        return view('provinsi.verifikasi', [
            'title' => 'Verifikasi Permohonan',
            'permohonanBelum' => $permohonanBelum,
            'permohonanDiproses' => $permohonanDiproses,
            'role' => Auth::user()->role,
            'notifPenerbitan' => 0
        ]);
    }

    /**
     * Verifikasi permohonan (mengubah status dari BELUM ke DIPROSES)
     */
    public function verifikasi($id)
    {
        $permohonan = Permohonan::findOrFail($id);

        if ($permohonan->status !== 'BELUM') {
            return redirect()->back()->with('error', 'Permohonan ini sudah diverifikasi sebelumnya.');
        }

        $permohonan->update([
            'status' => 'DIPROSES',
            'catatan' => null
        ]);

        return redirect()->back()->with('success', 'Permohonan berhasil diverifikasi! Berkas diteruskan ke daerah tujuan.');
    }

    /**
     * Tolak permohonan (mengubah status dari BELUM ke DITOLAK dengan alasan)
     */
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_tolak' => 'required|string|min:5'
        ]);

        $permohonan = Permohonan::findOrFail($id);

        if ($permohonan->status !== 'BELUM') {
            return redirect()->back()->with('error', 'Permohonan ini sudah diverifikasi sebelumnya.');
        }

        $permohonan->update([
            'status' => 'DITOLAK',
            'catatan' => $request->alasan_tolak
        ]);

        return redirect()->back()->with('success', 'Permohonan berhasil ditolak.');
    }
}
