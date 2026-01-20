<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatusPermohonan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PermohonanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis' => 'required|string',
            'nama' => 'required|string',
            'nik' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'nomor' => 'nullable|string',
            'wilayahTujuan' => 'nullable|string',
            'wilayah' => 'nullable|string',
            'daerahTujuan' => 'nullable|string',
            'daerahAsal' => 'nullable|string',
            'file' => 'nullable|file|max:2048|mimes:pdf,jpg,jpeg,png'
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $name = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/permohonan', $name);
            $filePath = Storage::url('permohonan/' . $name);
        }

        $entry = StatusPermohonan::create([
            'jenis' => $validated['jenis'],
            'nama' => $validated['nama'],
            'nik' => $validated['nik'] ?? null,
            'tanggal_surat' => $validated['tanggal'] ?? null,
            'nomor_surat' => $validated['nomor'] ?? null,
            'wilayah_tujuan' => $validated['wilayahTujuan'] ?? null,
            'wilayah' => $validated['wilayah'] ?? null,
            'daerah_tujuan' => $validated['daerahTujuan'] ?? null,
            'daerah_asal' => $validated['daerahAsal'] ?? null,
            'file_path' => $filePath,
            'status' => 'PENDING'
        ]);

        return response()->json(['success' => true, 'id' => $entry->id]);
    }
}
