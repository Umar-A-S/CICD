
/* ================= NAVIGASI ================= */
function detail(id) {
    // Halaman detail penerbitan
    window.location.href = `/detail_penerbitan-kota/${id}`;
}

function balas(id) {
    // HALAMAN UNGGAH PENERBITAN
    window.location.href = `/unggah_penerbitan-kota/${id}`;
}

/* ================= INIT ================= */
document.addEventListener('DOMContentLoaded', () => {
    renderPenerbitan();
    updateTotalPermohonan();
});