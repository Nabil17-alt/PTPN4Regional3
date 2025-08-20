document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchDate');
    const tableRows = document.querySelectorAll('tbody tr');
    const loader = document.getElementById('pageLoader');

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const keyword = searchInput.value.trim().toLowerCase();
            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(keyword) ? '' : 'none';
            });
        });
    }

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

    document.querySelectorAll('.lihatForm').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            if (loader) loader.classList.remove('hidden');
            setTimeout(() => {
                window.location.href = this.getAttribute('href');
            }, 300);
        });
    });

    document.querySelectorAll('.detailForm').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            if (loader) loader.classList.remove('hidden');
            setTimeout(() => {
                window.location.href = this.getAttribute('href');
            }, 300);
        });
    });
});

window.addEventListener('load', function () {
    const loader = document.getElementById('pageLoader');
    if (loader) loader.classList.add('hidden');
});

window.addEventListener('pageshow', function (event) {
    const loader = document.getElementById('pageLoader');
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
        if (loader) loader.classList.add('hidden');
    }
});
