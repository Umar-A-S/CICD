<x-layoutarsipkota>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="glass-panel rounded-2xl p-10 w-full bg-white">
        <!-- HEADER -->
        <div class="text-center mb-8">
            <i class="fa-solid fa-folder-open text-5xl text-black mb-3"></i>
            <h3 class="text-2xl font-semibold text-black">Riwayat Permintaan</h3>
        </div>

        <!-- SEARCH -->
        <div class="max-w-md mx-auto relative mb-6">
            <input
                id="searchInput"
                type="text"
                placeholder="Cari NIK atau Nama"
                class="w-full pl-10 pr-4 py-3 rounded-full
                    border border-gray-300
                    text-black placeholder-gray-400
                    bg-white
                    focus:outline-none focus:ring-2 focus:ring-lime-400"
                    />
            <i class="fa-solid fa-search absolute left-4 top-4 text-gray-400"></i>
        </div>

        <!-- FILTER -->
        <div class="flex items-center gap-3 mb-4">
            <span class="text-sm font-semibold text-black">Riwayat</span>
            <button onclick="filterStatus('all')" class="filter-btn active">Semua</button>
            <button onclick="filterStatus('rejected')" class="filter-btn">Ditolak</button>
            <button onclick="filterStatus('completed')" class="filter-btn">Selesai</button>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto rounded-xl border">
            <table class="w-full text-sm">
                <thead class="bg-lime-400 text-black">
                    <tr>
                        <th class="px-6 py-4 text-left">NAMA</th>
                        <th class="px-6 py-4 text-left">NIK</th>
                        <th class="px-6 py-4 text-left">JENIS PERMOHONAN</th>
                        <th class="px-6 py-4 text-left">TGL PENGAJUAN</th>
                        <th class="px-6 py-4 text-left">STATUS</th>
                        <th class="px-6 py-4 text-left">AKSI</th>
                    </tr>
                </thead>
                <tbody id="tableKotaKabupaten" class="text-black"></tbody>
            </table>
        </div>
    </div>
</x-layoutarsipkota>