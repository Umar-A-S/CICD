<x-layout-superadmin>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- HEADER WITH STATS -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="text-2xl font-bold text-gray-800">Monitor Permohonan</h3>
                <p class="text-sm text-gray-500 mt-1">Pantau semua permohonan dari seluruh daerah (Read-Only)</p>
            </div>
        </div>

        <!-- QUICK STATS -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-gray-500">
                <p class="text-xs text-gray-500 font-semibold uppercase">Total</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-yellow-500">
                <p class="text-xs text-gray-500 font-semibold uppercase">Menunggu</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $stats['menunggu'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-blue-500">
                <p class="text-xs text-gray-500 font-semibold uppercase">Diproses</p>
                <p class="text-2xl font-bold text-blue-600">{{ $stats['diproses'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-green-500">
                <p class="text-xs text-gray-500 font-semibold uppercase">Selesai</p>
                <p class="text-2xl font-bold text-green-600">{{ $stats['selesai'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-red-500">
                <p class="text-xs text-gray-500 font-semibold uppercase">Ditolak</p>
                <p class="text-2xl font-bold text-red-600">{{ $stats['ditolak'] }}</p>
            </div>
        </div>
    </div>

    <!-- FILTER PANEL -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
        <form method="GET" action="{{ route('superadmin.permohonan.index') }}" class="space-y-4">
            
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-filter text-lime-500"></i>
                    Filter & Pencarian
                </h4>
                @if(request()->hasAny(['status', 'wilayah', 'daerah_asal', 'dari_tanggal', 'sampai_tanggal', 'search']))
                    <a href="{{ route('superadmin.permohonan.index') }}" class="text-sm text-red-600 hover:text-red-700 font-semibold">
                        <i class="fa-solid fa-times-circle"></i> Reset Filter
                    </a>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pencarian</label>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" 
                        placeholder="No. Permohonan / Nama Pemohon"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-transparent">
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-transparent">
                        <option value="">-- Semua Status --</option>
                        <option value="BELUM" {{ ($filters['status'] ?? '') === 'BELUM' ? 'selected' : '' }}>Belum Diproses</option>
                        <option value="DIPROSES" {{ ($filters['status'] ?? '') === 'DIPROSES' ? 'selected' : '' }}>Diproses</option>
                        <option value="SELESAI" {{ ($filters['status'] ?? '') === 'SELESAI' ? 'selected' : '' }}>Selesai</option>
                        <option value="DITOLAK" {{ ($filters['status'] ?? '') === 'DITOLAK' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <!-- Wilayah Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Wilayah</label>
                    <select name="wilayah" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-transparent">
                        <option value="">-- Semua Wilayah --</option>
                        <option value="dalam" {{ ($filters['wilayah'] ?? '') === 'dalam' ? 'selected' : '' }}>Dalam Wilayah</option>
                        <option value="luar" {{ ($filters['wilayah'] ?? '') === 'luar' ? 'selected' : '' }}>Luar Wilayah</option>
                    </select>
                </div>

                <!-- Daerah Asal -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Daerah Asal</label>
                    <input type="text" name="daerah_asal" value="{{ $filters['daerah_asal'] ?? '' }}" 
                        placeholder="Nama daerah asal"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-transparent">
                </div>

                <!-- Dari Tanggal -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Dari Tanggal</label>
                    <input type="date" name="dari_tanggal" value="{{ $filters['dari_tanggal'] ?? '' }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-transparent">
                </div>

                <!-- Sampai Tanggal -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sampai Tanggal</label>
                    <input type="date" name="sampai_tanggal" value="{{ $filters['sampai_tanggal'] ?? '' }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-transparent">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-lime-400 hover:bg-lime-500 text-black px-6 py-2.5 rounded-lg font-bold transition flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-lime-300 text-black text-sm uppercase font-bold">
                    <tr>
                        <th class="px-6 py-4">No. Permohonan</th>
                        <th class="px-6 py-4">Dukcapil Asal</th>
                        <th class="px-6 py-4">Dukcapil Tujuan</th>
                        <th class="px-6 py-4">Nama Subjek</th>
                        <th class="px-6 py-4">Jenis</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($permohonan as $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <code class="text-xs bg-gray-100 px-2 py-1 rounded font-mono">{{ $item->nomor_surat }}</code>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-800">{{ $item->daerah_asal }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-800">{{ $item->daerah_tujuan }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $item->nama_subjek }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                    {{ $item->wilayah === 'dalam' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                    {{ ucfirst($item->wilayah) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                    @if ($item->status === 'BELUM') bg-yellow-100 text-yellow-800
                                    @elseif ($item->status === 'DIPROSES') bg-blue-100 text-blue-800
                                    @elseif ($item->status === 'SELESAI') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $item->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-3 text-lg">
                                    <a href="{{ route('superadmin.permohonan.show', $item->id) }}" 
                                        class="text-blue-600 hover:text-blue-800 transition" 
                                        title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                <i class="fa-solid fa-inbox text-5xl mb-4 block"></i>
                                <p class="text-lg font-semibold">Tidak ada permohonan</p>
                                <p class="text-sm">Coba ubah filter pencarian Anda</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        @if ($permohonan->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $permohonan->links() }}
            </div>
        @endif
    </div>

</x-layout-superadmin>
