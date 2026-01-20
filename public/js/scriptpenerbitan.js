// ================= DATA DUMMY (Sesuai Gambar) =================
let penerbitanData = [
    {
        id: 1,
        nama: 'Asep Yono Joyo',
        nik: '231156554131234',
        jenis: 'LEGALISIR',
        tgl_pengajuan: '20-11-2025',
        status: 'ready' // ready = siap cetak
    },
    {
        id: 2,
        nama: 'Asep',
        nik: '231156554131234',
        jenis: 'MUTASI',
        tgl_pengajuan: '24-11-2025',
        status: 'ready'
    },
    {
        id: 3,
        nama: 'Asep',
        nik: '231156554131234',
        jenis: 'KEABSAHAN',
        tgl_pengajuan: '24-11-2025',
        status: 'ready'
    },
    {
        id: 4,
        nama: 'Asep',
        nik: '231156554131234',
        jenis: 'LEGALISIR',
        tgl_pengajuan: '24-11-2025',
        status: 'ready'
    }
];

// ================= COUNTER =================
function updateTotalPengajuan() {
    const totalEl = document.getElementById('stat-total');
    if (totalEl) {
        totalEl.innerText = penerbitanData.length;
    }
}

// ================= RENDER LIST =================
function renderPenerbitan() {
    const container = document.getElementById('penerbitanList');
    if (!container) return;

    container.innerHTML = '';

    if (penerbitanData.length === 0) {
        container.innerHTML = `
            <div class="py-10 text-center text-gray-400 italic">
                Tidak ada data penerbitan
            </div>
        `;
        updateTotalPengajuan();
        return;
    }

    penerbitanData.forEach((item, index) => {
        // Logic Belang-Belang (Zebra Striping)
        // Baris ganjil (index 0, 2, ...) putih, Baris genap (index 1, 3...) hijau muda
        // Sesuai gambar: baris pertama putih, kedua hijau.
        const bgClass = index % 2 === 0 ? 'bg-white' : 'bg-[#F2F9DB]'; 

        container.innerHTML += `
            <div class="${bgClass} grid grid-cols-12 gap-4 px-6 py-5 items-center text-sm border-b border-gray-100 last:border-0 hover:bg-gray-50 transition">
                
                <div class="col-span-3 font-medium text-gray-900 text-left">
                    ${item.nama}
                </div>

                <div class="col-span-3 text-gray-600 font-medium text-left">
                    ${item.nik}
                </div>

                <div class="col-span-2 text-center text-gray-700 font-semibold uppercase text-xs">
                    ${item.jenis}
                </div>

                <div class="col-span-2 text-center text-gray-600 font-medium">
                    ${item.tgl_pengajuan}
                </div>

                <div class="col-span-2 flex justify-center">
                    <button onclick="kirimBapr(${item.id})" 
                        class="group flex items-center justify-center gap-2 bg-white hover:bg-gray-50 border border-gray-300 rounded-md px-4 py-2 shadow-sm transition-all active:scale-95 w-full max-w-[140px]">
                        
                        <i class="fa-solid fa-print text-gray-900 text-lg group-hover:text-black"></i>
                        
                        <span class="text-gray-900 font-bold text-xs group-hover:text-black">
                            Kirim BAPR
                        </span>
                    </button>
                </div>

            </div>
        `;
    });

    updateTotalPengajuan();
}

// ================= AKSI BUTTON =================
function kirimBapr(id) {
    // Arahkan ke halaman upload dengan membawa ID
    window.location.href = `/unggah_BAPR/${id}`;
}

// ================= INIT =================
document.addEventListener('DOMContentLoaded', () => {
    renderPenerbitan();
});