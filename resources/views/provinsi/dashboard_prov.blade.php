<x-layout_dashboard_prov :stat="$stat">
    <x-slot:title>{{ $title }}</x-slot:title>

    <section class="table-wrapper">
        <h3 class="table-title">Antrian Verifikasi Berkas</h3>
        <p class="subtitle">
            Periksa kelengkapan berkas sebelum diteruskan ke Disdukcapil
        </p>

        @if(session('success'))
            <div style="background: #dcfce7; color: #166534; padding: 10px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #bbf7d0;">
                ✓ {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table class="data-table" style="width: 100%; text-align: center;">
                <thead>
                    <tr>
                        <th>Tanggal Masuk</th>
                        <th>Dukcapil Asal</th>
                        <th>Wilayah</th>
                        <th>Daerah Tujuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($permohonanMasuk as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                        <td>{{ $item->daerah_asal }}</td>
                        
                        <td>
                            @if($item->wilayah == 'dalam')
                                Jateng
                            @else
                                Luar Jateng
                            @endif
                        </td>
                        
                        <td>{{ $item->daerah_tujuan }}</td>
                        
                        <td class="aksi" style="display:flex;justify-content:center;gap:6px;">
                            
                            <form action="{{ route('provinsi.verifikasi', $item->id) }}" method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin dokumen ini valid?')">
                                @csrf
                                <button type="submit" class="btn green" style="border:none; cursor:pointer; font-family:inherit; font-size:inherit;">
                                    Verifikasi
                                </button>
                            </form>

                            <button type="button" class="btn red" style="border:none; cursor:pointer; font-family:inherit; font-size:inherit;"
                                    onclick="bukaModalTolak('{{ route('provinsi.tolak', $item->id) }}')">
                                Kembalikan
                            </button>

                            <a href="{{ route('penerbitanprov.show', $item->id) }}" class="btn blue" style="text-decoration: none;">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 20px; color: #888; font-style: italic;">
                            Tidak ada antrian berkas saat ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div id="modalKembalikan" class="modal hidden">
        <div class="modal-content">
            <h3>Kembalikan Berkas</h3>
            <p>Silakan isi alasan pengembalian berkas</p>

            <form id="formTolak" method="POST" action="">
                @csrf
                <textarea
                    name="alasan_tolak"
                    id="alasanKembalikan"
                    placeholder="Contoh: Berkas belum lengkap / Data tidak sesuai..."
                    required
                    style="width: 100%; min-height: 100px; margin: 10px 0; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"
                ></textarea>

                <div class="modal-actions">
                    <button type="button" class="btn cancel" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn red">Kembalikan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Fungsi untuk membuka modal & set tujuan form (Action URL)
        function bukaModalTolak(urlAction) {
            // 1. Ambil Form
            const form = document.getElementById('formTolak');
            // 2. Set Action-nya sesuai tombol yg diklik (misal: /provinsi/tolak/5)
            form.action = urlAction;
            // 3. Reset isi textarea
            document.getElementById('alasanKembalikan').value = '';
            // 4. Munculkan Modal
            document.getElementById('modalKembalikan').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modalKembalikan').classList.add('hidden');
        }

        // Tutup modal kalau klik di luar area putih (Opsional/Bonus UX)
        window.onclick = function(event) {
            const modal = document.getElementById('modalKembalikan');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>

</x-layout_dashboard_prov>