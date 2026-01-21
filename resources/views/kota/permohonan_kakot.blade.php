<x-layout_permohonan_kakot>
    <x-slot:title>{{ $title }}</x-slot:title>
    <body class="bg-gray-50">

    <div class="max-w-6xl mx-auto p-8 bg-white rounded-xl mt-10 shadow">

    <div class="max-w-7xl mx-auto px-10 py-10">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-16">

        <!-- ================= KIRI ================= -->
        <div>
            <h2 class="text-lg font-bold mb-6">IDENTITAS</h2>

            <div class="space-y-5">

                <!-- Nama Subjek -->
                <div>
                    <label class="text-xs font-bold uppercase">Nama Subjek</label>
                    <input type="text" placeholder="Masukkan Nama Lengkap"
                        class="w-full mt-1 bg-gray-100 rounded-lg px-4 py-2 outline-none">
                </div>

                <!-- Daerah Asal -->
                <div>
                    <label class="text-xs font-bold uppercase">Daerah Asal</label>
                    <input type="text" placeholder="Masukkan Daerah Asal"
                        class="w-full mt-1 bg-gray-100 rounded-lg px-4 py-2 outline-none">
                </div>

                <!-- Daerah Tujuan -->
                <div>
                    <label class="text-xs font-bold uppercase">Daerah Tujuan</label>

                    <!-- Kab / Kota -->
                    <label class="text-[10px] font-semibold text-gray-500 uppercase mt-2 block">
                        Kabupaten / Kota
                    </label>
                    <select id="kabkota"
                        class="w-full mt-1 bg-gray-100 rounded-lg px-4 py-2 outline-none">
                        <option value="" disabled selected>Pilih Kabupaten/Kota</option>
                    </select>

                    <!-- Provinsi (AUTO) -->
                    <label class="text-[10px] font-semibold text-gray-500 uppercase mt-4 block">
                        Provinsi
                    </label>
                    <select id="provinsi"
                        class="w-full mt-1 bg-gray-100 rounded-lg px-4 py-2 outline-none">
                        <option value="" disabled selected>Pilih Provinsi</option>
                    </select>
                </div>

                <!-- Jenis Permohonan --> 
                <div> 
                    <label class="text-xs font-bold uppercase">Jenis Permohonan</label>
                    <select class="w-full mt-1 bg-gray-100 rounded-lg px-4 py-2 outline-none">
                        <option value="" disabled selected>Pilih Jenis Permohonan</option>
                        <option>KEABSAHAN</option> 
                        <option>LEGALISIR</option> 
                        <option>MUTASI</option> 
                    </select> 
                </div>

                <!-- Jenis Dokumen --> 
                <div> 
                    <label class="text-xs font-bold uppercase">Jenis Dokumen</label> 
                    <select class="w-full mt-1 bg-gray-100 rounded-lg px-4 py-2 outline-none">
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
            <h2 class="text-lg font-bold mb-6">HASIL</h2>

            <div class="space-y-5">

                <!-- Tanggal Selesai -->
                <div>
                    <label class="text-xs font-bold uppercase">Tanggal Selesai</label>
                    <input type="date" value="Tanggal selesai"
                        class="w-full mt-1 bg-gray-100 rounded-lg px-4 py-2 outline-none">
                </div>

                <!-- Keterangan -->
                <div>
                    <label class="text-xs font-bold uppercase">Keterangan</label>
                    <input type="text" placeholder="keterangan"
                        class="w-full mt-1 bg-gray-100 rounded-lg px-4 py-2 outline-none">
                </div>

                <!-- Hasil Pemeriksaan -->
                <div>
                    <label class="text-xs font-bold uppercase">Hasil Pemeriksaan</label>
                    <select class="w-full mt-1 bg-gray-100 rounded-lg px-4 py-2 outline-none">
                        <option value="" disabled selected>Pilih Hasil Pemeriksaan</option>
                        <option>TERCATAT</option>
                        <option>TIDAK TERCATAT</option>
                    </select>
                </div>

                <!-- Upload -->
                <div>
                    <label class="text-xs font-bold uppercase">Unggah Berkas <span class="text-red-500"> * </span>
                    </label>
                    <p class="text-xs text-gray-500 mb-2">
                        Unggah berkas dalam format PDF / IMG max 2Mb.
                    </p>

                    <label for="fileUpload"
                        class="cursor-pointer flex flex-col items-center justify-center
                        border-2 border-dashed border-lime-400
                        rounded-xl h-40 text-center hover:bg-lime-50 transition">

                        <i class="fa-solid fa-cloud-arrow-up text-lime-500 text-4xl mb-2"></i>
                        <span class="text-sm font-semibold">Klik untuk upload PDF/JPG</span>

                        <input id="fileUpload" type="file" class="hidden"
                            accept=".pdf,.jpg,.jpeg,.png" multiple>
                    </label>

                    <!-- PREVIEW FILE -->
                    <div id="filePreview" class="mt-4 space-y-3"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= FOOTER ================= -->
    <div class="flex justify-between items-center mt-16">

        <button onclick="goBack()"
            class="bg-lime-400 hover:bg-lime-500
            text-black font-bold px-5 py-2 rounded-lg">
            KEMBALI
        </button>

        <button onclick="submitForm()"
            class="bg-sky-500 hover:bg-sky-600
            text-white font-bold px-5 py-2 rounded-lg">
            KIRIM
        </button>
    </div>
</div>
</x-layout_permohonan_kakot>