document.addEventListener('DOMContentLoaded', () => {

    /* ================= DATA DUMMY ================= */
    const data = [
        {
            id: 1,
            nama: 'Asep Yono Joyo',
            nomor: '08.006/ITS/III/2025',
            jenis: 'LEGALISIR',
            tanggal: '20-11-2025',
            status: 'tercatat'
        },
        {
            id: 2,
            nama: 'Asep',
            nomor: '08.006/ITS/III/2025',
            jenis: 'MUTASI',
            tanggal: '24-11-2025',
            status: 'tidak_tercatat'
        },
        {
            id: 3,
            nama: 'Asep',
            nomor: '231156554131234',
            jenis: 'KEABSAHAN',
            tanggal: '24-11-2025',
            status: 'disetujui'
        },
        {
            id: 4,
            nama: 'Asep',
            nomor: '231156554131234',
            jenis: 'LEGALISIR',
            tanggal: '24-11-2025',
            status: 'ditolak'
        },
        {
            id: 5,
            nama: 'Asep',
            nomor: '231156554131234',
            jenis: 'MUTASI',
            tanggal: '24-11-2025',
            status: 'lainnya'
        },
    ];

    const tbody = document.getElementById('balasanBody');
    if (!tbody) return;

    /* ================= RENDER TABLE ================= */
    data.forEach((item, index) => {

        const bgRow = index % 2 === 0 ? 'bg-white' : 'bg-lime-50';

        const tr = document.createElement('tr');
        tr.className = `
            ${bgRow}
        `;

        tr.innerHTML = `
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

            <td class="px-6 py-4">
                <div class="flex justify-center">
                    ${statusBadge(item.status)}
                </div>
            </td>

            <td class="px-6 py-4">
                <div class="flex items-center justify-center gap-3">
                    <button
                        onclick="balas(${item.id})"
                        class="flex items-center gap-1 px-3 py-2 text-xs font-semibold 
                        border rounded-lg bg-white text-gray-800 
                        hover:bg-gray-100 transition">
                        <i class="fa-regular fa-pen-to-square"></i>
                        Balas
                    </button>

                    <button
                        onclick="detail(${item.id})"
                        class="px-4 py-2 text-xs font-semibold rounded-lg 
                        bg-green-600 text-white hover:bg-green-700 transition">
                        Detail
                    </button>
                </div>
            </td>
        `;

        tbody.appendChild(tr);
    });

    /* ================= STATUS BADGE ================= */
    function statusBadge(status) {
        switch (status) {
            case 'tercatat':
                return badge('TERCATAT', 'sky');
            case 'tidak_tercatat':
                return badge('TIDAK TERCATAT', 'red');
            case 'disetujui':
                return badge('DISETUJUI', 'green');
            case 'ditolak':
                return badge('DITOLAK', 'red');
            default:
                return badge('LAINNYA', 'gray');
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
});

/* ================= NAVIGASI ================= */
function detail(id) {
    window.location.href = `/detail_balasan-kota/${id}`;
}

function balas(id) {
    window.location.href = `/unggah_balasan-kota/${id}`;
}

const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });