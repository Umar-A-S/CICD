document.addEventListener('DOMContentLoaded', () => {
    // ================= DAERAH ASAL (JAWA TENGAH) =================
    fetch('/data/kota_kabupaten.json')
        .then(res => res.json())
        .then(data => {
            const daerahAsalSelect = document.getElementById('daerahAsal');
            
            // Populate Daerah Asal dengan kota/kabupaten Jawa Tengah
            if (data['Jawa Tengah']) {
                data['Jawa Tengah']
                    .sort((a, b) => a.localeCompare(b, 'id'))
                    .forEach(daerah => {
                        const opt = document.createElement('option');
                        opt.value = daerah;
                        opt.textContent = daerah;
                        daerahAsalSelect.appendChild(opt);
                    });
            }

            // ================= DAERAH TUJUAN (PROVINSI -> KAB/KOTA) =================
            const wilayahSelect = document.getElementById('wilayah');
            const provSelect = document.getElementById('provinsi');
            const kabSelect  = document.getElementById('kabkota');

            // Default: tampilkan provinsi Jawa Tengah saat load
            initializeJatengCities();

            // Saat wilayah dipilih
            wilayahSelect.addEventListener('change', () => {
                if (wilayahSelect.value === 'dalam') {
                    // Dalam daerah: tampilkan Jawa Tengah
                    document.getElementById('provinsiWrapper').classList.remove('hidden');
                    initializeJatengCities();
                } else if (wilayahSelect.value === 'luar') {
                    // Luar daerah: tampilkan semua provinsi
                    document.getElementById('provinsiWrapper').classList.remove('hidden');
                    provSelect.innerHTML = '';
                    
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
            });

            // Fungsi helper: inisialisasi Jawa Tengah
            function initializeJatengCities() {
                provSelect.innerHTML = '';
                
                const opt = document.createElement('option');
                opt.value = 'Jawa Tengah';
                opt.textContent = 'Jawa Tengah';
                opt.selected = true;
                provSelect.appendChild(opt);

                // Isi kabupaten/kota Jawa Tengah
                if (data['Jawa Tengah']) {
                    kabSelect.innerHTML = '';
                    
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

            // Saat provinsi dipilih
            provSelect.addEventListener('change', () => {
                const provinsiDipilih = provSelect.value;

                kabSelect.innerHTML = '';
                kabSelect.disabled = false;

                // placeholder
                const placeholder = document.createElement('option');
                placeholder.value = '';
                placeholder.textContent = 'Pilih Kab/Kota';
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

// ================= UPLOAD FILE PREVIEW =================
const fileInput = document.getElementById('fileUpload');
const filePreview = document.getElementById('filePreview'); 

if (fileInput && filePreview) {
    fileInput.addEventListener('change', () => {
        filePreview.innerHTML = ''; 
        const file = fileInput.files[0];

        if (file) {
            // Validasi sederhana di sisi klien
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

            // ===== PREVIEW =====
            const wrapper = document.createElement('div');
            wrapper.className = 'flex items-center justify-between bg-gray-100 rounded-lg p-3 border';

            const info = document.createElement('div');
            info.innerHTML = `
                <p class="text-sm font-semibold">${file.name}</p>
                <p class="text-xs text-gray-500">
                    ${(file.size / 1024).toFixed(1)} KB
                </p>
            `;

            wrapper.appendChild(info);
            filePreview.appendChild(wrapper);
        }
    });
}

// ================= FORM SUBMISSION =================


// ================= NAVIGATION =================
function goBack() {
    window.history.back();
}
