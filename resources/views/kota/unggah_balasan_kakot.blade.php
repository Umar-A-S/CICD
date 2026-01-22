<x-layout_unggah_balasan_kakot>
<x-slot:title>{{ $title }}</x-slot:title>

<!-- PAGE BACKGROUND -->
<div class="bg-gray-100 min-h-screen py-10">

    <!-- PAGE WRAPPER -->
    <div class="max-w-6xl mx-auto px-6">

        <!-- CARD -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 px-10 py-10">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-16">

                <!-- ================= KIRI ================= -->
                <div>
                    <h2 class="text-sm font-extrabold tracking-wide text-gray-700 mb-6">
                        IDENTITAS
                    </h2>

                    <div class="space-y-5">

                        <!-- Nama Subjek -->
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-600 mb-1">
                                Nama Subjek
                            </label>
                            <input type="text" placeholder="Masukkan Nama Lengkap"
                                class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2
                                outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400">
                        </div>

                        <!-- Daerah Asal -->
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-600 mb-1">
                                Daerah Asal
                            </label>
                            <input type="text" placeholder="Masukkan Daerah Asal"
                                class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2
                                outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400">
                        </div>

                        <!-- Daerah Tujuan -->
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-600 mb-2">
                                Daerah Tujuan
                            </label>

                            <!-- Provinsi -->
                            <label class="block text-[10px] font-semibold text-gray-500 uppercase mb-1">
                                Provinsi
                            </label>
                            <select id="provinsi"
                                class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2
                                outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400">
                                <option value="" disabled selected>Pilih Provinsi</option>
                            </select>

                            <!-- Kab / Kota -->
                            <label class="block text-[10px] font-semibold text-gray-500 uppercase mt-3 mb-1">
                                Kabupaten / Kota
                            </label>
                            <select id="kabkota"
                                class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2
                                outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400">
                                <option value="" disabled selected>Pilih Kabupaten/Kota</option>
                            </select>
                        </div>

                        <!-- Jenis Permohonan -->
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-600 mb-1">
                                Jenis Permohonan
                            </label>
                            <select
                                class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2
                                outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400">
                                <option value="" disabled selected>Pilih Jenis Permohonan</option>
                                <option>KEABSAHAN</option>
                                <option>LEGALISIR</option>
                                <option>MUTASI</option>
                            </select>
                        </div>

                        <!-- Jenis Dokumen -->
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-600 mb-1">
                                Jenis Dokumen
                            </label>
                            <select
                                class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2
                                outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400">
                                <option value="" disabled selected>Pilih Jenis Dokumen</option>
                                <option>Akta Kelahiran</option>
                                <option>Kartu Keluarga</option>
                                <option>KTP</option>
                            </select>
                        </div>

                    </div>
                </div>

                <!-- ================= KANAN ================= -->
                <div>
                    <h2 class="text-sm font-extrabold tracking-wide text-gray-700 mb-6">
                        HASIL
                    </h2>

                    <div class="space-y-5">

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-600 mb-1">
                                Tanggal Selesai
                            </label>
                            <input type="date"
                                class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2
                                outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-600 mb-1">
                                Keterangan
                            </label>
                            <input type="text" placeholder="Masukkan keterangan"
                                class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2
                                outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-600 mb-1">
                                Hasil Pemeriksaan
                            </label>
                            <select
                                class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2
                                outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400">
                                <option value="" disabled selected>Pilih Hasil Pemeriksaan</option>
                                <option>TERCATAT</option>
                                <option>TIDAK TERCATAT</option>
                            </select>
                        </div>

                        <!-- Upload -->
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-600 mb-1">
                                Unggah Berkas <span class="text-red-500">*</span>
                            </label>

                            <p class="text-xs text-gray-500 mb-3">
                                Format PDF / JPG / PNG, maksimal 2MB
                            </p>

                            <label for="fileUpload"
                                class="cursor-pointer flex flex-col items-center justify-center
                                border-2 border-dashed border-lime-400
                                rounded-xl h-40 text-center
                                hover:bg-lime-50 transition">

                                <i class="fa-solid fa-cloud-arrow-up text-lime-500 text-4xl mb-2"></i>
                                <span class="text-sm font-semibold text-gray-700">
                                    Klik untuk upload berkas
                                </span>

                                <input id="fileUpload" type="file" class="hidden"
                                    accept=".pdf,.jpg,.jpeg,.png" multiple>
                            </label>

                            <div id="filePreview" class="mt-4 space-y-3"></div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="flex justify-between items-center mt-16">
                <button onclick="goBack()"
                    class="bg-lime-400 hover:bg-lime-500
                    text-black font-bold px-6 py-2 rounded-xl shadow-sm">
                    KEMBALI
                </button>

                <button onclick="submitForm()"
                    class="bg-sky-500 hover:bg-sky-600
                    text-white font-bold px-6 py-2 rounded-xl shadow-sm">
                    KIRIM
                </button>
            </div>

        </div>
    </div>
</div>
</x-layout_unggah_balasan_kakot>