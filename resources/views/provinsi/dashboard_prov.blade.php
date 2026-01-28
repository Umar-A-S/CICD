<x-layout_dashboard_prov> 
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- TABLE -->
    <section class="table-wrapper">
        <h3 class="table-title">Antrian Verifikasi Berkas</h3>
        <p class="subtitle">
            Periksa kelengkapan berkas sebelum diteruskan ke Disdukcapil
        </p>

        <div class="table-container">
            <table class="data-table">
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
                    <tr data-status="pending">
                        <td>2025-01-25</td>
                        <td>Kota Semarang</td>
                        <td>Jateng</td>
                        <td>Tembalang</td>
                        <td class="aksi">
                            <span class="btn green">Verifikasi</span>
                            <span class="btn red">Kembalikan</span>
                            <span class="btn blue">Lihat Detail</span>
                        </td>
                    </tr>

                    <tr data-status="pending">
                        <td>2025-01-25</td>
                        <td>Kota Semarang</td>
                        <td>Luar Jateng</td>
                        <td>Bandung</td>
                        <td class="aksi">
                            <span class="btn green">Verifikasi</span>
                            <span class="btn red">Kembalikan</span>
                            <span class="btn blue">Lihat Detail</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- ================= MODAL VERIFIKASI ================= -->
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

    <!-- ================= NOTIF VERIFIKASI ================= -->
    <div id="notifVerifikasi" class="notif hidden">
        <div class="notif-box">
            <div class="checkmark" style="background:#22c55e">
                ✓
            </div>
            <p>Berkas berhasil diverifikasi</p>
        </div>
    </div>

    <!-- ================= MODAL KEMBALIKAN ================= -->
    <div id="modalKembalikan" class="modal hidden">
        <div class="modal-content">
            <h3>Kembalikan Berkas</h3>
            <p>Silakan isi alasan pengembalian berkas</p>

            <textarea
                id="alasanKembalikan"
                placeholder="Contoh: Berkas belum lengkap / Data tidak sesuai..."
            ></textarea>

            <div class="modal-actions">
                <button class="btn cancel" onclick="closeModal()">Batal</button>
                <button class="btn red" onclick="submitKembalikan()">Kembalikan</button>
            </div>
        </div>
    </div>

    <!-- ================= NOTIF KEMBALIKAN ================= -->
    <div id="notifSuccess" class="notif hidden">
        <div class="notif-box">
            <div class="checkmark">
                ✓
            </div>
            <p>Berkas berhasil dikembalikan</p>
        </div>
    </div>

</x-layout_dashboard_prov>