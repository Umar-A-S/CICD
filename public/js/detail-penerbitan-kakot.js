// ================= NAVIGATION =================

function goBack() {
    window.history.back();
}

// ================= ACTION BUTTONS =================

function lihatDokumen(url) {
    if (url && url !== '#') {
        window.open(url, '_blank');
    } else {
        alert('Dokumen fisik belum tersedia atau link rusak.');
    }
}

/**
 * Fungsi opsional jika nanti kamu ingin menambahkan tombol print
 */
function cetakHalaman() {
    window.print();
}