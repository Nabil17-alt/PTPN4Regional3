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

    const logoutBtn = document.getElementById('logoutForm');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();
            loader.classList.remove('hidden');
            setTimeout(() => {
                window.location.href = logoutBtn.getAttribute('href');
            }, 300);
        });
    }

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

document.addEventListener("DOMContentLoaded", () => {
    const jabatanSelect = document.getElementById("jabatanSelect");
    const unitSelect = document.getElementById("unitSelect");

    if (jabatanSelect && unitSelect) {
        jabatanSelect.addEventListener("change", function () {
            const selectedJabatan = this.value;

            if (selectedJabatan === "Admin" || selectedJabatan === "Asisten") {

                const kantorOption = Array.from(unitSelect.options).find(opt =>
                    opt.textContent.trim().toLowerCase() === "kantor regional".toLowerCase()
                );

                if (kantorOption) {
                    unitSelect.value = kantorOption.value;
                }   

                unitSelect.disabled = true;
            } else {
                unitSelect.disabled = false;
                unitSelect.value = "";
            }
        });
    }
});


