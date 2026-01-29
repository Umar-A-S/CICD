// ================= DATA DUMMY =================
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('nama').value = 'Agus';
    document.getElementById('asal').value = 'Kota Semarang';

    // FIELD BARU
    document.getElementById('tglPermohonan').value = '2026-01-15';
    document.getElementById('noSurat').value = '470/123/2026';
    document.getElementById('noSuratSelesai').value = '470/123-A/2026';
});

// ================= ACTION =================
function goBack() {
    window.location.href = '/permohonan-kota';
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

        const allowed = ['application/pdf', 'image/jpeg', 'image/png'];
        if (!allowed.includes(file.type)) {
            alert(`Format tidak valid: ${file.name}`);
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert(`Ukuran file > 2MB: ${file.name}`);
            return;
        }

        if (selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
            return;
        }

        selectedFiles.push(file);

        const wrapper = document.createElement('div');
        wrapper.className =
            'flex items-center justify-between bg-gray-100 rounded-lg p-3 border';

        wrapper.innerHTML = `
            <div>
                <p class="text-sm font-semibold">${file.name}</p>
                <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(1)} KB</p>
            </div>
            <div class="flex gap-2">
                <button class="text-xs bg-sky-500 text-white px-3 py-1 rounded">Review</button>
                <button class="text-xs bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
            </div>
        `;

        const [reviewBtn, deleteBtn] = wrapper.querySelectorAll('button');

        reviewBtn.onclick = () => window.open(URL.createObjectURL(file), '_blank');
        deleteBtn.onclick = () => {
            selectedFiles = selectedFiles.filter(f => f !== file);
            wrapper.remove();
        };

        filePreview.appendChild(wrapper);
    });

    fileInput.value = '';
});

// ================= DAERAH TUJUAN (DALAM / LUAR DAERAH) =================
const wilayahSelect = document.getElementById('wilayah');
const provSelect    = document.getElementById('provinsi');
const kabSelect     = document.getElementById('kabkota');
const provWrapper   = document.getElementById('provinsiWrapper');

let dataWilayah = {};

// default
provWrapper.style.display = 'none';
kabSelect.disabled = true;

fetch('/data/kota_kabupaten.json')
    .then(res => res.json())
    .then(data => {
        dataWilayah = data;

        // isi provinsi (LUAR DAERAH SAJA, TANPA JAWA TENGAH)
        Object.keys(data)
            .filter(p => p !== 'Jawa Tengah')
            .sort((a, b) => a.localeCompare(b, 'id'))
            .forEach(prov => {
                const opt = document.createElement('option');
                opt.value = prov;
                opt.textContent = prov;
                provSelect.appendChild(opt);
            });
    });

// pilih wilayah
wilayahSelect.addEventListener('change', () => {
    kabSelect.innerHTML = `<option disabled selected>Pilih Kabupaten/Kota</option>`;
    kabSelect.disabled = false;

    if (wilayahSelect.value === 'dalam') {
        // DALAM DAERAH
        provWrapper.style.display = 'none';

        dataWilayah['Jawa Tengah']
            .sort((a, b) => a.localeCompare(b, 'id'))
            .forEach(kab => {
                const opt = document.createElement('option');
                opt.value = kab;
                opt.textContent = kab;
                kabSelect.appendChild(opt);
            });

    } else {
        // LUAR DAERAH
        provWrapper.style.display = 'block';
        kabSelect.disabled = true;
        provSelect.selectedIndex = 0;
    }
});

// pilih provinsi (LUAR DAERAH)
provSelect.addEventListener('change', () => {
    kabSelect.innerHTML = `<option disabled selected>Pilih Kabupaten/Kota</option>`;
    kabSelect.disabled = false;

    dataWilayah[provSelect.value]
        .sort((a, b) => a.localeCompare(b, 'id'))
        .forEach(kab => {
            const opt = document.createElement('option');
            opt.value = kab;
            opt.textContent = kab;
            kabSelect.appendChild(opt);
        });
});

// ================= SIDEBAR =================
const sidebar = document.getElementById('sidebar');
const toggleBtn = document.getElementById('toggleSidebar');

toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('-translate-x-full');
});