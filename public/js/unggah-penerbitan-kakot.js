// document.addEventListener('DOMContentLoaded', () => {
//     // ================= DAERAH TUJUAN (PROVINSI -> KAB/KOTA) =================
//     fetch('/data/kota_kabupaten.json')
//         .then(res => res.json())
//         .then(data => {
//             const provSelect = document.getElementById('provinsi');
//             const kabSelect  = document.getElementById('kabkota');

//             if(provSelect && kabSelect) {
//                 Object.keys(data).sort().forEach(prov => {
//                     const opt = document.createElement('option');
//                     opt.value = prov;
//                     opt.textContent = prov;
//                     provSelect.appendChild(opt);
//                 });

//                 provSelect.addEventListener('change', () => {
//                     const provinsiDipilih = provSelect.value;
//                     kabSelect.innerHTML = '';
//                     kabSelect.disabled = false;
                    
//                     const placeholder = document.createElement('option');
//                     placeholder.text = 'Pilih Kab/Kota';
//                     placeholder.disabled = true; 
//                     placeholder.selected = true;
//                     kabSelect.appendChild(placeholder);

//                     data[provinsiDipilih].sort().forEach(kab => {
//                         const opt = document.createElement('option');
//                         opt.value = kab;
//                         opt.textContent = kab;
//                         kabSelect.appendChild(opt);
//                     });
//                 });
//             }
//         });
// });

// ================= NAVIGATION =================
function goBack() {
    window.history.back();
}

//================= UPLOAD FILE PREVIEW =================
document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('fileUpload');
    const filePreview = document.getElementById('filePreview'); 

    if (fileInput && filePreview) {
        fileInput.addEventListener('change', () => {
            // Bersihkan preview lama tiap kali user pilih file baru
            filePreview.innerHTML = ''; 
            const file = fileInput.files[0];

            if (file) {
                // 1. Validasi Ukuran (Max 10MB)
                if (file.size > 10 * 1024 * 1024) {
                    alert(`Ukuran file terlalu besar (max 10MB). Ukuran file: ${(file.size / 1024 / 1024).toFixed(2)} MB`);
                    fileInput.value = ''; // Reset input
                    return;
                }

                // 2. Validasi Tipe (PDF Only)
                if (!file.type.includes('pdf')) {
                    alert('Hanya file PDF yang diterima');
                    fileInput.value = ''; // Reset input
                    return;
                }

                // 3. Render HTML Preview
                const wrapper = document.createElement('div');
                wrapper.className = 'flex items-center justify-between bg-lime-50 rounded-lg p-3 border border-lime-200';

                // Bagian Info File
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

                // Bagian Tombol Hapus (X)
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button'; // Penting biar gak submit form
                removeBtn.className = 'text-red-400 hover:text-red-600 transition p-2';
                removeBtn.innerHTML = '<i class="fa-solid fa-xmark text-lg"></i>';
                
                // Logic Hapus File
                removeBtn.addEventListener('click', () => {
                    fileInput.value = ''; // Kosongkan input file asli
                    filePreview.innerHTML = ''; // Hapus tampilan preview
                });

                // Gabungkan elemen
                wrapper.appendChild(info);
                wrapper.appendChild(removeBtn);
                filePreview.appendChild(wrapper);
            }
        });
    }
});