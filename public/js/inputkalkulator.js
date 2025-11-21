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
});