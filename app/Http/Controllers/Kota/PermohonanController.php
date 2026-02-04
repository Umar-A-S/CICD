<?php

namespace App\Http\Controllers\Kota;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PermohonanController extends Controller
{
    /**
     * Display a listing of permohonan for the authenticated user
     */
// app/Http/Controllers/Kota/PermohonanController.php

// app/Http/Controllers/Kota/PermohonanController.php

    public function index()
    {
        $user = Auth::user();
        
        // Filter data 
        if ($user->role === 'daerah') {
            $permohonans = Permohonan::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        } else {
            abort(403, 'Akses tidak sah.');
        }

        return view('kota.permohonan_kakot', [
            'title' => 'Permohonan',
            'permohonans' => $permohonans
        ]);
    }


    public function show($id)
    {
        // Ambil data permohonan berdasarkan ID, jika tidak ada muncul 404
        $permohonan = Permohonan::findOrFail($id);

        // Proteksi Keamanan: User daerah hanya boleh lihat miliknya sendiri (yang dibuat user ini)
        if (Auth::user()->role === 'daerah' && $permohonan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('kota.detail_permohonan_kakot', [
            'title' => 'Detail Permohonan',
            'permohonan' => $permohonan
        ]);
    }

    /**
     * Show form for resubmitting rejected permohonan with pre-filled data
     */
    public function resubmit($id)
    {
        $permohonan = Permohonan::findOrFail($id);

        // Authorization: only owner can resubmit
        if ($permohonan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengajukan ulang permohonan ini.');
        }

        // Only DITOLAK status can be resubmitted
        if ($permohonan->status !== 'DITOLAK') {
            return redirect()->route('balasan.index')->with('error', 'Hanya permohonan yang ditolak yang dapat diajukan ulang.');
        }

        return view('kota.permohonan_kakot', [
            'title' => 'Ajukan Ulang Permohonan',
            'permohonan' => $permohonan,
            'isResubmit' => true
        ]);
    }

    /**
     * Store a new permohonan or update existing (resubmit)
     */
    public function store(Request $request)
    {
        // Cek apakah ini mode resubmit (update) atau create baru
        $isResubmit = $request->has('resubmit_id');
        $permohonanLama = null;

        if ($isResubmit) {
            $permohonanLama = Permohonan::findOrFail($request->resubmit_id);
            
            // Authorization: hanya pembuat yang bisa update
            if ($permohonanLama->user_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses untuk mengupdate permohonan ini.');
            }

            // Hanya permohonan DITOLAK yang bisa diajukan ulang
            if ($permohonanLama->status !== 'DITOLAK') {
                return back()->withErrors(['error' => 'Hanya permohonan yang ditolak yang dapat diajukan ulang.'])->withInput();
            }
        }

        // Validasi input
        $validated = $request->validate([
            'nama_subjek' => 'required|string',
            'daerah_asal' => 'required|string',
            'wilayah' => 'required|in:dalam,luar',
            'wilayah_tujuan' => 'required|string',
            'daerah_tujuan' => 'required|string',
            'jenis_permohonan' => 'required|string', 
            'jenis_dokumen' => 'required|string',       
            'nomor_surat' => 'required|string',
            'tanggal_surat' => 'required|date',
            'file' => $isResubmit ? 'nullable|file|mimes:pdf|max:10240' : 'required|file|mimes:pdf|max:10240',
        ]);

        // Handle file upload
        $filePath = $isResubmit ? $permohonanLama->file_path : null;
        if ($request->hasFile('file')) {
            // Jika resubmit, hapus file lama
            if ($isResubmit && $permohonanLama->file_path) {
                $oldFilePath = str_replace('/storage/', '', $permohonanLama->file_path);
                $oldFullPath = storage_path("app/public/{$oldFilePath}");
                if (file_exists($oldFullPath)) {
                    unlink($oldFullPath);
                }
            }

            $file = $request->file('file');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/permohonan', $fileName);
            $filePath = Storage::url('permohonan/' . $fileName);
        }

        // Ambil user daerah tujuan untuk verifikasi & dapatkan kode wilayah
        $targetUser = null;
        $kodeWilayahTujuan = null;

        if ($request->wilayah == 'dalam') {
            $targetUser = User::where('name', $request->daerah_tujuan)
                            ->where('role', 'daerah') 
                            ->first();

            if (!$targetUser) {
                return back()->withErrors(['daerah_tujuan' => 'Akun untuk daerah tujuan ini belum dibuat oleh Superadmin. Hubungi Admin Provinsi.'])->withInput();
            }

            $kodeWilayahTujuan = $targetUser->kode_wilayah;
        }

        $data = [
            'user_id' => Auth::id(),
            'nama_subjek' => $validated['nama_subjek'],
            'daerah_asal' => Auth::user()->name,
            'wilayah' => $validated['wilayah'],
            'wilayah_tujuan' => $validated['wilayah_tujuan'],
            'daerah_tujuan' => $validated['daerah_tujuan'],
            'kode_daerah_tujuan' => $kodeWilayahTujuan,
            'nomor_surat' => $validated['nomor_surat'],
            'tanggal_surat' => $validated['tanggal_surat'],
            'file_path' => $filePath,
            'status' => 'BELUM',
            'jenis_permohonan' => $validated['jenis_permohonan'],
            'jenis_dokumen' => $validated['jenis_dokumen'],
            'catatan' => null, // Clear rejection reason
        ];

        if ($isResubmit) {
            // UPDATE permohonan lama
            $permohonanLama->update($data);
            $message = 'Permohonan berhasil diajukan ulang!';
        } else {
            // CREATE permohonan baru
            Permohonan::create($data);
            $message = 'Permohonan berhasil dikirim!';
        }

        return redirect('/dashboard_kakot')->with('success', $message);

    }

    /**
     * SECURITY FIX: Download file permohonan dengan authorization check
     * Untuk user pembuat permohonan
     */
    public function downloadFile($id)
    {
        $permohonan = Permohonan::findOrFail($id);

        // Authorization: Bisa diakses oleh:
        // 1. Pembuat permohonan (user_id)
        // 2. Daerah tujuan (kode_daerah_tujuan)
        $isPembuat = $permohonan->user_id === Auth::id();
        $isDaerahTujuan = $permohonan->kode_daerah_tujuan === Auth::user()->kode_wilayah;
        
        if (!$isPembuat && !$isDaerahTujuan) {
            abort(403, 'Anda tidak memiliki akses ke file ini.');
        }

        if (!$permohonan->file_path) {
            abort(404, 'File tidak ditemukan.');
        }

        // Hapus /storage/ prefix jika ada, dan ubah ke path storage
        $filePath = str_replace('/storage/', '', $permohonan->file_path);
        $fullPath = storage_path("app/public/{$filePath}");
        
        // Preview di tab baru (bukan download)
        if (!file_exists($fullPath)) {
            abort(404, 'File tidak ditemukan di server.');
        }
        
        return response()->file($fullPath);
    }
}
