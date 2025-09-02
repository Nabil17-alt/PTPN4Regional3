document.addEventListener('DOMContentLoaded', () => {
    const loader = document.getElementById('pageLoader');
    const searchInput = document.getElementById('searchDate');
    const tableRows = document.querySelectorAll('tbody tr');
    const logoutBtn = document.getElementById('logoutForm');
    const greetingEl = document.getElementById('greeting');

    const showLoader = () => loader?.classList.remove('hidden');

    const hideLoader = () => loader?.classList.add('hidden');

    const handleSearch = () => {
        if (!searchInput) return;
        searchInput.addEventListener('input', () => {
            const keyword = searchInput.value.trim().toLowerCase();
            tableRows.forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(keyword) ? '' : 'none';
            });
        });
    };

    const handleNavigation = (selector) => {
        document.addEventListener('click', (e) => {
            const link = e.target.closest(selector);
            if (!link) return;

            e.preventDefault();
            showLoader();
            setTimeout(() => {
                window.location.href = link.getAttribute('href');
            }, 300);
        });
    };

    const setGreeting = () => {
        if (!greetingEl) return;

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

        greetingEl.textContent = `${greetingText}, ${greetingEl.dataset.username}`;
    };

    handleSearch();
    handleNavigation('#logoutForm');   
    handleNavigation('.lihatForm');    
    handleNavigation('.detailForm');   
    setGreeting();
});

window.addEventListener('load', () => {
    const loader = document.getElementById('pageLoader');
    loader?.classList.add('hidden');
});

window.addEventListener('pageshow', (event) => {
    const loader = document.getElementById('pageLoader');
    if (event.persisted || performance.getEntriesByType('navigation')[0].type === 'back_forward') {
        loader?.classList.add('hidden');
    }
});