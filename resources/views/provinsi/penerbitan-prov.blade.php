<x-layout-penerbitan-prov
:permohonanPerlu="$permohonanPerlu" 
:permohonanSelesai="$permohonanSelesai">
    <x-slot:title>Penerbitan Provinsi</x-slot:title>

    <div class="max-w-7xl mx-auto space-y-10">

        <div class="bg-white rounded-2xl p-8 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800">Perlu Dibalas</h3>
            <p class="text-sm text-gray-500 mb-6">Data valid siap cetak dan distribusi</p>

            <x-search-input 
                id="searchPerlu" 
                targetTable="tablePerlu" 
                placeholder="Cari nama, asal, atau nomor surat..." 
            />
            <div class="border rounded-xl overflow-hidden">
                <div class="max-h-[600px] overflow-y-auto">
                    <table class="w-full text-left border-collapse" id ="tablePerlu">
                        <thead class="bg-lime-300 text-black text-sm uppercase sticky top-0">
                            <tr>
                            <th class="px-6 py-3 font-semibold">No</th>
                            <th class="px-6 py-3 font-semibold">Dukcapil Asal</th>
                            <th class="px-6 py-3 font-semibold">Dukcapil Tujuan</th>
                            <th class="px-6 py-3 font-semibold text-center">Jenis Permohonan</th>
                            <th class="px-6 py-3 font-semibold text-center">Tanggal</th>
                            <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($permohonanPerlu as $item)
                        <tr class="hover:bg-gray-50 transition text-sm text-black">
                            <td class="px-6 py-4 font-medium">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 ">{{ $item->daerah_asal }}</td>
                            <td class="px-6 py-4">{{ $item->daerah_tujuan }}</td>
                            <td class="px-6 py-4 text-center">{{ $item->jenis_permohonan }}</td>
                            <td class="px-6 py-4 text-center text-gray-500">
                                {{ $item->tanggal_surat->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="/unggah-penerbitan-prov/proses/{{ $item->id }}" 
                                   class="bg-sky-500 hover:bg-sky-600 text-white px-5 py-2 rounded-lg text-xs font-bold transition inline-flex items-center gap-2 shadow-sm hover:shadow-md">
                                    <i class="fa-solid fa-upload"></i> BALAS
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-400 italic">
                                Tidak ada permohonan yang perlu dibalas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800">Selesai</h3>
            <p class="text-sm text-gray-500 mb-6">Data telah selesai diproses</p>

            <x-search-input 
                id="searchSelesai" 
                targetTable="tableSelesai" 
                placeholder="Cari nama, asal, atau nomor surat..." 
            />
            <div class="border rounded-xl overflow-hidden">
                <div class="max-h-[600px] overflow-y-auto">
                    <table class="w-full text-left border-collapse" id="tableSelesai">
                        <thead class="bg-lime-300 text-black text-sm uppercase sticky top-0">
                            <tr>
                            <th class="px-6 py-3 font-semibold">No</th>
                            <th class="px-6 py-3 font-semibold">Dukcapil Asal</th>
                            <th class="px-6 py-3 font-semibold">Dukcapil Tujuan</th>
                            <th class="px-6 py-3 font-semibold text-center">Jenis Permohonan</th>
                            <th class="px-6 py-3 font-semibold text-center">Hasil</th>
                            <th class="px-6 py-3 font-semibold text-center">Tanggal</th>
                            <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($permohonanSelesai as $item)
                        <tr class="bg-gray-50/50 text-sm ">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 ">{{ $item->daerah_asal }}</td>
                            <td class="px-6 py-4">{{ $item->daerah_tujuan }}</td>
                            <td class="px-6 py-4 text-center">{{ $item->jenis_permohonan }}</td>
                            <td class="px-6 py-4 text-center">
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
                            </td>
                            <td class="px-6 py-4 text-center">{{ $item->penerbitan->updated_at->format('d-m-Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="/detail-penerbitan-prov/{{ $item->id }}" 
                                   class="bg-lime-500 hover:bg-lime-600 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition inline-block">
                                    DETAIL
                                </a>
                                
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-10 text-center text-gray-400 italic">
                                Belum ada riwayat penerbitan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>

    </div>
</x-layout-penerbitan-prov>