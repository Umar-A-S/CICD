// ================= MASTER DATA (DUMMY) =================
const submissions = [
    {
        id: 1,
        daerah_asal: 'Kab. Semarang',
        nomor_surat: '08.006/ITS/III/2023',
        tanggal_submit: '20-11-2025',
        daerah_tujuan_kab: 'Kota Semarang',
        daerah_tujuan_prov: 'Jawa Tengah',
        jenis: 'LEGALISIR',
        date: '20-11-2025',
        nama_subjek: 'DALAM JATENG',
        berkas: 'legalisir.pdf'
    },
    {
        id: 2,
        daerah_asal: 'Kab. Semarang',
        nomor_surat: '08.006/ITS/III/2023',
        tanggal_submit: '24-11-2025',
        daerah_tujuan_kab: 'Kota Semarang',
        daerah_tujuan_prov: 'Jawa Tengah',
        jenis: 'MUTASI',
        date: '24-11-2025',
        nama_subjek: 'DALAM JATENG',
        berkas: 'mutasi.pdf'
    },
    {
        id: 3,
        daerah_asal: 'Kab. Semarang',
        nomor_surat: '08.006/ITS/III/2023',
        tanggal_submit: '24-11-2025',
        daerah_tujuan_kab: 'Kota Semarang',
        daerah_tujuan_prov: 'Jawa Tengah',
        jenis: 'KEABSAHAN',
        date: '24-11-2025',
        nama_subjek: 'DALAM JATENG',
        berkas: 'keabsahan.pdf'
    },
    {
        id: 4,
        daerah_asal: 'Kab. Semarang',
        nomor_surat: '08.006/ITS/III/2023',
        tanggal_submit: '24-11-2025',
        daerah_tujuan_kab: 'Kota Semarang',
        daerah_tujuan_prov: 'Jawa Tengah',
        jenis: 'LEGALISIR',
        date: '24-11-2025',
        nama_subjek: 'DALAM JATENG',
        berkas: 'legalisir.pdf'
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

// ================= DETAIL PAGE =================
function loadDetail() {
    console.log('LOAD DETAIL DIPANGGIL');

    if (!window.location.pathname.includes('detailarsip-kota')) return;

    const id = parseInt(window.location.pathname.split('/').pop());
    console.log('ID:', id);

    const data = submissions.find(item => item.id === id);
    console.log('DATA:', data);

    if (!data) {
        alert('Data arsip tidak ditemukan');
        return;
    }

    setVal('daerahasal', data.daerah_asal);
    setVal('nomorsurat', data.nomor_surat);
    setVal('tanggalsubmit', data.tanggal_submit);
    setVal('kabtujuan', data.daerah_tujuan_kab);
    setVal('provtujuan', data.daerah_tujuan_prov);
    setVal('jenispermohonan', data.jenis);
    setVal('tanggalpermohonan', data.date);
    setVal('namasubjek', data.nama_subjek);

    const link = document.getElementById('linkberkas');
    if (link) link.href = `/berkas/${data.berkas}`;
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