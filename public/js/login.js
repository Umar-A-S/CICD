// ================= LUPA PASSWORD VIA WA =================
        function lupaPasswordWA() {
            const username = document.getElementById('username').value.trim();

            if (!username) {
                alert('Silakan isi username terlebih dahulu.');
                return;
            }

            const nomorAdmin = '6281993726802'; // GANTI nomor admin

            const pesan = `Halo Admin SELAKSA,
            Saya lupa password akun saya.

            Username: ${username}

            Mohon bantu reset password.
            Terima kasih.`;

            const url = `https://wa.me/${nomorAdmin}?text=${encodeURIComponent(pesan)}`;
            window.open(url, '_blank');
        }