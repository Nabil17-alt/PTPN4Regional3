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

let currentBiayaOlah = 0;
let currentBProduksiPerTbsOlah = 0;
let currentBiayaAngkutJual = 0;

document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('pageLoader');
    const logoutBtn = document.getElementById('logoutForm');
    const pksSelect = document.getElementById('pks');
    const biayaSelect = document.getElementById('biaya_digunakan');
    const greetingEl = document.getElementById("greeting");

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

                currentBiayaOlah = parseFloat(selected.biaya_olah) || 0;
                currentBProduksiPerTbsOlah = parseFloat(selected.b_produksi_per_tbs_olah) || 0;
                currentBiayaAngkutJual = parseFloat(selected.biaya_angkut_jual) || 0;

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

    updateColumn();
});

function updateColumn() {
    const getInputValue = (el) => parseFloat(el && el.value) || 0;
    const setInputValue = (el, value) => {
        if (!el) return;
        el.value = isNaN(value) ? 0 : value.toFixed(2);
    };

    const getRupiahInputValue = (el) => {
        if (!el) return 0;
        let raw = (el.value || '').toString().trim();
        if (!raw) return 0;

        raw = raw.replace(/\./g, '').replace(',', '.');

        const num = parseFloat(raw);
        return isNaN(num) ? 0 : num;
    };

    const hargaCpoEl = document.getElementById('hargaCPO');
    const hargaPkEl = document.getElementById('hargaPK');
    const hargaCpo = getRupiahInputValue(hargaCpoEl);
    const hargaPk = getRupiahInputValue(hargaPkEl);

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
        const bProduksiEl = row.querySelector('input.b_produksi');
        const biayaAngkutJualEl = row.querySelector('input.biaya_angkut');

        const rendemenCpo = getInputValue(rendCpoEl);
        const rendemenPk = getInputValue(rendPkEl);
        const hargaPenetapanManual = getRupiahInputValue(hargaPenetapanEl);

        setInputValue(bProduksiEl, currentBProduksiPerTbsOlah);
        setInputValue(biayaAngkutJualEl, currentBiayaAngkutJual);

        const pendapatanCpo = hargaCpo * (rendemenCpo / 100);
        const pendapatanPk = hargaPk * (rendemenPk / 100);

        const hargaBep = (pendapatanCpo + pendapatanPk) - (currentBProduksiPerTbsOlah + currentBiayaAngkutJual);

        let eskalasi = 0;
        if (hargaBep !== 0 && hargaPenetapanManual !== 0) {
            eskalasi = (hargaBep - hargaPenetapanManual) / 500;
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

    // perbarui tabel preview rekap
    updatePreviewTable(hargaCpo, hargaPk);
}

// Render tabel preview menggunakan nilai form saat ini
function updatePreviewTable(hargaCpo, hargaPk) {
    // gunakan tbody khusus live preview agar tidak menimpa data dari DB
    const tbody = document.getElementById('previewTbodyLive');
    if (!tbody) return;

    const gradeRows = document.querySelectorAll('.grade-row');
    const pks = (document.getElementById('pks') && document.getElementById('pks').value) || '-';

    const fmtNum = (n) => {
        const v = parseFloat(n);
        if (isNaN(v)) return '-';
        return v.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    };

    const rows = [];
    gradeRows.forEach((row, idx) => {
        const gradeSel = row.querySelector('select[name="grade[]"]');
        const rendCpoEl = row.querySelector('input[name="rend_cpo[]"]');
        const rendPkEl = row.querySelector('input[name="rend_pk[]"]');
        const hargaBepEl = row.querySelector('input[name="harga_bep[]"]');
        const hargaPenetapanEl = row.querySelector('input[name="harga_penetapan_grade[]"]');
        const eskalasiEl = row.querySelector('input[name="harga_eskalasi[]"]');
        const pesaingEl = row.querySelector('input[name="info_harga_pesaing[]"]');

        const gradeVal = gradeSel && gradeSel.value ? gradeSel.value : '';
        const rendCpo = parseFloat(rendCpoEl && rendCpoEl.value) || 0;
        const rendPk = parseFloat(rendPkEl && rendPkEl.value) || 0;
        const hargaBep = parseFloat(hargaBepEl && hargaBepEl.value) || 0;
        const hargaPenetapan = parseFloat(hargaPenetapanEl && hargaPenetapanEl.value) || 0;
        const eskalasi = parseFloat(eskalasiEl && eskalasiEl.value) || 0;
        const hargaPesaing = parseFloat(pesaingEl && pesaingEl.value) || 0;

        // Jika baris benar-benar kosong, lewati
        const hasAny = gradeVal || rendCpo || rendPk || hargaBep || hargaPenetapan || hargaPesaing;
        if (!hasAny) return;

        // Harga Saat Ini = harga penetapan manual
        const hargaSaatIni = hargaPenetapan;
        // Harga Kemarin belum tersedia dari form/backend saat ini
        const hargaKemarin = null;
        // Selisih (Saat Ini - Kemarin) jika keduanya tersedia; else '-'
        const selisih = (hargaSaatIni != null && hargaKemarin != null) ? (hargaSaatIni - hargaKemarin) : null;

        rows.push(`
            <tr>
                <td class="px-3 py-2 border-b align-middle text-center">${idx + 1}</td>
                <td class="px-3 py-2 border-b align-middle">${pks || '-'}</td>
                <td class="px-3 py-2 border-b align-middle">${gradeVal || '-'}</td>
                <td class="px-3 py-2 border-b align-middle text-right">${fmtNum(hargaCpo)}</td>
                <td class="px-3 py-2 border-b align-middle text-right">${fmtNum(hargaPk)}</td>
                <td class="px-3 py-2 border-b align-middle text-right">${fmtNum(rendCpo)}</td>
                <td class="px-3 py-2 border-b align-middle text-right">${fmtNum(rendPk)}</td>
                <td class="px-3 py-2 border-b align-middle text-right">${fmtNum(hargaBep)}</td>
                <td class="px-3 py-2 border-b align-middle text-right">${fmtNum(hargaSaatIni)}</td>
                <td class="px-3 py-2 border-b align-middle text-right">${hargaKemarin == null ? '-' : fmtNum(hargaKemarin)}</td>
                <td class="px-3 py-2 border-b align-middle text-right">${selisih == null ? '-' : fmtNum(selisih)}</td>
                <td class="px-3 py-2 border-b align-middle text-right">${fmtNum(hargaPesaing)}</td>
                <td class="px-3 py-2 border-b align-middle text-right">${(isNaN(eskalasi) ? '-' : eskalasi.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }))}</td>
            </tr>
        `);
    });

    if (rows.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td class="px-3 py-2 border-b text-center" colspan="12">Belum ada data ditampilkan.</td>
            </tr>
        `;
    } else {
        tbody.innerHTML = rows.join('');
    }
}