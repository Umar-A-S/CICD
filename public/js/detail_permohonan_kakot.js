// ================= BUTTON ACTIONS =================

function goBack() {
    window.history.back();
}

function lihatBerkas(url) {
    // Nanti URL berkas akan dikirim dari Blade ke fungsi ini
    if (url) {
        window.open(url, '_blank');
    } else {
        alert('Berkas tidak ditemukan atau belum diunggah.');
    }
}