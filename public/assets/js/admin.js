document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');

    if (toggle && sidebar) {
        toggle.addEventListener('click', function () {
            sidebar.classList.toggle('open');
        });

        document.addEventListener('click', function (e) {
            if (window.innerWidth <= 768) {
                const isClickInside = sidebar.contains(e.target) || toggle.contains(e.target);
                if (!isClickInside) {
                    sidebar.classList.remove('open');
                }
            }
        });
    }

    const navItems = document.querySelectorAll('.nav-item');
    const currentPath = window.location.pathname;

    navItems.forEach(function (item) {
        const href = item.getAttribute('href');
        if (href && currentPath.startsWith(href) && href !== '/admin') {
            item.classList.add('active');
        }
        if (href && href === '/admin' && currentPath === '/admin') {
            item.classList.add('active');
        }
    });
});
