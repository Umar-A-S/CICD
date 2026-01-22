

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