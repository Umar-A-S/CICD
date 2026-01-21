<x-layout_detail_permohonan_kakot>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="max-w-7xl mx-auto bg-white px-16 py-14">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-24">

        <!-- ================= LEFT ================= -->
        <div class="flex flex-col justify-between">

            <div>
                <h2 class="font-extrabold text-sm mb-8 tracking-wide">IDENTITAS</h2>

                <div class="space-y-5">

                    @php
                        function input($label, $id) {
                            return "
                            <div>
                                <label class='block text-xs font-bold mb-2 uppercase'>$label</label>
                                <input id='$id' disabled
                                    class='w-full bg-gray-50 border border-gray-100
                                        rounded-xl px-4 py-3 text-sm text-black'>
                            </div>";
                        }
                    @endphp

                    {!! input('Nama Subjek', 'nama') !!}
                    {!! input('Wilayah Tujuan (Dalam/Luar)', 'wilayah') !!}
                    {!! input('Daerah Asal', 'asal') !!}

                    <div>
                        <label class="block text-xs font-bold mb-2 uppercase">
                            Daerah Tujuan
                        </label>

                        <div class="space-y-2">
                            <input id="tujuan" disabled
                                class="w-full bg-gray-50 border border-gray-100
                                    rounded-xl px-4 py-3 text-sm text-gray-700"
                                placeholder="Kab/kota">

                            <input id="provinsi" disabled
                                class="w-full bg-gray-50 border border-gray-100
                                    rounded-xl px-4 py-3 text-sm text-gray-700"
                                placeholder="Provinsi">
                        </div>
                    </div>

                    {!! input('Jenis Permohonan', 'jenis') !!}
                    {!! input('Jenis Dokumen', 'dokumen') !!}
                </div>
            </div>

            <!-- BUTTON -->
            <button onclick="goBack()"
                class="mt-16 w-fit bg-lime-400 hover:bg-lime-500
                    text-black font-bold px-10 py-3 rounded-lg">
                KEMBALI
            </button>

        </div>

        <!-- ================= RIGHT ================= -->
        <div class="space-y-14">

            <!-- PERMOHONAN -->
            <div>
                <h2 class="font-extrabold text-sm mb-8 tracking-wide">PERMOHONAN</h2>

                <div class="space-y-5">
                    {!! input('Tanggal Permohonan', 'tglPermohonan') !!}
                    {!! input('Nomor Surat', 'noSuratPermohonan') !!}
                    {!! input('Nomor Surat Selesai', 'noSuratSelesai') !!}

                    <div>
                        <label class="block text-xs font-bold mb-2 uppercase">Berkas</label>
                        <a onclick="lihatBerkas()"
                            class="inline-flex items-center gap-2 text-blue-600 font-semibold text-sm cursor-pointer">
                            <i class="fa-solid fa-file-lines"></i>
                            Lihat Berkas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layout_detail_permohonan_kakot>