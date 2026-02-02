<x-layout_penerbitan_prov
:permohonanPerlu="$permohonanPerlu" 
:permohonanSelesai="$permohonanSelesai">
    <x-slot:title>Penerbitan Provinsi</x-slot:title>

    <div class="max-w-7xl mx-auto space-y-10">

        <div class="bg-white rounded-2xl p-8 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800">Perlu Dibalas</h3>
            <p class="text-sm text-gray-500 mb-6">Data valid siap cetak dan distribusi</p>

            <x-search_input 
                id="searchPerlu" 
                targetTable="tablePerlu" 
                placeholder="Cari nama, asal, atau nomor surat..." 
            />
            <div class="border rounded-xl overflow-hidden">
                <table class="w-full text-left border-collapse" id ="tablePerlu">
                    <thead class="bg-lime-300 text-black text-sm uppercase">
                        <tr>
                            <th class="px-6 py-3 font-semibold">No</th>
                            <th class="px-6 py-3 font-semibold">Dukcapil Asal</th>
                            <th class="px-6 py-3 font-semibold">Nomor Surat</th>
                            <th class="px-6 py-3 font-semibold text-center">Jenis</th>
                            <th class="px-6 py-3 font-semibold text-center">Tanggal</th>
                            <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($permohonanPerlu as $item)
                        <tr class="hover:bg-gray-50 transition text-sm text-black">
                            <td class="px-6 py-4 font-medium">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 ">{{ $item->daerah_asal }}</td>
                            <td class="px-6 py-4">{{ $item->nomor_surat }}</td>
                            <td class="px-6 py-4 text-center">{{ $item->jenis_permohonan }}</td>
                            <td class="px-6 py-4 text-center text-gray-500">
                                {{ $item->tanggal_surat->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="/detail_permohonan_prov/{{ $item->id }}" 
                                   class="bg-lime-500 hover:bg-lime-600 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition inline-block">
                                    DETAIL
                                </a>
                                <a href="/unggah_penerbitan_prov/proses/{{ $item->id }}" 
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

        <div class="bg-white rounded-2xl p-8 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800">Selesai</h3>
            <p class="text-sm text-gray-500 mb-6">Data telah selesai diproses</p>

            <x-search_input 
                id="searchSelesai" 
                targetTable="tableSelesai" 
                placeholder="Cari nama, asal, atau nomor surat..." 
            />
            <div class="border rounded-xl overflow-hidden">
                <table class="w-full text-left border-collapse" id="tableSelesai">
                    <thead class="bg-lime-300 text-black text-sm uppercase">
                        <tr>
                            <th class="px-6 py-3 font-semibold">No</th>
                            <th class="px-6 py-3 font-semibold">Dukcapil Asal</th>
                            <th class="px-6 py-3 font-semibold">Nomor Surat</th>
                            <th class="px-6 py-3 font-semibold text-center">Jenis</th>
                            <th class="px-6 py-3 font-semibold text-center">Hasil</th>
                            <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($permohonanSelesai as $item)
                        <tr class="bg-gray-50/50 text-sm ">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 ">{{ $item->daerah_asal }}</td>
                            <td class="px-6 py-4">{{ $item->nomor_surat }}</td>
                            <td class="px-6 py-4 text-center">{{ $item->jenis_permohonan }}</td>
                            <td class="px-6 py-4 text-center">{{ $item->penerbitan->hasil }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="/detail_penerbitan_prov/{{ $item->id }}" 
                                   class="bg-lime-500 hover:bg-lime-600 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition inline-block">
                                    DETAIL
                                </a>
                                
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-400 italic">
                                Belum ada riwayat penerbitan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-layout_penerbitan_prov>