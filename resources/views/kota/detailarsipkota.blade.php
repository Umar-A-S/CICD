<x-layoutdetailarsipkota>
    
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- HEADER -->
    <div class="mb-6">
        <a href="/arsip-kota"
            class="inline-flex items-center gap-2 bg-lime-400 hover:bg-lime-500
            text-black text-sm px-4 py-1.5 rounded-full font-semibold">
            ← Kembali
        </a>
    </div>

    <h2 class="text-xl font-bold text-black mb-8">
        DETAIL ARSIP DATA
    </h2>

    <!-- CONTENT -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <!-- KIRI -->
        <div class="space-y-5">

            <div>
                <label class="text-xs font-bold uppercase">Daerah Asal</label>
                <input
                    id="daerahasal"
                    disabled
                    class="mt-2 w-full rounded-xl
                            bg-gray-50 border border-gray-200
                            px-4 py-3 text-sm
                            text-black
                            disabled:text-black
                            disabled:opacity-100">
            </div>

            <div>
                <label class="text-xs font-bold uppercase">Tanggal Submit</label>
                <input
                    id="tanggalsubmit"
                    disabled
                    class="mt-2 w-full rounded-xl
                            bg-gray-50 border border-gray-200
                            px-4 py-3 text-sm
                            text-black
                            disabled:text-black
                            disabled:opacity-100">
            </div>

            <div>
                <label class="text-xs font-bold uppercase">Daerah Tujuan</label>
                <input id="kabtujuan" disabled
                        class="mt-2 w-full rounded-xl bg-gray-50 border border-gray-200 px-4 py-3 text-sm 
                        text-black disabled:text-black disabled:opacity-100">
                <input id="provtujuan" disabled
                        class="mt-3 w-full rounded-xl bg-gray-50 border border-gray-200 px-4 py-3 text-sm 
                        text-black disabled:text-black disabled:opacity-100">
            </div>

            <div>
                <label class="text-xs font-bold uppercase">Jenis Permohonan</label>
                <input id="jenispermohonan" disabled
                        class="mt-2 w-full rounded-xl bg-gray-50 border border-gray-200 px-4 py-3 text-sm 
                        text-black disabled:text-black disabled:opacity-100">
            </div>

            <div>
                <label class="text-xs font-bold">Tanggal Permohonan</label>
                <input id="tanggalpermohonan" disabled
                        class="mt-2 w-full rounded-xl bg-gray-50 border border-gray-200 px-4 py-3 text-sm 
                        text-black disabled:text-black disabled:opacity-100">
            </div>

        </div>

        <!-- KANAN -->
        <div class="space-y-5">

            <div>
                <label class="text-xs font-bold">Nomor Surat</label>
                <input id="nomorsurat" disabled
                        class="mt-2 w-full rounded-xl bg-gray-50 border border-gray-200 px-4 py-3 text-sm 
                        text-black disabled:text-black disabled:opacity-100">
            </div>

            <div>
                <label class="text-xs font-bold">Nama Subjek</label>
                <input id="namasubjek" disabled
                        class="mt-2 w-full rounded-xl bg-gray-50 border border-gray-200 px-4 py-3 text-sm 
                        text-black disabled:text-black disabled:opacity-100">
            </div>

            <div>
                <label class="text-xs font-bold">Berkas</label>
                <div class="mt-2 flex items-center gap-3 rounded-xl bg-gray-50 border px-4 py-3 text-sm">
                    <i class="fa-solid fa-print text-sky-500"></i>
                    <a id="linkberkas" href="#" target="_blank"
                        class="text-sky-500 font-semibold hover:underline">
                        Lihat Berkas
                    </a>
                </div>
            </div>

        </div>

    </div>
</x-layoutdetailarsipkota>