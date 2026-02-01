<x-layout_unggah_penerbitan>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="bg-gray-100 min-h-screen py-10 px-6">

        <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-md px-12 py-12">

            <form method="POST" action="{{ route('penerbitanprov.store') }}" enctype="multipart/form-data">
                @csrf
                
                <input type="hidden" name="permohonan_id" value="{{ $permohonan->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-20">

                    <div class="space-y-14">

                        <section>
                            <h2 class="text-lg font-extrabold tracking-wide mb-8 text-gray-800">
                                IDENTITAS
                            </h2>

                            <div class="space-y-5">
                                <div>
                                    <label class="text-xs font-bold uppercase text-gray-600">Nama Subjek</label>
                                    <input type="text" value="{{ $permohonan->nama_subjek }}" disabled
                                        class="w-full mt-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase text-gray-600">Daerah Asal</label>
                                    <input type="text" value="{{ $permohonan->daerah_asal }}" disabled
                                        class="w-full mt-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase text-gray-600">Wilayah Tujuan</label>
                                    <input type="text" value="{{ $permohonan->wilayah }}" disabled
                                        class="w-full mt-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase text-gray-600">Daerah Tujuan</label>
                                    <div class="space-y-2 mt-1">
                                        <input type="text" value="{{ $permohonan->wilayah_tujuan }}" disabled
                                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                        <input type="text" value="{{ $permohonan->daerah_tujuan }}" disabled
                                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase text-gray-600">Jenis Permohonan</label>
                                    <input type="text" value="{{ $permohonan->jenis_permohonan }}" disabled
                                        class="w-full mt-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase text-gray-600">Jenis Dokumen</label>
                                    <input type="text" value="{{ $permohonan->jenis_dokumen }}" disabled
                                        class="w-full mt-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                </div>
                            </div>
                        </section>

                        <section>
                            <h2 class="text-lg font-extrabold tracking-wide mb-8 text-gray-800">
                                PENERBITAN
                            </h2>

                            <div class="space-y-5">
                                <div>
                                    <label class="text-xs font-bold uppercase text-gray-600">Nomor Surat Masuk</label>
                                    <input type="text" value="{{ $permohonan->nomor_surat }}" disabled
                                        class="w-full mt-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                                </div>
                                
                                <div>
                                    <label class="text-xs font-bold uppercase text-gray-600">
                                        Nomor Surat Selesai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="nomor_surat_selesai" required
                                        placeholder="Masukkan Nomor Surat Balasan" 
                                        class="w-full mt-1 bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                                </div>
                                
                                <div>
                                    <label class="text-xs font-bold uppercase text-gray-600">
                                        Tanggal Selesai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="tanggal_surat_selesai" required
                                        class="w-full mt-1 bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                                </div>

                            </div>
                        </section>
                    </div>

                    <div>
                        <h2 class="text-lg font-extrabold tracking-wide mb-8 text-gray-800">
                            HASIL PEMERIKSAAN
                        </h2>

                        <div class="space-y-5">

                            <div>
                                <label class="text-xs font-bold uppercase text-gray-600">
                                    Hasil <span class="text-red-500">*</span>
                                </label>
                                <select name="hasil" required
                                    class="w-full mt-1 bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                                    <option disabled selected value="">Pilih Hasil Pemeriksaan</option>
                                    <option value="TERCATAT">TERCATAT</option>
                                    <option value="TIDAK TERCATAT">TIDAK TERCATAT</option>
                                    <option value="DISETUJUI">DISETUJUI</option>
                                    <option value="DITOLAK">DITOLAK</option>
                                    <option value="LAINNYA">LAINNYA</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-xs font-bold uppercase text-gray-600">
                                    Keterangan / Alasan <span class="text-red-500">*</span>
                                </label>
                                <textarea name="alasan" required rows="4"
                                    placeholder="Masukkan keterangan atau alasan..."
                                    class="w-full mt-1 bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500"></textarea>
                            </div>

                            <div>
                                <label class="text-xs font-bold uppercase text-gray-600">
                                    Unggah Berkas Balasan <span class="text-red-500">*</span>
                                </label>

                                <label for="fileUpload"
                                    class="mt-3 cursor-pointer flex flex-col items-center justify-center
                                    border-2 border-dashed border-sky-400 rounded-2xl h-40
                                    hover:bg-sky-50 transition relative">

                                    <i class="fa-solid fa-cloud-arrow-up text-sky-500 text-4xl mb-2"></i>
                                    <span class="text-sm font-semibold text-gray-700">
                                        Klik untuk upload PDF
                                    </span>

                                    <input id="fileUpload" name="file_balasan" type="file" class="hidden" accept=".pdf" required>
                                </label>

                                <div id="filePreview" class="mt-4 space-y-3"></div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-16 pt-6 border-t border-gray-200">
                    <a href="{{ route('penerbitanprov.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold px-8 py-3 rounded-xl shadow-sm transition">
                        BATAL
                    </a>

                    <button type="submit"
                        class="bg-sky-500 hover:bg-sky-600 text-white font-bold px-10 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition">
                        KIRIM BALASAN
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.getElementById('fileUpload');
            const filePreview = document.getElementById('filePreview'); 

            if (fileInput && filePreview) {
                fileInput.addEventListener('change', () => {
                    filePreview.innerHTML = ''; 
                    const file = fileInput.files[0];

                    if (file) {
                        // Validasi Size
                        if (file.size > 10 * 1024 * 1024) {
                            alert(`Ukuran file terlalu besar (max 10MB).`);
                            fileInput.value = '';
                            return;
                        }

                        // Validasi Tipe
                        if (!file.type.includes('pdf')) {
                            alert('Hanya file PDF yang diterima');
                            fileInput.value = '';
                            return;
                        }

                        // Preview HTML
                        const wrapper = document.createElement('div');
                        wrapper.className = 'flex items-center justify-between bg-sky-50 rounded-lg p-3 border border-sky-200';

                        const info = document.createElement('div');
                        info.className = 'flex items-center gap-3';
                        info.innerHTML = `
                            <div class="w-8 h-8 bg-sky-100 rounded flex items-center justify-center text-sky-600">
                                <i class="fa-solid fa-file-pdf"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">${file.name}</p>
                                <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(1)} KB</p>
                            </div>
                        `;

                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.className = 'text-red-400 hover:text-red-600 transition p-2';
                        removeBtn.innerHTML = '<i class="fa-solid fa-xmark"></i>';
                        
                        removeBtn.addEventListener('click', () => {
                            fileInput.value = '';
                            filePreview.innerHTML = '';
                        });

                        wrapper.appendChild(info);
                        wrapper.appendChild(removeBtn);
                        filePreview.appendChild(wrapper);
                    }
                });
            }
        });
    </script>
</x-layout_unggah_penerbitan>