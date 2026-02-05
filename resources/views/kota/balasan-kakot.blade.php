<x-layout-balasan-kakot>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="max-w-7xl mx-auto space-y-10">

        <!-- STATS CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            
            <div class="glass-panel p-5 rounded-xl flex items-center gap-4 hover:bg-white/5 transition" style="background-color: #ffffff; box-shadow: 0px 4px 20px 0px rgba(0,0,0,0.20);">
                <div class="w-12 h-12 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-black">
                        {{ $permohonanDiproses->count() }}
                    </div>
                    <div class="text-xs text-black uppercase">Sedang Diproses</div>
                </div>
            </div>

            <div class="glass-panel p-5 rounded-xl flex items-center gap-4 hover:bg-white/5 transition" style="background-color: #ffffff; box-shadow: 0px 4px 20px 0px rgba(0,0,0,0.20);">
                <div class="w-12 h-12 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-check-circle"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-black">
                        {{ $permohonanSelesai->count() }}
                    </div>
                    <div class="text-xs text-black uppercase">Selesai</div>
                </div>
            </div>

        </div>

        <!-- TABEL 1: SEDANG DIPROSES -->
        <div class="bg-white rounded-2xl p-8 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800">Permohonan Sedang Diproses</h3>
            <p class="text-sm text-gray-500 mb-6">Permohonan yang masih dalam proses verifikasi dan penerbitan</p>

            <x-search-input 
                id="searchDiproses" 
                targetTable="tableDiproses" 
                placeholder="Cari nama, asal, atau nomor surat..." 
            />

            <div class="border rounded-xl overflow-hidden mt-4">
                <div class="max-h-[600px] overflow-y-auto">
                    <table class="w-full text-left border-collapse" id="tableDiproses">
                        <thead class="bg-lime-300 text-black text-sm uppercase sticky top-0">
                            <tr>
                                <th class="px-6 py-3 font-semibold">No</th>
                                <th class="px-6 py-3 font-semibold">Subjek</th>
                                <th class="px-6 py-3 font-semibold">Daerah Tujuan</th>
                                <th class="px-6 py-3 font-semibold text-center">Status</th>
                                <th class="px-6 py-3 font-semibold text-center">Tanggal Pengajuan</th>
                                <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($permohonanDiproses as $item)
                            <tr class="hover:bg-gray-50 transition text-sm">
                                <td class="px-6 py-4 font-medium">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 max-w-[180px]">
                                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $item->nama_subjek }}</p>
                                    <p class="text-[10px] text-gray-500 truncate">{{ $item->jenis_permohonan }}</p>
                                </td>
                                <td class="px-6 py-4 max-w-[180px] truncate">{{ $item->daerah_tujuan }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($item->status === 'BELUM')
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                            BELUM DIVERIFIKASI
                                        </span>
                                    @elseif($item->status === 'DIPROSES')
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                            SEDANG DIPROSES
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center text-gray-500">
                                    {{ $item->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="/detail-balasan-kakot/{{ $item->id }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition inline-block">
                                        DETAIL
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-10 text-center text-gray-400 italic">
                                    Tidak ada permohonan yang sedang diproses.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TABEL 2: RIWAYAT BALASAN -->
        <div class="bg-white rounded-2xl p-8 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800">Riwayat Balasan</h3>
            <p class="text-sm text-gray-500 mb-6">Permohonan yang sudah selesai atau ditolak</p>

            <x-search-input 
                id="searchSelesai" 
                targetTable="tableSelesai" 
                placeholder="Cari nama, asal, atau nomor surat..." 
            />

            <x-filter-bulan 
                id="filterBulanSelesai" 
                targetTable="tableSelesai" 
            />

            <div class="border rounded-xl overflow-hidden mt-4">
                <div class="max-h-[600px] overflow-y-auto">
                    <table class="w-full text-left border-collapse" id="tableSelesai">
                        <thead class="bg-lime-300 text-black text-sm uppercase sticky top-0">
                            <tr>
                                <th class="px-6 py-3 font-semibold">No</th>
                                <th class="px-6 py-3 font-semibold">Subjek</th>
                                <th class="px-6 py-3 font-semibold">Daerah Tujuan</th>
                                <th class="px-6 py-3 font-semibold text-center">Status</th>
                                <th class="px-6 py-3 font-semibold text-center">Hasil Balasan</th>
                                <th class="px-6 py-3 font-semibold text-center">Tanggal Selesai</th>
                                <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($permohonanSelesai as $item)
                            <tr class="bg-gray-50/50 text-sm">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 max-w-[180px]">
                                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $item->nama_subjek }}</p>
                                    <p class="text-[10px] text-gray-500 truncate">{{ $item->jenis_permohonan }}</p>
                                </td>
                                <td class="px-6 py-4 max-w-[180px] truncate">{{ $item->daerah_tujuan }}</td>
                                
                                {{-- KOLOM STATUS --}}
                                <td class="px-6 py-4 text-center">
                                    @if($item->status === 'SELESAI')
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                            SELESAI
                                        </span>
                                    @elseif($item->status === 'DITOLAK')
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            DITOLAK
                                        </span>
                                    @endif
                                </td>

                                {{-- KOLOM HASIL BALASAN --}}
                                <td class="px-6 py-4 text-center">
                                    @if($item->status === 'SELESAI' && $item->penerbitan)
                                        @if($item->penerbitan->hasil === 'TERCATAT')
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                TERCATAT
                                            </span>
                                        @elseif($item->penerbitan->hasil === 'TIDAK TERCATAT')
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                                TIDAK TERCATAT
                                            </span>
                                        @elseif($item->penerbitan->hasil === 'DISETUJUI')
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                                DISETUJUI
                                            </span>
                                        @elseif($item->penerbitan->hasil === 'DITOLAK')
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">
                                                DITOLAK
                                            </span>
                                        @else
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                                {{ $item->penerbitan->hasil }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>

                                {{-- KOLOM TANGGAL SELESAI --}}
                                <td class="px-6 py-4 text-center text-gray-500">
                                    {{ $item->updated_at->format('d/m/Y') }}
                                </td>

                                {{-- KOLOM AKSI --}}
                                <td class="px-6 py-4 text-center">
                                    <a href="/detail-balasan-kakot/{{ $item->id }}" 
                                       class="bg-lime-500 hover:bg-lime-600 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition inline-block">
                                        DETAIL
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="p-10 text-center text-gray-400 italic">
                                    Belum ada riwayat balasan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-layout-balasan-kakot>