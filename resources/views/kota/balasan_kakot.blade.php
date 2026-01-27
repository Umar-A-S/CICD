<x-layout_balasan_kakot>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Riwayat Balasan Dokumen</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse overflow-hidden rounded-xl">
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
                    @php $no = 1; @endphp @forelse($permohonans as $item)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="py-4 px-4 text-sm font-medium">{{ $no++ }}</td>
                        <td class="py-4 px-4">
                            <p class="text-sm font-bold text-gray-800">{{ $item->nama_subjek }}</p>
                            <p class="text-[10px] text-gray-500">{{ $item->jenis_permohonan }}</p>
                        </td>
                        <td class="py-4 px-4 text-sm text-gray-700">{{ $item->daerah_tujuan }}</td>
                        <td class="py-4 px-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase
                                {{ $item->penerbitan->hasil == 'TERCATAT' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $item->penerbitan->hasil }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-sm text-gray-500">
                            {{ $item->penerbitan->tanggal_surat_selesai->format('d/m/Y') }}
                        </td>
                        <td class="py-4 px-4 text-sm">
                            <a href="/detail_balasan_kakot/{{ $item->id }}" 
                            class="text-sky-500 hover:underline font-bold">
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