document.addEventListener('DOMContentLoaded', () => {
    const loader = document.getElementById('pageLoader');
    const searchInput = document.getElementById('searchDetail');
    const logoutBtn = document.getElementById('logoutForm');
    const backBtn = document.getElementById('backForm');
    const greetingEl = document.getElementById('greeting');
    const approveForm = document.querySelector('form[action*="pembelian.approve"]');
    const tableRows = document.querySelectorAll('tbody tr');

    const showLoader = () => loader?.classList.remove('hidden');

    const handleRedirect = (btn, delay = 300) => {
        if (!btn) return;
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            showLoader();
            btn.classList.add('pointer-events-none', 'opacity-70');
            setTimeout(() => {
                window.location.href = btn.getAttribute('href');
            }, delay);
        });
    };

    const setupSearchFilter = () => {
        if (!searchInput || !tableRows.length) return;

        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase();

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const match = text.includes(keyword);

                row.style.display = match ? '' : 'none';

                row.querySelectorAll('td').forEach(cell => {
                    if (match && keyword) {
                        const regex = new RegExp(`(${keyword})`, 'gi');
                        cell.innerHTML = cell.textContent.replace(regex, '<mark class="bg-yellow-200">$1</mark>');
                    } else {
                        cell.innerHTML = cell.textContent;
                    }
                });
            });
        });
    };

    const setGreeting = () => {
        if (!greetingEl) return;

        const hour = new Date().getHours();
        let greetingText = 'Selamat datang';

        if (hour >= 3 && hour < 10) greetingText = 'Selamat pagi';
        else if (hour >= 10 && hour < 15) greetingText = 'Selamat siang';
        else if (hour >= 15 && hour < 18) greetingText = 'Selamat sore';
        else greetingText = 'Selamat malam';

        greetingEl.textContent = `${greetingText}, ${greetingEl.dataset.username}`;
    };

    const setupApproveForm = () => {
        if (!approveForm) return;

        approveForm.addEventListener('submit', (e) => {
            e.preventDefault();
            showLoader();
            setTimeout(() => approveForm.submit(), 300);
        });
    };

    handleRedirect(logoutBtn);
    handleRedirect(backBtn);
    setupSearchFilter();
    setGreeting();
    setupApproveForm();
});