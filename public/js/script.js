// ================= DATA =================
let submissions = [
    { id: 1, date: '2025-01-20', nik: '3302150001880001', nama: 'Budi Santoso', status: 'pending', note: 'Menunggu Verifikasi', files: [] },
    { id: 2, date: '2025-01-21', nik: '3302150002880002', nama: 'Siti Aminah', status: 'valid', note: 'Sedang Diproses Provinsi', files: [] },
    { id: 3, date: '2025-01-22', nik: '3302150003880003', nama: 'Bambang Pamungkas', status: 'rejected', note: 'Scan KTP Buram', files: [] },
    { id: 4, date: '2025-01-23', nik: '3302150003880004', nama: 'Riski Ridho', status: 'completed', note: 'Dokumen Telah Terbit', files: [] }
];

let uploadedFiles = [];
let currentViewFiles = [];

// ================= STATUS UTIL =================
function getStatusLabel(status) {
    return {
        pending: 'MENUNGGU',
        valid: 'DIPROSES',
        rejected: 'DITOLAK',
        completed: 'SELESAI'
    }[status];
}

function getStatusBadge(status) {
    return {
        pending: 'bg-yellow-400/20 text-yellow-600 border-yellow-400/30',
        valid: 'bg-blue-400/20 text-blue-600 border-blue-400/30',
        rejected: 'bg-red-400/20 text-red-600 border-red-400/30',
        completed: 'bg-green-400/20 text-green-600 border-green-400/30'
    }[status];
}

function getStatusNote(status) {
    return {
        pending: 'Menunggu Verifikasi',
        valid: 'Sedang Diproses Provinsi',
        rejected: 'Pengajuan Ditolak',
        completed: 'Dokumen Telah Terbit'
    }[status];
}

// ================= DASHBOARD COUNTER =================
function updateDashboardCounter() {
    document.getElementById('stat-total').innerText = submissions.length;
    document.getElementById('stat-pending').innerText = submissions.filter(s => s.status === 'pending').length;
    document.getElementById('stat-valid').innerText = submissions.filter(s => s.status === 'valid').length;
    document.getElementById('stat-success').innerText = submissions.filter(s => s.status === 'completed').length;
    document.getElementById('stat-reject').innerText = submissions.filter(s => s.status === 'rejected').length;
}

// ================= SUBMIT =================
function submitData(e) {
    e.preventDefault();

    submissions.unshift({
        id: Date.now(),
        date: new Date().toISOString().split('T')[0],
        nik: inputNIK.value,
        nama: inputNama.value,
        status: 'pending',
        note: getStatusNote('pending'),
        files: [...uploadedFiles] // SIMPAN METADATA FILE
    });

    uploadedFiles = [];
    document.getElementById('fileList').innerHTML = '';
    document.getElementById('uploadPlaceholder').classList.remove('hidden');
    document.getElementById('btnAddFile').classList.add('hidden');

    document.getElementById('formInput').reset();
    showToast('Data permohonan berhasil dikirim!');
    refreshData();
}

// ================= UPLOAD FILE =================
function addFile() {
    document.getElementById('inputBerkas').click();
}

function handleFile(input) {
    const files = Array.from(input.files);
    if (!files.length) return;

    files.forEach(file => {
        if (file.size > 50 * 1024 * 1024) {
            alert(`File ${file.name} melebihi 50 MB`);
            return;
        }

        uploadedFiles.push({
            file: file,
            name: file.name,
            size: file.size,
            type: file.type,
            url: URL.createObjectURL(file)
        });
    });

    input.value = '';
    renderFiles();
}

function renderFiles() {
    const list = document.getElementById('fileList');
    const placeholder = document.getElementById('uploadPlaceholder');
    const btnAdd = document.getElementById('btnAddFile');

    list.innerHTML = '';

    uploadedFiles.forEach((item, index) => {
        const isImage = item.type.startsWith('image');
        const sizeKB = (item.size / 1024).toFixed(1);

        list.innerHTML += `
            <div class="flex items-center justify-between bg-white/70 rounded-lg p-4">
                <div class="flex items-center gap-3 max-w-[80%]">
                    <i class="fa-solid ${isImage ? 'fa-image text-sky-500' : 'fa-file-pdf text-red-500'} text-xl"></i>
                    <div class="flex flex-col overflow-hidden">
                        <span class="text-sm font-semibold truncate cursor-pointer"
                            title="${item.name}"
                            onclick="window.open('${item.url}','_blank')">
                            ${item.name}
                        </span>
                        <span class="text-xs text-black/50">${sizeKB} KB</span>
                    </div>
                </div>
                <button onclick="removeFile(${index})" class="text-red-500 hover:text-red-700">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        `;
    });

    placeholder.classList.toggle('hidden', uploadedFiles.length > 0);
    btnAdd.classList.toggle('hidden', uploadedFiles.length === 0);
}

function removeFile(index) {
    uploadedFiles.splice(index, 1);
    renderFiles();
}

// ================= TABLE =================
function refreshData() {
    renderTableKotaKabupaten();
    updateDashboardCounter();
}

function renderTableKotaKabupaten() {
    const tbody = document.getElementById('tableKotaKabupaten');
    tbody.innerHTML = '';

    submissions.forEach(item => {
        tbody.innerHTML += `
            <tr class="border-b">
                <td class="px-6 py-4">
                    <div class="font-bold">${item.nama}</div>
                    <div class="text-xs text-black/50">${item.nik}</div>
                </td>
                <td class="px-6 py-4 text-xs">${item.date}</td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1 rounded border text-xs font-bold ${getStatusBadge(item.status)}">
                        ${getStatusLabel(item.status)}
                    </span>
                </td>
                <td class="px-6 py-4 text-xs italic">${item.note}</td>
            </tr>
        `;
    });
}

// ================= TOAST =================
function showToast(msg) {
    const toast = document.getElementById('toast');
    document.getElementById('toastMsg').innerText = msg;

    toast.classList.remove('translate-y-20', 'opacity-0');
    setTimeout(() => {
        toast.classList.add('translate-y-20', 'opacity-0');
    }, 3000);
}

// ================= INIT (FIX DOM READY) =================
document.addEventListener('DOMContentLoaded', () => {
    refreshData();
});