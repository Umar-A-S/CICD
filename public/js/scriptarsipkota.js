// ================= MASTER DATA (DUMMY) =================
const submissions = [
    {
        id: 1,
        nama: 'Asep Yono Joyo',
        nik: '231156554131234',
        jenis: 'LEGALISIR',
        date: '20-11-2025',
        status: 'completed',
    },
    {
        id: 2,
        nama: 'Asep',
        nik: '231156554131234',
        jenis: 'MUTASI',
        date: '24-11-2025',
        status: 'rejected',
    },
    {
        id: 3,
        nama: 'Asep',
        nik: '231156554131234',
        jenis: 'KEABSAHAN',
        date: '24-11-2025',
        status: 'rejected',
    },
    {
        id: 4,
        nama: 'Asep',
        nik: '231156554131234',
        jenis: 'LEGALISIR',
        date: '24-11-2025',
        status: 'completed',
    }
];

// ================= STATE =================
let currentFilter = 'all';

// ================= STATUS UTIL =================
function statusText(status) {
    return status === 'completed' ? 'SELESAI' : 'DITOLAK';
}

function statusClass(status) {
    return status === 'completed'
        ? 'text-green-600 font-semibold'
        : 'text-red-600 font-semibold';
}

// ================= RENDER TABLE (HALAMAN LIST) =================
function renderTable(data) {
    const tbody = document.getElementById('tableKotaKabupaten');
    if (!tbody) return;

    tbody.innerHTML = '';

    if (!data.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-6 text-center text-gray-400">
                    Data tidak ditemukan
                </td>
            </tr>
        `;
        return;
    }

    data.forEach(item => {
        tbody.innerHTML += `
            <tr class="border-b even:bg-lime-50">
                <td class="px-6 py-4">${item.nama}</td>
                <td class="px-6 py-4">${item.nik}</td>
                <td class="px-6 py-4 uppercase">${item.jenis}</td>
                <td class="px-6 py-4">${item.date}</td>
                <td class="px-6 py-4 ${statusClass(item.status)}">
                    ${statusText(item.status)}
                </td>
                <td class="px-6 py-4">
                    <button
                        onclick="openDetail(${item.id})"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded-full text-xs">
                        DETAIL
                    </button>
                </td>
            </tr>
        `;
    });
}

// ================= SEARCH + FILTER =================
function applyFilter() {
    const input = document.getElementById('searchInput');
    if (!input) return;

    const keyword = input.value.toLowerCase();

    let filtered = submissions.filter(item =>
        item.nama.toLowerCase().includes(keyword) ||
        item.nik.includes(keyword)
    );

    if (currentFilter !== 'all') {
        filtered = filtered.filter(item => item.status === currentFilter);
    }

    renderTable(filtered);
}

function filterStatus(status, el) {
    currentFilter = status;

    document.querySelectorAll('.filter-btn')
        .forEach(btn => btn.classList.remove('active'));

    if (el) el.classList.add('active');

    applyFilter();
}

// ================= NAVIGATE DETAIL =================
function openDetail(id) {
    window.location.href = `/detailarsip-kota/${id}`;
}

// ================= UTIL =================
function setVal(id, value) {
    const el = document.getElementById(id);
    if (!el) return;
    el.value = value ?? '-';
}

// ================= INIT =================
document.addEventListener('DOMContentLoaded', () => {
    // halaman list
    renderTable(submissions);

    const search = document.getElementById('searchInput');
    if (search) search.addEventListener('input', applyFilter);

    // halaman detail
    loadDetail();
});