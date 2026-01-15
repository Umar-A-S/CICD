<x-layoutpermohonankota>
    <x-slot:title>{{ $title }}</x-slot:title>
    <body class="bg-gray-50">

    <div class="max-w-6xl mx-auto p-8 bg-white rounded-xl mt-10 shadow">

        <!-- FORM -->
        <form id="permohonanForm">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- KIRI -->
                <div class="space-y-4">

                    <div>
                        <label class="text-xs font-bold uppercase">Jenis Permohonan</label>
                        <select id="jenis" class="w-full mt-1 p-3 rounded-lg border">
                            <option>Keabsahan</option>
                            <option>Legalisir</option>
                            <option>Mutasi</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase">Nama Subjek</label>
                        <input id="nama" type="text" value="ASEP"
                            class="w-full mt-1 p-3 rounded-lg border">
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase">NIK</label>
                        <input id="nik" type="text" value="231156554131234"
                            class="w-full mt-1 p-3 rounded-lg border">
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase">Tanggal Surat</label>
                        <input id="tanggal" type="date"
                            class="w-full mt-1 p-3 rounded-lg border">
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase">Nomor Surat</label>
                        <input id="nomor" type="text" placeholder="Masukkan Nomor Surat"
                            class="w-full mt-1 p-3 rounded-lg border">
                    </div>

                </div>

                <!-- KANAN -->
                <div class="space-y-4">

                    <div>
                        <label class="text-xs font-bold uppercase">Daerah Asal</label>
                        <select id="daerahAsal" name="daerahAsal" class="w-full mt-1 p-3 rounded-lg border">
                            <option value="">-- Pilih Daerah Asal --</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase">Wilayah Tujuan (Dalam/Luar)</label>
                        <select id="wilayahTujuan" class="w-full mt-1 p-3 rounded-lg border">
                            <option>Luar Jateng</option>
                            <option>Dalam Jateng</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase">Wilayah</label>
                        <select id="wilayah" name="wilayah" class="w-full mt-1 p-3 rounded-lg border">
                            <option value="">-- Pilih Wilayah --</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase">Daerah Tujuan</label>
                        <select id="daerahTujuan" name="daerahTujuan" class="w-full mt-1 p-3 rounded-lg border">
                            <option value="">-- Pilih Daerah Tujuan --</option>
                        </select>
                    </div>

                </div>
            </div>

            <!-- UPLOAD -->
            <div class="mb-8">
            <label class="block text-xs font-bold uppercase mb-2 text-black">UNGGAH BALASAN</label>
            <p class="text-xs text-gray-600 mb-2">Unggah berkas dalam format PDF / IMG max 2Mb.</p>
            
            <div id="dropZoneArea" class="relative w-full bg-white border-2 border-dashed border-[#CFFF5E] rounded-[30px] h-64 flex flex-col items-center justify-center cursor-pointer hover:bg-lime-50 transition group" onclick="triggerUpload()">
                
                <div class="text-[#CFFF5E] mb-3 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-cloud-arrow-up text-6xl"></i>
                </div>
                
                <span id="uploadText" class="text-gray-500 font-medium text-sm">Klik area ini untuk upload PDF/JPG</span>
                
                <input type="file" id="fileInput" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
            </div>
            
            <div id="filePreviewContainer" class="hidden mt-4 p-4 bg-lime-100 rounded-lg border border-lime-300 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-file-pdf text-red-500 text-xl"></i>
                    <div>
                        <span id="selectedFileName" class="font-bold text-lime-900 text-sm">Nama File.pdf</span>
                        <div id="previewArea" class="mt-2"></div>
                    </div>
                </div>
                <button onclick="resetFile()" class="text-red-500 hover:text-red-700 text-xs font-bold uppercase">Hapus</button>
            </div>
        </div>

            <!-- SUBMIT -->
            <div class="flex justify-center mt-8">
                <button type="submit"
                        class="bg-lime-400 hover:bg-lime-500
                            px-8 py-3 rounded-full font-bold text-black">
                    Unggah permohonan
                </button>
            </div>

        </form>

    </div>
</x-layoutpermohonankota>