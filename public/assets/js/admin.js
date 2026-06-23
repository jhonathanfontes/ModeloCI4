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

    initMasks();
});

function initMasks() {
    document.querySelectorAll('[data-mask]').forEach(function (el) {
        var mask = el.getAttribute('data-mask');
        el.addEventListener('input', function () {
            var value = el.value.replace(/\D/g, '');
            var pattern = getMaskPattern(mask, value.length);
            el.value = applyMask(value, pattern);
        });
    });
}

function getMaskPattern(mask, len) {
    switch (mask) {
        case 'cpf': return '###.###.###-##';
        case 'cnpj': return '##.###.###/####-##';
        case 'cpfCnpj': return len <= 11 ? '###.###.###-##' : '##.###.###/####-##';
        case 'cep': return '#####-###';
        case 'telefone': return len <= 10 ? '(##) ####-####' : '(##) #####-####';
        case 'celular': return '(##) #####-####';
        case 'placa': return 'AAA-####';
        case 'data': return '##/##/####';
        default: return '';
    }
}

function applyMask(value, pattern) {
    var result = '';
    var idx = 0;
    for (var i = 0; i < pattern.length && idx < value.length; i++) {
        if (pattern[i] === '#') {
            result += value[idx++];
        } else {
            result += pattern[i];
        }
    }
    return result;
}
