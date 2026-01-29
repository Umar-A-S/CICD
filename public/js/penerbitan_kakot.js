/* ================= DATA DUMMY ================= */
const penerbitanData = [
    {
        id: 1,
        dukcapil_asal: 'Kota Semarang',
        nomor_surat: '231156554131234',
        jenis: 'LEGALISIR',
        tanggal: '20-11-2025',
        status: 'ready'
    },
    {
        id: 2,
        dukcapil_asal: 'Kab. Kudus',
        nomor_surat: '231156554131235',
        jenis: 'MUTASI',
        tanggal: '24-11-2025',
        status: 'ready'
    },
    {
        id: 3,
        dukcapil_asal: 'Kota Surakarta',
        nomor_surat: '231156554131236',
        jenis: 'LEGALISIR',
        tanggal: '18-11-2025',
        status: 'done'
    },
    {
        id: 4,
        dukcapil_asal: 'Kab. Pati',
        nomor_surat: '231156554131237',
        jenis: 'MUTASI',
        tanggal: '10-11-2025',
        status: 'done'
    }
];

/* ================= STATUS CARD ================= */
function updateStatusBar() {
    document.getElementById('stat-total') &&
        (document.getElementById('stat-total').innerText = penerbitanData.length);

    document.getElementById('stat-ready') &&
        (document.getElementById('stat-ready').innerText =
            penerbitanData.filter(d => d.status === 'ready').length);

    document.getElementById('stat-done') &&
        (document.getElementById('stat-done').innerText =
            penerbitanData.filter(d => d.status === 'done').length);
}

/* ================= RENDER TABLE ================= */
function renderPenerbitan() {
    const listPerlu = document.getElementById('listPerluDibalas');
    const listSelesai = document.getElementById('listSelesai');

    if (!listPerlu || !listSelesai) return;

    const searchPerlu = document.getElementById('searchPerlu')?.value.toLowerCase() || '';
    const searchSelesai = document.getElementById('searchSelesai')?.value.toLowerCase() || '';

    listPerlu.innerHTML = '';
    listSelesai.innerHTML = '';

    const dataPerlu = penerbitanData.filter(d =>
        d.status === 'ready' &&
        (d.dukcapil_asal.toLowerCase().includes(searchPerlu) ||
         d.nomor_surat.includes(searchPerlu))
    );

    const dataSelesai = penerbitanData.filter(d =>
        d.status === 'done' &&
        (d.dukcapil_asal.toLowerCase().includes(searchSelesai) ||
         d.nomor_surat.includes(searchSelesai))
    );

    /* ===== PERLU DIBALAS ===== */
    if (dataPerlu.length === 0) {
        listPerlu.innerHTML = `
            <div class="px-6 py-6 text-center text-gray-400 text-sm">
                Data tidak ditemukan
            </div>`;
    } else {
        dataPerlu.forEach((item, i) => {
            listPerlu.innerHTML += `
                <div class="grid grid-cols-12 px-6 py-4 text-sm text-black items-center
                            ${i % 2 ? 'bg-lime-50' : 'bg-white'}">
                    <div class="col-span-1 font-semibold">${i + 1}</div>
                    <div class="col-span-3">${item.dukcapil_asal}</div>
                    <div class="col-span-2 text-xs">${item.nomor_surat}</div>
                    <div class="col-span-2 text-center font-semibold">${item.jenis}</div>
                    <div class="col-span-2 text-center text-xs">${item.tanggal}</div>
                    <div class="col-span-2 flex justify-center gap-2">
                        <button onclick="balas(${item.id})"
                            class="border border-gray-300 px-3 py-1 rounded text-xs hover:bg-gray-100">
                            Balas
                        </button>
                        <button onclick="detail(${item.id})"
                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs">
                            Detail
                        </button>
                    </div>
                </div>`;
        });
    }

    /* ===== SELESAI ===== */
    if (dataSelesai.length === 0) {
        listSelesai.innerHTML = `
            <div class="px-6 py-6 text-center text-gray-400 text-sm">
                Data tidak ditemukan
            </div>`;
    } else {
        dataSelesai.forEach((item, i) => {
            listSelesai.innerHTML += `
                <div class="grid grid-cols-12 px-6 py-4 text-sm text-black items-center
                            ${i % 2 ? 'bg-lime-50' : 'bg-white'}">
                    <div class="col-span-1 font-semibold">${i + 1}</div>
                    <div class="col-span-3">${item.dukcapil_asal}</div>
                    <div class="col-span-2 text-xs">${item.nomor_surat}</div>
                    <div class="col-span-2 text-center font-semibold">${item.jenis}</div>
                    <div class="col-span-2 text-center text-xs">${item.tanggal}</div>
                    <div class="col-span-2 flex justify-center">
                        <button onclick="detail(${item.id})"
                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs">
                            Detail
                        </button>
                    </div>
                </div>`;
        });
    }
}

/* ================= NAVIGASI ================= */
function detail(id) {
    window.location.href = `/detail_penerbitan-kota/${id}`;
}

function balas(id) {
    window.location.href = `/unggah_penerbitan-kota/${id}`;
}

/* ================= INIT ================= */
document.addEventListener('DOMContentLoaded', () => {
    renderPenerbitan();
    updateStatusBar();

    document.getElementById('searchPerlu')?.addEventListener('input', renderPenerbitan);
    document.getElementById('searchSelesai')?.addEventListener('input', renderPenerbitan);
});