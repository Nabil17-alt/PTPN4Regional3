lucide.createIcons();

document.addEventListener('DOMContentLoaded', () => {
    const loader = document.getElementById('buttonLoader');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const menuLinks = document.querySelectorAll('.menu-item');
    const openSidebarBtn = document.getElementById('openSidebar');
    const closeSidebarBtn = document.getElementById('closeSidebar');

    // Sembunyikan sidebar saat awal load jika mobile
    if (window.innerWidth < 768) {
        sidebar.classList.add('hidden');
        overlay.classList.add('hidden');
    }

    // Navigasi menu dengan loader dan auto-tutup sidebar (mobile)
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

    // Buka sidebar
    openSidebarBtn.addEventListener('click', () => {
        sidebar.classList.remove('hidden');
        overlay.classList.remove('hidden');
    });

    // Tutup sidebar
    closeSidebarBtn.addEventListener('click', () => {
        sidebar.classList.add('hidden');
        overlay.classList.add('hidden');
    });

    // Klik overlay untuk tutup sidebar
    overlay.addEventListener('click', () => {
        sidebar.classList.add('hidden');
        overlay.classList.add('hidden');
    });
});
