<x-layout_detail_balasan_kakot>
<x-slot:title>{{ $title }}</x-slot:title>

@php
    if (!function_exists('input')) {
        // Tambahkan parameter $value = '' di sini
        function input($label, $id, $value = '') { 
            return '
            <div>
                <label class="block text-xs font-bold mb-2 uppercase text-gray-600">'.$label.'</label>
                <input id="'.$id.'" disabled value="'.$value.'"
                    class="w-full bg-gray-50 border border-gray-200
                        rounded-lg px-4 py-2.5 text-sm text-black">
            </div>';
        }
    }
@endphp

<!-- PAGE BACKGROUND -->
<div class="bg-gray-100 min-h-screen py-10 px-6">

    <!-- CARD CONTAINER -->
    <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-lg border border-gray-200 px-16 py-14">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-24">

            <!-- ================= LEFT ================= -->
            <div class="flex flex-col justify-between">

                <div class="space-y-14">

                    <!-- IDENTITAS -->
                    <div>
                        <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">
                            IDENTITAS
                        </h2>

                        <div class="space-y-5">
                            {!! input('Nama Subjek', 'nama', $permohonan->nama_subjek) !!}
                            {!! input('Daerah Asal', 'asal', $permohonan->daerah_asal) !!}
                            {!! input('Wilayah Tujuan (Dalam/Luar)', 'wilayah', $permohonan->wilayah) !!}

                            <div>
                                <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                    Daerah Tujuan
                                </label>
                                <div class="space-y-2">
                                    <input id="wilayahTujuan" disabled value="{{ $permohonan->wilayah_tujuan }}"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
                                    <input id="daerahTujuan" disabled value="{{ $permohonan->daerah_tujuan }}"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
                                </div>
                            </div>

                            {!! input('Jenis Permohonan', 'jenis', $permohonan->jenis_permohonan) !!}
                            {!! input('Jenis Dokumen', 'dokumen', $permohonan->jenis_dokumen) !!}
                        </div>
                    </div>

                    <!-- PERMOHONAN (KIRI) -->
                    <div>
                        <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">
                            PERMOHONAN
                        </h2>

                        <div class="space-y-5">
                            {!! input('Tanggal Permohonan', 'tglPermohonan', $permohonan->created_at->format('d-m-Y')) !!}
                            {!! input('Nomor Surat', 'noSuratPermohonan', $permohonan->nomor_surat) !!}
                            <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                Berkas
                            </label>
                            <a href="{{ asset($permohonan->penerbitan->file_path) }}" target="_blank"
                                class="inline-flex items-center gap-2 text-blue-600 font-semibold text-sm cursor-pointer">
                                <i class="fa-solid fa-file-lines"></i>
                                Lihat Berkas
                            </a>
                        </div>

                    </div>

                </div>
            </div>

            <!-- ================= RIGHT ================= -->
            <div class="space-y-14">

                <!-- PENERBITAN -->
                <div>
                    <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">
                        PENERBITAN
                    </h2>

                    <div class="space-y-5">
                        {!! input('Tanggal Penerbitan', 'tglTerbit', $permohonan->penerbitan->created_at->format('d-m-Y')) !!}
                        {!! input('Nomor Surat', 'noSuratTerbit', $permohonan->penerbitan->nomor_surat_selesai) !!}

                        <div>
                            <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                Berkas
                            </label>
                            <a href="{{ asset($permohonan->penerbitan->file_path) }}" target="_blank"
                                class="inline-flex items-center gap-2 text-blue-600 font-semibold text-sm cursor-pointer">
                                <i class="fa-solid fa-file-lines"></i>
                                Lihat Berkas
                            </a>
                        </div>
                    </div>
                </div>

                <!-- HASIL PEMERIKSAAN -->
                <div>
                    <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">
                        HASIL PEMERIKSAAN
                    </h2>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                Hasil
                            </label>
                            <input id="hasil" disabled value="{{ $permohonan->penerbitan->hasil }}"
                                class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm font-semibold">
                        </div>

                        <div>
                            <label class="block text-xs font-bold mb-2 uppercase text-gray-600">Keterangan/Alasan</label>
                            <textarea disabled rows="4"
                                class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm resize-none">{{ $permohonan->penerbitan->alasan }}</textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- BUTTON -->
        <div class="mt-20">
            <button onclick="goBack()"
                class="bg-lime-400 hover:bg-lime-500 text-black font-bold px-10 py-3 rounded-xl shadow-sm">
                KEMBALI
            </button>
        </div>

    </div>
</div>
</x-layout_detail_balasan_kakot>