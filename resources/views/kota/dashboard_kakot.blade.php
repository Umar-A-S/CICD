<x-layout_dashboard_kakot :stat="$stat"> 
    <x-slot:title>{{ $title }}</x-slot:title>
    
    <!-- ================= TABLE ================= -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <div class="glass-panel rounded-xl overflow-hidden">

                            <div class="p-4 border-b border-white/10 bg-white/5">
                                <h3 class="font-bold text-black">Status Permohonan Terkini</h3>
                            </div>
                            <x-search_input
                            id="SearchPermohonan"
                            targetTable="permohonanTable"
                            placeholder="Cari nama, asal, atau nomor surat..."
                            ></x-search_input>
                            <div class="flex flex-wrap gap-2 mb-4">
                                <button class="filter-btn active px-4 py-2 rounded-lg bg-gray-200" data-status="all">Semua</button>
                                <button class="filter-btn px-4 py-2 rounded-lg" data-status="belum">Belum</button>
                                <button class="filter-btn px-4 py-2 rounded-lg" data-status="diproses">Diproses</button>
                                <button class="filter-btn px-4 py-2 rounded-lg" data-status="selesai">Selesai</button>
                                <button class="filter-btn px-4 py-2 rounded-lg" data-status="ditolak">Ditolak</button>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse overflow-hidden rounded-xl" id ="permohonanTable">
                                    <thead class="bg-lime-300 text-black text-sm uppercase">
                                        <tr>
                                            <th class="px-6 py-3">NAMA</th>
                                            <th class="px-6 py-3">NOMOR SURAT/AKTA</th>
                                            <th class="px-6 py-3">JENIS PERMOHONAN</th>
                                            <th class="px-6 py-3">TGL PENGAJUAN</th>
                                            <th class="px-6 py-3">STATUS</th>
                                            <th class="px-6 py-3">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($permohonans as $permohonan)
                                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition" data-status="{{ strtolower($permohonan->status) }}">
                                                <td class="px-6 py-4 font-semibold">{{ $permohonan->nama_subjek }}</td>
                                                <td class="px-6 py-4">{{ $permohonan->nomor_surat }}</td>
                                                <td class="px-6 py-4">{{ $permohonan->jenis_permohonan }}</td>
                                                <td class="px-6 py-4">{{ $permohonan->created_at->format('d/m/Y') }}</td>
                                                <td class="px-6 py-4">
                                                    @php
                                                        $statusClass = match($permohonan->status) {
                                                            'BELUM' => 'bg-yellow-100 text-yellow-800',
                                                            'DIPROSES' => 'bg-blue-100 text-blue-800',
                                                            'SELESAI' => 'bg-green-100 text-green-800',
                                                            'DITOLAK' => 'bg-red-100 text-red-800',
                                                            default => 'bg-gray-100 text-gray-800'
                                                        };
                                                    @endphp
                                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusClass }}">
                                                        {{ $permohonan->status }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <a href="/detail_permohonan_kakot/{{ $permohonan->id }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                                        Lihat Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                                    Belum ada data permohonan
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
</x-layout_dashboard_kakot>

<script>
    // Mengonversi data dari Laravel ($permohonans) ke Array JavaScript
    window.submissions = @json($permohonans);
</script>