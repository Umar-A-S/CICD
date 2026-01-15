<x-layoutpenerbitkota>
    <x-slot:title>{{ $title }}</x-slot:title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">

        <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-800">
                Penerbitan Dokumen
            </h3>
            <p class="text-sm text-gray-500 mt-1">
                Data valid siap cetak dan distribusi
            </p>
        </div>

        <div class="bg-[#D4F575] rounded-t-lg grid grid-cols-12 gap-4 px-6 py-4 text-xs font-bold text-gray-700 uppercase tracking-wider text-center items-center">
            <div class="col-span-3 text-left">Nama</div>
            <div class="col-span-3 text-left">NIK</div>
            <div class="col-span-2">Jenis Permohonan</div>
            <div class="col-span-2">Tgl Pengajuan</div>
            <div class="col-span-2">Aksi</div>
        </div>

        <div id="penerbitanList" class="flex flex-col">
            </div>

    </div>

</x-layoutpenerbitkota>