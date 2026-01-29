/* ================= DATA ================= */
let submissions = [
    { id: 1, nama: 'Asep Yono Joyo', nomor_surat: '23115655431234', jenis: 'LEGALISIR', date: '20-11-2025', status: 'pending' },
    { id: 2, nama: 'Asep', nomor_surat: '23115655431235', jenis: 'MUTASI', date: '24-11-2025', status: 'valid' },
    { id: 3, nama: 'Asep', nomor_surat: '23115655431236', jenis: 'KEABSAHAN', date: '22-11-2025', status: 'rejected' },
    { id: 4, nama: 'Asep', nomor_surat: '23115655431237', jenis: 'LEGALISIR', date: '21-11-2025', status: 'success' }
];

let currentStatus = 'all';

/* ================= STATUS BADGE ================= */
function statusBadge(status) {
    const map = {
        pending: ['BELUM', 'bg-yellow-100 text-yellow-700'],
        valid: ['DIPROSES', 'bg-blue-100 text-blue-700'],
        rejected: ['DITOLAK', 'bg-red-100 text-red-700'],
        success: ['SELESAI', 'bg-green-100 text-green-700']
    };

    return `<span class="px-3 py-1 rounded-full text-xs font-bold ${map[status][1]}">${map[status][0]}</span>`;
}

/* ================= DASHBOARD ================= */
function updateDashboard() {
    document.getElementById('stat-total').innerText = submissions.length;
    document.getElementById('stat-pending').innerText = submissions.filter(i => i.status === 'pending').length;
    document.getElementById('stat-valid').innerText = submissions.filter(i => i.status === 'valid').length;
    document.getElementById('stat-success').innerText = submissions.filter(i => i.status === 'success').length;
    document.getElementById('stat-rejected').innerText = submissions.filter(i => i.status === 'rejected').length;
}

/* ================= RENDER TABLE ================= */
function renderTable() {
    const tbody = document.getElementById('tableKotaKabupaten');
    const keyword = document.getElementById('searchInput').value.toLowerCase();

    let data = submissions.filter(item => {
        const matchStatus = currentStatus === 'all' || item.status === currentStatus;
        const matchSearch =
            item.nama.toLowerCase().includes(keyword) ||
            item.nomor_surat.includes(keyword);
        return matchStatus && matchSearch;
    });

    tbody.innerHTML = '';

    if (!data.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="py-6 text-center text-gray-400">
                    Data tidak ditemukan
                </td>
            </tr>
        `;
        return;
    }

    data.forEach((item, index) => {
        tbody.innerHTML += `
            <tr class="${index % 2 ? 'bg-lime-100/60' : ''}">
                <td class="px-4 py-3 text-center font-semibold">${index + 1}</td>
                <td class="px-4 py-3">${item.nama}</td>
                <td class="px-4 py-3 text-xs">${item.nomor_surat}</td>
                <td class="px-4 py-3 text-xs font-semibold">${item.jenis}</td>
                <td class="px-4 py-3 text-xs">${item.date}</td>
                <td class="px-4 py-3 text-center">${statusBadge(item.status)}</td>
                <td class="px-4 py-3 text-center">
                    <button
                        onclick="openDetail(${item.id})"
                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-full text-xs font-semibold">
                        DETAIL
                    </button>
                </td>
            </tr>
        `;
    });
}

/* ================= FILTER ================= */
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        currentStatus = btn.dataset.status;
        renderTable();
    });
});

/* ================= SEARCH ================= */
document.getElementById('searchInput').addEventListener('input', renderTable);

/* ================= DETAIL ================= */
function openDetail(id) {
    window.location.href = `/detail_permohonan-kota/${id}`;
}

/* ================= INIT ================= */
updateDashboard();
renderTable();