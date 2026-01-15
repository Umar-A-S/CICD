// ================= MASTER DATA (DUMMY) =================
const submissions = [
    {
        id: 1,
        daerah_asal: 'Kab. Semarang',
        nomor_surat: '08.006/ITS/III/2023',
        tanggal_submit: '20-11-2025',
        daerah_tujuan_kab: 'Kota Semarang',
        daerah_tujuan_prov: 'Jawa Tengah',
        jenis: 'LEGALISIR',
        nama_subjek: 'DALAM JATENG',
        files: [
            { name: 'legalisir.pdf', url: 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf' }
        ]
    },
    {
        id: 2,
        daerah_asal: 'Kab. Semarang',
        nomor_surat: '08.006/ITS/III/2023',
        tanggal_submit: '24-11-2025',
        daerah_tujuan_kab: 'Kota Semarang',
        daerah_tujuan_prov: 'Jawa Tengah',
        jenis: 'MUTASI',
        nama_subjek: 'DALAM JATENG',
        files: [
            { name: 'mutasi.pdf', url: 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf' }
        ]
    },
    {
        id: 3,
        daerah_asal: 'Kab. Semarang',
        nomor_surat: '08.006/ITS/III/2023',
        tanggal_submit: '24-11-2025',
        daerah_tujuan_kab: 'Kota Semarang',
        daerah_tujuan_prov: 'Jawa Tengah',
        jenis: 'KEABSAHAN',
        nama_subjek: 'DALAM JATENG',
        files: [
            { name: 'keabsahan.pdf', url: 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf' }
        ]
    },
    {
        id: 4,
        daerah_asal: 'Kab. Semarang',
        nomor_surat: '08.006/ITS/III/2023',
        tanggal_submit: '24-11-2025',
        daerah_tujuan_kab: 'Kota Semarang',
        daerah_tujuan_prov: 'Jawa Tengah',
        jenis: 'LEGALISIR',
        nama_subjek: 'DALAM JATENG',
        files: [
            { name: 'legalisir.pdf', url: 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf' }
        ]
    }
];

// ================= RENDER TABLE (HALAMAN LIST) =================
function renderTable(data) {
    const tbody = document.getElementById('tableKotaKabupaten');
    if (!tbody) return;

    tbody.innerHTML = '';

    if (!data.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-6 text-center text-gray-400">
                    Data tidak ditemukan
                </td>
            </tr>
        `;
        return;
    }

    data.forEach(item => {
        tbody.innerHTML += `
            <tr class="border-b even:bg-lime-50">
                <td class="px-6 py-4">${item.daerah_asal}</td>
                <td class="px-6 py-4">${item.jenis}</td>
                <td class="px-6 py-4">${item.tanggal_submit}</td>
                <td class="px-6 py-4">
                    <button
                        onclick="openDetail(${item.id})"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded-full text-xs">
                        DETAIL
                    </button>
                </td>
            </tr>
        `;
    });
}

// ================= NAVIGATE DETAIL =================
function openDetail(id) {
    window.location.href = `/detailarsip-kota/${id}`;
}

// ================= DETAIL PAGE =================
function loadDetail() {
    if (!window.location.pathname.includes('detailarsip-kota')) return;

    const id = parseInt(window.location.pathname.split('/').pop());
    const data = submissions.find(item => item.id === id);

    if (!data) {
        alert('Data arsip tidak ditemukan');
        return;
    }

    setVal('daerahasal', data.daerah_asal);
    setVal('nomorsurat', data.nomor_surat);
    setVal('tanggalsubmit', data.tanggal_submit);
    setVal('kabtujuan', data.daerah_tujuan_kab);
    setVal('provtujuan', data.daerah_tujuan_prov);
    setVal('jenispermohonan', data.jenis);
    setVal('tanggalpermohonan', data.tanggal_submit);
    setVal('namasubjek', data.nama_subjek);
    // Render berkas (bisa lebih dari satu)
    const container = document.getElementById('berkasContainer');
    if (container) {
        container.innerHTML = '';

        // first try to fetch files from server (uploaded files)
        fetch(`/unggah-bapr/files/${id}`)
            .then(r => r.json())
            .then(res => {
                if (res && res.files && res.files.length) {
                    res.files.forEach(f => {
                        container.innerHTML += `
                            <div class="mt-2 flex items-center gap-3 rounded-xl bg-gray-50 border px-4 py-3 text-sm">
                                <i class="fa-solid fa-print text-sky-500"></i>
                                <a href="${f.url}" target="_blank" class="text-sky-500 font-semibold hover:underline">${f.name}</a>
                            </div>
                        `;
                    });
                    return;
                }

                // fallback to client-side dummy data
                if (data.files && data.files.length) {
                    data.files.forEach(f => {
                        const url = f.url ? f.url : `/berkas/${f.name}`;
                        container.innerHTML += `
                            <div class="mt-2 flex items-center gap-3 rounded-xl bg-gray-50 border px-4 py-3 text-sm">
                                <i class="fa-solid fa-print text-sky-500"></i>
                                <a href="${url}" target="_blank" class="text-sky-500 font-semibold hover:underline">${f.name}</a>
                            </div>
                        `;
                    });
                    return;
                }

                container.innerHTML = '<span class="text-gray-400">Tidak ada berkas.</span>';
            })
            .catch(err => {
                console.error('Gagal mengambil berkas:', err);
                // fallback
                if (data.files && data.files.length) {
                    data.files.forEach(f => {
                        const url = f.url ? f.url : `/berkas/${f.name}`;
                        container.innerHTML += `
                            <div class="mt-2 flex items-center gap-3 rounded-xl bg-gray-50 border px-4 py-3 text-sm">
                                <i class="fa-solid fa-print text-sky-500"></i>
                                <a href="${url}" target="_blank" class="text-sky-500 font-semibold hover:underline">${f.name}</a>
                            </div>
                        `;
                    });
                } else {
                    container.innerHTML = '<span class="text-gray-400">Tidak ada berkas.</span>';
                }
            });
    }
}

// ================= UTIL =================
function setVal(id, value) {
    const el = document.getElementById(id);
    if (!el) return;
    el.value = value ?? '-';
}

// ================= INIT =================
document.addEventListener('DOMContentLoaded', () => {

    // Halaman LIST
    if (document.getElementById('tableKotaKabupaten')) {
        renderTable(submissions);
    }

    // Halaman DETAIL
    if (document.getElementById('daerahasal')) {
        loadDetail();
    }
});