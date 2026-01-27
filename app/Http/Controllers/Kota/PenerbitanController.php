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
        $daerahUser = Auth::user()->username; // Asumsi: username = nama daerah (misal: admin_magelang)

        // Data 1: Perlu Dibalas (Status bukan SELESAI dan ditujukan ke user ini)
        $permohonanPerlu = Permohonan::where('daerah_tujuan', $daerahUser)
            ->where('status', '!=', 'SELESAI')
            ->orderBy('created_at', 'asc')
            ->get();

        // Data 2: Selesai (Status SELESAI dan ditujukan ke user ini)
        $permohonanSelesai = Permohonan::where('daerah_tujuan', $daerahUser)
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
        // 1. Validasi Input (Sesuai name di form)
        $request->validate([
            'permohonan_id' => 'required|exists:permohonan,id',
            'hasil'         => 'required|in:TERCATAT,TIDAK TERCATAT,DISETUJUI,DITOLAK,LAINNYA',
            'alasan'        => 'required|string',
            'file_balasan'  => 'required|file|mimes:pdf|max:10240', // Max 10MB
        ]);

        $cekPermohonan = Permohonan::findOrFail($request->permohonan_id);
    
        if ($cekPermohonan->status == 'SELESAI') {
             return redirect()->route('penerbitan.index')
                ->with('error', 'Eits, data ini sudah selesai diproses. Tidak bisa double input!');
     }

        // 2. Proses Upload File
        $file = $request->file('file_balasan');
        // Format nama file: TIME_JUDUL_RANDOM.pdf
        $fileName = time() . '_balasan_' . Str::random(5) . '.pdf';
        // Simpan ke storage/app/public/penerbitan
        $path = $file->storeAs('public/penerbitan', $fileName); 

        // 3. Generate Nomor Surat Otomatis (Format: NO/BLS/THN)
        // Kalau mau manual, nanti tambahkan input di form view-nya
        $bulanRomawi = $this->getRomawi(date('n'));
        $tahun = date('Y');
        $nomorSurat = "470/" . rand(100, 999) . "/BALASAN/" . $bulanRomawi . "/" . $tahun;

        // 4. Simpan ke Database Penerbitan
        Penerbitan::create([
            'permohonan_id'         => $request->permohonan_id,
            'hasil'                 => $request->hasil,
            'alasan'                => $request->alasan,
            'nomor_surat_selesai'   => $nomorSurat,
            'tanggal_surat_selesai' => Carbon::now(),
            'file_path'             => '/storage/penerbitan/' . $fileName, // Path untuk diakses di view
        ]);

        // 5. Update Status Permohonan jadi SELESAI
        $permohonan = Permohonan::find($request->permohonan_id);
        $permohonan->update(['status' => 'SELESAI']);

        // 6. Redirect dengan Pesan Sukses
        return redirect()->route('penerbitan.index')->with('success', 'Dokumen berhasil diterbitkan dan dikirim!');
    }

    /**
     * Menampilkan Detail (Opsional jika belum ada)
     */
    public function show($id)
    {
        $permohonan = Permohonan::with('penerbitan')->findOrFail($id);

        return view('kota.detail_penerbitan_kakot', [
            'title' => 'Detail Penerbitan',
            'permohonan' => $permohonan
        ]);
    }

    // Helper kecil buat angka romawi bulan
    private function getRomawi($bulan) {
        $map = [1=>'I', 2=>'II', 3=>'III', 4=>'IV', 5=>'V', 6=>'VI', 7=>'VII', 8=>'VIII', 9=>'IX', 10=>'X', 11=>'XI', 12=>'XII'];
        return $map[$bulan];
    }
}