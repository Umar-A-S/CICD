<x-layout_superadmin>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- BREADCRUMB -->
    <div class="mb-6">
        <a href="{{ route('superadmin.permohonan.index') }}" class="text-lime-500 hover:text-lime-600 font-semibold text-sm flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Monitor Permohonan
        </a>
    </div>

    <!-- READ-ONLY BADGE -->
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-lg">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-eye text-yellow-600 text-xl"></i>
            <div>
                <p class="font-bold text-yellow-800">Mode Monitor (Read-Only)</p>
                <p class="text-sm text-yellow-700">Anda hanya dapat melihat informasi. Tidak dapat melakukan verifikasi atau penerbitan.</p>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- LEFT COLUMN - Permohonan Details -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Header Card -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">Detail Permohonan</h3>
                        <code class="text-sm bg-gray-100 px-3 py-1 rounded mt-2 inline-block">{{ $permohonan->nomor_surat }}</code>
                    </div>
                    <span class="px-4 py-2 rounded-full text-sm font-bold
                        @if ($permohonan->status === 'BELUM') bg-yellow-100 text-yellow-800
                        @elseif ($permohonan->status === 'DIPROSES') bg-blue-100 text-blue-800
                        @elseif ($permohonan->status === 'SELESAI') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ $permohonan->status }}
                    </span>
                </div>
            </div>

            <!-- Data Permohonan -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-file-lines text-lime-500"></i>
                    Informasi Permohonan
                </h4>
                
                <div class="space-y-4">
                    <div class="border-b pb-3">
                        <p class="text-xs text-gray-500 uppercase font-semibold">Daerah Asal</p>
                        <p class="text-lg font-bold text-gray-800 mt-1">{{ $permohonan->daerah_asal }}</p>
                    </div>

                    <div class="border-b pb-3">
                        <p class="text-xs text-gray-500 uppercase font-semibold">Jenis Wilayah</p>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-bold mt-1
                            {{ $permohonan->wilayah === 'dalam' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                            {{ ucfirst($permohonan->wilayah) }} Wilayah
                        </span>
                    </div>

                    @if ($permohonan->wilayah === 'dalam')
                        <div class="border-b pb-3">
                            <p class="text-xs text-gray-500 uppercase font-semibold">Daerah Tujuan</p>
                            <p class="text-lg font-bold text-gray-800 mt-1">{{ $permohonan->daerah_tujuan }}</p>
                        </div>
                    @endif

                    <div class="border-b pb-3">
                        <p class="text-xs text-gray-500 uppercase font-semibold">Nama Pemohon</p>
                        <p class="text-lg text-gray-800 mt-1">{{ $permohonan->nama_subjek }}</p>
                    </div>

                    <div class="border-b pb-3">
                        <p class="text-xs text-gray-500 uppercase font-semibold">Jenis Dokumen</p>
                        <p class="text-lg text-gray-800 mt-1">{{ $permohonan->jenis_dokumen }}</p>
                    </div>

                    <div class="border-b pb-3">
                        <p class="text-xs text-gray-500 uppercase font-semibold">Jenis Permohonan</p>
                        <p class="text-gray-700 mt-1">{{ $permohonan->jenis_permohonan ?? '-' }}</p>
                    </div>

                    @if ($permohonan->catatan)
                        <div class="border-b pb-3">
                            <p class="text-xs text-gray-500 uppercase font-semibold">Catatan</p>
                            <div class="bg-blue-50 p-3 rounded-lg mt-2">
                                <p class="text-gray-700">{{ $permohonan->catatan }}</p>
                            </div>
                        </div>
                    @endif

                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Tanggal Dibuat</p>
                        <p class="text-gray-700 mt-1">{{ $permohonan->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- File Permohonan -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-paperclip text-lime-500"></i>
                    File Permohonan
                </h4>
                
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                    <div class="bg-red-100 rounded-lg p-3">
                        <i class="fa-solid fa-file-pdf text-red-600 text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">Dokumen Permohonan</p>
                        <p class="text-sm text-gray-500">{{ basename($permohonan->file_path) }}</p>
                    </div>
                    <a href="{{ route('superadmin.permohonan.download', $permohonan->id) }}" 
                        class="bg-lime-400 hover:bg-lime-500 text-black px-4 py-2 rounded-lg font-bold transition">
                        <i class="fa-solid fa-download"></i> Download
                    </a>
                </div>
            </div>

            <!-- Penerbitan (if exists) -->
            @if ($penerbitan)
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-file-circle-check text-lime-500"></i>
                        Informasi Penerbitan
                    </h4>
                    
                    <div class="space-y-4">
                        <div class="border-b pb-3">
                            <p class="text-xs text-gray-500 uppercase font-semibold">No. Penerbitan</p>
                            <code class="text-sm bg-gray-100 px-3 py-1 rounded mt-1 inline-block">{{ $penerbitan->nomor_surat_selesai }}</code>
                        </div>

                        <div class="border-b pb-3">
                            <p class="text-xs text-gray-500 uppercase font-semibold">Tanggal Terbit</p>
                            <p class="text-gray-700 mt-1">{{ \Carbon\Carbon::parse($penerbitan->tanggal_surat_selesai)->format('d M Y') }}</p>
                        </div>

                        <div class="border-b pb-3">
                            <p class="text-xs text-gray-500 uppercase font-semibold">Hasil Verifikasi</p>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-bold mt-1
                                {{ $penerbitan->hasil === 'SAH' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $penerbitan->hasil }}
                            </span>
                        </div>

                        @if ($permohonan->catatan)
                            <div class="border-b pb-3">
                                <p class="text-xs text-gray-500 uppercase font-semibold">Keterangan/Alasan</p>
                                <div class="bg-red-50 p-3 rounded-lg mt-2">
                                    <p class="text-gray-700">{{ $permohonan->catatan }}</p>
                                </div>
                            </div>
                        @endif

                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold mb-2">File Penerbitan</p>
                            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                                <div class="bg-green-100 rounded-lg p-3">
                                    <i class="fa-solid fa-file-pdf text-green-600 text-2xl"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">Surat Penerbitan</p>
                                    <p class="text-sm text-gray-500">{{ basename($penerbitan->file_path) }}</p>
                                </div>
                                <a href="{{ route('superadmin.penerbitan.download', $penerbitan->id) }}" 
                                    class="bg-lime-400 hover:bg-lime-500 text-black px-4 py-2 rounded-lg font-bold transition">
                                    <i class="fa-solid fa-download"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <!-- RIGHT COLUMN - Timeline & Actions -->
        <div class="space-y-6">
            
            <!-- Quick Info Card -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h4 class="text-lg font-bold text-gray-800 mb-4">Info Cepat</h4>
                
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-sm">
                        <i class="fa-solid fa-user text-gray-400"></i>
                        <span class="text-gray-600">Dibuat oleh:</span>
                        <span class="font-semibold text-gray-800">{{ $permohonan->user->name }}</span>
                    </div>
                    
                    <div class="flex items-center gap-3 text-sm">
                        <i class="fa-solid fa-clock text-gray-400"></i>
                        <span class="text-gray-600">Tanggal:</span>
                        <span class="font-semibold text-gray-800">{{ $permohonan->created_at->format('d M Y') }}</span>
                    </div>

                    <div class="flex items-center gap-3 text-sm">
                        <i class="fa-solid fa-hourglass text-gray-400"></i>
                        <span class="text-gray-600">Umur:</span>
                        <span class="font-semibold text-gray-800">{{ $permohonan->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h4 class="text-lg font-bold text-gray-800 mb-4">Aksi</h4>
                
                <div class="space-y-3">
                    <a href="{{ route('superadmin.permohonan.download', $permohonan->id) }}" 
                        class="w-full flex items-center justify-center gap-2 bg-lime-400 hover:bg-lime-500 text-black px-4 py-3 rounded-lg font-bold transition">
                        <i class="fa-solid fa-download"></i>
                        Download File
                    </a>

                    @if ($penerbitan)
                        <a href="{{ route('superadmin.penerbitan.download', $penerbitan->id) }}" 
                            class="w-full flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-lg font-bold transition">
                            <i class="fa-solid fa-file-pdf"></i>
                            Download Penerbitan
                        </a>
                    @endif

                    <a href="{{ route('superadmin.permohonan.index') }}" 
                        class="w-full flex items-center justify-center gap-2 bg-gray-300 hover:bg-gray-400 text-black px-4 py-3 rounded-lg font-bold transition">
                        <i class="fa-solid fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>

        </div>

    </div>

</x-layout_superadmin>
