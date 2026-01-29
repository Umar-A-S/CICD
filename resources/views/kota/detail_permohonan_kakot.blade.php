<x-layout_detail_permohonan_kakot>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="bg-gray-100 min-h-screen py-10 px-6">
        <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-md px-16 py-14">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-24">

                <!-- ================= LEFT ================= -->
                <div class="flex flex-col justify-between">

                    <div>
                        <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">
                        IDENTITAS
                    </h2>

                        <div class="space-y-5">

                            <!-- Nama -->
                            <div>
                                <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                    Nama Subjek
                                </label>
                                <input disabled value="Asep"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                            </div>

                            <!-- Asal -->
                            <div>
                                <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                    Daerah Asal
                                </label>
                                <input disabled value="Kota Semarang"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                            </div>

                            <!-- Wilayah -->
                            <div>
                                <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                    Wilayah Tujuan
                                </label>
                                <input disabled value="Luar Daerah"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                            </div>

                            <!-- Tujuan -->
                            <div>
                                <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                    Daerah Tujuan
                                </label>

                                <div class="space-y-2">
                                    <input disabled value="Jawa Barat"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                    <input disabled value="Kota Bandung"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                </div>
                            </div>

                            <!-- Jenis -->
                            <div>
                                <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                    Jenis Permohonan
                                </label>
                                <input disabled value="KEABSAHAN"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                            </div>

                            <!-- Dokumen -->
                            <div>
                                <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                    Jenis Dokumen
                                </label>
                                <input disabled value="Akta Kelahiran"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                            </div>

                        </div>
                    </div>

                    <!-- BUTTON -->
                    <button onclick="history.back()"
                        class="mt-16 w-fit bg-lime-400 hover:bg-lime-500 text-black font-bold px-10 py-3 rounded-xl">
                        KEMBALI
                    </button>

                </div>

                <!-- ================= RIGHT ================= -->
                <div>

                    <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">
                        PERMOHONAN
                    </h2>

                    <div class="space-y-5">

                        <div>
                            <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                Tanggal Permohonan
                            </label>
                            <input disabled value="20-11-2025"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                Nomor Surat
                            </label>
                            <input disabled value="08.006/ITS/III/2023"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                Tanggal Surat
                            </label>
                            <input disabled value="22-11-2025"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                Berkas
                            </label>
                            <span class="text-blue-600 font-semibold text-sm cursor-pointer">
                                <i class="fa-solid fa-file-lines"></i>
                                Lihat Berkas
                            </span>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</x-layout_detail_permohonan_kakot>