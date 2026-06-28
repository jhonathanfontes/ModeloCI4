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

