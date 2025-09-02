document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('pageLoader');
    const editbuyForm = document.getElementById('editbuyForm');
    const logoutBtn = document.getElementById('logoutForm');
    
    if (editbuyForm && loader) {
        editbuyForm.addEventListener('submit', function () {
            loader.classList.remove('hidden');
        });
    }

    if (logoutBtn && loader) {
        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();
            loader.classList.remove('hidden');
            setTimeout(() => {
                window.location.href = logoutBtn.getAttribute('href');
            }, 300);
        });
    }
});