<x-layout_detail_permohonan_prov>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="bg-gray-100 min-h-screen py-10 px-6">
        <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow px-12 py-10">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-16">

                <!-- ================= IDENTITAS ================= -->
                <div>
                    <h2 class="text-sm font-extrabold tracking-wide text-gray-700 mb-6">
                        IDENTITAS
                    </h2>

                    <div class="space-y-5">

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                NAMA SUBJEK
                            </label>
                            <input type="text" value="Siti Aminah" readonly
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                DAERAH ASAL
                            </label>
                            <input type="text" value="Kota Semarang" readonly
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                WILAYAH TUJUAN
                            </label>
                            <input type="text" value="dalam" readonly
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                DAERAH TUJUAN
                            </label>
                            <input type="text" value="Jawa Tengah" readonly
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm">
                            <input type="text" value="admin_magelang" readonly
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                JENIS PERMOHONAN
                            </label>
                            <input type="text" value="KEABSAHAN" readonly
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                JENIS DOKUMEN
                            </label>
                            <input type="text" value="KTP" readonly
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm">
                        </div>

                    </div>
                </div>

                <!-- ================= PERMOHONAN ================= -->
                <div>
                    <h2 class="text-sm font-extrabold tracking-wide text-gray-700 mb-6">
                        PERMOHONAN
                    </h2>

                    <div class="space-y-5">

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                TANGGAL PERMOHONAN
                            </label>
                            <input type="text" value="27-01-2026" readonly
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                NOMOR SURAT
                            </label>
                            <input type="text" value="123/SMG/2026" readonly
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                TANGGAL SURAT
                            </label>
                            <input type="text" value="25-01-2026" readonly
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                BERKAS
                            </label>

                            <a href="/storage/berkas/contoh.pdf"
                                target="_blank"
                                class="inline-flex items-center gap-2 text-blue-600 font-semibold hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5z"/>
                                </svg>
                                Lihat Berkas
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ================= BUTTON ================= -->
            <div class="mt-14">
                <button id="btnKembali"
                    class="bg-lime-400 hover:bg-lime-500 text-black font-bold px-10 py-3 rounded-xl">
                    KEMBALI
                </button>
            </div>

        </div>
    </div>
</x-layout_detail_permohonan_prov>