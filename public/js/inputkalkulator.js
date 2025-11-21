document.addEventListener('DOMContentLoaded', function () {
    const pksSelect = document.getElementById('pks');
    const biayaSelect = document.getElementById('biaya_digunakan');

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
});