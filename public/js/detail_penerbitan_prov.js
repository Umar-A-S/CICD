// ================= NAVIGATION =================

function goBack() {
    window.history.back();
}

// ================= ACTION BUTTONS =================

/**
 * Fungsi untuk membuka file dokumen penerbitan di tab baru.
 * URL file nanti akan dikirim dari tombol di Blade (PHP).
 */
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