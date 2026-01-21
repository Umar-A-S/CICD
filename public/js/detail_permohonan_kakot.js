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
        noSuratTerbitSelesai: '08.006/ITS/III/2023'
    };

    // ================= ISI INPUT =================
    Object.entries(data).forEach(([id, value]) => {
        const el = document.getElementById(id);
        if (el) el.value = value;
    });
});

// ================= BUTTON =================
function goBack() {
    window.history.back();
}

function lihatBerkas() {
    alert('Lihat berkas (dummy)');
}