<x-layout_dashboard_kakot>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- ================= TABLE ================= -->
    <div class="lg:col-span-5">
        <div class="glass-panel rounded-2xl bg-white shadow-sm">

            <!-- HEADER -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-black">
                    Status Permohonan Terkini
                </h3>
            </div>

            <!-- FILTER -->
            <div class="px-6 py-4 flex flex-wrap gap-2">
                <button class="filter-btn active" data-status="all">Semua</button>
                <button class="filter-btn" data-status="pending">Belum</button>
                <button class="filter-btn" data-status="valid">Diproses</button>
                <button class="filter-btn" data-status="success">Selesai</button>
                <button class="filter-btn" data-status="rejected">Ditolak</button>
            </div>

            <!-- TABLE WRAPPER (BIAR TIDAK MEPET) -->
            <div class="px-6 pb-6">
                <div class="max-h-[420px] overflow-y-auto rounded-xl border border-gray-100">

                    <table class="w-full table-fixed text-sm text-black">
                        <thead class="sticky top-0 z-10 bg-lime-400 text-xs font-bold uppercase">
                            <tr>
                                <th class="px-6 py-4 w-[18%] text-left">Nama</th>
                                <th class="px-6 py-4 w-[24%] text-left">Nomor Surat/Akta</th>
                                <th class="px-6 py-4 w-[18%] text-left">Jenis Permohonan</th>
                                <th class="px-6 py-4 w-[14%] text-left">Tgl Pengajuan</th>
                                <th class="px-6 py-4 w-[14%] text-center">Status</th>
                                <th class="px-6 py-4 w-[12%] text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody
                            id="tableKotaKabupaten"
                            class="divide-y divide-gray-100"
                        >
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout_dashboard_kakot>
