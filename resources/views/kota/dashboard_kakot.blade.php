<x-layout_dashboard_kakot> >
    <x-slot:title>{{ $title }}</x-slot:title>
    
    <!-- ================= TABLE ================= -->
                    <div class="lg:col-span-5">
                        <div class="glass-panel rounded-xl overflow-hidden">

                            <div class="p-4 border-b border-white/10 bg-white/5">
                                <h3 class="font-bold text-black">Status Permohonan Terkini</h3>
                            </div>

                            <div class="flex flex-wrap gap-2 mb-4">
                                <button class="filter-btn active" data-status="all">Semua</button>
                                <button class="filter-btn" data-status="pending">Belum</button>
                                <button class="filter-btn" data-status="valid">Diproses</button>
                                <button class="filter-btn" data-status="success">Selesai</button>
                                <button class="filter-btn" data-status="rejected">Ditolak</button>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm text-black">
                                    <thead class="bg-lime-400 text-xs font-bold uppercase">
                                        <tr>
                                            <th class="px-6 py-3">NAMA</th>
                                            <th class="px-6 py-3">NOMOR SURAT/AKTA</th>
                                            <th class="px-6 py-3">JENIS PERMOHONAN</th>
                                            <th class="px-6 py-3">TGL PENGAJUAN</th>
                                            <th class="px-6 py-3">STATUS</th>
                                            <th class="px-6 py-3">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableKotaKabupaten"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
</x-layout_dashboard_kakot>