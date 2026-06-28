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
    initConfirmForms();
});

function initConfirmForms() {
    document.addEventListener('submit', function (e) {
        var form = e.target;
        var message = form.getAttribute('data-confirm');
        if (message) {
            e.preventDefault();
            Swal.fire({
                title: 'Confirmar',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#dc3545'
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    });
}

function initMasks() {
    document.querySelectorAll('[data-mask]').forEach(function (el) {
        var mask = el.getAttribute('data-mask');
        
        // Format initial value if any
        if (el.value) {
            var val = el.value.replace(/\D/g, '');
            var pat = getMaskPattern(mask, val.length);
            if (pat) {
                el.value = applyMask(val, pat);
            }
        }

        el.addEventListener('input', function () {
            var value = el.value.replace(/\D/g, '');
            var pattern = getMaskPattern(mask, value.length);
            if (pattern) {
                el.value = applyMask(value, pattern);
            }
        });
    });
}

function getMaskPattern(mask, len) {
    switch (mask) {
        case 'cpf': return '###.###.###-##';
        case 'cnpj': return '##.###.###/####-##';
        case 'cpf_cnpj':
        case 'cpfCnpj': return len <= 11 ? '###.###.###-##' : '##.###.###/####-##';
        case 'cep': return '#####-###';
        case 'phone':
        case 'telefone':
        case 'celular': return len <= 10 ? '(##) ####-####' : '(##) #####-####';
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
