// ================= 1. DATA DUMMY (LENGKAP DENGAN LINK AKTIF) =================
const dbPenerbitan = [
    {
        id: 1,
        nama: 'Asep Yono Joyo',
        jenis: 'LEGALISIR',
        no_surat: '8637/B/20222',
        nik: '231156554131234',
        tgl_submit: '28-09-2026',
        asal: 'Kota Semarang',
        files: [
            // URL ini adalah contoh PDF asli dari internet agar bisa dibuka
            { name: '1. FILE-KK-ASEP.PDF', url: 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf' },
            { name: '2. FILE-KTP-ASEP.PDF', url: 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf' }
        ]
    },
    {
        id: 2,
        nama: 'Budi Santoso',
        jenis: 'MUTASI',
        no_surat: '9921/M/2025',
        nik: '3301123456789',
        tgl_submit: '24-11-2025',
        asal: 'Kab. Boyolali',
        files: [
            { name: '1. SURAT-PINDAH.PDF', url: 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf' }
        ]
    }
];

// ================= 2. FUNGSI UTAMA (INIT) =================
document.addEventListener('DOMContentLoaded', () => {
    console.log("Jalan: Script Upload Dimulai...");
    
    // 1. Jalankan Load Data
    loadData();

    // 2. Setup Listener untuk Input File
    const fileInput = document.getElementById('fileInput');
    if(fileInput) {
        fileInput.addEventListener('change', handleFileSelect);
    }

    // setup upload button state
    const uploadBtn = document.getElementById('uploadBtn');
    if (uploadBtn) uploadBtn.disabled = true;
});

// ================= 3. LOGIKA LOAD DATA =================
function loadData() {
    // Ambil ID dari URL (contoh: /upload/1)
    const path = window.location.pathname;
    const parts = path.split('/');
    let id = parseInt(parts[parts.length - 1]);

    // FALLBACK: Jika URL tidak ada angka ID, PAKSA pakai ID 1
    // Ini solusi agar form tidak pernah kosong
    if (isNaN(id)) {
        console.warn("ID tidak ditemukan diURL. Menggunakan Default ID 1.");
        id = 1; 
    }

    console.log("Mencari data untuk ID:", id);

    // Cari data di database dummy
    let data = dbPenerbitan.find(item => item.id == id);
    
    // Jika tidak ketemu, pakai data pertama
    if (!data) data = dbPenerbitan[0];

    // Isi Form HTML
    setValue('nama', data.nama);
    setValue('jenis', data.jenis);
    setValue('nosurat', data.no_surat);
    setValue('nik', data.nik);
    setValue('tglsubmit', data.tgl_submit);
    setValue('asal', data.asal);

    // Render List Berkas
    renderFiles(data.files);
}

// Helper untuk mengisi value input
function setValue(id, val) {
    const el = document.getElementById(id);
    if(el) el.value = val;
}

// Helper untuk menampilkan list file
function renderFiles(files) {
    const container = document.getElementById('fileList');
    if(!container) return;

    container.innerHTML = ''; // Kosongkan dulu

    if(!files || files.length === 0) {
        container.innerHTML = '<span class="text-gray-400">Tidak ada berkas lampiran.</span>';
        return;
    }

    files.forEach(file => {
        container.innerHTML += `
            <div class="flex items-center gap-2 mb-1 group" data-name="${file.name}">
                <span class="text-sky-500 font-bold text-xs">=</span>
                <a href="${file.url}" target="_blank" 
                   class="text-sky-500 hover:text-sky-700 hover:underline text-sm font-bold uppercase transition mr-3">
                   ${file.name} <i class="fa-solid fa-arrow-up-right-from-square text-xs ml-1 opacity-50 group-hover:opacity-100"></i>
                </a>
                <button onclick="deleteUploadedFile('${file.name}')" class="text-red-500 text-xs font-bold uppercase">Hapus</button>
            </div>
        `;
    });
}

// ================= 4. LOGIKA UPLOAD & INTERAKSI UI =================

// Trigger klik input file (saat kotak besar diklik)
function triggerUpload() {
    document.getElementById('fileInput').click();
}

// Saat user memilih file dari komputernya
function handleFileSelect(event) {
    const input = event.target;
    if (input.files && input.files.length > 0) {
        const file = input.files[0];
        
        // Tampilkan nama file yang dipilih
        document.getElementById('selectedFileName').innerText = file.name;
        
        // Ubah tampilan: Sembunyikan kotak upload, Munculkan preview hijau
        document.getElementById('dropZoneArea').classList.add('hidden');
        document.getElementById('filePreviewContainer').classList.remove('hidden');

        // Show preview for images; for pdf provide preview link
        const previewArea = document.getElementById('previewArea');
        if (previewArea) previewArea.innerHTML = '';
        const blobUrl = URL.createObjectURL(file);
        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = blobUrl;
            img.className = 'max-h-40 rounded-md';
            if (previewArea) previewArea.appendChild(img);
        } else if (file.type === 'application/pdf') {
            const a = document.createElement('a');
            a.href = blobUrl;
            a.target = '_blank';
            a.className = 'text-sky-600 underline font-bold text-sm';
            a.innerText = 'Lihat preview PDF';
            if (previewArea) previewArea.appendChild(a);
        } else {
            if (previewArea) previewArea.innerText = 'Preview tidak tersedia untuk tipe file ini.';
        }

        // enable upload button
        const uploadBtn = document.getElementById('uploadBtn');
        if (uploadBtn) uploadBtn.disabled = false;
    }
}

// Reset pilihan file (tombol Hapus)
function resetFile() {
    const input = document.getElementById('fileInput');
    input.value = ''; // Reset input
    
    // Kembalikan tampilan ke awal
    const drop = document.getElementById('dropZoneArea');
    const previewContainer = document.getElementById('filePreviewContainer');
    if (drop) drop.classList.remove('hidden');
    if (previewContainer) previewContainer.classList.add('hidden');
    const previewArea = document.getElementById('previewArea');
    if (previewArea) previewArea.innerHTML = '';

    const uploadBtn = document.getElementById('uploadBtn');
    if (uploadBtn) uploadBtn.disabled = true;
}

// Tombol Upload Balasan diklik
function simpanBalasan() {
    const input = document.getElementById('fileInput');
    
    // Validasi: Cek apakah file sudah dipilih
    if (!input.files || input.files.length === 0) {
        alert("PERINGATAN:\nSilakan pilih berkas PDF atau Gambar terlebih dahulu!");
        return;
    }

    const file = input.files[0];

    // Build FormData
    const form = new FormData();
    form.append('file', file);

    // ID dari URL
    const parts = window.location.pathname.split('/');
    let id = parts[parts.length - 1];

    const uploadUrl = `/unggah-bapr/upload/${id}`;

    // CSRF token
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    const token = tokenMeta ? tokenMeta.getAttribute('content') : '';

    fetch(uploadUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        body: form
    })
    .then(r => r.json())
    .then(data => {
        if (data && data.success) {
            // setelah upload sukses, tambahkan ke daftar berkas pemohon via API list atau langsung redirect ke detail
            const parts = window.location.pathname.split('/');
            let id = parts[parts.length - 1];

            // Optional: langsung redirect ke halaman detail agar file muncul di bagian berkas pemohon
            // atau redirect ke halaman balasan sesuai permintaan
            // arahkan ke halaman balasan
            window.location.href = '/balasan-kota';
        } else {
            alert('Gagal mengunggah: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan saat mengunggah berkas. Cek console.');
    });
}

// Hapus file yang sudah diunggah
function deleteUploadedFile(name) {
    if (!confirm('Hapus berkas "' + name + '" ?')) return;

    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    const token = tokenMeta ? tokenMeta.getAttribute('content') : '';

    // ID dari URL
    const parts = window.location.pathname.split('/');
    let id = parts[parts.length - 1];

    fetch('/unggah-bapr/delete', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ name, id })
    })
    .then(r => r.json())
    .then(data => {
        if (data && data.success) {
            // remove element from list
            const el = document.querySelector(`#fileList [data-name="${name}"]`);
            if (el) el.remove();
            alert('Berkas dihapus.');
        } else {
            alert('Gagal menghapus berkas.');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan saat menghapus berkas.');
    });
}