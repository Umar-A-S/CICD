<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT AKUN UNTUK KAMU LOGIN (PENTING!)
        // Kita anggap kamu login sebagai "Kabupaten Magelang"
        User::create([
            'name' => 'Admin Kab. Magelang',
            'username' => 'admin_magelang', // Username buat login
            'password' => Hash::make('password'), // Password: password
            'role' => 'daerah',
            'kode_wilayah' => '33.08', // Kode Magelang
        ]);

        // Kita anggap kamu login sebagai "Provinsi Jawa Tengah"
        User::create([
            'name' => 'Admin Prov. Jawa Tengah',
            'username' => 'admin_jawa_tengah', // Username buat login
            'password' => Hash::make('password123'), // Password: password
            'role' => 'provinsi',
            'kode_wilayah' => '', // Kode Jawa Tengah
        ]);

        // 2. Panggil Seeder Penerbitan (Untuk isi data dummy surat masuk)
        $this->call([
            PenerbitanSeeder::class,
        ]);
    }
}