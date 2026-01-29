<x-layout_unggah_penerbitan_kakot>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- PAGE BACKGROUND -->
    <div class="bg-gray-100 min-h-screen py-10 px-6">

        <!-- CARD -->
        <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-md px-12 py-12">

            <form method="POST" action="#" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-20">

                    <!-- ================= KIRI ================= -->
                    <div class="space-y-14">

                        <!-- IDENTITAS -->
                        <section>
                            <h2 class="text-lg font-extrabold tracking-wide mb-8 text-gray-800">
                                IDENTITAS
                            </h2>

                            <div class="space-y-5">
                                <div>
                                    <label class="text-xs font-bold uppercase text-gray-600">
                                        Nama Subjek
                                    </label>
                                    <input type="text" value="Asep" disabled
                                        class="w-full mt-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase text-gray-600">
                                        Daerah Asal
                                    </label>
                                    <input type="text" value="Kota Semarang" disabled
                                        class="w-full mt-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase text-gray-600">
                                        Wilayah Tujuan
                                    </label>
                                    <input type="text" value="Luar Daerah" disabled
                                        class="w-full mt-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase text-gray-600">
                                        Daerah Tujuan
                                    </label>
                                    <div class="space-y-2 mt-1">
                                        <input type="text" value="Jawa Barat" disabled
                                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                        <input type="text" value="Kota Bandung" disabled
                                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase text-gray-600">
                                        Jenis Permohonan
                                    </label>
                                    <input type="text" value="Keabsahan" disabled
                                        class="w-full mt-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase text-gray-600">
                                        Jenis Dokumen
                                    </label>
                                    <input type="text" value="Akta Kelahiran" disabled
                                        class="w-full mt-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                </div>
                            </div>
                        </section>

                        <!-- PENERBITAN -->
                        <section>
                            <h2 class="text-lg font-extrabold tracking-wide mb-8 text-gray-800">
                                PENERBITAN
                            </h2>

                            <div class="space-y-5">
                                <div>
                                    <label class="text-xs font-bold uppercase text-gray-600">
                                        Tanggal Selesai
                                    </label>
                                    <input type="text" value="20/01/2026" disabled
                                        class="w-full mt-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase text-gray-600">
                                        Nomor Surat Selesai 
                                    </label>
                                    <input type="text" value="08.006/ITS/111/2023" disabled
                                        class="w-full mt-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                </div>

                                <!-- BERKAS (FIXED) -->
                                <div>
                                    <label class="text-xs font-bold uppercase text-gray-600">
                                        Berkas
                                    </label>

                                    <div>
                                        <div
                                            class="inline-flex items-center gap-2 text-blue-600 font-semibold text-sm">
                                            <i class="fa-solid fa-file-lines"></i>
                                            Surat_Penerbitan.pdf
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </section>
                    </div>

                    <!-- ================= KANAN ================= -->
                    <div>
                        <h2 class="text-lg font-extrabold tracking-wide mb-8 text-gray-800">
                            HASIL PEMERIKSAAN
                        </h2>

                        <div class="space-y-5">

                            <div>
                                <label class="text-xs font-bold uppercase text-gray-600">
                                    Hasil <span class="text-red-500">*</span>
                                </label>
                                <select name="hasil" required
                                    class="w-full mt-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                    <option disabled selected>Pilih Hasil Pemeriksaan</option>
                                    <option>TERCATAT</option>
                                    <option>TIDAK TERCATAT</option>
                                    <option>DISETUJUI</option>
                                    <option>DITOLAK</option>
                                    <option>LAINNYA</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-xs font-bold uppercase text-gray-600">
                                    Keterangan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="keterangan" required
                                    placeholder="Masukkan Keterangan"
                                    class="w-full mt-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                            </div>

                            <!-- UPLOAD -->
                            <div>
                                <label class="text-xs font-bold uppercase text-gray-600">
                                    Unggah Berkas <span class="text-red-500">*</span>
                                </label>

                                <p class="text-xs text-gray-500 mb-3">
                                    Unggah berkas format PDF / JPG / PNG (max 2MB)
                                </p>

                                <label
                                    class="cursor-pointer flex flex-col items-center justify-center
                                    border-2 border-dashed border-lime-400 rounded-2xl h-40
                                    hover:bg-lime-50 transition">

                                    <i class="fa-solid fa-cloud-arrow-up text-lime-500 text-4xl mb-2"></i>

                                    <span class="text-sm font-semibold text-gray-700">
                                        Klik untuk upload berkas
                                    </span>

                                    <input type="file" name="file" required
                                        accept=".pdf,.jpg,.jpeg,.png" class="hidden">
                                </label>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="flex justify-between items-center mt-16">
                    <a href="{{ url()->previous() }}"
                        class="bg-lime-400 hover:bg-lime-500 text-black font-bold px-8 py-3 rounded-xl shadow-sm">
                        KEMBALI
                    </a>

                    <button type="submit"
                        class="bg-sky-500 hover:bg-sky-600 text-white font-bold px-10 py-3 rounded-xl shadow-sm">
                        KIRIM
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-layout_unggah_penerbitan_kakot>