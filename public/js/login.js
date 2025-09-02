document.addEventListener('DOMContentLoaded', () => {
    const loader = document.getElementById('pageLoader');
    const loginForm = document.getElementById('loginForm');
    const signupBtn = document.getElementById('signupBtn');

    const showLoader = () => loader?.classList.remove('hidden');

    loginForm?.addEventListener('submit', showLoader);

    signupBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        showLoader();
        setTimeout(() => {
            window.location.href = signupBtn.href;
        }, 1000);
    });
});

window.addEventListener('pageshow', (event) => {
    const loader = document.getElementById('pageLoader');
    const navType = performance.getEntriesByType('navigation')[0]?.type;
    if (event.persisted || navType === 'back_forward') {
        loader?.classList.add('hidden');
    }
});

window.addEventListener('load', () => {
    document.getElementById('pageLoader')?.classList.add('hidden');
});