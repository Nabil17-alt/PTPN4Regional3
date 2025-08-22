document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('pageLoader');

    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function () {
            loader.classList.remove('hidden');
        });
    }

    const signupBtn = document.getElementById('signupBtn');
    if (signupBtn) {
        signupBtn.addEventListener('click', function (e) {
            e.preventDefault();
            loader.classList.remove('hidden');

            setTimeout(() => {
                window.location.href = signupBtn.href;
            }, 1000);
        });
    }
});

window.addEventListener('pageshow', function (event) {
    const loader = document.getElementById('pageLoader');
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
        loader?.classList.add('hidden');
    }
});

window.addEventListener('load', function () {
    const loader = document.getElementById('pageLoader');
    loader?.classList.add('hidden');
});