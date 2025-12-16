document.addEventListener('DOMContentLoaded', () => {
    const dropdowns = document.querySelectorAll('.dropdown-wrapper');

    dropdowns.forEach(wrapper => {
        const toggle = wrapper.querySelector('.dropdown-toggle');
        const menu = wrapper.querySelector('.dropdown-menu');
        let hoverTimeout;

        toggle?.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();

            // Close other open dropdowns
            document.querySelectorAll('.dropdown-menu.show').forEach(open => {
                if (open !== menu) open.classList.remove('show');
            });

            // Toggle current menu
            menu.classList.toggle('show');
        });

        // Handle hover so it doesn’t close instantly
        wrapper.addEventListener('mouseenter', () => {
            clearTimeout(hoverTimeout);
        });

        wrapper.addEventListener('mouseleave', () => {
            hoverTimeout = setTimeout(() => {
                menu.classList.remove('show');
            }, 300);
        });
    });

    // Close dropdowns if clicking outside
    document.addEventListener('click', (e) => {
        document.querySelectorAll('.dropdown-wrapper .dropdown-menu.show').forEach(menu => {
            if (!menu.parentElement.contains(e.target)) {
                menu.classList.remove('show');
            }
        });
    });

    // Simulate notification count
    setTimeout(() => {
        const badge = document.querySelector('.notification .badge');
        if (badge) badge.textContent = '5';
    }, 3000);
});
