function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
}

function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
}

function openEditModal(username, name, email, level) {
    document.getElementById('editUsername').value = name;
    document.getElementById('editEmail').value = email;
    document.getElementById('editLevel').value = level;
    document.getElementById('editPassword').value = '';

    const form = document.getElementById('editForm');
    form.action = `/akun/${username}`;

    document.getElementById('editModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function confirmDelete(username) {
    Swal.fire({
        title: 'Yakin ingin menghapus akun ini?',
        text: "Tindakan ini tidak dapat dibatalkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        preConfirm: () => {
            const loader = document.getElementById('pageLoader');
            if (loader) {
                loader.classList.remove('hidden');
            }

            return new Promise((resolve) => {
                setTimeout(() => {
                    document.getElementById('delete-form-' + username).submit();
                    resolve();
                }, 300);
            });
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const loader = document.getElementById('pageLoader');

    const addakunForm = document.getElementById('addakunForm');
    if (addakunForm) {
        addakunForm.addEventListener('submit', () => {
            loader.classList.remove('hidden');
        });
    }

    const cariForm = document.getElementById('cariForm');
    if (cariForm) {
        cariForm.addEventListener('submit', () => {
            loader.classList.remove('hidden');
        });
    }

    const editForm = document.getElementById('editForm');
    if (editForm) {
        editForm.addEventListener('submit', () => {
            loader.classList.remove('hidden');
        });
    }
});