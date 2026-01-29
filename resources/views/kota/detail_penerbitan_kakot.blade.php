<x-layout_detail_penerbitan_kakot>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="bg-gray-100 min-h-screen py-10 px-6">
        <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-md px-16 py-14">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-24">

                <!-- ================= LEFT ================= -->
                <div class="space-y-14">

                    <!-- IDENTITAS -->
                    <section>
                        <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">
                            IDENTITAS
                        </h2>

                        <div class="space-y-5">

                            @php
                                $inputClass = 'w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-black';
                                $labelClass = 'block text-xs font-bold mb-2 uppercase text-gray-600';
                            @endphp

                            <div>
                                <label class="{{ $labelClass }}">Nama Subjek</label>
                                <input value="Asep" disabled class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Daerah Asal</label>
                                <input value="Kota Semarang" disabled class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Wilayah Tujuan</label>
                                <input value="Luar Daerah" disabled class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Daerah Tujuan</label>
                                <div class="space-y-2">
                                    <input value="Jawa Barat" disabled class="{{ $inputClass }}">
                                    <input value="Kota Bandung" disabled class="{{ $inputClass }}">
                                </div>
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Jenis Permohonan</label>
                                <input value="Keabsahan" disabled class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Jenis Dokumen</label>
                                <input value="Akta Kelahiran" disabled class="{{ $inputClass }}">
                            </div>

                        </div>
                    </section>

                    <!-- PERMOHONAN -->
                    <section>
                        <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">
                            PERMOHONAN
                        </h2>

                        <div class="space-y-5">
                            <div>
                                <label class="{{ $labelClass }}">Tanggal Permohonan</label>
                                <input value="20-01-2025" disabled class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Nomor Surat</label>
                                <input value="123/LEG/I/2025" disabled class="{{ $inputClass }}">
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label class="{{ $labelClass }}">Tanggal Surat</label>
                                <input value="21-01-2025" disabled class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Berkas</label>
                                <span class="inline-flex items-center gap-2 text-blue-600 font-semibold text-sm">
                                    <i class="fa-solid fa-file-lines"></i>
                                    Surat_Permohonan.pdf
                                </span>
                            </div>
                        </div>
                    </section>

                </div>

                <!-- ================= RIGHT ================= -->
                <div class="space-y-14">

                    <!-- PENERBITAN -->
                    <section>
                        <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">
                            PENERBITAN
                        </h2>

                        <div class="space-y-5">
                            <div>
                                <label class="{{ $labelClass }}">Tanggal Penerbitan</label>
                                <input value="25-01-2025" disabled class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Nomor Surat</label>
                                <input value="123/LEG/I/2025" disabled class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Nomor Surat Selesai</label>
                                <input value="456/LEG/I/2025" disabled class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Berkas</label>
                                <span class="inline-flex items-center gap-2 text-blue-600 font-semibold text-sm">
                                    <i class="fa-solid fa-file-lines"></i>
                                    Surat_Penerbitan.pdf
                                </span>
                            </div>
                        </div>
                    </section>

                    <!-- HASIL -->
                    <section>
                        <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">
                            HASIL
                        </h2>

                        <div class="space-y-5">
                            <div>
                                <label class="{{ $labelClass }}">Hasil Pemeriksaan</label>
                                <input value="DITERIMA" disabled class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Keterangan</label>
                                <input value="Berkas Lengkap & Valid" disabled class="{{ $inputClass }}">
                            </div>
                        </div>
                    </section>

                </div>
            </div>

            <!-- BUTTON -->
            <div class="mt-20">
                <button onclick="history.back()"
                    class="bg-lime-400 hover:bg-lime-500 text-black font-bold px-12 py-3 rounded-xl">
                    KEMBALI
                </button>
            </div>

        </div>
    </div>
</x-layout_detail_penerbitan_kakot>