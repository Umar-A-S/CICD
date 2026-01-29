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
            'name' => 'Kabupaten Magelang',
            'username' => 'adminmagelang', // Username buat login
            'password' => Hash::make('password'), // Password: password
            'role' => 'daerah',
            'kode_wilayah' => '33.08', // Kode Magelang
        ]);

        User::create([
            'name' => 'Kabupaten Demak',
            'username' => 'admindemak', 
            'password' => Hash::make('password'), 
            'role' => 'daerah',
            'kode_wilayah' => '33.04', 
        ]);

        
        User::create([
            'name' => 'Provinsi Jawa Tengah',
            'username' => 'adminjawatengah', 
            'password' => Hash::make('password123'), 
            'role' => 'provinsi',
            'kode_wilayah' => '', 
        ]);

        // 2. Panggil Seeder Penerbitan (Untuk isi data dummy surat masuk)
        $this->call([
        ]);
    }
}