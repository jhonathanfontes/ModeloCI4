document.addEventListener('DOMContentLoaded', function () {
    var toggle = document.getElementById('painelSidebarToggle');
    var sidebar = document.getElementById('painelSidebar');

    if (toggle && sidebar) {
        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            sidebar.classList.toggle('open');
        });

        document.addEventListener('click', function (e) {
            if (window.innerWidth <= 768 &&
                !sidebar.contains(e.target) &&
                !toggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
    }

    var navItems = document.querySelectorAll('.painel-nav .nav-item');
    var currentPath = window.location.pathname.replace(/\/+$/, '');
    navItems.forEach(function (item) {
        var href = item.getAttribute('href');
        if (href && href.replace(/\/+$/, '') === currentPath) {
            item.classList.add('active');
        }
    });
});
