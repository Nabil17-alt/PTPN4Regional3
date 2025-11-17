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
            showSidebar(true);
            toggleOverlay(true);
            toggleButtons(false);
        } else if (width < 640) {
            showSidebar(false);
            toggleOverlay(false);
            toggleButtons(true);
        } else {
            showSidebar(true);
            toggleOverlay(false);
            toggleButtons(false);
        }
    }

    /**
     * Show or hide sidebar.
     * @param {boolean} show
     */
    function showSidebar(show) {
        sidebar.classList.toggle('hidden', !show);
        sidebar.classList.toggle('flex', show);
    }

    /**
     * Show or hide overlay.
     * @param {boolean} show
     */
    function toggleOverlay(show) {
        overlay.classList.toggle('hidden', !show);
    }

    /**
     * Show or hide open/close buttons.
     * @param {boolean} show
     */
    function toggleButtons(show) {
        openSidebarBtn?.classList.toggle('hidden', !show);
        closeSidebarBtn?.classList.toggle('hidden', !show);
    }

    updateSidebarVisibility();
    window.addEventListener('resize', updateSidebarVisibility);

    openSidebarBtn?.addEventListener('click', () => {
        showSidebar(true);
        toggleOverlay(true);
    });

    closeSidebarBtn?.addEventListener('click', () => {
        showSidebar(false);
        toggleOverlay(false);
    });

    overlay?.addEventListener('click', () => {
        showSidebar(false);
        toggleOverlay(false);
    });

    function attachLoaderOnLinks(selector) {
        document.querySelectorAll(selector).forEach(link => {
            link.addEventListener('click', (event) => {
                const target = event.currentTarget;
                const tagName = target.tagName.toLowerCase();
                const hasHref = tagName === 'a' && target.getAttribute('href');

                if (!hasHref) {
                    return;
                }

                loader?.classList.remove('hidden');
                loader?.classList.add('flex');
            });
        });
    }

    // Loader untuk menu utama dan submenu kalkulator harga
    attachLoaderOnLinks('.menu-item');
    attachLoaderOnLinks('#kalkulatorSubmenu .submenu-item');
});

window.addEventListener('pageshow', (event) => {
    const loader = document.getElementById('buttonLoader');
    const navType = performance.getEntriesByType('navigation')[0]?.type;
    if (event.persisted || navType === 'back_forward') {
        loader?.classList.add('hidden');
        loader?.classList.remove('flex');
    }
});

window.addEventListener('load', () => {
    const loader = document.getElementById('buttonLoader');
    loader?.classList.add('hidden');
    loader?.classList.remove('flex');
});