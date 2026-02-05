<?php

namespace App\Http\Controllers\Provinsi;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PermohonanProvController extends Controller
{
    /**
     * Display a listing of permohonan for the authenticated user
     */
// app/Http/Controllers/Kota/PermohonanController.php

// app/Http/Controllers/Kota/PermohonanController.php

    public function index()
    {
        $user = Auth::user();
        

        $permohonans = Permohonan::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('provinsi.permohonan-prov', [
            'title' => 'Permohonan',
            'permohonans' => $permohonans
        ]);
    }


    public function show($id)
    {
        // Ambil data permohonan berdasarkan ID, jika tidak ada muncul 404
        $permohonan = Permohonan::findOrFail($id);

        // // Proteksi Keamanan: User daerah hanya boleh lihat miliknya sendiri
        // if (Auth::user()->role === 'daerah' && $permohonan->user_id !== Auth::id()) {
        //     abort(403, 'Anda tidak memiliki akses ke data ini.');
        // }

        return view('provinsi.detail-permohonan-prov', [
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

        // Create permohonan
        $permohonan = Permohonan::create([
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
        ]);

        return redirect('/dashboard-provinsi')->with('success', 'Permohonan berhasil dikirim!');

    }
}
