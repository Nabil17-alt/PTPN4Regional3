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
