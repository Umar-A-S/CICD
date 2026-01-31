<x-layout_dashboard_prov :stat="$stat">
    <x-slot:title>{{ $title }}</x-slot:title>

    <section class="table-wrapper">
        <h3 class="table-title">Antrian Verifikasi Berkas</h3>
        <p class="subtitle">
            Periksa kelengkapan berkas sebelum diteruskan ke Disdukcapil
        </p>

        @if(session('success'))
            <div style="background: #dcfce7; color: #166534; padding: 12px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #bbf7d0; font-size: 14px;">
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
                    {{-- Tambahkan data-id untuk dikenali JS --}}
                    <tr data-id="{{ $item->id }}" data-status="pending">
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
                            {{-- Tombol Span sesuai model mentah --}}
                            <span class="btn green">Verifikasi</span>
                            <span class="btn red">Kembalikan</span>
                            <span class="btn blue">Lihat Detail</span>

                            {{-- Hidden Forms untuk Logika Backend --}}
                            <form id="form-verifikasi-{{ $item->id }}" action="{{ route('provinsi.verifikasi', $item->id) }}" method="POST" class="hidden">
                                @csrf
                            </form>

                            <form id="form-tolak-{{ $item->id }}" action="{{ route('provinsi.tolak', $item->id) }}" method="POST" class="hidden">
                                @csrf
                                <input type="hidden" name="alasan_tolak" id="input-alasan-{{ $item->id }}">
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 40px; color: #888; font-style: italic;">
                            Tidak ada antrian berkas saat ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div id="modalVerifikasi" class="modal hidden">
        <div class="modal-content">
            <h3>Verifikasi Berkas</h3>
            <p>Pastikan seluruh berkas telah lengkap dan sesuai</p>
            <div class="modal-actions">
                <button class="btn cancel" onclick="closeModalVerifikasi()">Batal</button>
                <button class="btn green" onclick="submitVerifikasi()">Verifikasi</button>
            </div>
        </div>
    </div>

    <div id="notifVerifikasi" class="notif hidden">
        <div class="notif-box">
            <div class="checkmark" style="background:#22c55e">✓</div>
            <p>Berkas berhasil diverifikasi</p>
        </div>
    </div>

    <div id="modalKembalikan" class="modal hidden">
        <div class="modal-content">
            <h3>Kembalikan Berkas</h3>
            <p>Silakan isi alasan pengembalian berkas</p>
            <textarea id="alasanKembalikan" placeholder="Contoh: Berkas belum lengkap..."></textarea>
            <div class="modal-actions">
                <button class="btn cancel" onclick="closeModal()">Batal</button>
                <button class="btn red" onclick="submitKembalikan()">Kembalikan</button>
            </div>
        </div>
    </div>

    <div id="notifSuccess" class="notif hidden">
        <div class="notif-box">
            <div class="checkmark">✓</div>
            <p>Berkas berhasil dikembalikan</p>
        </div>
    </div>

    <script>
        window.detailBaseUrl = "{{ url('/detail_permohonan_prov') }}";
    </script>
</x-layout_dashboard_prov>