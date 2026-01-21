<x-layout_penerbitan_kakot>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- ================= PERLU DIBALAS ================= -->
    <div class="bg-white rounded-2xl p-8 mb-10">

    <h3 class="text-lg font-semibold text-gray-800">Perlu Dibalas</h3>
    <p class="text-sm text-gray-500 mb-6">Data valid siap cetak dan distribusi</p>

    <!-- WRAPPER SCROLL -->
    <div class="border rounded-xl overflow-hidden">

        <!-- HEADER (FIXED) -->
        <div class="bg-lime-300 px-6 py-3 grid grid-cols-10 text-sm font-semibold text-gray-700">
            <div class="col-span-2">DUKCAPIL ASAL</div>
            <div class="col-span-2">NOMOR SURAT/AKTA</div>
            <div class="col-span-2 text-center">JENIS PERMOHONAN</div>
            <div class="col-span-2 text-center">TGL PENGAJUAN</div>
            <div class="col-span-2 text-center">AKSI</div>
        </div>

        <!-- BODY (SCROLLABLE) -->
        <div
            id="listPerluDibalas"
            class="max-h-[200px] overflow-y-auto divide-y"
        >
        </div>

    </div>
</div>

    <!-- ================= SELESAI ================= -->
    <div class="bg-white rounded-2xl p-8">

    <h3 class="text-lg font-semibold text-gray-800">SELESAI</h3>
    <p class="text-sm text-gray-500 mb-6">Data valid siap cetak dan distribusi</p>

    <!-- WRAPPER SCROLL -->
    <div class="border rounded-xl overflow-hidden">

        <!-- HEADER (FIXED) -->
        <div class="bg-lime-300 px-6 py-3 grid grid-cols-10 text-sm font-semibold text-gray-700">
            <div class="col-span-2">DUKCAPIL ASAL</div>
            <div class="col-span-2">NOMOR SURAT/AKTA</div>
            <div class="col-span-2 text-center">JENIS PERMOHONAN</div>
            <div class="col-span-2 text-center">TGL PENGAJUAN</div>
            <div class="col-span-2 text-center">AKSI</div>
        </div>

        <!-- BODY (SCROLLABLE) -->
        <div
            id="listSelesai"
            class="max-h-[200px] overflow-y-auto divide-y"
        >
        </div>

    </div>
</div>

</x-layout_penerbitan_kakot>