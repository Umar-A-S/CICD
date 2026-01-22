document.addEventListener('DOMContentLoaded', () => {

    // ================= DATA DUMMY =================
    const data = {
        nama: 'Asep',
        wilayah: 'LUAR JATENG',
        asal: 'Semarang',
        tujuan: 'Kab/Kota',
        provinsi: 'Provinsi',
        jenis: 'KEABSAHAN',
        dokumen: 'Akta Kelahiran',

        tglPermohonan: '20-11-2025',
        noSuratPermohonan: '08.006/ITS/III/2023',
        noSuratSelesai: '08.006/ITS/III/2023',

        tglTerbit: '20-01-2026',
        noSuratTerbit: '08.006/ITS/III/2023',
        noSuratTerbitSelesai: '08.006/ITS/III/2023',

        hasil: 'Disetujui',
        alasan: 'Data sesuai dengan dokumen asli.'
    };

    // ================= ISI INPUT =================
    for (const id in data) {
        const el = document.getElementById(id);
        if (el) {
            el.value = data[id];
        }
    }
});

// ================= BUTTON =================
function goBack() {
    window.history.back();
}

function lihatBerkas() {
    alert('Lihat berkas (dummy)');
}