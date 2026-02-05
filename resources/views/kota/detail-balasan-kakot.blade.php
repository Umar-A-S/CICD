<x-layout-detail-balasan-kakot>
<x-slot:title>{{ $title }}</x-slot:title>

@php
    if (!function_exists('input')) {
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

    // Logic penentu nilai
    $penerbitanExists = $permohonan->penerbitan?->exists ?? false;
    
    // TANGGAL & NOMOR: Ambil dari relasi penerbitan jika ada
    $tglTerbit = $penerbitanExists ? $permohonan->penerbitan->created_at->format('d-m-Y') : '-';
    $tglSuratSelesai = $penerbitanExists ? \Carbon\Carbon::parse($permohonan->penerbitan->tanggal_surat_selesai)->format('d-m-Y') : '-';
    $noSuratTerbit = $penerbitanExists ? $permohonan->penerbitan->nomor_surat_selesai : '-';
    
    // HASIL: Jika ada data penerbitan pakai kolom hasil, jika tidak pakai status utama (DITOLAK)
    $hasilPemeriksaan = $penerbitanExists ? $permohonan->penerbitan->hasil : $permohonan->status;
    
    // ALASAN: Sekarang ambil langsung dari kolom catatan di tabel permohonan
    $alasanPemeriksaan = $permohonan->catatan ?? '-';
@endphp

<div class="bg-gray-100 min-h-screen py-10 px-6">
    <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-lg border border-gray-200 px-16 py-14">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-24">

            <div class="flex flex-col justify-between">
                <div class="space-y-14">
                    <div>
                        <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">IDENTITAS</h2>
                        <div class="space-y-5">
                            {!! input('Nama Subjek', 'nama', $permohonan->nama_subjek) !!}
                            {!! input('Daerah Asal', 'asal', $permohonan->daerah_asal) !!}
                            {!! input('Wilayah Tujuan (Dalam/Luar)', 'wilayah', $permohonan->wilayah) !!}

                            <div>
                                <label class="block text-xs font-bold mb-2 uppercase text-gray-600">Daerah Tujuan</label>
                                <div class="space-y-2">
                                    <input id="wilayahTujuan" disabled value="{{ $permohonan->wilayah_tujuan }}"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-black">
                                    <input id="daerahTujuan" disabled value="{{ $permohonan->daerah_tujuan }}"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-black">
                                </div>
                            </div>

                            {!! input('Jenis Permohonan', 'jenis', $permohonan->jenis_permohonan) !!}
                            {!! input('Jenis Dokumen', 'dokumen', $permohonan->jenis_dokumen) !!}
                        </div>
                    </div>

                    <div>
                        <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">PERMOHONAN</h2>
                        <div class="space-y-5">
                            {!! input('Tanggal Permohonan', 'tglPermohonan', $permohonan->created_at->format('d-m-Y')) !!}
                            {!! input('Nomor Surat', 'noSuratPermohonan', $permohonan->nomor_surat) !!}
                            {!! input('Tanggal Surat', 'tglSuratPermohonan', $permohonan->tanggal_surat ? \Carbon\Carbon::parse($permohonan->tanggal_surat)->format('d-m-Y') : '-') !!}
                            
                            <label class="block text-xs font-bold mb-2 uppercase text-gray-600">Berkas</label>
                            @if($permohonan->file_path)
                                <a href="{{ route('permohonan.preview', $permohonan->id) }}" target="_blank"
                                    class="inline-flex items-center gap-2 text-blue-600 font-semibold text-sm cursor-pointer hover:underline">
                                    <i class="fa-solid fa-file-lines"></i> Lihat Berkas Permohonan
                                </a>
                            @else
                                <span class="text-gray-400 text-sm italic">Berkas tidak tersedia</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-14">
                <div>
                    <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">PENERBITAN</h2>
                    <div class="space-y-5">
                        {!! input('Tanggal Diterbitkan di Sistem', 'tglTerbit', $tglTerbit) !!}
                        {!! input('Tanggal Surat Selesai', 'tglSuratSelesai', $tglSuratSelesai) !!}
                        {!! input('Nomor Surat', 'noSuratTerbit', $noSuratTerbit) !!}

                        <div>
                            <label class="block text-xs font-bold mb-2 uppercase text-gray-600">Berkas Balasan</label>
                            @if($penerbitanExists)
                                <a href="{{ route('penerbitan.preview', $permohonan->id) }}" target="_blank"
                                    class="inline-flex items-center gap-2 text-blue-600 font-semibold text-sm cursor-pointer hover:underline">
                                    <i class="fa-solid fa-file-lines"></i> Lihat Berkas Balasan
                                </a>
                            @else
                                <span class="text-gray-400 text-sm italic text-black">Dokumen belum diterbitkan/ditolak</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-extrabold tracking-wide mb-8 text-gray-800">HASIL PEMERIKSAAN</h2>
                    <div class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold mb-2 uppercase text-gray-600">Hasil</label>
                            <input id="hasil" disabled value="{{ $hasilPemeriksaan }}"
                                class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm font-semibold text-black uppercase">
                        </div>

                        <div>
                            <label class="block text-xs font-bold mb-2 uppercase text-gray-600">Keterangan/Alasan</label>
                            <textarea disabled rows="4"
                                class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm resize-none text-black">{{ $alasanPemeriksaan }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-20 flex justify-between items-center">
            <a href="{{ route('balasan.index') }}"
                class="bg-gray-800 hover:bg-black text-white font-bold px-12 py-3 rounded-xl transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <i class="fa-solid fa-arrow-left mr-2"></i> KEMBALI
            </a>

            @if($permohonan->status === 'DITOLAK')
                <a href="{{ route('permohonan.resubmit', $permohonan->id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-12 py-3 rounded-xl transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <i class="fa-solid fa-rotate-right mr-2"></i> AJUKAN ULANG
                </a>
            @endif
        </div>
    </div>
</div>
</x-layout-detail-balasan-kakot>