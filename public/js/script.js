document.addEventListener('DOMContentLoaded', function() {
    // Ambil semua elemen yang punya class 'table-search'
    const searchInputs = document.querySelectorAll('.table-search');

    searchInputs.forEach(input => {
        input.addEventListener('keyup', function() {
            // 1. Ambil kata kunci pencarian (huruf kecil semua biar gak case sensitive)
            const term = this.value.toLowerCase();
            
            // 2. Cari tabel sasaran berdasarkan ID yang dikirim
            const targetId = this.getAttribute('data-target');
            const tableBody = document.querySelector(`#${targetId} tbody`);
            
            if (!tableBody) return; // Stop kalau tabel gak ketemu

            // 3. Ambil semua baris (tr) di dalam tbody
            const rows = tableBody.getElementsByTagName('tr');

            // 4. Loop tiap baris untuk dicek
            Array.from(rows).forEach(row => {
                // Lewati baris "Tidak ada data" (biasanya yang punya colspan)
                if (row.querySelector('td[colspan]')) return;

                const text = row.textContent.toLowerCase();
                
                // Jika teks baris mengandung kata kunci, tampilkan. Kalau tidak, sembunyikan.
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });
    });
});