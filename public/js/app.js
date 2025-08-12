lucide.createIcons();

document.addEventListener('DOMContentLoaded', () => {
    const loader = document.getElementById('buttonLoader');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const menuLinks = document.querySelectorAll('.menu-item');
    const openSidebarBtn = document.getElementById('openSidebar');
    const closeSidebarBtn = document.getElementById('closeSidebar');

    if (window.innerWidth < 768) {
        sidebar.classList.add('hidden');
        overlay.classList.add('hidden');
    }

    menuLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const href = link.getAttribute('href');

            loader.classList.remove('hidden');

            if (window.innerWidth < 768) {
                sidebar.classList.add('hidden');
                overlay.classList.add('hidden');
            }

            setTimeout(() => {
                window.location.href = href;
            }, 500);
        });
    });

    openSidebarBtn.addEventListener('click', () => {
        sidebar.classList.remove('hidden');
        overlay.classList.remove('hidden');
    });

    closeSidebarBtn.addEventListener('click', () => {
        sidebar.classList.add('hidden');
        overlay.classList.add('hidden');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.add('hidden');
        overlay.classList.add('hidden');
    });
});