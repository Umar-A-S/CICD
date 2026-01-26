<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PermohonanController extends Controller
{
    /**
     * Display a listing of permohonan for the authenticated user
     */
    public function index()
    {
        $user = Auth::user();
        
        // Filter berdasarkan role dan wilayah
        if ($user->role === 'daerah') {
            // User daerah: lihat permohonan yang dibuat + permohonan yang ditujukan ke daerahnya
            $permohonan = Permohonan::where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere(function ($q) use ($user) {
                          $q->where('status', 'DIPROSES')
                            ->where('daerah_tujuan', $user->kode_wilayah);
                      });
            })
            ->orderBy('created_at', 'desc')
            ->get();
        } elseif ($user->role === 'provinsi') {
            // Admin provinsi: lihat semua permohonan dengan status BELUM (belum diverifikasi)
            $permohonan = Permohonan::where('status', 'BELUM')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Superadmin: lihat semua
            $permohonan = Permohonan::orderBy('created_at', 'desc')->get();
        }

        return response()->json($permohonan);
    }

    /**
     * Show a single permohonan detail
     */
    public function show($id)
    {
        $permohonan = Permohonan::with(['user', 'balasanProvinsi', 'penerbitan'])->find($id);

        if (!$permohonan) {
            return response()->json(['message' => 'Permohonan tidak ditemukan'], 404);
        }

        // Check authorization
        $user = Auth::user();
        $authorized = false;

        if ($user->role === 'daerah') {
            // User daerah hanya bisa lihat permohonan miliknya atau yang ditujukan ke daerahnya
            if ($permohonan->user_id === $user->id || 
                ($permohonan->status === 'DIPROSES' && $permohonan->daerah_tujuan === $user->kode_wilayah)) {
                $authorized = true;
            }
        } elseif ($user->role === 'provinsi') {
            // Admin provinsi bisa lihat semua
            $authorized = true;
        } else {
            // Superadmin bisa lihat semua
            $authorized = true;
        }

        if (!$authorized) {
            return response()->json(['message' => 'Tidak diizinkan'], 403);
        }

        return response()->json($permohonan);
    }

    /**
     * Store a new permohonan
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'jenis' => 'required|string',
            'nama_subjek' => 'required|string',
            'nomor_surat' => 'required|string',
            'tanggal_surat' => 'required|date',
            'wilayah' => 'required|in:dalam,luar',
            'wilayah_tujuan' => 'required|string',
            'daerah_tujuan' => 'required|string',
            'daerah_asal' => 'required|string',
            'file' => 'required|file|mimes:pdf|max:10240', // 10MB
        ]);

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/permohonan', $fileName);
            $filePath = Storage::url('permohonan/' . $fileName);
        }

        // Create permohonan
        $permohonan = Permohonan::create([
            'user_id' => Auth::id(),
            'jenis' => $validated['jenis'],
            'nama_subjek' => $validated['nama_subjek'],
            'nomor_surat' => $validated['nomor_surat'],
            'tanggal_surat' => $validated['tanggal_surat'],
            'wilayah' => $validated['wilayah'],
            'wilayah_tujuan' => $validated['wilayah_tujuan'],
            'daerah_tujuan' => $validated['daerah_tujuan'],
            'daerah_asal' => $validated['daerah_asal'],
            'file_path' => $filePath,
            'status' => 'BELUM',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permohonan berhasil dibuat',
            'id' => $permohonan->id
        ], 201);
    }
}
