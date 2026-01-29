// DATA DUMMY PROFIL INSTANSI
const profilInstansi = {
    nama: "Kantor Kota Semarang",
    kode: "3.74.01.1001"
};

// SET DATA KE INPUT
document.getElementById("namaInstansi").value = profilInstansi.nama;
document.getElementById("kodeWilayah").value = profilInstansi.kode;

const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });