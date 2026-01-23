<x-layout_balasan_kakot>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="max-w-7xl mx-auto bg-white p-6 rounded-2xl shadow space-y-4">

        <!-- SEARCH -->
        <input
            id="searchBalasan"
            type="text"
            placeholder="Cari nama / nomor surat / jenis..."
            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm text-black
                focus:outline-none focus:ring-2 focus:ring-lime-400"
        />

        <!-- SCROLL CONTAINER -->
        <div class="max-h-[420px] overflow-y-auto">

            <table class="w-full table-fixed">

                <!-- HEADER -->
                <thead class="sticky top-0 z-10">
                    <tr class="bg-lime-300 text-black text-sm font-semibold uppercase">
                        <th class="px-6 py-4 text-left w-[6%]">No</th>
                        <th class="px-6 py-4 text-left w-[18%]">Nama</th>
                        <th class="px-6 py-4 text-left w-[22%]">Nomor Surat/Akta</th>
                        <th class="px-6 py-4 text-left w-[16%]">Jenis</th>
                        <th class="px-6 py-4 text-left w-[14%]">Tanggal</th>
                        <th class="px-6 py-4 text-center w-[12%]">Hasil</th>
                        <th class="px-6 py-4 text-center w-[12%]">Aksi</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody id="balasanBody" class="divide-y divide-gray-100"></tbody>

            </table>

        </div>
    </div>
</x-layout_balasan_kakot>