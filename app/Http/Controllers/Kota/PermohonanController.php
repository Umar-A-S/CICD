<?php

namespace App\Http\Controllers\Kota;

use App\Http\Controllers\Controller;
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
// app/Http/Controllers/Kota/PermohonanController.php

// app/Http/Controllers/Kota/PermohonanController.php

    public function index()
    {
        $user = Auth::user();
        
        // Filter data (sama seperti sebelumnya)
        if ($user->role === 'daerah') {
            $permohonans = Permohonan::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        } else {
            $permohonans = Permohonan::orderBy('created_at', 'desc')->get();
        }

        // JANGAN PAKAI response()->json()!
        // Gunakan return view agar menampilkan halaman desain kamu
        return view('kota.permohonan_kakot', [
            'title' => 'Daftar Permohonan',
            'permohonans' => $permohonans
        ]);
    }
    /**
     * Show a single permohonan detail
     */
// app/Http/Controllers/Kota/PermohonanController.php

    public function show($id)
    {
        // Ambil data permohonan berdasarkan ID, jika tidak ada muncul 404
        $permohonan = Permohonan::findOrFail($id);

        // Proteksi Keamanan: User daerah hanya boleh lihat miliknya sendiri
        if (Auth::user()->role === 'daerah' && $permohonan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('kota.detail_permohonan_kakot', [
            'title' => 'Detail Permohonan',
            'permohonan' => $permohonan
        ]);
    }

    /**
     * Store a new permohonan
     */
    public function store(Request $request)
    {
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
            'file' => 'required|file|mimes:pdf|max:10240',
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
        'nama_subjek' => $validated['nama_subjek'],
        'daerah_asal' => $validated['daerah_asal'],
        'wilayah' => $validated['wilayah'],
        'wilayah_tujuan' => $validated['wilayah_tujuan'],
        'daerah_tujuan' => $validated['daerah_tujuan'],
        'nomor_surat' => $validated['nomor_surat'],
        'tanggal_surat' => $validated['tanggal_surat'],
        'file_path' => $filePath  , // Contoh fungsi upload
        'status' => 'BELUM',
        
        // Pemetaan: Isi kolom 'jenis' di DB dengan data 'jenis_permohonan' dari form
        'jenis' => $validated['jenis_permohonan'], 
        'jenis_permohonan' => $validated['jenis_permohonan'],
        'jenis_dokumen' => $validated['jenis_dokumen'],
    ]);

        return redirect('/dashboard_kakot')->with('success', 'Permohonan berhasil dikirim!');

    }
}
