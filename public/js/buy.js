document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchDate');
    const tableRows = document.querySelectorAll('tbody tr');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase();

            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(keyword) ? '' : 'none';
            });
        });
    }

    const loader = document.getElementById('pageLoader');
    const logoutBtn = document.getElementById('logoutForm');

    if (logoutBtn) {
        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (loader) loader.classList.remove('hidden');
            setTimeout(() => {
                window.location.href = logoutBtn.getAttribute('href');
            }, 300);
        });
    }
});