<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    
    <!-- ================= TABLE ================= -->
                    <div class="lg:col-span-2">
                        <div class="glass-panel rounded-xl overflow-hidden">

                            <div class="p-4 border-b border-white/10 bg-white/5">
                                <h3 class="font-bold text-black">Status Pengajuan Terkini</h3>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm text-black">
                                    <thead class="bg-lime-400 text-xs font-bold uppercase">
                                        <tr>
                                            <th class="px-6 py-3">NIK & Nama</th>
                                            <th class="px-6 py-3">Tanggal</th>
                                            <th class="px-6 py-3">Status</th>
                                            <th class="px-6 py-3">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableKotaKabupaten"></tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
        <!-- ================= MODAL LIHAT BERKAS ================= -->
    <div id="modalDoc"
        class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50">

        <div class="bg-white rounded-xl w-full max-w-lg p-6 relative">

            <button onclick="closeModal()"
                class="absolute top-3 right-3 text-red-500">
                <i class="fa-solid fa-times"></i>
            </button>

            <h3 class="font-bold mb-4 flex items-center gap-2">
                <i class="fa-solid fa-folder-open text-sky-500"></i>
                Berkas Permohonan
            </h3>

            <div id="modalFiles" class="space-y-4 max-h-[60vh] overflow-auto"></div>
        </div>
    </div>

    <!-- ================= TOAST ================= -->
    <div id="toast"
        class="fixed bottom-6 right-6 bg-black text-white px-4 py-3 rounded-lg shadow-lg translate-y-20 opacity-0 transition">
        <span id="toastMsg"></span>
</x-layout>