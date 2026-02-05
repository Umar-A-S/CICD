document.addEventListener('DOMContentLoaded', () => {

    /* ================= DATA DUMMY ================= */
    const data = [
        { id: 1, nama: 'Asep Yono Joyo', nomor: '08.006/ITS/III/2025', jenis: 'LEGALISIR', tanggal: '20-11-2025', status: 'tercatat' },
        { id: 2, nama: 'Asep', nomor: '08.006/ITS/III/2025', jenis: 'MUTASI', tanggal: '24-11-2025', status: 'tidak_tercatat' },
        { id: 3, nama: 'Asep', nomor: '231156554131234', jenis: 'KEABSAHAN', tanggal: '24-11-2025', status: 'disetujui' },
        { id: 4, nama: 'Asep', nomor: '231156554131234', jenis: 'LEGALISIR', tanggal: '24-11-2025', status: 'ditolak' },
        { id: 5, nama: 'Asep', nomor: '231156554131234', jenis: 'MUTASI', tanggal: '24-11-2025', status: 'lainnya' },
    ];

    const tbody = document.getElementById('balasanBody');
    const searchInput = document.getElementById('searchBalasan');

    if (!tbody) return;

    /* ================= RENDER ================= */
    function renderTable(keyword = '') {
        tbody.innerHTML = '';

        const filtered = data.filter(item =>
            item.nama.toLowerCase().includes(keyword) ||
            item.nomor.toLowerCase().includes(keyword) ||
            item.jenis.toLowerCase().includes(keyword)
        );

        if (filtered.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-400 text-sm">
                        Data tidak ditemukan
                    </td>
                </tr>`;
            return;
        }

        filtered.forEach((item, index) => {
            const bgRow = index % 2 === 0 ? 'bg-white' : 'bg-lime-50';

            const tr = document.createElement('tr');
            tr.className = bgRow;

            tr.innerHTML = `
                <td class="px-6 py-4 text-sm font-semibold text-gray-800">
                    ${index + 1}
                </td>

                <td class="px-6 py-4 text-sm font-semibold text-gray-800">
                    ${item.nama}
                </td>

                <td class="px-6 py-4 text-sm text-gray-700 truncate">
                    ${item.nomor}
                </td>

                <td class="px-6 py-4 text-sm text-gray-700">
                    ${item.jenis}
                </td>

                <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                    ${item.tanggal}
                </td>

                <td class="px-6 py-4 text-center">
                    ${statusBadge(item.status)}
                </td>

                <td class="px-6 py-4 text-center">
                    <button
                        onclick="detail(${item.id})"
                        class="px-4 py-2 text-xs font-semibold rounded-lg 
                               bg-green-600 text-white hover:bg-green-700 transition">
                        Detail
                    </button>
                </td>
            `;

            tbody.appendChild(tr);
        });
    }

    /* ================= STATUS BADGE ================= */
    function statusBadge(status) {
        switch (status) {
            case 'tercatat': return badge('TERCATAT', 'sky');
            case 'tidak_tercatat': return badge('TIDAK TERCATAT', 'red');
            case 'disetujui': return badge('DISETUJUI', 'green');
            case 'ditolak': return badge('DITOLAK', 'red');
            default: return badge('LAINNYA', 'gray');
        }
    }

    function badge(text, color) {
        return `
            <span class="px-4 py-1 rounded-full text-xs font-semibold
                         bg-${color}-100 text-${color}-700">
                ${text}
            </span>
        `;
    }

    /* ================= SEARCH EVENT ================= */
    searchInput.addEventListener('input', e => {
        renderTable(e.target.value.toLowerCase());
    });

    /* INIT */
    renderTable();
});

/* ================= NAVIGASI ================= */
function detail(id) {
    window.location.href = `/detail-balasan-kota/${id}`;
}