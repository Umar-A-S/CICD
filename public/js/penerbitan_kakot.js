/* ================= DATA DUMMY ================= */
const penerbitanData = [
    { id: 1, dukcapil_asal: 'Asep Yono Joyo', nomor_surat: '231156554131234', jenis: 'LEGALISIR', tanggal: '20-11-2025', status: 'ready' },
    { id: 2, dukcapil_asal: 'Asep', nomor_surat: '231156554131234', jenis: 'MUTASI', tanggal: '24-11-2025', status: 'ready' },
    { id: 3, dukcapil_asal: 'Asep Yono Joyo', nomor_surat: '231156554131234', jenis: 'LEGALISIR', tanggal: '20-11-2025', status: 'done' },
    { id: 4, dukcapil_asal: 'Asep', nomor_surat: '231156554131234', jenis: 'MUTASI', tanggal: '24-11-2025', status: 'done' }
];

/* ================= COUNTER ================= */
function updateTotalPermohonan() {
    document.getElementById('stat-total').innerText = penerbitanData.length;
    document.getElementById('stat-ready').innerText = penerbitanData.filter(i => i.status === 'ready').length;
    document.getElementById('stat-done').innerText  = penerbitanData.filter(i => i.status === 'done').length;
}

/* ================= RENDER ================= */
function renderPenerbitan() {
    const perlu = document.getElementById('listPerluDibalas');
    const selesai = document.getElementById('listSelesai');

    perlu.innerHTML = '';
    selesai.innerHTML = '';

    penerbitanData.forEach(item => {
        const row = `
        <div class="grid grid-cols-10 px-6 py-4 text-black text-sm odd:bg-white even:bg-lime-100 rounded-md my-2">
            <div class="col-span-2">${item.dukcapil_asal}</div>
            <div class="col-span-2">${item.nomor_surat}</div>
            <div class="col-span-2 text-center font-semibold">${item.jenis}</div>
            <div class="col-span-2 text-center">${item.tanggal}</div>
            <div class="col-span-2 flex justify-center gap-2">

                ${item.status === 'ready' ? `
                <button 
                    onclick="balas(${item.id})"
                    class="border border-gray-300 px-3 py-1 rounded text-xs hover:bg-gray-100">
                    <i class="fa-solid fa-pen-to-square mr-1"></i>
                    Balas
                </button>` : ''}

                <button 
                    onclick="detail(${item.id})"
                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs">
                    Detail
                </button>

            </div>
        </div>`;

        item.status === 'ready'
            ? perlu.insertAdjacentHTML('beforeend', row)
            : selesai.insertAdjacentHTML('beforeend', row);
    });
}

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