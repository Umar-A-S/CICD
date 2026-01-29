<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permohonan;
use App\Models\Penerbitan;
use Carbon\Carbon;

class PermohonanSelesaiSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Permohonan dengan status SELESAI
        $permohonan = Permohonan::create([
            'user_id' => 1, // Pastikan ID user 1 (Admin Magelang) sudah ada
            'jenis_permohonan' => 'KEABSAHAN',
            'jenis_dokumen' => 'Akta Kelahiran',
            'nama_subjek' => 'Budi Santoso',
            'nomor_surat' => 'SRT/2026/001',
            'tanggal_surat' => Carbon::now()->subDays(5),
            'wilayah' => 'dalam',
            'wilayah_tujuan' => 'Jawa Tengah',
            'daerah_tujuan' => 'Kabupaten Brebes',
            'daerah_asal' => 'Kota Semarang',
            'file_path' => '/storage/permohonan/dummy_request.pdf',
            'status' => 'SELESAI', // Status wajib SELESAI
        ]);

        // 2. Buat Balasannya di tabel Penerbitan
        Penerbitan::create([
            'permohonan_id' => $permohonan->id,
            'tanggal_surat_selesai' => Carbon::now(),
            'nomor_surat_selesai' => 'SRT/2026/001/SELESAI',
            'alasan' => 'Data ditemukan dan sudah sesuai dengan database kependudukan.',
            'file_path' => '/storage/penerbitan/hasil_balasan_dummy.pdf', // Path file hasil
            'hasil' => 'TERCATAT', // Berdasarkan enum di migration
        ]);
    }
}