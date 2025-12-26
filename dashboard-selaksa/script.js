// Data Dummy
let submissions = [
    { id: 1, date: '2025-01-20', nik: '3302150001880001', nama: 'Budi Santoso', status: 'pending', note: '-' },
    { id: 2, date: '2025-01-21', nik: '3302150002880002', nama: 'Siti Aminah', status: 'valid', note: 'Menunggu Penerbitan' },
    { id: 3, date: '2025-01-22', nik: '3302150003880003', nama: 'Joko Widodo', status: 'rejected', note: 'Scan KTP Buram' }
];

// === NAVIGASI ===
function switchMenu(menuName) {
    document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
    document.getElementById('nav-' + menuName).classList.add('active');

    document.getElementById('view-dashboard').classList.add('hidden-section');
    document.getElementById('view-arsip').classList.add('hidden-section');
    document.getElementById('view-pengaturan').classList.add('hidden-section');
    
    document.getElementById('view-' + menuName).classList.remove('hidden-section');
}

// === ROLE SWITCHER ===
function switchRole() {
    const role = document.getElementById('roleSelector').value;
    const labels = {
        'domisili': 'Petugas Domisili',
        'provinsi': 'Admin Provinsi',
        'penerbit': 'Petugas Penerbit'
    };
    
    document.getElementById('userRoleLabel').innerText = labels[role];
    document.getElementById('role-domisili').classList.add('hidden-section');
    document.getElementById('role-provinsi').classList.add('hidden-section');
    document.getElementById('role-penerbit').classList.add('hidden-section');
    document.getElementById('role-' + role).classList.remove('hidden-section');
    refreshData();
}

// === ACTION LOGIC ===
function submitData(e) {
    e.preventDefault();
    const nik = document.getElementById('inputNIK').value;
    const nama = document.getElementById('inputNama').value;
    
    submissions.unshift({
        id: Date.now(),
        date: new Date().toISOString().split('T')[0],
        nik: nik,
        nama: nama,
        status: 'pending',
        note: '-'
    });

    document.getElementById('formInput').reset();
    showToast('Data permohonan berhasil dikirim!');
    refreshData();
}

function verifAction(id, action) {
    const item = submissions.find(i => i.id === id);
    if (!item) return;

    if (action === 'valid') {
        item.status = 'valid';
        item.note = 'Terverifikasi oleh Provinsi';
        showToast('Berkas divalidasi. Dikirim ke Penerbit.');
    } else {
        let reason = prompt("Masukkan alasan penolakan:", "Dokumen tidak lengkap");
        if (!reason) return;
        item.status = 'rejected';
        item.note = reason;
        showToast('Berkas ditolak. Dikembalikan ke Domisili.', 'error');
    }
    refreshData();
}

function issueDoc(id) {
    if(confirm('Terbitkan dokumen resmi sekarang?')) {
        const item = submissions.find(i => i.id === id);
        item.status = 'completed';
        item.note = 'Dokumen Telah Terbit';
        showToast('Dokumen berhasil diterbitkan!', 'success');
        refreshData();
    }
}

// === RENDER TABLES (UPDATED FOR DARK MODE) ===
function refreshData() {
    renderStats();
    renderTableDomisili();
    renderTableProvinsi();
    renderTablePenerbit();
}

function renderStats() {
    document.getElementById('stat-total').innerText = submissions.length;
    document.getElementById('stat-pending').innerText = submissions.filter(i => i.status === 'pending').length;
    document.getElementById('stat-success').innerText = submissions.filter(i => i.status === 'completed').length;
    document.getElementById('stat-reject').innerText = submissions.filter(i => i.status === 'rejected').length;
}

function renderTableDomisili() {
    const tbody = document.getElementById('tableDomisili');
    tbody.innerHTML = '';
    submissions.forEach(item => {
        let statusBadge = '';
        if(item.status === 'pending') statusBadge = '<span class="bg-yellow-500/20 text-yellow-300 border border-yellow-500/30 px-2 py-1 rounded text-xs font-bold">MENUNGGU</span>';
        else if(item.status === 'valid') statusBadge = '<span class="bg-blue-500/20 text-blue-300 border border-blue-500/30 px-2 py-1 rounded text-xs font-bold">DIPROSES</span>';
        else if(item.status === 'rejected') statusBadge = '<span class="bg-red-500/20 text-red-300 border border-red-500/30 px-2 py-1 rounded text-xs font-bold">DITOLAK</span>';
        else statusBadge = '<span class="bg-green-500/20 text-green-300 border border-green-500/30 px-2 py-1 rounded text-xs font-bold">SELESAI</span>';

        // Perubahan class: text-slate-300, hover:bg-white/5
        tbody.innerHTML += `
            <tr class="hover:bg-white/5 transition border-b border-white/10">
                <td class="px-6 py-4">
                    <div class="font-bold text-slate-200">${item.nama}</div>
                    <div class="text-xs font-mono text-slate-500">${item.nik}</div>
                </td>
                <td class="px-6 py-4 text-xs text-slate-400">${item.date}</td>
                <td class="px-6 py-4">${statusBadge}</td>
                <td class="px-6 py-4 text-xs italic text-slate-500">${item.note}</td>
            </tr>
        `;
    });
}

function renderTableProvinsi() {
    const tbody = document.getElementById('tableProvinsi');
    tbody.innerHTML = '';
    const data = submissions.filter(i => i.status === 'pending');
    
    if(data.length === 0) tbody.innerHTML = '<tr><td colspan="4" class="p-6 text-center text-slate-500 italic">Tidak ada antrean baru.</td></tr>';

    data.forEach(item => {
        tbody.innerHTML += `
            <tr class="hover:bg-white/5 transition border-b border-white/10">
                <td class="px-6 py-4 text-xs text-slate-400">${item.date}</td>
                <td class="px-6 py-4 font-medium text-slate-200">${item.nama}<br><span class="text-xs font-normal text-slate-500">${item.nik}</span></td>
                <td class="px-6 py-4">
                    <button onclick="openModal()" class="text-blue-400 hover:text-blue-300 text-xs font-bold flex items-center gap-1">
                        <i class="fa-solid fa-file-pdf"></i> Lihat Berkas
                    </button>
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center gap-2">
                        <button onclick="verifAction(${item.id}, 'valid')" class="w-8 h-8 rounded bg-green-500/20 text-green-400 hover:bg-green-500/40"><i class="fa-solid fa-check"></i></button>
                        <button onclick="verifAction(${item.id}, 'rejected')" class="w-8 h-8 rounded bg-red-500/20 text-red-400 hover:bg-red-500/40"><i class="fa-solid fa-times"></i></button>
                    </div>
                </td>
            </tr>
        `;
    });
}

function renderTablePenerbit() {
    const tbody = document.getElementById('tablePenerbit');
    tbody.innerHTML = '';
    const data = submissions.filter(i => i.status === 'valid');

    if(data.length === 0) tbody.innerHTML = '<tr><td colspan="4" class="p-6 text-center text-slate-500 italic">Belum ada data validasi masuk.</td></tr>';

    data.forEach(item => {
        tbody.innerHTML += `
            <tr class="hover:bg-white/5 transition border-b border-white/10">
                <td class="px-6 py-4 font-mono text-xs text-slate-400">${item.nik}</td>
                <td class="px-6 py-4 font-bold text-slate-200">${item.nama}</td>
                <td class="px-6 py-4"><span class="text-green-400 text-xs flex items-center gap-1"><i class="fa-solid fa-check-circle"></i> Data Valid (SIAK)</span></td>
                <td class="px-6 py-4 text-right">
                    <button onclick="issueDoc(${item.id})" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-indigo-500 shadow-lg shadow-indigo-500/30 transition">
                        <i class="fa-solid fa-print mr-1"></i> Terbitkan
                    </button>
                </td>
            </tr>
        `;
    });
}

function openModal() {
    const modal = document.getElementById('modalDoc');
    const content = document.getElementById('modalContent');
    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeModal() {
    const modal = document.getElementById('modalDoc');
    const content = document.getElementById('modalContent');
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    document.getElementById('toastMsg').innerText = message;
    
    toast.classList.remove('translate-y-20', 'opacity-0');
    setTimeout(() => {
        toast.classList.add('translate-y-20', 'opacity-0');
    }, 3000);
}

// INIT
refreshData();
switchMenu('dashboard');