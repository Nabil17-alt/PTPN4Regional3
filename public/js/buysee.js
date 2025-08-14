document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('pageLoader');
    const logoutBtn = document.getElementById('logoutForm');
    const backBtn = document.getElementById('backForm');

    if (logoutBtn) {
        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (loader) loader.classList.remove('hidden');
            setTimeout(() => {
                window.location.href = logoutBtn.getAttribute('href');
            }, 300);
        });
    }

    if (backBtn) {
        backBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (loader) loader.classList.remove('hidden');
            setTimeout(() => {
                window.location.href = backBtn.getAttribute('href');
            }, 300);
        });
    }

});