<x-layout_detail_permohonan>
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
                                <input disabled value="{{ $permohonan->nama_subjek }}"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                            </div>

                            <!-- Asal -->
                            <div>
                                <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                    Daerah Asal
                                </label>
                                <input disabled value="{{ $permohonan->daerah_asal }}"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                            </div>

                            <!-- Wilayah -->
                            <div>
                                <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                    Wilayah Tujuan
                                </label>
                                <input disabled value="{{ $permohonan->wilayah }}"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                            </div>

                            <!-- Tujuan -->
                            <div>
                                <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                    Daerah Tujuan
                                </label>

                                <div class="space-y-2">
                                    <input disabled value="{{ $permohonan->wilayah_tujuan}}"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                    <input disabled value="{{ $permohonan->daerah_tujuan }}"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                </div>
                            </div>

                            <!-- Jenis -->
                            <div>
                                <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                    Jenis Permohonan
                                </label>
                                <input disabled value="{{ $permohonan->jenis_permohonan }}"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                            </div>

                            <!-- Dokumen -->
                            <div>
                                <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                    Jenis Dokumen
                                </label>
                                <input disabled value="{{ $permohonan->jenis_dokumen }}"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                            </div>

                        </div>
                    </div>

                    <!-- BUTTON -->
                <div class="mt-20 flex justify-start">
                    <button onclick="javascript:history.back()"
                        class="bg-gray-800 hover:bg-black text-white font-bold px-12 py-3 rounded-xl transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <i class="fa-solid fa-arrow-left mr-2"></i> KEMBALI
                    </a>
                </div>

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
                            <input disabled value="{{ $permohonan->created_at->format('d-m-Y') }}"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                Nomor Surat
                            </label>
                            <input disabled value="{{ $permohonan->nomor_surat }}"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                Tanggal Surat
                            </label>
                            <input disabled value="{{ $permohonan->tanggal_surat->format('d-m-Y') }}"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                        </div>

                            <div class="mb-4">
                                <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                    Berkas
                                </label>
                                
                                @if($permohonan->file_path)
                                    <a href="{{ asset($permohonan->file_path) }}" target="_blank" class="inline-block">
                                        <span class="text-blue-600 font-semibold text-sm cursor-pointer hover:text-blue-800 transition">
                                            <i class="fa-solid fa-file-lines"></i>
                                            Lihat Berkas
                                        </span>
                                    </a>
                                @else
                                    <span class="text-red-500 font-semibold text-sm italic">
                                        <i class="fa-solid fa-circle-exmark"></i>
                                        Berkas tidak ditemukan
                                    </span>
                                @endif
                            </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</x-layout_detail_permohonan>