<x-layout_balasan_kakot>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="max-w-7xl mx-auto bg-white p-6 rounded-2xl shadow">

    <!-- SCROLL CONTAINER -->
    <div class="max-h-[420px] overflow-y-auto">

        <table class="w-full table-fixed">
            
            <!-- HEADER -->
            <thead class="sticky top-0 z-10">
                <tr class="bg-lime-300 text-black text-sm font-semibold uppercase">
                    <th class="px-6 py-4 text-left w-[18%]">Nama</th>
                    <th class="px-6 py-4 text-left w-[22%]">Nomor Surat/Akta</th>
                    <th class="px-6 py-4 text-left w-[16%]">Jenis</th>
                    <th class="px-6 py-4 text-left w-[14%]">Tanggal</th>
                    <th class="px-6 py-4 text-center w-[12%]">Hasil</th>
                    <th class="px-6 py-4 text-center w-[18%]">Aksi</th>
                </tr>
            </thead>

            <!-- BODY -->
            <tbody id="balasanBody" class="divide-y divide-gray-100"></tbody>

        </table>

    </div>
</div>

</x-layout_balasan_kakot>