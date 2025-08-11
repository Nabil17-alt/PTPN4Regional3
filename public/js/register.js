document.addEventListener("DOMContentLoaded", function () {
    const loader = document.getElementById('buttonLoader');

    const registerForm = document.querySelector('.register-form');
    if (registerForm) {
        registerForm.addEventListener('submit', function () {
            loader.classList.remove('hidden');
        });
    }

    const signinBtn = document.getElementById('signinBtn');
    if (signinBtn) {
        signinBtn.addEventListener('click', function (e) {
            e.preventDefault();
            loader.classList.remove('hidden');
            setTimeout(() => {
                window.location.href = signinBtn.href;
            }, 1000);
        });
    }
});
