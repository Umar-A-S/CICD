// public/js/dashboard_kakot.js

document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const tableRows = document.querySelectorAll('tbody tr[data-status]');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // 1. Ubah tampilan tombol aktif
            filterButtons.forEach(btn => btn.classList.remove('active', 'bg-lime-400', 'text-white'));
            this.classList.add('active', 'bg-lime-400', 'text-white');

            const selectedStatus = this.getAttribute('data-status');

            // 2. Filter Baris Tabel
            tableRows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                
                if (selectedStatus === 'all' || rowStatus === selectedStatus) {
                    row.style.display = ''; // Tampilkan
                } else {
                    row.style.display = 'none'; // Sembunyikan
                }
            });
        });
    });
});