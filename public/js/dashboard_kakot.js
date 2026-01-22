// ================= DATA =================
let submissions = [
    {
        id: 1,
        nama: 'Asep Yono Joyo',
        nomor_surat: '23115655431234',
        jenis: 'LEGALISIR',
        date: '20-11-2025',
        status: 'pending'
    },
    {
        id: 2,
        nama: 'Asep',
        nomor_surat: '23115655431234',
        jenis: 'MUTASI',
        date: '24-11-2025',
        status: 'valid'
    },
    {
        id: 3,
        nama: 'Asep',
        nomor_surat: '23115655431234',
        jenis: 'KEABSAHAN',
        date: '24-11-2025',
        status: 'rejected'
    },
    {
        id: 4,
        nama: 'Asep',
        nomor_surat: '23115655431234',
        jenis: 'LEGALISIR',
        date: '24-11-2025',
        status: 'success'
    }
];

const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });
    
// ================= FILTER BUTTON =================
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn')
            .forEach(b => b.classList.remove('active'));

        btn.classList.add('active');

        const status = btn.dataset.status;

        if (status === 'all') {
            renderTableKotaKabupaten(submissions);
        } else {
            renderTableKotaKabupaten(
                submissions.filter(item => item.status === status)
            );
        }
    });
});

// ================= STATUS BADGE =================
function statusBadge(status) {
    const map = {
        pending: {
            text: 'BELUM',
            class: 'bg-yellow-100 text-yellow-700'
        },
        valid: {
            text: 'DIPROSES',
            class: 'bg-blue-100 text-cyan-700'
        },
        rejected: {
            text: 'DITOLAK',
            class: 'bg-red-100 text-red-700'
        },
        success: {
            text: 'SELESAI',
            class: 'bg-green-100 text-green-700'
        }
    };

    const s = map[status];

    return `
        <span class="inline-flex items-center px-3 py-1
                    rounded-full text-xs font-bold ${s.class}">
            ${s.text}
        </span>
    `;
}

// ================= DASHBOARD COUNTER =================
function updateDashboardCounter() {
    document.getElementById('stat-total').innerText = submissions.length;
    document.getElementById('stat-pending').innerText =
        submissions.filter(s => s.status === 'pending').length;
    document.getElementById('stat-valid').innerText =
        submissions.filter(s => s.status === 'valid').length;
    document.getElementById('stat-rejected').innerText =
        submissions.filter(s => s.status === 'rejected').length;
    document.getElementById('stat-success').innerText =
        submissions.filter(s => s.status === 'success').length;
}

// ================= TABLE RENDER =================
function renderTableKotaKabupaten(data = submissions) {
    const tbody = document.getElementById('tableKotaKabupaten');
    tbody.innerHTML = '';

    if (!data.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-6 text-gray-400">
                    Data tidak ditemukan
                </td>
            </tr>
        `;
        return;
    }

    data.forEach((item, index) => {
        const rowBg = index % 2 === 1 ? 'bg-lime-100/70' : '';

        tbody.innerHTML += `
            <tr class="${rowBg}">
                <td class="px-6 py-4 font-medium">${item.nama}</td>
                <td class="px-6 py-4 text-xs">${item.nomor_surat}</td>
                <td class="px-6 py-4 text-xs font-semibold">${item.jenis}</td>
                <td class="px-6 py-4 text-xs">${item.date}</td>
                <td class="px-6 py-4 text-xs">
                    ${statusBadge(item.status)}
                </td>
                <td class="px-6 py-4">
                    <button
                        onclick="openDetail(${item.id})"
                        class="bg-green-600 hover:bg-green-700
                                transition text-white px-4 py-1
                                rounded-full text-xs font-semibold">
                        DETAIL
                    </button>
                </td>
            </tr>
        `;
    });
}

// ================= DETAIL ACTION =================
function openDetail(id) {
    const data = submissions.find(item => item.id === id);

    if (!data) {
        alert('Data tidak ditemukan');
        return;
    }

    // contoh: pindah halaman detail
    window.location.href = `/detail_permohonan-kota/${id}`;
}

// ================= INIT =================
document.addEventListener('DOMContentLoaded', () => {
    renderTableKotaKabupaten();
    updateDashboardCounter();
});