function updateColumn() {
    const rendemenCpoInput = document.getElementById('rendemen_cpo');
    const rendemenPkInput = document.getElementById('rendemen_pk');
    const hargaCpoInput = document.getElementById('hargaCPO');
    const hargaPkInput = document.getElementById('hargaPK');
    const totalRendemenInput = document.getElementById('total_rendemen');
    const biayaOlahInput = document.getElementById('biayaOlah');
    const pendapatanCpoInput = document.getElementById('pendapatanCPO');
    const pendapatanPkInput = document.getElementById('pendapatanPK');
    const totalPendapatanInput = document.getElementById('totalPendapatan');
    const biayaProduksiInput = document.getElementById('biayaProduksi');
    const biayaAngkutInput = document.getElementById('biayaAngkut');
    const totalBiayaInput = document.getElementById('totalBiaya');
    const hargaPenetapanInput = document.getElementById('hargaPenetapan');
    const hargaEskalasiInput = document.getElementById('hargaEskalasi');
    const marginInput = document.getElementById('margin');

    const rendemenCpoValue = parseFloat(rendemenCpoInput?.value) || 0;
    const rendemenPkValue = parseFloat(rendemenPkInput?.value) || 0;
    const hargaCpoValue = parseFloat(hargaCpoInput?.value) || 0;
    const hargaPkValue = parseFloat(hargaPkInput?.value) || 0;
    const biayaOlahValue = parseFloat(biayaOlahInput?.value) || 0;
    const biayaAngkutValue = parseFloat(biayaAngkutInput?.value) || 0;
    const hargaEskalasiValue = parseFloat(hargaEskalasiInput?.value) || 0;

    const totalRendemen = rendemenCpoValue + rendemenPkValue;
    const pendapatanCpo = hargaCpoValue * (rendemenCpoValue / 100);
    const pendapatanPk = hargaPkValue * (rendemenPkValue / 100);
    const totalPendapatan = pendapatanCpo + pendapatanPk;
    const biayaProduksi = (biayaOlahValue / 100) * totalRendemen;
    const totalBiaya = biayaProduksi + biayaAngkutValue;
    const hargaPenetapan = totalPendapatan - totalBiaya;

    let margin = 0;
    if (hargaPenetapan !== 0) {
        margin = ((1 - (hargaEskalasiValue / hargaPenetapan)) * 100);
    }

    if (totalRendemenInput) totalRendemenInput.value = totalRendemen.toFixed(2);
    if (pendapatanCpoInput) pendapatanCpoInput.value = pendapatanCpo.toFixed(2);
    if (pendapatanPkInput) pendapatanPkInput.value = pendapatanPk.toFixed(2);
    if (totalPendapatanInput) totalPendapatanInput.value = totalPendapatan.toFixed(2);
    if (biayaProduksiInput) biayaProduksiInput.value = biayaProduksi.toFixed(2);
    if (totalBiayaInput) totalBiayaInput.value = totalBiaya.toFixed(2);
    if (hargaPenetapanInput) hargaPenetapanInput.value = hargaPenetapan.toFixed(2);
    if (marginInput) marginInput.value = margin.toFixed(2);
}

document.addEventListener('DOMContentLoaded', function () {
    updateColumn();

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

    const loader = document.getElementById('pageLoader');
    const addbuyForm = document.getElementById('addbuyForm');
    if (addbuyForm && loader) {
        addbuyForm.addEventListener('submit', function () {
            updateColumn(); // <-- Tambahan penting!
            loader.classList.remove('hidden');
        });
    }

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