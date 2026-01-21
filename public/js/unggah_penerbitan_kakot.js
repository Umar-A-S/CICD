// ================= DATA DUMMY =================
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('nama').value = 'Asep';
    document.getElementById('asal').value = 'Semarang';
    document.getElementById('tglSelesai').value = '2026-01-20';
});

// ================= ACTION =================
function goBack() {
    window.history.back();
}

function kirim() {
    alert('Data berhasil dikirim (dummy)');
}

// ================= UPLOAD MULTI FILE =================
const fileInput   = document.getElementById('fileUpload');
const filePreview = document.getElementById('filePreview');

let selectedFiles = [];

fileInput.addEventListener('change', () => {
    const files = Array.from(fileInput.files);

    files.forEach(file => {

        // validasi format
        const allowed = ['application/pdf', 'image/jpeg', 'image/png'];
        if (!allowed.includes(file.type)) {
            alert(`Format tidak valid: ${file.name}`);
            return;
        }

        // validasi ukuran (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert(`Ukuran file > 2MB: ${file.name}`);
            return;
        }

        // cegah file dobel
        if (selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
            return;
        }

        selectedFiles.push(file);

        // ===== PREVIEW =====
        const wrapper = document.createElement('div');
        wrapper.className =
            'flex items-center justify-between bg-gray-100 rounded-lg p-3 border';

        const info = document.createElement('div');
        info.innerHTML = `
            <p class="text-sm font-semibold">${file.name}</p>
            <p class="text-xs text-gray-500">
                ${(file.size / 1024).toFixed(1)} KB
            </p>
        `;

        const actions = document.createElement('div');
        actions.className = 'flex gap-2';

        // review
        const reviewBtn = document.createElement('button');
        reviewBtn.className = 'text-xs bg-sky-500 text-white px-3 py-1 rounded';
        reviewBtn.innerText = 'Review';
        reviewBtn.onclick = () => {
            window.open(URL.createObjectURL(file), '_blank');
        };

        // hapus
        const deleteBtn = document.createElement('button');
        deleteBtn.className = 'text-xs bg-red-500 text-white px-3 py-1 rounded';
        deleteBtn.innerText = 'Hapus';
        deleteBtn.onclick = () => {
            selectedFiles = selectedFiles.filter(f => f !== file);
            wrapper.remove();
        };

        actions.appendChild(reviewBtn);
        actions.appendChild(deleteBtn);

        wrapper.appendChild(info);
        wrapper.appendChild(actions);
        filePreview.appendChild(wrapper);
    });

    // reset supaya file yang sama bisa dipilih lagi
    fileInput.value = '';
});

// ================= DAERAH TUJUAN (PROVINSI -> KAB/KOTA) =================
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
    });