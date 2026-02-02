<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Permohonan;
use App\Models\Penerbitan;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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

        echo "\n✅ Created 35 daerah accounts + 1 provinsi + 1 superadmin\n";

        // 4. GENERATE DUMMY PERMOHONAN
        $this->generateDummyPermohonan($users);
    }

    /**
     * Generate realistic dummy permohonan data
     */
    private function generateDummyPermohonan($users)
    {
        $jenisDokumen = [
            'Akta Kelahiran',
            'Akta Kematian',
            'Akta Perkawinan',
            'Akta Perceraian',
            'Kartu Keluarga',
            'KTP',
        ];

        $namaPemohon = [
            'Budi Santoso', 'Siti Nurhaliza', 'Ahmad Dhani', 'Dewi Lestari',
            'Rudi Hartono', 'Ani Yudhoyono', 'Joko Widodo', 'Mega Sari',
            'Bambang Pamungkas', 'Rina Susanti', 'Hendra Wijaya', 'Maya Sari',
            'Agus Salim', 'Fitri Handayani', 'Dedi Corbuzier', 'Nia Ramadhani',
            'Eko Patrio', 'Sandra Dewi', 'Ridwan Kamil', 'Syahrini',
        ];

        // Daerah di luar Jawa Tengah (contoh berbagai provinsi)
        $daerahLuarJateng = [
            ['nama' => 'Kabupaten Badung', 'provinsi' => 'Bali'],
            ['nama' => 'Kota Denpasar', 'provinsi' => 'Bali'],
            ['nama' => 'Kabupaten Bantul', 'provinsi' => 'DI Yogyakarta'],
            ['nama' => 'Kota Yogyakarta', 'provinsi' => 'DI Yogyakarta'],
            ['nama' => 'Kabupaten Bogor', 'provinsi' => 'Jawa Barat'],
            ['nama' => 'Kota Bandung', 'provinsi' => 'Jawa Barat'],
            ['nama' => 'Kabupaten Malang', 'provinsi' => 'Jawa Timur'],
            ['nama' => 'Kota Surabaya', 'provinsi' => 'Jawa Timur'],
            ['nama' => 'Kabupaten Kotawaringin Barat', 'provinsi' => 'Kalimantan Tengah'],
            ['nama' => 'Kota Palangkaraya', 'provinsi' => 'Kalimantan Tengah'],
            ['nama' => 'Kabupaten Barito Kuala', 'provinsi' => 'Kalimantan Selatan'],
            ['nama' => 'Kota Banjarmasin', 'provinsi' => 'Kalimantan Selatan'],
            ['nama' => 'Kabupaten Tangerang', 'provinsi' => 'Banten'],
            ['nama' => 'Kota Tangerang Selatan', 'provinsi' => 'Banten'],
            ['nama' => 'Kabupaten Lampung Selatan', 'provinsi' => 'Lampung'],
            ['nama' => 'Kota Bandar Lampung', 'provinsi' => 'Lampung'],
        ];

        $statusList = ['BELUM', 'DIPROSES', 'SELESAI', 'DITOLAK'];
        $wilayahList = ['dalam', 'luar'];

        $permohonanCounter = 1;

        // Generate 80 permohonan dari berbagai daerah
        for ($i = 0; $i < 80; $i++) {
            $user = $users[array_rand($users)];
            $wilayah = $wilayahList[array_rand($wilayahList)];
            $status = $statusList[array_rand($statusList)];
            
            // Random date dalam 3 bulan terakhir
            $createdAt = Carbon::now()->subDays(rand(1, 90));
            
            $daerahTujuan = null;
            $kodeDaerahTujuan = null;
            $wilayahTujuan = null;
            
            if ($wilayah === 'dalam') {
                // Untuk dalam wilayah: pilih daerah lain di Jawa Tengah
                $targetUser = $users[array_rand($users)];
                $daerahTujuan = $targetUser->name;
                $kodeDaerahTujuan = $targetUser->kode_wilayah;
                $wilayahTujuan = 'Jawa Tengah';
            } else {
                // Untuk luar wilayah: pilih dari daerah luar Jawa Tengah
                $targetDaerah = $daerahLuarJateng[array_rand($daerahLuarJateng)];
                $daerahTujuan = $targetDaerah['nama'];
                $wilayahTujuan = $targetDaerah['provinsi'];
                $kodeDaerahTujuan = null; // Luar jateng tidak punya kode 33.xx
            }

            $permohonan = Permohonan::create([
                'user_id' => $user->id,
                'nomor_surat' => 'PRM/' . $user->kode_wilayah . '/' . str_pad($permohonanCounter++, 4, '0', STR_PAD_LEFT) . '/' . $createdAt->format('Y'),
                'nama_subjek' => $namaPemohon[array_rand($namaPemohon)],
                'tanggal_surat' => $createdAt->format('Y-m-d'),
                'daerah_asal' => $user->name,
                'wilayah' => $wilayah,
                'wilayah_tujuan' => $wilayahTujuan,
                'daerah_tujuan' => $daerahTujuan,
                'kode_daerah_tujuan' => $kodeDaerahTujuan,
                'jenis_permohonan' => 'Verifikasi Dokumen',
                'jenis_dokumen' => $jenisDokumen[array_rand($jenisDokumen)],
                'file_path' => 'permohonan/dummy_' . $i . '.pdf',
                'status' => $status,
                'catatan' => $status === 'DIPROSES' ? 'Sedang dalam proses verifikasi oleh tim.' : null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // Generate Penerbitan untuk status SELESAI atau DITOLAK
            if ($status === 'SELESAI' || $status === 'DITOLAK') {
                $tanggalTerbit = $createdAt->copy()->addDays(rand(3, 14));
                
                Penerbitan::create([
                    'permohonan_id' => $permohonan->id,
                    'nomor_surat_selesai' => 'SRT/' . $user->kode_wilayah . '/' . str_pad($permohonan->id, 4, '0', STR_PAD_LEFT) . '/' . $tanggalTerbit->format('Y'),
                    'tanggal_surat_selesai' => $tanggalTerbit,
                    'hasil' => $status === 'SELESAI' ? 'SAH' : 'TIDAK SAH',
                    'alasan' => $status === 'DITOLAK' ? 'Dokumen tidak memenuhi persyaratan administrasi yang ditentukan.' : null,
                    'file_path' => 'penerbitan/dummy_penerbitan_' . $permohonan->id . '.pdf',
                    'created_at' => $tanggalTerbit,
                    'updated_at' => $tanggalTerbit,
                ]);
            }
        }

        echo "✅ Generated 80 dummy permohonan with realistic data\n\n";
        echo "📊 Summary:\n";
        echo "   - Total Users: " . (count($users) + 2) . " (35 daerah + 1 provinsi + 1 superadmin)\n";
        echo "   - Total Permohonan: 80\n";
        echo "   - Credentials: username=daerah_name, password=password\n";
        echo "   - Superadmin: username=superadmin, password=password123\n";
        echo "   - Provinsi: username=adminjateng, password=password\n\n";
    }
}
