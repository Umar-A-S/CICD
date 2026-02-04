<x-layout_detail_penerbitan_kakot>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="bg-gray-100 min-h-screen py-10 px-6">
        <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-md px-16 py-14">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-24">

                <div class="space-y-14">

                    <section>
                        <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">
                            IDENTITAS
                        </h2>

                        <div class="space-y-5">
                            @php
                                $inputClass = 'w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-black font-medium';
                                $labelClass = 'block text-xs font-bold mb-2 uppercase text-gray-600';
                            @endphp

                            <div>
                                <label class="{{ $labelClass }}">Nama Subjek</label>
                                <input value="{{ $permohonan->nama_subjek }}" disabled class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Daerah Asal</label>
                                <input value="{{ $permohonan->daerah_asal }}" disabled class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Wilayah Tujuan</label>
                                <input value="{{ $permohonan->wilayah_tujuan }}" disabled class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Daerah Tujuan</label>
                                <div class="space-y-2">
                                    <input value="{{ $permohonan->daerah_tujuan }}" disabled class="{{ $inputClass }}">
                                </div>
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Jenis Permohonan</label>
                                <input value="{{ $permohonan->jenis_permohonan }}" disabled class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Jenis Dokumen</label>
                                <input value="{{ $permohonan->jenis_dokumen }}" disabled class="{{ $inputClass }}">
                            </div>
                        </div>
                    </section>

                    <section>
                        <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">
                            PERMOHONAN MASUK
                        </h2>

                        <div class="space-y-5">
                            <div>
                                <label class="{{ $labelClass }}">Tanggal Surat Masuk</label>
                                <input value="{{ $permohonan->tanggal_surat->format('d/m/Y') }}" disabled class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Nomor Surat Permohonan</label>
                                <input value="{{ $permohonan->nomor_surat }}" disabled class="{{ $inputClass }}">
                            </div>
                        </div>

                        <div class="mt-5">
                            <label class="{{ $labelClass }}">Berkas Permohonan</label>
                            @if($permohonan->file_path)
                                <a href="{{ route('penerbitan.preview_permohonan', $permohonan->id) }}" target="_blank" 
                                   class="inline-flex items-center gap-2 text-sky-600 hover:text-sky-800 font-bold text-sm transition">
                                    <i class="fa-solid fa-file-pdf text-xl"></i>
                                    Lihat Dokumen Asli
                                </a>
                            @else
                                <span class="text-red-500 text-sm italic">Tidak ada berkas terlampir</span>
                            @endif
                        </div>
                    </section>

                </div>

                <div class="space-y-14">

                    <section>
                        <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">
                            PENERBITAN (BALASAN)
                        </h2>

                        @if($permohonan->penerbitan)
                        <div class="space-y-5">
                            <div>
                                <label class="{{ $labelClass }}">Tanggal Diselesaikan</label>
                                <input value="{{ $permohonan->penerbitan->tanggal_surat_selesai ? $permohonan->penerbitan->tanggal_surat_selesai->format('d/m/Y') : '-' }}" disabled class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Nomor Surat Balasan</label>
                                <input value="{{ $permohonan->penerbitan->nomor_surat_selesai ?? '-' }}" disabled class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Berkas Balasan</label>
                                @if($permohonan->penerbitan->file_path)
                                        <a href="{{ route('penerbitan.preview', $permohonan->id) }}" target="_blank"
                                        class="inline-flex items-center gap-2 text-sky-600 hover:text-sky-800 font-bold text-sm transition">
                                            <i class="fa-solid fa-file-circle-check text-xl"></i>
                                            Lihat Surat Balasan
                                        </a>
                                    @else
                                        <span class="text-red-500 text-sm italic">Tidak ada berkas</span>
                                    @endif
                            </div>
                        </div>
                        @else
                        <div class="p-6 bg-yellow-50 rounded-xl border border-yellow-200 text-yellow-800 text-sm">
                            <i class="fa-solid fa-circle-exclamation mr-2"></i> Belum ada data penerbitan.
                        </div>
                        @endif
                    </section>

                    @if($permohonan->penerbitan)
                    <section>
                        <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">
                            HASIL AKHIR
                        </h2>

                        <div class="space-y-5">
                            <div>
                                <label class="{{ $labelClass }}">Status Keputusan</label>
                                <input value="{{ $permohonan->penerbitan->hasil }}" disabled 
                                    class="{{ $inputClass }} {{ $permohonan->penerbitan->hasil == 'TERCATAT' ? 'text-green-600 font-extrabold bg-green-50 border-green-200' : 'text-red-600 font-extrabold bg-red-50 border-red-200' }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Catatan / Keterangan</label>
                                <textarea disabled rows="4" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-black font-medium resize-none">{{ $permohonan->catatan }}</textarea>
                            </div>
                        </div>
                    </section>
                    @endif

                </div>
            </div>

            <div class="mt-20 flex justify-start">
                <a href="{{ route('penerbitan.index') }}"
                    class="bg-gray-800 hover:bg-black text-white font-bold px-12 py-3 rounded-xl transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <i class="fa-solid fa-arrow-left mr-2"></i> KEMBALI
                </a>
            </div>

        </div>
    </div>
</x-layout_detail_penerbitan_kakot>