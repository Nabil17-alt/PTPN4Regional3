document.addEventListener('DOMContentLoaded', () => {
    const loader = document.getElementById('pageLoader');
    const logoutBtn = document.getElementById('logoutFormSubmit');
    const backBtn = document.getElementById('backForm');
    const searchDateInput = document.getElementById('searchDate');
    const greetingEl = document.getElementById('greeting');

    /**
     * Tampilkan loader dan redirect ke URL
     * @param {HTMLElement} button
     * @param {boolean} withDelay
     */
    const handleRedirectWithLoader = (button, withDelay = false) => {
        if (!button) return;
        button.addEventListener('click', (e) => {
            e.preventDefault();
            if (loader) loader.classList.remove('hidden');

            button.classList.add('pointer-events-none', 'opacity-70');

            const targetUrl = button.getAttribute('href');
            if (targetUrl) {
                setTimeout(() => {
                    window.location.href = targetUrl;
                }, withDelay ? 300 : 0);
            }
        });
    };

    handleRedirectWithLoader(logoutBtn);
    handleRedirectWithLoader(backBtn, true);

    if (searchDateInput) {
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
        if (currentDate) {
            searchDateInput.value = currentDate;
        }
    }

    if (greetingEl) {
        const hour = new Date().getHours();
        let greetingText;

        if (hour >= 3 && hour < 10) {
            greetingText = 'Selamat pagi';
        } else if (hour >= 10 && hour < 15) {
            greetingText = 'Selamat siang';
        } else if (hour >= 15 && hour < 18) {
            greetingText = 'Selamat sore';
        } else {
            greetingText = 'Selamat malam';
        }

        const username = greetingEl.dataset.username || '';
        greetingEl.textContent = `${greetingText}, ${username}`;
    }
});

/**
 * Konfirmasi hapus data
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
            if (loader) loader.classList.remove('hidden');
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById(`delete-form-${id}`);
            if (form) form.submit();
        }
    });
}