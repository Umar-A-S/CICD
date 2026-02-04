<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. SUPERADMIN
        User::create([
            'name' => 'Administrator',
            'username' => 'superadmin',
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
        ]);

        // 2. USER PROVINSI JAWA TENGAH
        User::create([
            'name' => 'Provinsi Jawa Tengah',
            'username' => 'adminjateng',
            'password' => Hash::make('password'),
            'role' => 'provinsi',
        ]);

        // 3. SEMUA DAERAH JAWA TENGAH (35 Kota/Kabupaten)
        $daerahList = [
            ['name' => 'Kabupaten Cilacap', 'username' => 'cilacap', 'kode' => '33.01'],
            ['name' => 'Kabupaten Banyumas', 'username' => 'banyumas', 'kode' => '33.02'],
            ['name' => 'Kabupaten Purbalingga', 'username' => 'purbalingga', 'kode' => '33.03'],
            ['name' => 'Kabupaten Banjarnegara', 'username' => 'banjarnegara', 'kode' => '33.04'],
            ['name' => 'Kabupaten Kebumen', 'username' => 'kebumen', 'kode' => '33.05'],
            ['name' => 'Kabupaten Purworejo', 'username' => 'purworejo', 'kode' => '33.06'],
            ['name' => 'Kabupaten Wonosobo', 'username' => 'wonosobo', 'kode' => '33.07'],
            ['name' => 'Kabupaten Magelang', 'username' => 'magelang', 'kode' => '33.08'],
            ['name' => 'Kabupaten Boyolali', 'username' => 'boyolali', 'kode' => '33.09'],
            ['name' => 'Kabupaten Klaten', 'username' => 'klaten', 'kode' => '33.10'],
            ['name' => 'Kabupaten Sukoharjo', 'username' => 'sukoharjo', 'kode' => '33.11'],
            ['name' => 'Kabupaten Wonogiri', 'username' => 'wonogiri', 'kode' => '33.12'],
            ['name' => 'Kabupaten Karanganyar', 'username' => 'karanganyar', 'kode' => '33.13'],
            ['name' => 'Kabupaten Sragen', 'username' => 'sragen', 'kode' => '33.14'],
            ['name' => 'Kabupaten Grobogan', 'username' => 'grobogan', 'kode' => '33.15'],
            ['name' => 'Kabupaten Blora', 'username' => 'blora', 'kode' => '33.16'],
            ['name' => 'Kabupaten Rembang', 'username' => 'rembang', 'kode' => '33.17'],
            ['name' => 'Kabupaten Pati', 'username' => 'pati', 'kode' => '33.18'],
            ['name' => 'Kabupaten Kudus', 'username' => 'kudus', 'kode' => '33.19'],
            ['name' => 'Kabupaten Jepara', 'username' => 'jepara', 'kode' => '33.20'],
            ['name' => 'Kabupaten Demak', 'username' => 'demak', 'kode' => '33.21'],
            ['name' => 'Kabupaten Semarang', 'username' => 'semarang', 'kode' => '33.22'],
            ['name' => 'Kabupaten Temanggung', 'username' => 'temanggung', 'kode' => '33.23'],
            ['name' => 'Kabupaten Kendal', 'username' => 'kendal', 'kode' => '33.24'],
            ['name' => 'Kabupaten Batang', 'username' => 'batang', 'kode' => '33.25'],
            ['name' => 'Kabupaten Pekalongan', 'username' => 'pekalongan', 'kode' => '33.26'],
            ['name' => 'Kabupaten Pemalang', 'username' => 'pemalang', 'kode' => '33.27'],
            ['name' => 'Kabupaten Tegal', 'username' => 'tegal', 'kode' => '33.28'],
            ['name' => 'Kabupaten Brebes', 'username' => 'brebes', 'kode' => '33.29'],
            ['name' => 'Kota Magelang', 'username' => 'kotamagelang', 'kode' => '33.71'],
            ['name' => 'Kota Surakarta', 'username' => 'surakarta', 'kode' => '33.72'],
            ['name' => 'Kota Salatiga', 'username' => 'salatiga', 'kode' => '33.73'],
            ['name' => 'Kota Semarang', 'username' => 'kotasemarang', 'kode' => '33.74'],
            ['name' => 'Kota Pekalongan', 'username' => 'kotapekalongan', 'kode' => '33.75'],
            ['name' => 'Kota Tegal', 'username' => 'kotategal', 'kode' => '33.76'],
        ];

        $users = [];
        foreach ($daerahList as $daerah) {
            $users[] = User::create([
                'name' => $daerah['name'],
                'username' => $daerah['username'],
                'password' => Hash::make('password'),
                'role' => 'daerah',
                'kode_wilayah' => $daerah['kode'],
            ]);
        }

        echo "\n✅ Seeded 37 user accounts:\n";
        echo "   - 1 Superadmin (username: superadmin, password: password123)\n";
        echo "   - 1 Provinsi (username: adminjateng, password: password)\n";
        echo "   - 35 Daerah (username: nama_daerah, password: password)\n\n";
    }
}
