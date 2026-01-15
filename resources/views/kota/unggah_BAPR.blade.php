<x-layoutunggahbapr>
    <x-slot:title>UNGGAH BAPR</x-slot:title>
    
    <div class="p-6 md:p-10 min-h-screen relative pb-24 max-w-7xl mx-auto bg-gray-50">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-6 mb-8">
            
            <div>
                <label class="block text-xs font-bold uppercase mb-2 text-black">Nama</label>
                <input type="text" id="nama" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 font-bold text-black focus:outline-none focus:ring-2 focus:ring-lime-400">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase mb-2 text-black">Jenis Permohonan</label>
                <input type="text" id="jenis" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 font-medium text-black focus:outline-none focus:ring-2 focus:ring-lime-400">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase mb-2 text-black">Nomor Surat</label>
                <input type="text" id="nosurat" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 font-medium text-black focus:outline-none focus:ring-2 focus:ring-lime-400">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase mb-2 text-black">NIK</label>
                <input type="text" id="nik" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 font-medium text-black focus:outline-none focus:ring-2 focus:ring-lime-400">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase mb-2 text-black">Tanggal Submit</label>
                <input type="text" id="tglsubmit" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 font-medium text-black focus:outline-none focus:ring-2 focus:ring-lime-400">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase mb-2 text-black">Asal Pemohon</label>
                <input type="text" id="asal" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 font-medium text-black focus:outline-none focus:ring-2 focus:ring-lime-400">
            </div>

        </div>

        <div class="mb-8">
            <label class="block text-xs font-bold uppercase mb-2 text-black">BERKAS PEMOHON</label>
            <div id="fileList" class="ml-1 space-y-2">
                <span class="text-gray-400 text-sm italic">Sedang mengambil data berkas...</span>
            </div>
        </div>

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

        <div class="flex justify-center mb-12">
            <button id="uploadBtn" onclick="simpanBalasan()" disabled class="bg-[#CFFF5E] disabled:opacity-60 hover:bg-[#bcec4b] text-black font-bold text-sm px-10 py-3 rounded-lg shadow-md transition transform active:scale-95">
                <i class="fa-solid fa-paper-plane mr-2"></i> UPLOAD BALASAN
            </button>
        </div>

        <div class="fixed bottom-8 left-8">
            <button onclick="window.history.back()" class="bg-[#CFFF5E] hover:bg-[#bcec4b] text-black font-bold text-sm px-8 py-3 rounded-lg shadow-md transition uppercase">
                KEMBALI
            </button>
        </div>

    </div>
</x-layoutunggahbapr>