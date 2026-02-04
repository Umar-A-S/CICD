document.addEventListener('DOMContentLoaded', () => {
    
    // Fetch Data JSON hanya untuk Provinsi & Kota Tujuan
    fetch('/data/kota_kabupaten.json')
        .then(res => res.json())
        .then(data => {
            
            // ================= DAERAH TUJUAN (PROVINSI -> KAB/KOTA) =================
            const wilayahSelect = document.getElementById('wilayah');
            const provSelect = document.getElementById('provinsi');
            const kabSelect  = document.getElementById('kabkota');
            const provWrapper = document.getElementById('provinsiWrapper');

            // Fungsi Helper: Reset & Inisialisasi Jawa Tengah
            function initializeJatengCities() {
                // Set Provinsi ke Jawa Tengah (Lock)
                provSelect.innerHTML = '';
                const opt = document.createElement('option');
                opt.value = 'Jawa Tengah';
                opt.textContent = 'Jawa Tengah';
                opt.selected = true;
                provSelect.appendChild(opt);

                // Isi kabupaten/kota Jawa Tengah
                if (data['Jawa Tengah']) {
                    kabSelect.innerHTML = '';
                    kabSelect.disabled = false; // Pastikan aktif
                    
                    const placeholder = document.createElement('option');
                    placeholder.value = '';
                    placeholder.textContent = 'Pilih Kabupaten/Kota';
                    placeholder.disabled = true;
                    placeholder.selected = true;
                    kabSelect.appendChild(placeholder);

                    data['Jawa Tengah']
                        .sort((a, b) => a.localeCompare(b, 'id'))
                        .forEach(kab => {
                            const opt = document.createElement('option');
                            opt.value = kab;
                            opt.textContent = kab;
                            kabSelect.appendChild(opt);
                        });
                }
            }

            // --- LOGIC UTAMA ---

            // 1. Saat Halaman Baru Dimuat (Default)
            // Cek apakah user sudah memilih sesuatu (misal setelah refresh/error validation)
            if(wilayahSelect.value === 'dalam') {
                provWrapper.classList.remove('hidden');
                initializeJatengCities();
            } else if (wilayahSelect.value === 'luar') {
                provWrapper.classList.remove('hidden');
                loadAllProvinces();
            } else {
                // Jika belum pilih apa-apa, sembunyikan dropdown provinsi/kota (Opsional, biar rapi)
                // provWrapper.classList.add('hidden'); 
                // Atau biarkan default (kosong)
            }

            // 2. Saat User Mengganti Pilihan "Wilayah Tujuan"
            wilayahSelect.addEventListener('change', () => {
                provWrapper.classList.remove('hidden'); // Pastikan wrapper muncul

                if (wilayahSelect.value === 'dalam') {
                    // Logic Dalam Daerah: Lock Provinsi Jateng & Load Kotanya
                    initializeJatengCities();

                } else if (wilayahSelect.value === 'luar') {
                    // Logic Luar Daerah: Load Semua Provinsi
                    loadAllProvinces();
                }
            });

            // Fungsi Helper: Load Semua Provinsi (Untuk Luar Daerah)
            function loadAllProvinces() {
                provSelect.innerHTML = '';
                kabSelect.innerHTML = '<option value="" disabled selected>Pilih Provinsi Dulu</option>';
                kabSelect.disabled = true; // Disable kab/kota sampai provinsi dipilih
                
                const placeholder = document.createElement('option');
                placeholder.value = '';
                placeholder.textContent = 'Pilih Provinsi';
                placeholder.disabled = true;
                placeholder.selected = true;
                provSelect.appendChild(placeholder);

                Object.keys(data)
                    .sort((a, b) => a.localeCompare(b, 'id'))
                    .forEach(prov => {

                        const opt = document.createElement('option');
                        opt.value = prov;
                        opt.textContent = prov;
                        provSelect.appendChild(opt);
                    });
            }

            // 3. Saat User Mengganti Provinsi (Khusus Luar Daerah)
            provSelect.addEventListener('change', () => {
                const provinsiDipilih = provSelect.value;
                if (!provinsiDipilih) return;

                kabSelect.innerHTML = '';
                kabSelect.disabled = false;

                // placeholder
                const placeholder = document.createElement('option');
                placeholder.value = '';
                placeholder.textContent = 'Pilih Kabupaten/Kota';
                placeholder.disabled = true;
                placeholder.selected = true;
                kabSelect.appendChild(placeholder);

                // isi kab/kota sesuai provinsi
                if (data[provinsiDipilih]) {
                    data[provinsiDipilih]
                        .sort((a, b) => a.localeCompare(b, 'id'))
                        .forEach(kab => {
                            const opt = document.createElement('option');
                            opt.value = kab;
                            opt.textContent = kab;
                            kabSelect.appendChild(opt);
                        });
                }
            });
        })
        .catch(err => console.error('Gagal memuat data wilayah:', err));
});

//================= UPLOAD FILE PREVIEW (TIDAK PERLU DIUBAH) =================
document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('fileUpload');
    const filePreview = document.getElementById('filePreview'); 

    if (fileInput && filePreview) {
        fileInput.addEventListener('change', () => {
            filePreview.innerHTML = ''; 
            const file = fileInput.files[0];

            if (file) {
                if (file.size > 10 * 1024 * 1024) {
                    alert(`Ukuran file terlalu besar (max 10MB). Ukuran file: ${(file.size / 1024 / 1024).toFixed(2)} MB`);
                    fileInput.value = ''; 
                    return;
                }
                if (!file.type.includes('pdf')) {
                    alert('Hanya file PDF yang diterima');
                    fileInput.value = ''; 
                    return;
                }
                const wrapper = document.createElement('div');
                wrapper.className = 'flex items-center justify-between bg-lime-50 rounded-lg p-3 border border-lime-200';
                const info = document.createElement('div');
                info.className = 'flex items-center gap-3';
                info.innerHTML = `
                    <div class="w-8 h-8 bg-lime-100 rounded flex items-center justify-center text-lime-600">
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
                removeBtn.innerHTML = '<i class="fa-solid fa-xmark text-lg"></i>';
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