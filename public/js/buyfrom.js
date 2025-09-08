function showTopLoader() {
    const loader = document.getElementById('topLoader');
    let progress = 0;
    loader.style.opacity = "1";
    loader.style.display = "block";
    loader.style.width = "0%";

    let interval = setInterval(() => {
        progress += Math.random() * 20 + 10;
        if (progress > 90) progress = 90;
        loader.style.width = progress + "%";
    }, 200);

    return interval;
}

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
    const inputIDs = [
        'rendemen_cpo',
        'rendemen_pk',
        'hargaCPO',
        'hargaPK',
        'biayaAngkut',
        'hargaEskalasi',
        'biayaOlah'
    ];

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
            setTimeout(() => {
                window.location.href = logoutBtn.getAttribute('href');
            }, 300);
        });
    }
}

function setupGreeting() {
    const greetingEl = document.getElementById("greeting");
    if (!greetingEl) return;

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

    const username = greetingEl.dataset.username || '';
    greetingEl.textContent = `${greetingText}, ${username}`;
}

document.addEventListener('DOMContentLoaded', () => {
    updateColumn();
    setupInputListeners();
    setupLogoutLoader();
    setupGreeting();

    const addbuyForm = document.getElementById('addbuyForm');
    if (addbuyForm) {
        addbuyForm.addEventListener('submit', function () {
            const loader = document.getElementById('topLoader');
            loader.style.transition = "none";
            loader.style.width = "0%";
            loader.style.opacity = "1";
            loader.style.display = "block";
            void loader.offsetWidth;
            loader.style.transition = "width 0.6s cubic-bezier(.4,1,.7,1), opacity 0.6s";
            loader.style.width = "100%";
        });
    }
});