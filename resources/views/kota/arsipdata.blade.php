<x-layoutarsipkota >
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Arsip Data -->
    <div class="glass-panel rounded-xl p-12 w-full">
        <div class="text-center mb-10">
            <i class="fa-solid fa-folder-open text-6xl text-lime-400 mb-4"></i>
            <h3 class="text-xl font-bold text-black">Arsip Data Kependudukan</h3>
            <p class="text-black">
                Semua riwayat data yang telah selesai diproses tersimpan di sini.
            </p>
        </div>

        <!-- SEARCH -->
        <div class="max-w-md mx-auto relative mb-6">
            <input
                id="searchInput"
                type="text"
                placeholder="Cari NIK atau Nama..."
                class="w-full pl-10 pr-4 py-3 glass-input rounded-full focus:border-lime-400 transition"
            >
            <i class="fa-solid fa-search absolute left-4 top-4 text-lime-400"></i>
        </div>

        <!-- TITLE -->
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-lg font-semibold text-black">Riwayat</h4>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto bg-white rounded-2xl shadow-md w-full">
            <table class="w-full text-sm">
                <thead class="bg-lime-400 text-black">
                    <tr>
                        <th class="text-left px-6 py-4">NIK & NAMA</th>
                        <th class="text-left px-6 py-4">TANGGAL</th>
                        <th class="text-left px-6 py-4">STATUS</th>
                        <th class="text-left px-6 py-4">KETERANGAN</th>
                    </tr>
                </thead>
                <tbody id="tableKotaKabupaten" class="text-black">
                </tbody>
            </table>
        </div>
    </div>

</x-layoutarsipkota>