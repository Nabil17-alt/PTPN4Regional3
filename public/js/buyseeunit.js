document.addEventListener('DOMContentLoaded', () => {
    const loader = document.getElementById('pageLoader');
    const logoutBtn = document.getElementById('logoutForm');
    const backBtn = document.getElementById('backForm');
    const greetingEl = document.getElementById('greeting');

    /**
     * Tampilkan loader lalu redirect ke URL yang ditentukan
     * @param {HTMLElement} element
     */
    const handleRedirectWithLoader = (element) => {
        if (!element) return;
        element.addEventListener('click', (e) => {
            e.preventDefault();
            if (loader) loader.classList.remove('hidden');
            const targetUrl = element.getAttribute('href');
            if (targetUrl) {
                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 300);
            }
        });
    };

    handleRedirectWithLoader(logoutBtn);
    handleRedirectWithLoader(backBtn);

    if (greetingEl) {
        const hour = new Date().getHours();
        let greetingText;

        if (hour >= 3 && hour < 10) {
            greetingText = "Selamat pagi";
        } else if (hour >= 10 && hour < 15) {
            greetingText = "Selamat siang";
        } else if (hour >= 15 && hour < 18) {
            greetingText = "Selamat sore";
        } else {
            greetingText = "Selamat malam";
        }

        greetingEl.textContent = `${greetingText}, ${greetingEl.dataset.username || ''}`;
    }
});

/**
 * Konfirmasi penghapusan data
 * @param {number|string} id
 */
function confirmDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
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

/**
 * Buka modal edit dan isi dengan data
 * @param {number|string} id
 * @param {string|number} hargaPenetapan
 * @param {string|number} hargaEskalasi
 */
function openEditModal(id, hargaPenetapan, hargaEskalasi) {
    const modal = document.getElementById('editModal');
    if (!modal) return;

    modal.classList.remove('hidden');

    const hargaPenetapanInput = document.getElementById('harga_penetapan');
    const hargaEskalasiInput = document.getElementById('harga_escalasi');
    const editForm = document.getElementById('editForm');

    if (hargaPenetapanInput) hargaPenetapanInput.value = hargaPenetapan;
    if (hargaEskalasiInput) hargaEskalasiInput.value = hargaEskalasi;
    if (editForm) editForm.action = `/pembelian/${id}/update-harga`;
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    if (modal) modal.classList.add('hidden');
}