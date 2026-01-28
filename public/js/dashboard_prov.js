// public/js/dashboard_prov.js

document.addEventListener('DOMContentLoaded', function () {

    let selectedRow = null;

    document.querySelectorAll('tbody tr').forEach(row => {

        const btnVerifikasi = row.querySelector('.btn.green');
        const btnKembalikan = row.querySelector('.btn.red');
        const btnDetail     = row.querySelector('.btn.blue');

        // ================= VERIFIKASI =================
        btnVerifikasi.addEventListener('click', () => {
            selectedRow = row;
            document.getElementById('modalVerifikasi').classList.remove('hidden');
        });

        // ================= KEMBALIKAN =================
        btnKembalikan.addEventListener('click', () => {
            selectedRow = row;
            document.getElementById('modalKembalikan').classList.remove('hidden');
        });

        // ================= DETAIL =================
        btnDetail.addEventListener('click', () => {
            window.location.href = '/detail-permohonan-prov';
        });
    });

    // ================= MODAL VERIFIKASI =================
    window.closeModalVerifikasi = function () {
        document.getElementById('modalVerifikasi').classList.add('hidden');
    };

    window.submitVerifikasi = function () {
        if (selectedRow) {
            selectedRow.setAttribute('data-status', 'verified');
            selectedRow.classList.remove('bg-red-50');
            selectedRow.classList.add('bg-green-50');
        }

        closeModalVerifikasi();

        const notif = document.getElementById('notifVerifikasi');
        notif.classList.remove('hidden');

        setTimeout(() => {
            notif.classList.add('hidden');
        }, 2000);
    };

    // ================= MODAL KEMBALIKAN =================
    window.closeModal = function () {
        document.getElementById('modalKembalikan').classList.add('hidden');
        document.getElementById('alasanKembalikan').value = '';
    };

    window.submitKembalikan = function () {
        const alasan = document.getElementById('alasanKembalikan').value.trim();
        if (!alasan) return;

        if (selectedRow) {
            selectedRow.setAttribute('data-status', 'returned');
            selectedRow.classList.remove('bg-green-50');
            selectedRow.classList.add('bg-red-50');
        }

        closeModal();

        const notif = document.getElementById('notifSuccess');
        notif.classList.remove('hidden');

        setTimeout(() => {
            notif.classList.add('hidden');
        }, 2000);
    };

});