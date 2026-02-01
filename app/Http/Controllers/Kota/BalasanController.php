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

        // ambil permohonan yang dibuat oleh user ini dan statusnya SELESAI atau DITOLAK
        $permohonans = Permohonan::with('penerbitan')
            ->where('user_id', $user->id)
            ->whereIn('status', ['SELESAI','DITOLAK'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('kota.balasan_kakot', [
            'title' => 'Daftar Balasan Permohonan',
            'permohonans' => $permohonans
        ]);
    }

    /**
     * Menampilkan detail balasan untuk satu permohonan tertentu.
     */
    public function show($id): View
    {
        // Ambil data permohonan beserta relasi penerbitannya
        $permohonan = Permohonan::with('penerbitan')->findOrFail($id);

        if ($permohonan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke data balasan ini.');
        }

        return view('kota.detail_balasan_kakot', [
            'title' => 'Detail Balasan Dokumen',
            'permohonan' => $permohonan
        ]);
    }
}