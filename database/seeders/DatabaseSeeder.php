<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Magelang',
            'username' => 'admin_magelang',
            'password' => Hash::make('password123'),
            'role' => 'daerah',
            'kode_wilayah' => '33.08', // Contoh kode wilayah Magelang
        ]);
    }
}