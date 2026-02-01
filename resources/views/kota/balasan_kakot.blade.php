<x-layout_balasan_kakot>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Riwayat Balasan Dokumen</h2>
        </div>

        <div class="overflow-x-auto">
            <x-search_input 
                id="searchBalasan" 
                targetTable="tableBalasan" 
                placeholder="Cari nama, asal, atau nomor surat...">
            </x-search_input>
            <table class="w-full text-left border-collapse overflow-hidden rounded-xl" id="tableBalasan">
                <thead>
                    <tr class="bg-lime-400 text-black">
                        <th class="py-4 px-4 text-xs font-bold ">No</th>
                        <th class="py-4 px-4 text-xs font-bold uppercase">Subjek</th>
                        <th class="py-4 px-4 text-xs font-bold uppercase">Daerah Tujuan</th>
                        <th class="py-4 px-4 text-xs font-bold uppercase">Hasil Balasan</th>
                        <th class="py-4 px-4 text-xs font-bold uppercase">Tanggal Selesai</th>
                        <th class="py-4 px-4 text-xs font-bold uppercase rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp 
                    @forelse($permohonans as $item)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="py-4 px-4 text-sm font-medium">{{ $no++ }}</td>
                        <td class="py-4 px-4">
                            <p class="text-sm font-bold text-gray-800">{{ $item->nama_subjek }}</p>
                            <p class="text-[10px] text-gray-500">{{ $item->jenis_permohonan }}</p>
                        </td>
                        <td class="py-4 px-4 text-sm text-gray-700">{{ $item->daerah_tujuan }}</td>
                        
                        {{-- KOLOM HASIL BALASAN --}}
                        <td class="py-4 px-4">
                            @if($item->penerbitan->exists)
                                {{-- Jika Selesai di level Kota --}}
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase
                                    {{ in_array($item->penerbitan->hasil, ['TERCATAT', 'DISETUJUI']) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $item->penerbitan->hasil }}
                                </span>
                            @else
                                {{-- Jika Ditolak (baik oleh Prov atau Kota) --}}
                                <div class="flex flex-col gap-1">
                                    <span class="w-max px-3 py-1 rounded-full text-[10px] font-black uppercase bg-red-100 text-red-700">
                                        {{ $item->status }}
                                    </span>
                                </div>
                            @endif
                        </td>

                        {{-- KOLOM TANGGAL SELESAI --}}
                        <td class="py-4 px-4 text-sm text-gray-500">
                            {{-- Kita pakai optional chaining atau fallback ke updated_at permohonan --}}
                            {{ \Carbon\Carbon::parse($item->penerbitan->tanggal_surat_selesai ?? $item->updated_at)->format('d/m/Y') }}
                        </td>

                        {{-- KOLOM AKSI --}}
                        <td class="py-4 px-4 text-sm">
                            <a href="/detail_balasan_kakot/{{ $item->id }}" class="text-sky-500 hover:underline font-bold">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-gray-400 italic">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout_balasan_kakot>