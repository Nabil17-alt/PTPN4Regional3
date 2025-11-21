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
    const greetingEl = document.getElementById("greeting");
    const formBiaya = document.getElementById('formBiaya');


    if (logoutBtn) {
        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();
            loader.classList.remove('hidden');
            setTimeout(() => {
                window.location.href = logoutBtn.getAttribute('href');
            }, 300);
        });
    }

    if (pksSelect) {
        pksSelect.addEventListener('change', function () {
            const pks = this.value;
            if (pks) {
                if (loader) {
                    loader.classList.remove('hidden');
                }
                const url = new URL(window.location.href);
                url.searchParams.set('pks', pks);
                window.location.href = url.toString();
            }
        });
    }

    if (formBiaya) {
        formBiaya.addEventListener('submit', function () {
            const topLoader = document.getElementById('topLoader');
            if (!topLoader) return;

            topLoader.style.transition = "none";
            topLoader.style.width = "0%";
            topLoader.style.opacity = "1";
            topLoader.style.display = "block";
            void topLoader.offsetWidth;
            topLoader.style.transition = "width 0.6s cubic-bezier(.4,1,.7,1), opacity 0.6s";
            topLoader.style.width = "100%";
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