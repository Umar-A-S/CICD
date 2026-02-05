<x-layout-profil-prov >
    <x-slot:title>{{ $title }}</x-slot:title>
    <body class="bg-gray-100 min-h-screen flex items-start justify-center py-12">

        <!-- CARD -->
        <div class="w-full bg-white rounded-2xl px-8 py-6 shadow-sm">

            <h2 class="text-sm font-semibold text-gray-700 mb-6">
                Profil Instansi
            </h2>

            <!-- Nama Instansi -->
            <div class="mb-5">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">
                    Nama Instansi
                </label>
                <input
                    id="namaInstansi"
                    value="{{ $user->name }}"
                    disabled
                    class="w-full bg-gray-50 rounded-xl px-5 py-3
                        text-sm text-gray-700 border border-gray-100">
            </div>

            <!-- Kode Wilayah -->
            <div>
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">
                    Kode Wilayah
                </label>
                <input
                    id="kodeWilayah"
                    value=""
                    disabled
                    class="w-full bg-gray-50 rounded-xl px-5 py-3
                        text-sm text-gray-700 border border-gray-100">
            </div>
        </div>
    </body>
</x-layout-profil-prov>