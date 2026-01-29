<x-layout_penerbitan_kakot>
    <x-slot:title>Penerbitan Kota/Kabupaten</x-slot:title>

    <div class="max-w-7xl mx-auto space-y-10">

        <!-- ================= PERLU DIBALAS ================= -->
        <div class="bg-white rounded-2xl p-8">

            <h3 class="text-lg font-semibold text-gray-800">Perlu Dibalas</h3>
            <p class="text-sm text-gray-500 mb-6">Data valid siap cetak dan distribusi</p>

            <input
                id="searchPerlu"
                type="text"
                placeholder="Cari dukcapil / nomor surat..."
                class="mb-4 w-full border border-gray-300 rounded-lg px-4 py-2 text-black text-sm
                       focus:outline-none focus:ring-2 focus:ring-lime-400"
            />

            <div class="border rounded-xl overflow-hidden">
                <div class="bg-lime-300 px-6 py-3 grid grid-cols-12 text-sm font-semibold text-black">
                    <div class="col-span-1">NO</div>
                    <div class="col-span-3">DUKCAPIL ASAL</div>
                    <div class="col-span-2">NOMOR SURAT</div>
                    <div class="col-span-2 text-center">JENIS</div>
                    <div class="col-span-2 text-center">TANGGAL</div>
                    <div class="col-span-2 text-center">AKSI</div>
                </div>

                <div
                    id="listPerluDibalas"
                    class="max-h-[400px] overflow-y-auto divide-y">
                </div>
            </div>
        </div>

        <!-- ================= SELESAI ================= -->
        <div class="bg-white rounded-2xl p-8">

            <h3 class="text-lg font-semibold text-gray-800">Selesai</h3>
            <p class="text-sm text-gray-500 mb-6">Data telah selesai diproses</p>

            <input
                id="searchSelesai"
                type="text"
                placeholder="Cari dukcapil / nomor surat..."
                class="mb-4 w-full border border-gray-300 rounded-lg px-4 py-2 text-black text-sm
                       focus:outline-none focus:ring-2 focus:ring-lime-400"
            />

            <div class="border rounded-xl overflow-hidden">
                <div class="bg-lime-300 px-6 py-3 grid grid-cols-12 text-sm font-semibold text-black">
                    <div class="col-span-1">NO</div>
                    <div class="col-span-3">DUKCAPIL ASAL</div>
                    <div class="col-span-2">NOMOR SURAT</div>
                    <div class="col-span-2 text-center">JENIS</div>
                    <div class="col-span-2 text-center">TANGGAL</div>
                    <div class="col-span-2 text-center">AKSI</div>
                </div>

                <div
                    id="listSelesai"
                    class="max-h-[400px] overflow-y-auto divide-y">
                </div>
            </div>
        </div>

    </div>
</x-layout_penerbitan_kakot>