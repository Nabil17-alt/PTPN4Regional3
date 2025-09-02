document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('pageLoader');

    ['logoutForm', 'backForm'].forEach(id => {
        const btn = document.getElementById(id);
        if (!btn) return;
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            if (loader) loader.classList.remove('hidden');
            setTimeout(() => window.location.href = btn.getAttribute('href'), 300);
        });
    });

    const greetingEl = document.getElementById("greeting");
    if (greetingEl) {
        const hour = new Date().getHours();
        let greetingText = (hour >= 3 && hour < 10) ? "Selamat pagi" :
            (hour >= 10 && hour < 15) ? "Selamat siang" :
                (hour >= 15 && hour < 18) ? "Selamat sore" : "Selamat malam";
        greetingEl.textContent = greetingText + ", " + greetingEl.dataset.username;
    }

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then(result => {
                if (result.isConfirmed) {
                    if (loader) loader.classList.remove('hidden');
                    btn.closest('form')?.submit();
                }
            });
        });
    });
});