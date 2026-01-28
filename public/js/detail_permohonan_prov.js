document.addEventListener('DOMContentLoaded', function () {

    const btnKembali = document.getElementById('btnKembali');

    btnKembali.addEventListener('click', function () {
        window.history.back();
    });

});