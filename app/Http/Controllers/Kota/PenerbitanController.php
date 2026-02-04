<?php

namespace App\Http\Controllers\Kota;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Penerbitan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PenerbitanController extends Controller
{
    /**
     * Menampilkan daftar penerbitan (Perlu Dibalas & Selesai)
     */
    public function index()
    {
        $daerahUser = Auth::user()->name; // Asumsi: username = nama daerah (misal: admin_magelang)

        // Data 1: Perlu Dibalas (Status bukan SELESAI dan ditujukan ke user ini)
        $permohonanPerlu = Permohonan::where('daerah_tujuan', $daerahUser)
            ->where('status', 'DIPROSES')
            ->orderBy('created_at', 'asc')
            ->get();

        // Data 2: Selesai (Status SELESAI dan ditujukan ke user ini)
        $permohonanSelesai = Permohonan::with('penerbitan')
            ->where('daerah_tujuan', $daerahUser)
            ->where('status', 'SELESAI')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('kota.penerbitan_kakot', compact('permohonanPerlu', 'permohonanSelesai'));
    }

    /**
     * Menampilkan Form Unggah Balasan
     */
    public function create($id)
    {
        $permohonan = Permohonan::findOrFail($id);

        // --- SATPAM 0: Cek Authorization (Permohonan harus ditujukan ke daerah ini) ---
        if ($permohonan->kode_daerah_tujuan !== Auth::user()->kode_wilayah) {
            abort(403, 'Permohonan ini bukan untuk daerah Anda.');
        }

        // --- SATPAM 1: Cek Status ---
        // Kalau status sudah SELESAI, dilarang masuk form lagi!
        if ($permohonan->status == 'SELESAI') {
            return redirect()->route('penerbitan.index')
                ->with('error', 'Permohonan ini sudah diselesaikan sebelumnya!');
        }
        // ----------------------------

        return view('kota.unggah_penerbitan_kakot', [
            'title' => 'Proses Penerbitan',
            'permohonan' => $permohonan
        ]);
    }

    /**
     * Menyimpan Data Penerbitan (Action dari Form)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'permohonan_id'         => 'required|exists:permohonan,id',
            'nomor_surat_selesai'   => 'required|string',
            'tanggal_surat_selesai' => 'required|date',
            'hasil'                 => 'required|in:TERCATAT,TIDAK TERCATAT,DISETUJUI,DITOLAK,LAINNYA',
            'alasan'                => 'nullable|string',
            'file_balasan'          => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $permohonan = Permohonan::findOrFail($request->permohonan_id);

        // Cek agar tidak double input
        if (in_array($permohonan->status, ['SELESAI', 'DITOLAK'])) {
            return redirect()->route('penerbitan.index')
                ->with('error', 'Data ini sudah selesai diproses!');
        }

        // 2. Proses Upload File (hanya jika ada file yang diupload)
        $filePath = null;
        if ($request->hasFile('file_balasan')) {
            $file = $request->file('file_balasan');
            $fileName = time() . '_balasan_' . Str::random(5) . '.pdf';
            $file->storeAs('public/penerbitan', $fileName);
            $filePath = '/storage/penerbitan/' . $fileName;
        } 

        // 3. Simpan ke Database Penerbitan 
        Penerbitan::create([
            'permohonan_id'         => $request->permohonan_id,
            'hasil'                 => $request->hasil,
            'nomor_surat_selesai'   => $request->nomor_surat_selesai,
            'tanggal_surat_selesai' => $request->tanggal_surat_selesai,
            'file_path'             => $filePath, // Bisa null jika tidak ada file
        ]);

        // 4. UPDATE TABEL PERMOHONAN (Pusat Data)
        $statusFinal = ($request->hasil == 'DITOLAK') ? 'DITOLAK' : 'SELESAI';

        $permohonan->update([
            'status'  => $statusFinal,
            'catatan' => $request->alasan 
        ]);

        return redirect()->route('penerbitan.index')->with('success', 'Dokumen berhasil diproses!');
    }
    /**
     * Menampilkan Detail Permohonan dari Menu Penerbitan (untuk Daerah Tujuan)
     * Dipisah dari PermohonanController karena context berbeda
     */
    public function detailPermohonan($id)
    {
        $permohonan = Permohonan::findOrFail($id);

        // Proteksi Keamanan: Hanya daerah tujuan yang bisa lihat detail di menu penerbitan
        if ($permohonan->kode_daerah_tujuan !== Auth::user()->kode_wilayah) {
            abort(403, 'Permohonan ini bukan untuk daerah Anda.');
        }

        return view('kota.detail_permohonan_kakot', [
            'title' => 'Detail Permohonan (Penerbitan)',
            'permohonan' => $permohonan
        ]);
    }

    /**
     * Menampilkan Detail Penerbitan (Balasan yang sudah diproses)
     */
    public function show($id)
    {
        $permohonan = Permohonan::with('penerbitan')->findOrFail($id);

        // Proteksi Keamanan: Hanya daerah tujuan yang bisa melihat detail penerbitan
        if ($permohonan->kode_daerah_tujuan !== Auth::user()->kode_wilayah) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('kota.detail_penerbitan_kakot', [
            'title' => 'Detail Penerbitan',
            'permohonan' => $permohonan
        ]);
    }

    /**
     * SECURITY FIX: Download file penerbitan dengan authorization check
     */
    public function downloadPenerbitanFile($id)
    {
        $permohonan = Permohonan::with('penerbitan')->findOrFail($id);

        // Authorization check: Bisa diakses oleh:
        // 1. Pembuat permohonan (yang menerima balasan)
        // 2. Daerah tujuan (yang mengurus permohonan dan membuat penerbitan)
        $isPembuat = $permohonan->user_id === Auth::id();
        $isDaerahTujuan = $permohonan->kode_daerah_tujuan === Auth::user()->kode_wilayah;
        
        if (!$isPembuat && !$isDaerahTujuan) {
            abort(403, 'Anda tidak memiliki akses ke file ini.');
        }

        // Cek apakah penerbitan sudah ada
        if (!$permohonan->penerbitan || !$permohonan->penerbitan->file_path) {
            abort(404, 'File tidak ditemukan.');
        }

        $filePath = str_replace('/storage/', '', $permohonan->penerbitan->file_path);
        $fullPath = storage_path("app/public/{$filePath}");
        
        // Preview di tab baru (bukan download)
        if (!file_exists($fullPath)) {
            abort(404, 'File tidak ditemukan di server.');
        }
        
        return response()->file($fullPath);
    }

    /**
     * SECURITY FIX: Download file permohonan (asli) dengan authorization check
     */
    public function downloadPermohonanFile($id)
    {
        $permohonan = Permohonan::findOrFail($id);

        // Authorization check: Hanya daerah tujuan yang bisa download file permohonan yang ditujukan ke mereka
        if ($permohonan->kode_daerah_tujuan !== Auth::user()->kode_wilayah) {
            abort(403, 'Anda tidak memiliki akses ke file ini.');
        }

        if (!$permohonan->file_path) {
            abort(404, 'File tidak ditemukan.');
        }

        $filePath = str_replace('/storage/', '', $permohonan->file_path);
        $fullPath = storage_path("app/public/{$filePath}");
        
        // Preview di tab baru (bukan download)
        if (!file_exists($fullPath)) {
            abort(404, 'File tidak ditemukan di server.');
        }
        
        return response()->file($fullPath);
    }

    private function getRomawi($bulan) {
        $map = [1=>'I', 2=>'II', 3=>'III', 4=>'IV', 5=>'V', 6=>'VI', 7=>'VII', 8=>'VIII', 9=>'IX', 10=>'X', 11=>'XI', 12=>'XII'];
        return $map[$bulan];
    }
}