document.addEventListener('DOMContentLoaded', function () {
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
