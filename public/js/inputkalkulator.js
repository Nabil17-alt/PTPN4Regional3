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

    if (!pksSelect || !biayaSelect || !Array.isArray(biayaList)) {
        return;
    }

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
            if (typeof updateColumn === 'function') {
                updateColumn();
            }
        }
    });

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

    const inputIDs = [
        'rendemen_cpo',
        'rendemen_pk',
        'hargaCPO',
        'hargaPK'
        // biayaOlah & biayaAngkut diisi otomatis dari biayaList, tapi bisa juga ikut supaya jika berubah manual langsung hitung
        , 'biayaOlah',
        'biayaAngkut'
    ];

    inputIDs.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', updateColumn);
            el.addEventListener('change', updateColumn);
        }
    });

    // hitung awal
    updateColumn();
});

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
    const hargaEskalasiInput = getValue('hargaEskalasi'); // bebas: bisa dipakai atau hanya output

    const totalRendemen = rendemenCpo + rendemenPk;
    const pendapatanCpo = hargaCpo * (rendemenCpo / 100);
    const pendapatanPk = hargaPk * (rendemenPk / 100);
    const totalPendapatan = pendapatanCpo + pendapatanPk;
    const biayaProduksi = (biayaOlah / 100) * totalRendemen;
    const totalBiaya = biayaProduksi + biayaAngkut;
    const hargaPenetapan = totalPendapatan - totalBiaya; // ini yang akan mengisi harga_penetapan_grade

    // Harga BEP otomatis diisi ketika rendemen CPO & PK sudah ada
    // di sini saya isi sama dengan biayaProduksi per kg (bisa Anda ubah rumus jika ada ketentuan lain)
    const hargaBep = biayaProduksi;

    // Eskalasi otomatis ketika sudah ada harga penetapan:
    // misal rumus: eskalasi = (hargaPenetapan / hargaBep - 1) * 100 (persen)
    let eskalasi = 0;
    if (hargaBep !== 0) {
        eskalasi = ((hargaPenetapan / hargaBep) - 1) * 100;
    }

    // Margin jika Anda tetap ingin pakai logika lama:
    let margin = 0;
    if (hargaPenetapan !== 0 && hargaEskalasiInput !== 0) {
        margin = ((1 - (hargaEskalasiInput / hargaPenetapan)) * 100);
    }

    setValue('total_rendemen', totalRendemen);
    setValue('pendapatanCPO', pendapatanCpo);
    setValue('pendapatanPK', pendapatanPk);
    setValue('totalPendapatan', totalPendapatan);
    setValue('biayaProduksi', biayaProduksi);
    setValue('totalBiaya', totalBiaya);

    // ini dua poin utama permintaan Anda:
    setValue('harga_bep', hargaBep);          // Harga BEP otomatis
    setValue('hargaPenetapan', hargaPenetapan); // Harga Penetapan (hasil) otomatis
    setValue('hargaEskalasi', eskalasi);     // Eskalasi (%) otomatis

    setValue('margin', margin);
}