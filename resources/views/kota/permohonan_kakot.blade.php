<x-layout_permohonan_kakot>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- PAGE BACKGROUND -->
    <div class="bg-gray-100 min-h-screen px-6 py-6">

        <!-- CARD -->
        <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow px-12 py-10">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-16">

                <!-- ================= KIRI ================= -->
                <div>
                    <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">
                        IDENTITAS
                    </h2>

                    <div class="space-y-5">

                        <div>
                            <label class="text-xs font-bold uppercase">Nama Subjek</label>
                            <input type="text" placeholder="Masukkan Nama Lengkap"
                                class="w-full mt-1 bg-gray-50 border border-gray-200
                                rounded-xl px-4 py-3 text-sm outline-none">
                        </div>

                        <div>
                            <label class="text-xs font-bold uppercase">Daerah Asal</label>
                            <input type="text" placeholder="Masukkan Daerah Asal"
                                class="w-full mt-1 bg-gray-50 border border-gray-200
                                rounded-xl px-4 py-3 text-sm outline-none">
                        </div>

                        <!-- Wilayah Tujuan -->
                        <div>
                            <label class="text-xs font-bold uppercase">Wilayah Tujuan</label>

                            <!-- Dalam / Luar Daerah -->
                            <select id="wilayah"
                                class="w-full mt-1 bg-gray-100 rounded-lg px-4 py-2 outline-none">
                                <option value="" disabled selected>Pilih Wilayah</option>
                                <option value="dalam">Dalam Daerah (Jawa Tengah)</option>
                                <option value="luar">Luar Daerah</option>
                            </select>
                        </div>
                        
                        <!-- Daerah Tujuan -->
                        <div>
                            <label class="text-xs font-bold uppercase">Daerah Tujuan</label>

                            <!-- Provinsi -->
                            <div id="provinsiWrapper" class="mt-4">
                                <label class="text-[10px] font-semibold text-gray-500 uppercase block">
                                    Provinsi
                                </label>
                                <select id="provinsi"
                                    class="w-full mt-1 bg-gray-100 rounded-lg px-4 py-2 outline-none">
                                    <option value="" disabled selected>Pilih Provinsi</option>
                                </select>
                            </div>

                            <!-- Kabupaten / Kota -->
                            <label class="text-[10px] font-semibold text-gray-500 uppercase mt-4 block">
                                Kabupaten / Kota
                            </label>
                            <select id="kabkota"
                                class="w-full mt-1 bg-gray-100 rounded-lg px-4 py-2 outline-none">
                                <option value="" disabled selected>Pilih Kabupaten/Kota</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-xs font-bold uppercase">Jenis Permohonan</label>
                            <select
                                class="w-full mt-1 bg-gray-50 border border-gray-200
                                rounded-xl px-4 py-3 text-sm outline-none">
                                <option disabled selected>Pilih Jenis Permohonan</option>
                                <option>KEABSAHAN</option>
                                <option>LEGALISIR</option>
                                <option>MUTASI</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-xs font-bold uppercase">Jenis Dokumen</label>
                            <select
                                class="w-full mt-1 bg-gray-50 border border-gray-200
                                rounded-xl px-4 py-3 text-sm outline-none">
                                <option disabled selected>Pilih Jenis Dokumen</option>
                                <option>Akta Kelahiran</option>
                                <option>Kartu Keluarga</option>
                                <option>KTP</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- ================= KANAN ================= -->
                <div>
                    <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">
                        PERMOHONAN
                    </h2>


                <div class="space-y-5">

                <!-- Nomor Surat -->
                <div>
                    <label class="text-xs font-bold uppercase">
                        Nomor Surat
                    </label>
                    <input type="text" id="noSurat"
                        placeholder="Masukkan Nomor Surat"
                        class="w-full mt-1 bg-gray-50 border border-gray-200
                        rounded-xl px-4 py-3 text-sm outline-none">
                </div>

                <!-- Tanggal Surat -->
                <div>
                    <label class="text-xs font-bold uppercase">
                        Tanggal Surat
                    </label>
                    <input type="date" id="tglSurat"
                        class="w-full mt-1 bg-gray-50 border border-gray-200
                        rounded-xl px-4 py-3 text-sm outline-none">
                </div>

                <!-- UPLOAD -->
                <div>
                    <label class="text-xs font-bold uppercase">
                        Unggah Berkas <span class="text-red-500">*</span>
                    </label>

                    <label for="fileUpload"
                        class="mt-3 cursor-pointer flex flex-col items-center justify-center
                        border-2 border-dashed border-lime-400
                        rounded-2xl h-40 text-center hover:bg-lime-50 transition">

                        <i class="fa-solid fa-cloud-arrow-up
                        text-lime-500 text-4xl mb-2"></i>
                        <span class="text-sm font-semibold">
                            Klik untuk upload PDF/JPG
                        </span>

                        <input id="fileUpload" type="file" class="hidden" multiple>
                    </label>

                    <div id="filePreview" class="mt-4 space-y-3"></div>
                </div>

            </div>
        </div>
    </div>
            <!-- FOOTER -->
            <div class="flex justify-between items-center mt-14">
                <button onclick="goBack()"
                    class="bg-lime-400 hover:bg-lime-500
                    text-black font-bold px-6 py-2 rounded-xl">
                    KEMBALI
                </button>

                <button onclick="submitForm()"
                    class="bg-sky-500 hover:bg-sky-600
                    text-white font-bold px-6 py-2 rounded-xl">
                    KIRIM
                </button>
            </div>

        </div>
    </div>
</x-layout_permohonan_kakot>