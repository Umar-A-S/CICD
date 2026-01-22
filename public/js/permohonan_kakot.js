document.addEventListener('DOMContentLoaded', () => {
    // ================= DAERAH TUJUAN (PROVINSI -> KAB/KOTA) =================
    // Tetap dipertahankan karena ini logika UI yang bagus
    fetch('/data/kota_kabupaten.json')
        .then(res => res.json())
        .then(data => {

            const provSelect = document.getElementById('provinsi');
            const kabSelect  = document.getElementById('kabkota');

            // isi provinsi
            Object.keys(data)
                .sort((a, b) => a.localeCompare(b, 'id'))
                .forEach(prov => {
                    const opt = document.createElement('option');
                    opt.value = prov;
                    opt.textContent = prov;
                    provSelect.appendChild(opt);
                });

            // saat provinsi dipilih
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
                data[provinsiDipilih]
                    .sort((a, b) => a.localeCompare(b, 'id'))
                    .forEach(kab => {
                        const opt = document.createElement('option');
                        opt.value = kab;
                        opt.textContent = kab;
                        kabSelect.appendChild(opt);
                    });
            });
        })
        .catch(err => console.error('Gagal memuat data wilayah:', err));
});

// ================= UPLOAD MULTI FILE (Preview UI) =================
// Bagian ini juga dipertahankan agar user bisa melihat file yang dipilih
const fileInput = document.querySelector('input[name="file_upload"]');
// Pastikan elemen preview ada di blade nanti, kalau tidak ada kode ini aman dicuekin browser
const filePreview = document.getElementById('filePreview'); 

if (fileInput && filePreview) {
    let selectedFiles = [];

    fileInput.addEventListener('change', () => {
        // Reset preview container setiap kali pilih file baru (untuk single file upload)
        filePreview.innerHTML = ''; 
        const files = Array.from(fileInput.files);

        files.forEach(file => {
            // Validasi sederhana di sisi klien (opsional, server juga akan validasi)
            if (file.size > 2 * 1024 * 1024) {
                alert(`Ukuran file > 2MB: ${file.name}`);
                return;
            }

            // ===== PREVIEW =====
            const wrapper = document.createElement('div');
            wrapper.className = 'flex items-center justify-between bg-gray-100 rounded-lg p-3 border mt-2';

            const info = document.createElement('div');
            info.innerHTML = `
                <p class="text-sm font-semibold">${file.name}</p>
                <p class="text-xs text-gray-500">
                    ${(file.size / 1024).toFixed(1)} KB
                </p>
            `;

            wrapper.appendChild(info);
            filePreview.appendChild(wrapper);
        });
    });
}