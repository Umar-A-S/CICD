<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permohonan;
use App\Models\Penerbitan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class PenerbitanSeeder extends Seeder
{
    public function run(): void
    {
        // A. BUAT USER PENGIRIM (Daerah Lain)
        // Kita butuh akun ini agar kolom user_id tidak error (Foreign Key)
        $semarang = User::create([
            'name' => 'Admin Kota Semarang',
            'username' => 'admin_semarang',
            'password' => Hash::make('password'),
            'role' => 'daerah',
            'kode_wilayah' => '33.74'
        ]);

        $brebes = User::create([
            'name' => 'Admin Kab. Brebes',
            'username' => 'admin_brebes',
            'password' => Hash::make('password'),
            'role' => 'daerah',
            'kode_wilayah' => '33.29'
        ]);

        // B. SKENARIO 1: SURAT MASUK (PERLU DIBALAS)
        // Dari Semarang -> Ke Magelang (Kamu)
        Permohonan::create([
            'user_id' => $semarang->id, // Pengirim
            'nama_subjek' => 'Siti Aminah',
            'daerah_asal' => 'Kota Semarang',
            
            // PENTING: Harus sama dengan Username/Nama akun login kamu
            // Agar muncul di filter where('daerah_tujuan', $user->username)
            'daerah_tujuan' => 'admin_magelang', 
            'wilayah_tujuan' => 'Jawa Tengah',
            
            'wilayah' => 'dalam',
            'jenis_permohonan' => 'KEABSAHAN',
            'jenis_dokumen' => 'KTP',
            'nomor_surat' => '123/SMG/2026',
            'tanggal_surat' => Carbon::now()->subDays(2),
            'file_path' => 'dummy/ktp_siti.pdf', // Pastikan path ini string
            'status' => 'BELUM',
        ]);

        // C. SKENARIO 2: SURAT SELESAI (SUDAH DIBALAS)
        // Dari Brebes -> Ke Magelang (Kamu) -> Sudah dibalas
        $permohonanSelesai = Permohonan::create([
            'user_id' => $brebes->id, // Pengirim
            'nama_subjek' => 'Ahmad Fauzi',
            'daerah_asal' => 'Kabupaten Brebes',
            'daerah_tujuan' => 'admin_magelang', // Tujuan ke kamu
            'wilayah_tujuan' => 'Jawa Tengah',
            'wilayah' => 'dalam',
            'jenis_permohonan' => 'LEGALISIR',
            'jenis_dokumen' => 'Kartu Keluarga',
            'nomor_surat' => '99/BRB/2026',
            'tanggal_surat' => Carbon::now()->subDays(5),
            'file_path' => 'dummy/kk_ahmad.pdf',
            'status' => 'SELESAI',
        ]);

        // Karena status SELESAI, wajib isi tabel Penerbitan
        Penerbitan::create([
            'permohonan_id' => $permohonanSelesai->id,
            'hasil' => 'TERCATAT',
            'alasan' => 'Data valid dan sesuai database.',
            'nomor_surat_selesai' => '001/MGL/BLS/2026', // Opsional, kalau ada di tabel
            'tanggal_surat_selesai' => Carbon::now()->subDays(1), // Sesuai koreksi kamu sebelumnya
            'file_path' => 'dummy/balasan_ahmad.pdf',
        ]);
    }
}