<?php

namespace App\Http\Controllers\Provinsi;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Penerbitan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PenerbitanProv extends Controller
{
    /**
     * Menampilkan daftar penerbitan (Perlu Dibalas & Selesai)
     */
    public function index()
    {
        // Data 1: Perlu Dibalas (Status bukan SELESAI dan ditujukan ke user ini)
        $permohonanPerlu = Permohonan::where('wilayah', 'luar')
            ->where('status', 'DIPROSES')
            ->orderBy('created_at', 'asc')
            ->get();

        // Data 2: Selesai (Status SELESAI dan ditujukan ke user ini)
        $permohonanSelesai = Permohonan::where('wilayah', 'luar')
            ->whereIn('status', ['SELESAI', 'DITOLAK'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('provinsi.penerbitan_prov', compact('permohonanPerlu', 'permohonanSelesai'));
    }

    /**
     * Menampilkan Form Unggah Balasan
     */
    public function create($id)
    {
        $permohonan = Permohonan::findOrFail($id);

        // --- SATPAM 0: Cek Authorization (Hanya permohonan luar Jateng yang boleh diproses Provinsi) ---
        if ($permohonan->wilayah !== 'luar') {
            abort(403, 'Hanya permohonan tujuan luar Jateng yang bisa diproses di menu ini.');
        }

        // --- SATPAM 1: Cek Status ---
        // Kalau status sudah SELESAI, dilarang masuk form lagi!
        if ($permohonan->status == 'SELESAI') {
            return redirect()->route('penerbitanprov.index')
                ->with('error', 'Permohonan ini sudah diselesaikan sebelumnya!');
        }
        // ----------------------------

        return view('provinsi.unggah_penerbitan_prov', [
            'title' => 'Penerbitan',
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
            'permohonan_id' => 'required|exists:permohonan,id',
            'hasil'         => 'required|in:TERCATAT,TIDAK TERCATAT,DISETUJUI,DITOLAK,LAINNYA',
            'alasan'        => 'required|string',
            'file_balasan'  => 'required|file|mimes:pdf|max:10240',
        ]);

        $permohonan = Permohonan::findOrFail($request->permohonan_id);

        // Cek agar tidak double input
        if (in_array($permohonan->status, ['SELESAI', 'DITOLAK'])) {
            return redirect()->route('penerbitanprov.index')
                ->with('error', 'Data ini sudah selesai diproses!');
        }

        // 2. Proses Upload File
        $file = $request->file('file_balasan');
        $fileName = time() . '_balasan_' . Str::random(5) . '.pdf';
        $file->storeAs('public/penerbitan', $fileName); 

        // 3. Generate Nomor Surat
        $bulanRomawi = $this->getRomawi(date('n'));
        $tahun = date('Y');
        $nomorSurat = "470/" . rand(100, 999) . "/BALASAN/" . $bulanRomawi . "/" . $tahun;

        // 4. Simpan ke Database Penerbitan 
        Penerbitan::create([
            'permohonan_id'         => $request->permohonan_id,
            'hasil'                 => $request->hasil,
            'nomor_surat_selesai'   => $nomorSurat,
            'tanggal_surat_selesai' => $request->tanggal_surat_selesai ?? Carbon::now(),
            'file_path'             => '/storage/penerbitan/' . $fileName,
        ]);

        // 5. UPDATE TABEL PERMOHONAN (Pusat Data)
        $statusFinal = ($request->hasil == 'DITOLAK') ? 'DITOLAK' : 'SELESAI';

        $permohonan->update([
            'status'  => $statusFinal,
            'catatan' => $request->alasan 
        ]);

        return redirect()->route('penerbitanprov.index')->with('success', 'Dokumen berhasil diproses!');
    }
    /**
     * Menampilkan Detail (Opsional jika belum ada)
     */
    public function show($id)
    {
        $permohonan = Permohonan::with('penerbitan')->findOrFail($id);

        // Proteksi Keamanan: Hanya permohonan luar Jateng yang boleh dilihat di menu Penerbitan Provinsi
        if ($permohonan->wilayah !== 'luar') {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('provinsi.detail_penerbitan_prov', [
            'title' => 'Detail Penerbitan',
            'permohonan' => $permohonan
        ]);
    }

    private function getRomawi($bulan) {
        $map = [1=>'I', 2=>'II', 3=>'III', 4=>'IV', 5=>'V', 6=>'VI', 7=>'VII', 8=>'VIII', 9=>'IX', 10=>'X', 11=>'XI', 12=>'XII'];
        return $map[$bulan];
    }
}