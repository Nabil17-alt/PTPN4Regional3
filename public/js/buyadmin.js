document.addEventListener('DOMContentLoaded', () => {
    const loader = document.getElementById('pageLoader');
    const logoutBtn = document.getElementById('logoutFormSubmit');
    const backBtn = document.getElementById('backForm');
    const searchDateInput = document.getElementById('searchDate');
    const greetingEl = document.getElementById('greeting');

    const showLoader = () => loader?.classList.remove('hidden');

    const hideLoader = () => loader?.classList.add('hidden');

    /**
     * Handle tombol redirect dengan loader
     * @param {HTMLElement|null} button
     * @param {boolean} delay
     */
    const setupRedirectButton = (button, delay = false) => {
        if (!button) return;

        button.addEventListener('click', (e) => {
            e.preventDefault();
            showLoader();

            button.classList.add('pointer-events-none', 'opacity-70');

            const targetUrl = button.getAttribute('href');
            if (targetUrl) {
                setTimeout(() => {
                    window.location.href = targetUrl;
                }, delay ? 300 : 0);
            }
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

        const username = greetingEl.dataset.username || '';
        greetingEl.textContent = `${greetingText}, ${username}`;
    };

    const setupDateFilter = () => {
        if (!searchDateInput) return;

        searchDateInput.addEventListener('change', function () {
            const selectedDate = this.value;
            if (selectedDate) {
                const url = new URL(window.location.href);
                url.searchParams.set('tanggal', selectedDate);
                window.location.href = url.toString();
            }
        });

        const urlParams = new URLSearchParams(window.location.search);
        const currentDate = urlParams.get('tanggal');
        if (currentDate) searchDateInput.value = currentDate;
    };

    setupRedirectButton(logoutBtn);
    setupRedirectButton(backBtn, true);
    setupDateFilter();
    setGreeting();
});

/**
 * Konfirmasi hapus data menggunakan SweetAlert2
 * @param {number|string} id
 */
function confirmDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        buttonsStyling: false,
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        },
        preConfirm: () => {
            const loader = document.getElementById('pageLoader');
            loader?.classList.remove('hidden');
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById(`delete-form-${id}`);
            if (form) form.submit();
        }
    });
}