<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Penerbitan;
use Illuminate\Http\Request;

class PermohonanMonitorController extends Controller
{
    /**
     * Display all permohonan with filters (READ-ONLY for monitoring)
     */
    public function index(Request $request)
    {
        $query = Permohonan::with(['user']);

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by Wilayah (dalam/luar)
        if ($request->filled('wilayah')) {
            $query->where('wilayah', $request->wilayah);
        }

        // Filter by Daerah Asal
        if ($request->filled('daerah_asal')) {
            $query->where('daerah_asal', 'LIKE', '%' . $request->daerah_asal . '%');
        }

        // Filter by Date Range
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }
        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        // Search by No Permohonan or Nama Subjek
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nomor_surat', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('nama_subjek', 'LIKE', '%' . $request->search . '%');
            });
        }

        // Get statistics for current filter
        $stats = [
            'total' => (clone $query)->count(),
            'menunggu' => (clone $query)->where('status', 'BELUM')->count(),
            'diproses' => (clone $query)->where('status', 'DIPROSES')->count(),
            'selesai' => (clone $query)->where('status', 'SELESAI')->count(),
            'ditolak' => (clone $query)->where('status', 'DITOLAK')->count(),
        ];

        // Paginate results
        $permohonan = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('superadmin.permohonan.index', [
            'title' => 'Monitor Permohonan',
            'permohonan' => $permohonan,
            'stats' => $stats,
            'filters' => $request->all(),
        ]);
    }

    /**
     * Display detail permohonan (READ-ONLY)
     */
    public function show($id)
    {
        $permohonan = Permohonan::with(['user'])->findOrFail($id);
        
        // Get penerbitan if exists
        $penerbitan = Penerbitan::where('permohonan_id', $id)->first();

        return view('superadmin.permohonan.show', [
            'title' => 'Detail Permohonan',
            'permohonan' => $permohonan,
            'penerbitan' => $penerbitan,
        ]);
    }

    /**
     * Download permohonan file
     */
    public function downloadFile($id)
    {
        $permohonan = Permohonan::findOrFail($id);

        // Handle both formats: '/storage/permohonan/file.pdf' or 'permohonan/file.pdf'
        $relativePath = str_replace('/storage/', '', $permohonan->file_path);
        $filePath = storage_path('app/public/' . $relativePath);
        
        // If file doesn't exist (dummy data), create a simple text response
        if (!file_exists($filePath)) {
            $content = "DOKUMEN PERMOHONAN (DUMMY DATA)\n\n";
            $content .= "No. Permohonan: {$permohonan->nomor_surat}\n";
            $content .= "Daerah Asal: {$permohonan->daerah_asal}\n";
            $content .= "Nama Subjek: {$permohonan->nama_subjek}\n";
            $content .= "Jenis Dokumen: {$permohonan->jenis_dokumen}\n";
            $content .= "Status: {$permohonan->status}\n\n";
            $content .= "Catatan: Ini adalah data dummy untuk demonstrasi.\n";
            $content .= "File permohonan asli akan tersedia setelah upload dokumen nyata.";
            
            return response($content, 200)
                ->header('Content-Type', 'text/plain')
                ->header('Content-Disposition', 'attachment; filename="Permohonan_' . $permohonan->nomor_surat . '.txt"');
        }

        // Get original filename from path or use default
        $fileName = basename($filePath);
        return response()->download($filePath, $fileName);
    }

    /**
     * View penerbitan detail
     */
    public function showPenerbitan($id)
    {
        $penerbitan = Penerbitan::with(['permohonan'])->findOrFail($id);

        return view('superadmin.permohonan.penerbitan', [
            'title' => 'Detail Penerbitan',
            'penerbitan' => $penerbitan,
        ]);
    }

    /**
     * Download penerbitan file
     */
    public function downloadPenerbitan($id)
    {
        $penerbitan = Penerbitan::findOrFail($id);

        // Handle both formats: '/storage/penerbitan/file.pdf' or 'penerbitan/file.pdf'
        $relativePath = str_replace('/storage/', '', $penerbitan->file_path);
        $filePath = storage_path('app/public/' . $relativePath);
        
        // If file doesn't exist (dummy data), create a simple text response
        if (!file_exists($filePath)) {
            $content = "DOKUMEN PENERBITAN (DUMMY DATA)\n\n";
            $content .= "No. Penerbitan: {$penerbitan->nomor_surat_selesai}\n";
            $content .= "Tanggal Terbit: {$penerbitan->tanggal_surat_selesai}\n";
            $content .= "Hasil: {$penerbitan->hasil}\n";
            if ($penerbitan->alasan) {
                $content .= "Alasan: {$penerbitan->alasan}\n";
            }
            $content .= "\nCatatan: Ini adalah data dummy untuk demonstrasi.\n";
            $content .= "File penerbitan asli akan tersedia setelah proses penerbitan nyata.";
            
            return response($content, 200)
                ->header('Content-Type', 'text/plain')
                ->header('Content-Disposition', 'attachment; filename="Penerbitan_' . $penerbitan->nomor_surat_selesai . '.txt"');
        }

        // Get original filename from path or use default
        $fileName = basename($filePath);
        return response()->download($filePath, $fileName);
    }
}
