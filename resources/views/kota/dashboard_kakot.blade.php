<x-layout_dashboard_kakot>
    <x-slot:title>{{ $title }}</x-slot:title>

    <body class="bg-gray-100 p-10">

    <div class="max-w-7xl mx-auto space-y-6">

        <!-- ================= TABLE CARD ================= -->
        <div class="bg-white rounded-2xl shadow-sm">

            <!-- HEADER -->
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-bold text-black">
                    Status Permohonan Terkini
                </h3>
            </div>

            <!-- SEARCH -->
            <div class="px-6 pt-6">
                <input
                    id="searchInput"
                    type="text"
                    placeholder="Cari nama / nomor surat..."
                    class="w-full border border-gray-200 rounded-xl px-4 py-2
                        text-sm text-black focus:outline-none focus:ring-2 focus:ring-lime-400"
                >
            </div>

            <!-- FILTER -->
            <div class="px-6 py-4 flex flex-wrap gap-2">
                <button class="filter-btn active" data-status="all">Semua</button>
                <button class="filter-btn" data-status="pending">Belum</button>
                <button class="filter-btn" data-status="valid">Diproses</button>
                <button class="filter-btn" data-status="success">Selesai</button>
                <button class="filter-btn" data-status="rejected">Ditolak</button>
            </div>

            <!-- TABLE -->
            <div class="px-6 pb-6">
                <div class="max-h-[420px] overflow-y-auto rounded-xl border">

                    <table class="w-full table-fixed text-sm text-black">
                        <thead class="sticky top-0 z-10 bg-lime-400 text-xs font-bold uppercase text-black">
                            <tr>
                                <th class="px-4 py-4 w-[6%] text-center">No</th>
                                <th class="px-6 py-4 w-[18%] text-left">Nama</th>
                                <th class="px-6 py-4 w-[24%] text-left">Nomor Surat</th>
                                <th class="px-6 py-4 w-[18%] text-left">Jenis</th>
                                <th class="px-6 py-4 w-[14%] text-left">Tanggal</th>
                                <th class="px-6 py-4 w-[14%] text-center">Status</th>
                                <th class="px-6 py-4 w-[12%] text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="tableKotaKabupaten" class="divide-y"></tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</x-layout_dashboard_kakot>