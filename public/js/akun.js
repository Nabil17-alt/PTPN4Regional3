const openAddModal = () => document.getElementById('addModal')?.classList.remove('hidden');
const closeAddModal = () => document.getElementById('addModal')?.classList.add('hidden');

const openEditModal = (username, name, email, level, kodeUnit) => {
    const editUsername = document.getElementById('editUsername');
    const editLevel = document.getElementById('editLevel');
    const unitSelectEdit = document.getElementById('unitSelectEdit');
    const editPassword = document.getElementById('editPassword');
    const editForm = document.getElementById('editForm');

    if (editUsername && editLevel && unitSelectEdit && editPassword && editForm) {
        editUsername.value = username;
        editLevel.value = level;
        unitSelectEdit.value = kodeUnit;
        editPassword.value = '';
        editForm.action = `/akun/${username}`;
    }

    document.getElementById('editModal')?.classList.remove('hidden');
};

const closeModal = () => document.getElementById('editModal')?.classList.add('hidden');

const confirmDelete = (username) => {
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
            loader?.classList.remove('hidden');

            return new Promise((resolve) => {
                setTimeout(() => {
                    document.getElementById(`delete-form-${username}`)?.submit();
                    resolve();
                }, 300);
            });
        }
    });
};

document.addEventListener('DOMContentLoaded', () => {
    const loader = document.getElementById('pageLoader');

    const logoutBtn = document.getElementById('logoutForm');
    logoutBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        loader?.classList.remove('hidden');
        setTimeout(() => {
            window.location.href = logoutBtn.getAttribute('href');
        }, 300);
    });

    const addakunForm = document.getElementById('addakunForm');
    const unitSelectAdd = document.getElementById('unitSelectAdd');
    const kodeUnitHidden = document.getElementById('kodeUnitHidden');

    if (addakunForm && unitSelectAdd && kodeUnitHidden) {
        addakunForm.addEventListener('submit', () => {
            kodeUnitHidden.value = unitSelectAdd.value || '';
        });
    }

    ['cariForm', 'editForm'].forEach(formId => {
        const form = document.getElementById(formId);
        form?.addEventListener('submit', () => loader?.classList.remove('hidden'));
    });

    const greetingEl = document.getElementById('greeting');
    if (greetingEl) {
        const hour = new Date().getHours();
        const greetings = [
            { start: 3, end: 10, text: 'Selamat pagi' },
            { start: 10, end: 15, text: 'Selamat siang' },
            { start: 15, end: 18, text: 'Selamat sore' }
        ];
        const greetingText = greetings.find(g => hour >= g.start && hour < g.end)?.text || 'Selamat malam';
        greetingEl.textContent = `${greetingText}, ${greetingEl.dataset.username}`;
    }

    const jabatanSelect = document.getElementById('jabatanSelect');
    if (jabatanSelect && unitSelectAdd && kodeUnitHidden) {
        const updateUnitField = () => {
            const selectedJabatan = jabatanSelect.value;
            if (['Admin', 'General_Manager', 'Region_Head'].includes(selectedJabatan)) {
                const kantorOption = Array.from(unitSelectAdd.options).find(opt =>
                    opt.textContent.trim().toLowerCase() === 'kantor regional'
                );
                if (kantorOption) {
                    unitSelectAdd.value = kantorOption.value;
                    kodeUnitHidden.value = kantorOption.value;
                }
                unitSelectAdd.disabled = true;
                unitSelectAdd.classList.add('bg-gray-100');
            } else {
                unitSelectAdd.disabled = false;
                unitSelectAdd.classList.remove('bg-gray-100');
                kodeUnitHidden.value = unitSelectAdd.value;
            }
        };

        jabatanSelect.addEventListener('change', updateUnitField);
        unitSelectAdd.addEventListener('change', () => {
            kodeUnitHidden.value = unitSelectAdd.value;
        });
        updateUnitField();
    }
});