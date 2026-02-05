
/* ================= NAVIGASI ================= */
function detail(id) {
    // Halaman detail penerbitan
    window.location.href = `/detail-penerbitan-kota/${id}`;
}

function balas(id) {
    // HALAMAN UNGGAH PENERBITAN
    window.location.href = `/unggah-penerbitan-kota/${id}`;
}

/* ================= INIT ================= */
document.addEventListener('DOMContentLoaded', () => {
    renderPenerbitan();
    updateTotalPermohonan();
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