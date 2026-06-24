<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], static function (RouteCollection $routes) {
    $routes->get('/',             'Dashboard::index',   ['as' => 'admin.dashboard']);

    $routes->get('usuarios',        'Usuarios::index',   ['as' => 'admin.usuarios']);
    $routes->get('usuarios/novo',   'Usuarios::novo',    ['as' => 'admin.usuarios.novo']);
    $routes->get('usuarios/(:num)', 'Usuarios::editar/$1', ['as' => 'admin.usuarios.editar']);
    $routes->post('usuarios/salvar',  'Usuarios::salvar',  ['as' => 'admin.usuarios.salvar']);
    $routes->post('usuarios/(:num)/excluir', 'Usuarios::excluir/$1', ['as' => 'admin.usuarios.excluir']);

    $routes->get('empresas',                'Empresas::index',        ['as' => 'admin.empresas']);
    $routes->get('empresas/novo',           'Empresas::novo',         ['as' => 'admin.empresas.novo']);
    $routes->get('empresas/visualizar/(:num)', 'Empresas::visualizar/$1', ['as' => 'admin.empresas.visualizar']);
    $routes->get('empresas/(:num)',          'Empresas::editar/$1',    ['as' => 'admin.empresas.editar']);
    $routes->post('empresas/salvar',  'Empresas::salvar',  ['as' => 'admin.empresas.salvar']);
    $routes->post('empresas/(:num)/excluir', 'Empresas::excluir/$1', ['as' => 'admin.empresas.excluir']);

    $routes->get('empresas/(:num)/usuarios',          'EmpresaUsuarios::index/$1',      ['as' => 'admin.empresas.usuarios']);
    $routes->get('empresas/(:num)/usuarios/vincular', 'EmpresaUsuarios::vincular/$1',   ['as' => 'admin.empresas.usuarios.vincular']);
    $routes->post('empresas/(:num)/usuarios/salvar',    'EmpresaUsuarios::salvar/$1',     ['as' => 'admin.empresas.usuarios.salvar']);
    $routes->post('empresas/(:num)/usuarios/(:num)/desvincular', 'EmpresaUsuarios::desvincular/$1/$2', ['as' => 'admin.empresas.usuarios.desvincular']);

    // Empresa Serviços (UUID nas URLs)
    $routes->get('empresas/(:any)/servicos',                          'EmpresaServicos::index/$1',          ['as' => 'admin.empresas.servicos']);
    $routes->post('empresas/(:any)/servicos/salvar-licenca',          'EmpresaServicos::salvarLicenca/$1',  ['as' => 'admin.empresas.servicos.salvar-licenca']);
    $routes->post('empresas/(:any)/servicos/salvar',                  'EmpresaServicos::salvarServicos/$1', ['as' => 'admin.empresas.servicos.salvar']);

    // Planos (UUID nas URLs)
    $routes->get('planos',                            'Planos::index',             ['as' => 'admin.planos']);
    $routes->get('planos/novo',                       'Planos::novo',              ['as' => 'admin.planos.novo']);
    $routes->get('planos/visualizar/(:any)',          'Planos::visualizar/$1',    ['as' => 'admin.planos.visualizar']);
    $routes->get('planos/editar/(:any)',              'Planos::editar/$1',        ['as' => 'admin.planos.editar']);
    $routes->post('planos/salvar',                     'Planos::salvar',           ['as' => 'admin.planos.salvar']);
    $routes->post('planos/(:any)/excluir',            'Planos::excluir/$1',       ['as' => 'admin.planos.excluir']);

    // Menu
    $routes->get('menu',                          'Menu::index',             ['as' => 'admin.menu']);
    $routes->get('menu/modulos/novo',             'Menu::moduloNovo',        ['as' => 'admin.menu.modulo.novo']);
    $routes->get('menu/modulos/(:num)',           'Menu::moduloEditar/$1',   ['as' => 'admin.menu.modulo.editar']);
    $routes->post('menu/modulos/salvar',           'Menu::moduloSalvar',      ['as' => 'admin.menu.modulo.salvar']);
    $routes->post('menu/modulos/(:num)/excluir',  'Menu::moduloExcluir/$1',  ['as' => 'admin.menu.modulo.excluir']);
    $routes->get('menu/servicos/(:num)',          'Menu::servicos/$1',       ['as' => 'admin.menu.servicos']);
    $routes->get('menu/servicos/novo/(:num)',     'Menu::servicoNovo/$1',    ['as' => 'admin.menu.servico.novo']);
    $routes->get('menu/servicos/editar/(:num)',   'Menu::servicoEditar/$1',  ['as' => 'admin.menu.servico.editar']);
    $routes->post('menu/servicos/salvar',          'Menu::servicoSalvar',     ['as' => 'admin.menu.servico.salvar']);
    $routes->post('menu/servicos/(:num)/excluir', 'Menu::servicoExcluir/$1', ['as' => 'admin.menu.servico.excluir']);
    $routes->post('menu/servicos/(:num)/copiar',  'Menu::servicoCopiar/$1',  ['as' => 'admin.menu.servico.copiar']);
    $routes->get('menu/funcionalidades/(:num)',       'Menu::funcionalidades/$1',       ['as' => 'admin.menu.funcionalidades']);
    $routes->get('menu/funcionalidades/novo/(:num)',  'Menu::funcionalidadeNovo/$1',    ['as' => 'admin.menu.funcionalidade.novo']);
    $routes->get('menu/funcionalidades/editar/(:num)', 'Menu::funcionalidadeEditar/$1',  ['as' => 'admin.menu.funcionalidade.editar']);
    $routes->post('menu/funcionalidades/salvar',       'Menu::funcionalidadeSalvar',     ['as' => 'admin.menu.funcionalidade.salvar']);
    $routes->post('menu/funcionalidades/(:num)/excluir', 'Menu::funcionalidadeExcluir/$1', ['as' => 'admin.menu.funcionalidade.excluir']);
});

$routes->get('painel/login',  'Painel\Login::index',     ['as' => 'painel.login']);
$routes->post('painel/login', 'Painel\Login::autenticar', ['as' => 'painel.autenticar']);
$routes->get('painel/logout', 'Painel\Login::sair',       ['as' => 'painel.logout']);

$routes->group('painel', ['namespace' => 'App\Controllers\Painel', 'filter' => 'auth'], static function (RouteCollection $routes) {
    $routes->get('/',                'Dashboard::index', ['as' => 'painel.dashboard']);
    $routes->get('empresa/ativar/(:num)', 'Empresa::ativar/$1', ['as' => 'painel.empresa.ativar']);
    $routes->group('cadastros', static function (RouteCollection $routes) {
        // Cadastro CRUD
        $routes->get('clientes',              'Clientes::index',        ['as' => 'painel.clientes']);
        $routes->get('clientes/novo',         'Clientes::novo',         ['as' => 'painel.clientes.novo']);
        $routes->get('clientes/(:num)',       'Clientes::editar/$1',    ['as' => 'painel.clientes.editar']);
        $routes->post('clientes/salvar',      'Clientes::salvar',       ['as' => 'painel.clientes.salvar']);
        $routes->post('clientes/(:num)/excluir', 'Clientes::excluir/$1', ['as' => 'painel.clientes.excluir']);

        $routes->get('fornecedores',              'Fornecedores::index',        ['as' => 'painel.fornecedores']);
        $routes->get('fornecedores/novo',         'Fornecedores::novo',         ['as' => 'painel.fornecedores.novo']);
        $routes->get('fornecedores/(:num)',       'Fornecedores::editar/$1',     ['as' => 'painel.fornecedores.editar']);
        $routes->post('fornecedores/salvar',      'Fornecedores::salvar',        ['as' => 'painel.fornecedores.salvar']);
        $routes->post('fornecedores/(:num)/excluir', 'Fornecedores::excluir/$1', ['as' => 'painel.fornecedores.excluir']);

        $routes->get('funcionarios',              'Funcionarios::index',        ['as' => 'painel.funcionarios']);
        $routes->get('funcionarios/novo',         'Funcionarios::novo',         ['as' => 'painel.funcionarios.novo']);
        $routes->get('funcionarios/(:num)',       'Funcionarios::editar/$1',    ['as' => 'painel.funcionarios.editar']);
        $routes->post('funcionarios/salvar',      'Funcionarios::salvar',       ['as' => 'painel.funcionarios.salvar']);
        $routes->post('funcionarios/(:num)/excluir', 'Funcionarios::excluir/$1', ['as' => 'painel.funcionarios.excluir']);

        $routes->get('produtos',              'Produtos::index',        ['as' => 'painel.produtos']);
        $routes->get('produtos/novo',         'Produtos::novo',         ['as' => 'painel.produtos.novo']);
        $routes->get('produtos/(:num)',       'Produtos::editar/$1',    ['as' => 'painel.produtos.editar']);
        $routes->post('produtos/salvar',      'Produtos::salvar',       ['as' => 'painel.produtos.salvar']);
        $routes->post('produtos/(:num)/excluir', 'Produtos::excluir/$1', ['as' => 'painel.produtos.excluir']);

        $routes->get('servicos-cadastro',              'ServicosCadastro::index',        ['as' => 'painel.servicos-cadastro']);
        $routes->get('servicos-cadastro/novo',         'ServicosCadastro::novo',         ['as' => 'painel.servicos-cadastro.novo']);
        $routes->get('servicos-cadastro/(:num)',       'ServicosCadastro::editar/$1',     ['as' => 'painel.servicos-cadastro.editar']);
        $routes->post('servicos-cadastro/salvar',      'ServicosCadastro::salvar',        ['as' => 'painel.servicos-cadastro.salvar']);
        $routes->post('servicos-cadastro/(:num)/excluir', 'ServicosCadastro::excluir/$1', ['as' => 'painel.servicos-cadastro.excluir']);
    });

    $routes->get('(:any)/(:any)', 'Pagina::servico/$1/$2');
    $routes->get('(:any)',        'Pagina::modulo/$1');
});
