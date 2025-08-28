function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
}

function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
}

function openEditModal(username, name, email, level, kodeUnit) {
    document.getElementById('editUsername').value = username;
    document.getElementById('editLevel').value = level;
    document.getElementById('unitSelectEdit').value = kodeUnit;
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
            if (loader) loader.classList.remove('hidden');

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
    const unitSelectAdd = document.getElementById('unitSelectAdd');
    const kodeUnitHidden = document.getElementById('kodeUnitHidden');

    if (addakunForm && unitSelectAdd && kodeUnitHidden) {
        addakunForm.addEventListener('submit', () => {
            kodeUnitHidden.value = unitSelectAdd.value || '';
        });
    }

    const cariForm = document.getElementById('cariForm');
    if (cariForm) cariForm.addEventListener('submit', () => loader.classList.remove('hidden'));

    const editForm = document.getElementById('editForm');
    if (editForm) editForm.addEventListener('submit', () => loader.classList.remove('hidden'));

    const greetingEl = document.getElementById("greeting");
    if (greetingEl) {
        const hour = new Date().getHours();
        let greetingText = "Selamat datang";
        if (hour >= 3 && hour < 10) greetingText = "Selamat pagi";
        else if (hour >= 10 && hour < 15) greetingText = "Selamat siang";
        else if (hour >= 15 && hour < 18) greetingText = "Selamat sore";
        else greetingText = "Selamat malam";

        greetingEl.textContent = greetingText + ", " + greetingEl.dataset.username;
    }

    const jabatanSelect = document.getElementById("jabatanSelect");
    if (jabatanSelect && unitSelectAdd && kodeUnitHidden) {
        function updateUnitField() {
            const selectedJabatan = jabatanSelect.value;
            if (selectedJabatan === "Admin" || selectedJabatan === "General_Manager" || selectedJabatan === "Region_Head") {
                const kantorOption = Array.from(unitSelectAdd.options).find(opt =>
                    opt.textContent.trim().toLowerCase() === "kantor regional"
                );
                if (kantorOption) {
                    unitSelectAdd.value = kantorOption.value;
                    kodeUnitHidden.value = kantorOption.value;
                }
                unitSelectAdd.setAttribute("disabled", "disabled");
                unitSelectAdd.classList.add("bg-gray-100");
            } else {
                unitSelectAdd.removeAttribute("disabled");
                unitSelectAdd.classList.remove("bg-gray-100");
                kodeUnitHidden.value = unitSelectAdd.value;
            }
        }

        jabatanSelect.addEventListener("change", updateUnitField);
        unitSelectAdd.addEventListener("change", () => {
            kodeUnitHidden.value = unitSelectAdd.value;
        });
        updateUnitField();
    }
});