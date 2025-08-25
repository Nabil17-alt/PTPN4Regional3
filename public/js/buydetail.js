document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchDetail');
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

    const greetingEl = document.getElementById("greeting");
    if (greetingEl) {
        const hour = new Date().getHours();
        let greetingText = "Selamat datang";

        if (hour >= 3 && hour < 10) {
            greetingText = "Selamat pagi";
        } else if (hour >= 10 && hour < 15) {
            greetingText = "Selamat siang";
        } else if (hour >= 15 && hour < 18) {
            greetingText = "Selamat sore";
        } else {
            greetingText = "Selamat malam";
        }

        greetingEl.textContent = greetingText + ", " + greetingEl.dataset.username;
    }

});