<x-layout_verifikasi
:permohonanBelum="$permohonanBelum" 
:permohonanDiproses="$permohonanDiproses">
    <x-slot:title>Verifikasi Permohonan</x-slot:title>

    <div class="max-w-7xl mx-auto space-y-10">

        <!-- STATS CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <div class="glass-panel p-5 rounded-xl flex items-center gap-4 hover:bg-white/5 transition" style="background-color: #ffffff; box-shadow: 0px 4px 20px 0px rgba(0,0,0,0.20);">
                <div class="w-12 h-12 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-file-invoice"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-black">
                        {{ $permohonanBelum->count() + $permohonanDiproses->count() }}
                    </div>
                    <div class="text-xs text-black uppercase">Total</div>
                </div>
            </div>

            <div class="glass-panel p-5 rounded-xl flex items-center gap-4 hover:bg-white/5 transition" style="background-color: #ffffff; box-shadow: 0px 4px 20px 0px rgba(0,0,0,0.20);">
                <div class="w-12 h-12 rounded-full bg-yellow-500/20 text-yellow-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-exclamation-circle"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-black">
                        {{ $permohonanBelum->count() }}
                    </div>
                    <div class="text-xs text-black uppercase">Perlu Diverifikasi</div>
                </div>
            </div>

            <div class="glass-panel p-5 rounded-xl flex items-center gap-4 hover:bg-white/5 transition" style="background-color: #ffffff; box-shadow: 0px 4px 20px 0px rgba(0,0,0,0.20);">
                <div class="w-12 h-12 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-black">
                        {{ $permohonanDiproses->count() }}
                    </div>
                    <div class="text-xs text-black uppercase">Selesai</div>
                </div>
            </div>

        </div>

        <!-- SESSION MESSAGES -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-green-700 text-sm">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-red-700 text-sm">
                ✗ {{ session('error') }}
            </div>
        @endif

        <!-- TABEL 1: PERLU DIVERIFIKASI -->
        <div class="bg-white rounded-2xl p-8 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800">Antrian Verifikasi</h3>
            <p class="text-sm text-gray-500 mb-6">Permohonan yang menunggu untuk diverifikasi</p>

            <x-search_input 
                id="searchBelum" 
                targetTable="tableBelum" 
                placeholder="Cari nama, asal, atau nomor surat..." 
            />
            <div class="border rounded-xl overflow-hidden">
                <table class="w-full text-left border-collapse" id="tableBelum">
                    <thead class="bg-lime-300 text-black text-sm uppercase">
                        <tr>
                            <th class="px-6 py-3 font-semibold">No</th>
                            <th class="px-6 py-3 font-semibold">Daerah Asal</th>
                            <th class="px-6 py-3 font-semibold">Daerah Tujuan</th>
                            <th class="px-6 py-3 font-semibold text-center">Wilayah</th>
                            <th class="px-6 py-3 font-semibold text-center">Tanggal</th>
                            <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($permohonanBelum as $item)
                        <tr class="hover:bg-gray-50 transition text-sm text-black" data-id="{{ $item->id }}">
                            <td class="px-6 py-4 font-medium">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $item->daerah_asal }}</td>
                            <td class="px-6 py-4">{{ $item->daerah_tujuan }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $item->wilayah === 'dalam' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                    {{ $item->wilayah === 'dalam' ? 'Jateng' : 'Luar' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-500">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <button onclick="showModalVerifikasi({{ $item->id }})" 
                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition inline-block">
                                    <i class="fa-solid fa-check mr-1"></i>VERIFIKASI
                                </button>
                                <button onclick="showModalTolak({{ $item->id }})" 
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition inline-block">
                                    <i class="fa-solid fa-times mr-1"></i>TOLAK
                                </button>
                                <a href="{{ route('provinsi.detail', $item->id) }}" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition inline-block">
                                    DETAIL
                                </a>
                            </td>
                        </tr>

                        <!-- Hidden Forms -->
                        <form id="form-verifikasi-{{ $item->id }}" 
                            action="{{ route('provinsi.verifikasi.submit', $item->id) }}" 
                            method="POST" class="hidden">
                            @csrf
                        </form>

                        <form id="form-tolak-{{ $item->id }}" 
                            action="{{ route('provinsi.tolak', $item->id) }}" 
                            method="POST" class="hidden">
                            @csrf
                            <input type="hidden" name="alasan_tolak" id="input-alasan-{{ $item->id }}">
                        </form>

                        @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-400 italic">
                                Tidak ada permohonan yang perlu diverifikasi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TABEL 2: SUDAH TERVERIFIKASI -->
        <div class="bg-white rounded-2xl p-8 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800">Riwayat Verifikasi</h3>
            <p class="text-sm text-gray-500 mb-6">Permohonan yang sudah diverifikasi</p>

            <x-search_input 
                id="searchDiproses" 
                targetTable="tableDiproses" 
                placeholder="Cari nama, asal, atau nomor surat..." 
            />
            <div class="border rounded-xl overflow-hidden">
                <table class="w-full text-left border-collapse" id="tableDiproses">
                    <thead class="bg-lime-300 text-black text-sm uppercase">
                        <tr>
                            <th class="px-6 py-3 font-semibold">No</th>
                            <th class="px-6 py-3 font-semibold">Daerah Asal</th>
                            <th class="px-6 py-3 font-semibold">Daerah Tujuan</th>
                            <th class="px-6 py-3 font-semibold text-center">Wilayah</th>
                            <th class="px-6 py-3 font-semibold text-center">Tanggal</th>
                            <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($permohonanDiproses as $item)
                        <tr class="bg-gray-50/50 text-sm">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $item->daerah_asal }}</td>
                            <td class="px-6 py-4">{{ $item->daerah_tujuan }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $item->wilayah === 'dalam' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                    {{ $item->wilayah === 'dalam' ? 'Jateng' : 'Luar' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('provinsi.detail', $item->id) }}" 
                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition inline-block">
                                    DETAIL
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-400 italic">
                                Belum ada riwayat verifikasi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- MODAL VERIFIKASI -->
    <div id="modalVerifikasi" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg p-6 max-w-sm w-full mx-4">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Verifikasi Permohonan</h3>
            <p class="text-gray-600 mb-6">Pastikan seluruh berkas telah lengkap dan sesuai sebelum meneruskan ke daerah tujuan.</p>
            <div class="flex gap-3">
                <button type="button" onclick="closeModalVerifikasi()"
                    class="flex-1 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg transition">
                    Batal
                </button>
                <button type="button" onclick="submitVerifikasi()"
                    class="flex-1 px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition">
                    Verifikasi
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL TOLAK -->
    <div id="modalTolak" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg p-6 max-w-sm w-full mx-4">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Tolak Permohonan</h3>
            <p class="text-gray-600 mb-4">Silakan isi alasan penolakan:</p>
            <textarea id="alasanTolak" placeholder="Contoh: Berkas tidak lengkap, ada kesalahan data..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 mb-6"
                rows="4"></textarea>
            <div class="flex gap-3">
                <button type="button" onclick="closeModalTolak()"
                    class="flex-1 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg transition">
                    Batal
                </button>
                <button type="button" onclick="submitTolak()"
                    class="flex-1 px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition">
                    Tolak
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentPermohonanId = null;

        // MODAL VERIFIKASI
        function showModalVerifikasi(id) {
            currentPermohonanId = id;
            document.getElementById('modalVerifikasi').classList.remove('hidden');
        }

        function closeModalVerifikasi() {
            document.getElementById('modalVerifikasi').classList.add('hidden');
            currentPermohonanId = null;
        }

        function submitVerifikasi() {
            if (currentPermohonanId) {
                document.getElementById('form-verifikasi-' + currentPermohonanId).submit();
            }
        }

        // MODAL TOLAK
        function showModalTolak(id) {
            currentPermohonanId = id;
            document.getElementById('alasanTolak').value = '';
            document.getElementById('modalTolak').classList.remove('hidden');
        }

        function closeModalTolak() {
            document.getElementById('modalTolak').classList.add('hidden');
            currentPermohonanId = null;
        }

        function submitTolak() {
            const alasan = document.getElementById('alasanTolak').value.trim();

            if (!alasan) {
                alert('Alasan penolakan tidak boleh kosong!');
                return;
            }

            if (alasan.length < 5) {
                alert('Alasan minimal 5 karakter!');
                return;
            }

            document.getElementById('input-alasan-' + currentPermohonanId).value = alasan;
            document.getElementById('form-tolak-' + currentPermohonanId).submit();
        }

        // Close modal jika klik di luar
        document.getElementById('modalVerifikasi')?.addEventListener('click', function(e) {
            if (e.target === this) closeModalVerifikasi();
        });

        document.getElementById('modalTolak')?.addEventListener('click', function(e) {
            if (e.target === this) closeModalTolak();
        });
    </script>
</x-layout_verifikasi>
