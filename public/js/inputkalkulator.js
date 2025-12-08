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

document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('pageLoader');
    const logoutBtn = document.getElementById('logoutForm');
    const pksSelect = document.getElementById('pks');
    const biayaSelect = document.getElementById('biaya_digunakan');
    const greetingEl = document.getElementById("greeting");

    // inisialisasi dropdown biaya jika data tersedia
    if (pksSelect && biayaSelect && Array.isArray(biayaList)) {
        resetBiayaOptions();
        biayaSelect.disabled = true;

        pksSelect.addEventListener('change', function () {
            const selectedPks = this.value;
            resetBiayaOptions();

            if (!selectedPks) {
                biayaSelect.disabled = true;
                return;
            }

            const filtered = biayaList.filter(function (b) {
                return b.nama_pks === selectedPks;
            });

            const monthNames = [
                'Januari', 'Februari', 'Maret', 'April',
                'Mei', 'Juni', 'Juli', 'Agustus',
                'September', 'Oktober', 'November', 'Desember'
            ];

            filtered.forEach(function (b) {
                const opt = document.createElement('option');
                opt.value = b.id;

                const parts = String(b.bulan).split('-');
                let label = b.bulan;
                if (parts.length === 2) {
                    const monthIndex = parseInt(parts[1], 10) - 1;
                    if (monthIndex >= 0 && monthIndex < 12) {
                        label = monthNames[monthIndex];
                    }
                }

                opt.textContent = label;
                biayaSelect.appendChild(opt);
            });

            biayaSelect.disabled = filtered.length === 0;
        });

        biayaSelect.addEventListener('change', function () {
            const selectedId = parseInt(this.value, 10);
            const selected = biayaList.find(b => b.id === selectedId);

            if (selected) {
                const biayaOlahEl = document.getElementById('biayaOlah');
                const biayaAngkutEl = document.getElementById('biayaAngkut');

                const totalAngkut = (parseFloat(selected.tarif_angkut_cpo) || 0) +
                    (parseFloat(selected.tarif_angkut_pk) || 0);

                if (biayaOlahEl) biayaOlahEl.value = selected.biaya_olah || 0;
                if (biayaAngkutEl) biayaAngkutEl.value = totalAngkut.toFixed(2);

                // setelah ambil biaya, hitung ulang
                updateColumn();
            }
        });
    }

    function resetBiayaOptions() {
        while (biayaSelect.firstChild) {
            biayaSelect.removeChild(biayaSelect.firstChild);
        }
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.textContent = 'Biaya bulan mana...';
        biayaSelect.appendChild(defaultOption);
    }

    if (logoutBtn) {
        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();
            loader.classList.remove('hidden');
            setTimeout(() => {
                window.location.href = logoutBtn.getAttribute('href');
            }, 300);
        });
    }

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

    const hargaCpoInput = document.getElementById('hargaCPO');
    const hargaPkInput = document.getElementById('hargaPK');

    if (hargaCpoInput) {
        hargaCpoInput.addEventListener('input', updateColumn);
        hargaCpoInput.addEventListener('change', updateColumn);
    }

    if (hargaPkInput) {
        hargaPkInput.addEventListener('input', updateColumn);
        hargaPkInput.addEventListener('change', updateColumn);
    }

    document.addEventListener('input', function (e) {
        if (e.target.matches('input[name="rend_cpo[]"]') ||
            e.target.matches('input[name="rend_pk[]"]') ||
            e.target.matches('input[name="harga_penetapan_grade[]"]')) {
            updateColumn();
        }
    });

    document.addEventListener('change', function (e) {
        if (e.target.matches('input[name="rend_cpo[]"]') ||
            e.target.matches('input[name="rend_pk[]"]') ||
            e.target.matches('input[name="harga_penetapan_grade[]"]')) {
            updateColumn();
        }
    });

    // hitung awal (jika ada nilai default di beberapa grade)
    updateColumn();
});

function updateColumn() {
    const getInputValue = (el) => parseFloat(el && el.value) || 0;
    const setInputValue = (el, value) => {
        if (!el) return;
        el.value = isNaN(value) ? 0 : value.toFixed(2);
    };

    const hargaCpoEl = document.getElementById('hargaCPO');
    const hargaPkEl = document.getElementById('hargaPK');
    const hargaCpo = getInputValue(hargaCpoEl);
    const hargaPk = getInputValue(hargaPkEl);

    let totalPendapatanCpo = 0;
    let totalPendapatanPk = 0;
    let totalBep = 0;

    const gradeRows = document.querySelectorAll('.grade-row');

    gradeRows.forEach((row) => {
        const rendCpoEl = row.querySelector('input[name="rend_cpo[]"]');
        const rendPkEl = row.querySelector('input[name="rend_pk[]"]');
        const hargaBepEl = row.querySelector('input.harga_bep');
        const hargaPenetapanEl = row.querySelector('input[name="harga_penetapan_grade[]"]');
        const eskalasiEl = row.querySelector('input.hargaEskalasi');

        const rendemenCpo = getInputValue(rendCpoEl);
        const rendemenPk = getInputValue(rendPkEl);
        const hargaPenetapanManual = getInputValue(hargaPenetapanEl);

        const pendapatanCpo = hargaCpo * (rendemenCpo / 100);
        const pendapatanPk = hargaPk * (rendemenPk / 100);
        const hargaBep = pendapatanCpo + pendapatanPk;

        let eskalasi = 0;
        if (hargaBep !== 0 && hargaPenetapanManual !== 0) {
            eskalasi = ((hargaPenetapanManual - hargaBep) / hargaBep) * 100;
        }

        setInputValue(hargaBepEl, hargaBep);
        setInputValue(eskalasiEl, eskalasi);

        totalPendapatanCpo += pendapatanCpo;
        totalPendapatanPk += pendapatanPk;
        totalBep += hargaBep;
    });

    const pendapatanCpoRingkasan = document.getElementById('pendapatanCPO');
    const pendapatanPkRingkasan = document.getElementById('pendapatanPK');
    const totalPendapatanRingkasan = document.getElementById('totalPendapatan');
    const ringkasanBepEl = document.getElementById('ringkasanHargaBep');
    const ringkasanPenetapanEl = document.getElementById('ringkasanHargaPenetapan');
    const ringkasanEskalasiEl = document.getElementById('ringkasanEskalasi');

    setInputValue(pendapatanCpoRingkasan, totalPendapatanCpo);
    setInputValue(pendapatanPkRingkasan, totalPendapatanPk);
    setInputValue(totalPendapatanRingkasan, totalBep);
    setInputValue(ringkasanBepEl, totalBep);

    if (ringkasanPenetapanEl && ringkasanEskalasiEl) {
        if (gradeRows.length > 0) {
            const lastRow = gradeRows[gradeRows.length - 1];
            const lastPenetapanEl = lastRow.querySelector('input[name="harga_penetapan_grade[]"]');
            const lastEskalasiEl = lastRow.querySelector('input.hargaEskalasi');

            const lastPenetapan = getInputValue(lastPenetapanEl);
            const lastEskalasi = getInputValue(lastEskalasiEl);

            setInputValue(ringkasanPenetapanEl, lastPenetapan);
            setInputValue(ringkasanEskalasiEl, lastEskalasi);
        } else {
            setInputValue(ringkasanPenetapanEl, 0);
            setInputValue(ringkasanEskalasiEl, 0);
        }
    }
}