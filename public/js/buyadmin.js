document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('pageLoader');
    const logoutBtn = document.getElementById('logoutFormSubmit');
    const backBtn = document.getElementById('backForm');
    const searchDate = document.getElementById('searchDate');

    if (logoutBtn) {
        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (loader) loader.classList.remove('hidden');
            window.location.href = logoutBtn.getAttribute('href');
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

    if (searchDate) {
        searchDate.addEventListener('change', function () {
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
            searchDate.value = currentDate;
        }
    }
});

function confirmDelete(id) {
    Swal.fire({
        title: 'Apakah kamu yakin?',
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        buttonsStyling: false,
        customClass: {
            confirmButton: 'btn-danger',
            cancelButton: 'btn-secondary'
        },
        preConfirm: () => {
            const loader = document.getElementById('pageLoader');
            if (loader) loader.classList.remove('hidden');
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('delete-form-' + id);
            if (form) form.submit();
        }
    });
}