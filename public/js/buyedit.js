function updateColumn() {
    const getValue = (id) => parseFloat(document.getElementById(id)?.value) || 0;
    const setValue = (id, value) => {
        const el = document.getElementById(id);
        if (el) el.value = isNaN(value) ? 0 : value.toFixed(2);
    };

    const rendemenCpo = getValue('rendemen_cpo');
    const rendemenPk = getValue('rendemen_pk');
    const hargaCpo = getValue('hargaCPO');
    const hargaPk = getValue('hargaPK');
    const biayaOlah = getValue('biayaOlah');
    const biayaAngkut = getValue('biayaAngkut');
    const hargaEskalasi = getValue('hargaEskalasi');

    const totalRendemen = rendemenCpo + rendemenPk;
    const pendapatanCpo = hargaCpo * (rendemenCpo / 100);
    const pendapatanPk = hargaPk * (rendemenPk / 100);
    const totalPendapatan = pendapatanCpo + pendapatanPk;
    const biayaProduksi = (biayaOlah / 100) * totalRendemen;
    const totalBiaya = biayaProduksi + biayaAngkut;
    const hargaPenetapan = totalPendapatan - totalBiaya;

    let margin = 0;
    if (hargaPenetapan !== 0) {
        margin = ((1 - (hargaEskalasi / hargaPenetapan)) * 100);
    }

    setValue('total_rendemen', totalRendemen);
    setValue('pendapatanCPO', pendapatanCpo);
    setValue('pendapatanPK', pendapatanPk);
    setValue('totalPendapatan', totalPendapatan);
    setValue('biayaProduksi', biayaProduksi);
    setValue('totalBiaya', totalBiaya);
    setValue('hargaPenetapan', hargaPenetapan);
    setValue('margin', margin);
}

function setupInputListeners() {
    const editForm = document.getElementById('editbuyForm');
    const userLevel = editForm ? editForm.dataset.userLevel : '';

    let inputIDs = ['hargaEskalasi']; // Always allow harga_escalasi to be edited

    // If user is Admin, also allow editing harga_cpo and harga_pk
    if (userLevel === 'Admin') {
        inputIDs.push('hargaCPO', 'hargaPK');

        // Make these fields editable for admin
        const hargaCPOEl = document.getElementById('hargaCPO');
        const hargaPKEl = document.getElementById('hargaPK');

        if (hargaCPOEl) {
            hargaCPOEl.readOnly = false;
            hargaCPOEl.classList.remove('bg-gray-100');
            hargaCPOEl.classList.add('focus:ring', 'focus:ring-indigo-200');
        }

        if (hargaPKEl) {
            hargaPKEl.readOnly = false;
            hargaPKEl.classList.remove('bg-gray-100');
            hargaPKEl.classList.add('focus:ring', 'focus:ring-indigo-200');
        }
    }

    inputIDs.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', updateColumn);
            el.addEventListener('change', updateColumn);
        }
    });
}

function setupLogoutLoader() {
    const loader = document.getElementById('pageLoader');
    const logoutBtn = document.getElementById('logoutForm');

    if (logoutBtn && loader) {
        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();
            loader.classList.remove('hidden');
            loader.classList.add('flex');
            setTimeout(() => {
                window.location.href = logoutBtn.getAttribute('href');
            }, 400);
        });
    }
}

function setupFormSubmit() {
    const editForm = document.getElementById('editbuyForm');
    const loader = document.getElementById('pageLoader');

    if (editForm && loader) {
        editForm.addEventListener('submit', function () {
            loader.classList.remove('hidden');
            loader.classList.add('flex');
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    updateColumn();
    setupInputListeners();
    setupLogoutLoader();
    setupFormSubmit();
});