<x-layout_detail_penerbitan_kakot>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- PAGE BACKGROUND -->
    <div class="bg-gray-100 min-h-screen py-10 px-6">

        <!-- CARD -->
        <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-md px-16 py-14">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-24">

                <!-- ================= LEFT ================= -->
                <div>
                    <h2 class="font-extrabold text-sm mb-8 tracking-wide text-gray-700">
                        IDENTITAS
                    </h2>

                    <div class="space-y-5">

                        @php
                            function input($label, $id) {
                                return "
                                <div>
                                    <label class='block text-xs font-bold mb-2 uppercase text-gray-600'>
                                        $label
                                    </label>
                                    <input id='$id' disabled
                                        class='w-full bg-gray-50 border border-gray-200
                                        rounded-xl px-4 py-3 text-sm text-black'>
                                </div>";
                            }
                        @endphp

                        {!! input('Nama Subjek', 'nama') !!}
                        {!! input('Wilayah Tujuan (Dalam/Luar)', 'wilayah') !!}
                        {!! input('Daerah Asal', 'asal') !!}

                        <div>
                            <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                Daerah Tujuan
                            </label>

                            <div class="space-y-2">
                                <input id="provinsi" disabled
                                    class="w-full bg-gray-50 border border-gray-200
                                    rounded-xl px-4 py-3 text-sm text-black"
                                    placeholder="Provinsi">

                                <input id="tujuan" disabled
                                    class="w-full bg-gray-50 border border-gray-200
                                    rounded-xl px-4 py-3 text-sm text-black"
                                    placeholder="Kab/Kota">
                            </div>
                        </div>

                        {!! input('Jenis Permohonan', 'jenis') !!}
                        {!! input('Jenis Dokumen', 'dokumen') !!}
                    </div>
                </div>

                <!-- ================= RIGHT ================= -->
                <div class="space-y-16">

                    <!-- PERMOHONAN -->
                    <div>
                        <h2 class="font-extrabold text-sm mb-8 tracking-wide text-gray-700">
                            PERMOHONAN
                        </h2>

                        <div class="space-y-5">
                            {!! input('Tanggal Permohonan', 'tglPermohonan') !!}
                            {!! input('Nomor Surat', 'noSuratPermohonan') !!}
                            {!! input('Nomor Surat Selesai', 'noSuratSelesai') !!}

                            <div>
                                <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                    Berkas
                                </label>
                                <a onclick="lihatBerkas()"
                                    class="inline-flex items-center gap-2
                                    text-blue-600 font-semibold text-sm cursor-pointer">
                                    <i class="fa-solid fa-file-lines"></i>
                                    Lihat Berkas
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- PENERBITAN -->
                    <div>
                        <h2 class="font-extrabold text-sm mb-8 tracking-wide text-gray-700">
                            PENERBITAN
                        </h2>

                        <div class="space-y-5">
                            {!! input('Tanggal Penerbitan', 'tglTerbit') !!}
                            {!! input('Nomor Surat', 'noSuratTerbit') !!}
                            {!! input('Nomor Surat Selesai', 'noSuratTerbitSelesai') !!}

                            <div>
                                <label class="block text-xs font-bold mb-2 uppercase text-gray-600">
                                    Berkas
                                </label>
                                <a onclick="lihatBerkas()"
                                    class="inline-flex items-center gap-2
                                    text-blue-600 font-semibold text-sm cursor-pointer">
                                    <i class="fa-solid fa-file-lines"></i>
                                    Lihat Berkas
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- BUTTON -->
            <div class="mt-20">
                <button onclick="goBack()"
                    class="bg-lime-400 hover:bg-lime-500
                    text-black font-bold px-10 py-3 rounded-xl shadow-sm">
                    KEMBALI
                </button>
            </div>

        </div>
    </div>
</x-layout_detail_penerbitan_kakot>