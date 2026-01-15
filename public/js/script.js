// ================= DATA =================
let submissions = [
    {
        id: 1,
        nama: 'Asep Yono Joyo',
        nik: '23115655431234',
        jenis: 'LEGALISIR',
        date: '20-11-2025',
        status: 'pending'
    },
    {
        id: 2,
        nama: 'Asep',
        nik: '23115655431234',
        jenis: 'MUTASI',
        date: '24-11-2025',
        status: 'valid'
    },
    {
        id: 3,
        nama: 'Asep',
        nik: '23115655431234',
        jenis: 'KEABSAHAN',
        date: '24-11-2025',
        status: 'valid'
    },
    {
        id: 4,
        nama: 'Asep',
        nik: '23115655431234',
        jenis: 'LEGALISIR',
        date: '24-11-2025',
        status: 'pending'
    }
];

document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        // reset active
        document.querySelectorAll('.filter-btn')
            .forEach(b => b.classList.remove('active'));

        // set active
        btn.classList.add('active');

        const status = btn.dataset.status;

        if (status === 'all') {
            renderTableKotaKabupaten(submissions);
        } else {
            const filtered = submissions.filter(item => item.status === status);
            renderTableKotaKabupaten(filtered);
        }
    });
});

// ================= STATUS MAP (PERSIS GAMBAR) =================
function statusText(status) {
    return {
        pending: 'MENUNGGU',
        valid: 'DIPROSES',
        rejected: 'DITOLAK',
        completed: 'SELESAI'
    }[status];
}

// ================= DASHBOARD COUNTER =================
function updateDashboardCounter() {
    document.getElementById('stat-total').innerText = submissions.length;
    document.getElementById('stat-pending').innerText =
        submissions.filter(s => s.status === 'pending').length;
    document.getElementById('stat-valid').innerText =
        submissions.filter(s => s.status === 'valid').length;
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
        // baris hijau selang-seling (sesuai gambar)
        const rowBg = index % 2 === 1 ? 'bg-lime-100/70' : '';

        tbody.innerHTML += `
            <tr class="${rowBg}">
                <td class="px-6 py-4 font-medium">${item.nama}</td>
                <td class="px-6 py-4 text-xs">${item.nik}</td>
                <td class="px-6 py-4 text-xs font-semibold">${item.jenis}</td>
                <td class="px-6 py-4 text-xs">${item.date}</td>
                <td class="px-6 py-4 text-xs font-semibold">
                    ${statusText(item.status)}
                </td>
            </tr>
        `;
    });
}

// ================= FILTER TAB =================
function filterStatus(type) {
    if (type === 'all') {
        renderTableKotaKabupaten(submissions);
        return;
    }

    const map = {
        pending: 'pending',
        valid: 'valid',
        rejected: 'rejected',
        completed: 'completed'
    };

    renderTableKotaKabupaten(
        submissions.filter(s => s.status === map[type])
    );
}

// ================= INIT =================
document.addEventListener('DOMContentLoaded', () => {
    renderTableKotaKabupaten();
    updateDashboardCounter();
});