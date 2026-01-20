// ================= LUPA PASSWORD VIA WA =================
        function lupaPasswordWA() {
            const email = document.getElementById('email').value.trim();

            if (!email) {
                alert('Silakan isi email terlebih dahulu.');
                return;
            }

            const nomorAdmin = '6281993726802'; // GANTI nomor admin

            const pesan = `Halo Admin SELAKSA,
            Saya lupa password akun saya.

            Email: ${email}

            Mohon bantu reset password.
            Terima kasih.`;

            const url = `https://wa.me/${nomorAdmin}?text=${encodeURIComponent(pesan)}`;
            window.open(url, '_blank');
        }