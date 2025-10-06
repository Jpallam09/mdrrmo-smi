document.addEventListener('DOMContentLoaded', () => {
    const BREAKPOINT_MOBILE = 768; // match CSS
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');

    /* ===== Overlay setup ===== */
    const overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    document.body.appendChild(overlay);

    const openSidebar = () => {
        sidebar.classList.add('is-open');
        overlay.classList.add('is-visible');
        toggleBtn.setAttribute('aria-expanded', 'true');
    };

    const closeSidebar = () => {
        sidebar.classList.remove('is-open');
        overlay.classList.remove('is-visible');
        toggleBtn.setAttribute('aria-expanded', 'false');
    };

    const toggleSidebar = () =>
        sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar();

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', () => {
            if (window.innerWidth < BREAKPOINT_MOBILE) toggleSidebar();
        });

        overlay.addEventListener('click', closeSidebar);

        window.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeSidebar();
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= BREAKPOINT_MOBILE) {
                closeSidebar(); // sidebar always visible on larger screens
            }
        });
    }

    /* ===== Dropdown auto-close behavior ===== */
    const dropdowns = document.querySelectorAll('details');
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('toggle', () => {
            if (dropdown.open) {
                dropdowns.forEach(other => {
                    if (other !== dropdown) other.removeAttribute('open');
                });
            }
        });
    });
});
