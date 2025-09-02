document.addEventListener('DOMContentLoaded', () => {
    const loader = document.getElementById('pageLoader');
    const editForm = document.getElementById('editbuyForm');
    const logoutBtn = document.getElementById('logoutForm');

    const showLoader = () => {
        if (!loader) return;
        loader.classList.remove('hidden');
        loader.classList.add('flex');
    };

    if (editForm) {
        editForm.addEventListener('submit', () => {
            showLoader();
        });
    }

    if (logoutBtn) {
        logoutBtn.addEventListener('click', (e) => {
            e.preventDefault();
            showLoader();
            setTimeout(() => {
                window.location.href = logoutBtn.getAttribute('href');
            }, 400);
        });
    }
});