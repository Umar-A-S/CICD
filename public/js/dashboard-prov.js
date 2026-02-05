document.addEventListener('DOMContentLoaded', function () {
    let selectedRow = null;

    document.querySelectorAll('tbody tr').forEach(row => {
        const btnVerifikasi = row.querySelector('.btn.green');
        const btnKembalikan = row.querySelector('.btn.red');
        const btnDetail     = row.querySelector('.btn.blue');

        // ================= TRIGGER MODAL =================
        if(btnVerifikasi) {
            btnVerifikasi.addEventListener('click', () => {
                selectedRow = row;
                document.getElementById('modalVerifikasi').classList.remove('hidden');
            });
        }

        if(btnKembalikan) {
            btnKembalikan.addEventListener('click', () => {
                selectedRow = row;
                document.getElementById('modalKembalikan').classList.remove('hidden');
            });
        }

        // ================= DETAIL REDIRECT =================
        if(btnDetail) {
            btnDetail.addEventListener('click', () => {
                const id = row.dataset.id;
                window.location.href = `${window.detailBaseUrl}/${id}`;
            });
        }
    });

    // ================= LOGIKA VERIFIKASI =================
    window.closeModalVerifikasi = function () {
        document.getElementById('modalVerifikasi').classList.add('hidden');
    };

    window.submitVerifikasi = function () {
        if (selectedRow) {
            const id = selectedRow.dataset.id;
            // Tampilkan Notif Visual (Opsional sebelum reload)
            document.getElementById('notifVerifikasi').classList.remove('hidden');
            
            // Submit Form Backend setelah jeda singkat agar notif terlihat
            setTimeout(() => {
                document.getElementById(`form-verifikasi-${id}`).submit();
            }, 800);
        }
        closeModalVerifikasi();
    };

    // ================= LOGIKA KEMBALIKAN (TOLAK) =================
    window.closeModal = function () {
        document.getElementById('modalKembalikan').classList.add('hidden');
        document.getElementById('alasanKembalikan').value = '';
    };

    window.submitKembalikan = function () {
        const alasan = document.getElementById('alasanKembalikan').value.trim();
        if (!alasan) return alert('Alasan wajib diisi');

        if (selectedRow) {
            const id = selectedRow.dataset.id;
            
            // Masukkan alasan dari textarea modal ke hidden input di form
            document.getElementById(`input-alasan-${id}`).value = alasan;

            // Tampilkan Notif Visual
            document.getElementById('notifSuccess').classList.remove('hidden');

            // Submit Form Backend
            setTimeout(() => {
                document.getElementById(`form-tolak-${id}`).submit();
            }, 800);
        }
        closeModal();
    };
});