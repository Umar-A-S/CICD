<x-layout_unggah_penerbitan_kakot>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- PAGE BACKGROUND -->
    <div class="bg-gray-100 min-h-screen py-10 px-6">

        <!-- CARD -->
        <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-md px-12 py-12">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-20">

                <!-- ================= KIRI ================= -->
                <div>
                    <h2 class="text-sm font-extrabold tracking-wide mb-8 text-gray-700">
                        IDENTITAS
                    </h2>

                    <div class="space-y-5">

                        <div>
                            <label class="text-xs font-bold uppercase text-gray-600">
                                Nama Subjek
                            </label>
                            <input type="text" value="Asep" disabled
                                class="w-full mt-1 bg-gray-50 border border-gray-200
                                rounded-xl px-4 py-3 text-sm text-black">
                        </div>

                        <div>
                            <label class="text-xs font-bold uppercase text-gray-600">
                                Daerah Asal
                            </label>
                            <input type="text" value="Semarang" disabled
                                class="w-full mt-1 bg-gray-50 border border-gray-200
                                rounded-xl px-4 py-3 text-sm text-black">
                        </div>

                        <div>
                            <label class="text-xs font-bold uppercase text-gray-600">
                                Daerah Tujuan
                            </label>

                            <div class="space-y-2 mt-1">
                                <input type="text" value="Jawa Tengah" disabled
                                    class="w-full bg-gray-50 border border-gray-200
                                    rounded-xl px-4 py-3 text-sm text-black">
                                    
                                <input type="text" value="Semarang" disabled
                                    class="w-full bg-gray-50 border border-gray-200
                                    rounded-xl px-4 py-3 text-sm text-black">
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-bold uppercase text-gray-600">
                                Jenis Permohonan
                            </label>
                            <input type="text" value="Keabsahan" disabled
                                class="w-full mt-1 bg-gray-50 border border-gray-200
                                rounded-xl px-4 py-3 text-sm text-black">
                        </div>

                        <div>
                            <label class="text-xs font-bold uppercase text-gray-600">
                                Jenis Dokumen
                            </label>
                            <input type="text" value="Akta Kelahiran" disabled
                                class="w-full mt-1 bg-gray-50 border border-gray-200
                                rounded-xl px-4 py-3 text-sm text-black">
                        </div>

                    </div>
                </div>

                <!-- ================= KANAN ================= -->
                <div>
                    <h2 class="text-sm font-extrabold tracking-wide mb-8 text-gray-700">
                        HASIL
                    </h2>

                    <div class="space-y-5">

                        <div>
                            <label class="text-xs font-bold uppercase text-gray-600">
                                Tanggal Selesai <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                class="w-full mt-1 bg-gray-50 border border-gray-200
                                rounded-xl px-4 py-3 text-sm outline-none">
                        </div>

                        <div>
                            <label class="text-xs font-bold uppercase text-gray-600">
                                Keterangan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" placeholder="Keterangan"
                                class="w-full mt-1 bg-gray-50 border border-gray-200
                                rounded-xl px-4 py-3 text-sm outline-none">
                        </div>

                        <div>
                            <label class="text-xs font-bold uppercase text-gray-600">
                                Hasil Pemeriksaan <span class="text-red-500">*</span>
                            </label>
                            <select
                                class="w-full mt-1 bg-gray-50 border border-gray-200
                                rounded-xl px-4 py-3 text-sm outline-none">
                                <option disabled selected>Pilih Hasil Pemeriksaan</option>
                                <option>TERCATAT</option>
                                <option>TIDAK TERCATAT</option>
                            </select>
                        </div>

                        <!-- UPLOAD -->
                        <div>
                            <label class="text-xs font-bold uppercase text-gray-600">
                                Unggah Berkas <span class="text-red-500">*</span>
                            </label>

                            <p class="text-xs text-gray-500 mb-3">
                                Unggah berkas format PDF / JPG / PNG (max 2MB)
                            </p>

                            <label for="fileUpload"
                                class="cursor-pointer flex flex-col items-center justify-center
                                border-2 border-dashed border-lime-400
                                rounded-2xl h-40 text-center
                                hover:bg-lime-50 transition">

                                <i class="fa-solid fa-cloud-arrow-up
                                text-lime-500 text-4xl mb-2"></i>

                                <span class="text-sm font-semibold text-gray-700">
                                    Klik untuk upload berkas
                                </span>

                                <input id="fileUpload" type="file" class="hidden"
                                    accept=".pdf,.jpg,.jpeg,.png">
                            </label>

                            <div id="filePreview" class="mt-4 space-y-3"></div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- ================= FOOTER ================= -->
            <div class="flex justify-between items-center mt-16">

                <button onclick="goBack()"
                    class="bg-lime-400 hover:bg-lime-500
                    text-black font-bold px-8 py-3 rounded-xl shadow-sm">
                    KEMBALI
                </button>

                <button onclick="submitForm()"
                    class="bg-sky-500 hover:bg-sky-600
                    text-white font-bold px-10 py-3 rounded-xl shadow-sm">
                    KIRIM
                </button>

            </div>

        </div>
    </div>
</x-layout_unggah_penerbitan_kakot>