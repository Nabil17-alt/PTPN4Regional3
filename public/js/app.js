lucide.createIcons();

document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const openSidebarBtn = document.getElementById('openSidebar');
    const closeSidebarBtn = document.getElementById('closeSidebar');
    const loader = document.getElementById('buttonLoader');

    function updateSidebarVisibility() {
        const width = window.innerWidth;

        if (width >= 640 && width < 768) {
            sidebar.classList.remove('hidden');
            sidebar.classList.add('flex');
            overlay.classList.remove('hidden');
            openSidebarBtn?.classList.add('hidden');
            closeSidebarBtn?.classList.add('hidden');
        } else if (width < 640) {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('flex');
            overlay.classList.add('hidden');
            openSidebarBtn?.classList.remove('hidden');
            closeSidebarBtn?.classList.remove('hidden');
        } else {
            sidebar.classList.remove('hidden');
            sidebar.classList.add('flex');
            overlay.classList.add('hidden');
            openSidebarBtn?.classList.add('hidden');
            closeSidebarBtn?.classList.add('hidden');
        }
    }

    updateSidebarVisibility();
    window.addEventListener('resize', updateSidebarVisibility);

    openSidebarBtn?.addEventListener('click', () => {
        sidebar.classList.remove('hidden');
        sidebar.classList.add('flex');
        overlay.classList.remove('hidden');
    });

    closeSidebarBtn?.addEventListener('click', () => {
        sidebar.classList.add('hidden');
        sidebar.classList.remove('flex');
        overlay.classList.add('hidden');
    });

    overlay?.addEventListener('click', () => {
        sidebar.classList.add('hidden');
        sidebar.classList.remove('flex');
        overlay.classList.add('hidden');
    });

    document.querySelectorAll('.menu-item').forEach(link => {
        link.addEventListener('click', function (e) {
            loader?.classList.remove('hidden');
            loader?.classList.add('flex');
        });
    });
});

window.addEventListener('pageshow', function (event) {
    const loader = document.getElementById('buttonLoader');
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
        loader?.classList.add('hidden');
        loader?.classList.remove('flex');
    }
});

window.addEventListener('load', function () {
    const loader = document.getElementById('buttonLoader');
    loader?.classList.add('hidden');
    loader?.classList.remove('flex');
});