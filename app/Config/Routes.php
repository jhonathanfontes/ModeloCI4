<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], static function (RouteCollection $routes) {
    $routes->get('/',             'Dashboard::index',   ['as' => 'admin.dashboard']);

    $routes->get('usuarios',        'Usuarios::index',   ['as' => 'admin.usuarios']);
    $routes->get('usuarios/novo',   'Usuarios::novo',    ['as' => 'admin.usuarios.novo']);
    $routes->get('usuarios/(:any)', 'Usuarios::editar/$1', ['as' => 'admin.usuarios.editar']);
    $routes->post('usuarios/salvar',  'Usuarios::salvar',  ['as' => 'admin.usuarios.salvar']);
    $routes->post('usuarios/(:any)/excluir', 'Usuarios::excluir/$1', ['as' => 'admin.usuarios.excluir']);

    $routes->get('empresas',                'Empresas::index',        ['as' => 'admin.empresas']);
    $routes->get('empresas/novo',           'Empresas::novo',         ['as' => 'admin.empresas.novo']);
    $routes->get('empresas/visualizar/(:any)', 'Empresas::visualizar/$1', ['as' => 'admin.empresas.visualizar']);
    $routes->post('empresas/salvar',  'Empresas::salvar',  ['as' => 'admin.empresas.salvar']);

    $routes->get('empresas/(:any)/usuarios',          'EmpresaUsuarios::index/$1',      ['as' => 'admin.empresas.usuarios']);
    $routes->get('empresas/(:any)/usuarios/vincular', 'EmpresaUsuarios::vincular/$1',   ['as' => 'admin.empresas.usuarios.vincular']);
    $routes->post('empresas/(:any)/usuarios/salvar',    'EmpresaUsuarios::salvar/$1',     ['as' => 'admin.empresas.usuarios.salvar']);
    $routes->post('empresas/(:any)/usuarios/(:num)/desvincular', 'EmpresaUsuarios::desvincular/$1/$2', ['as' => 'admin.empresas.usuarios.desvincular']);

    // Empresa Serviços (UUID nas URLs)
    $routes->get('empresas/(:any)/servicos',                          'EmpresaServicos::index/$1',          ['as' => 'admin.empresas.servicos']);
    $routes->post('empresas/(:any)/servicos/salvar-licenca',          'EmpresaServicos::salvarLicenca/$1',  ['as' => 'admin.empresas.servicos.salvar-licenca']);
    $routes->post('empresas/(:any)/servicos/salvar',                  'EmpresaServicos::salvarServicos/$1', ['as' => 'admin.empresas.servicos.salvar']);

    // Empresa Endereços
    $routes->get('empresas/(:any)/enderecos',                    'EmpresaEnderecos::index/$1',    ['as' => 'admin.empresas.enderecos']);
    $routes->get('empresas/(:any)/enderecos/novo',               'EmpresaEnderecos::novo/$1',     ['as' => 'admin.empresas.enderecos.novo']);
    $routes->get('empresas/(:any)/enderecos/(:num)/editar',      'EmpresaEnderecos::editar/$1/$2',['as' => 'admin.empresas.enderecos.editar']);
    $routes->post('empresas/(:any)/enderecos/salvar',             'EmpresaEnderecos::salvar/$1',   ['as' => 'admin.empresas.enderecos.salvar']);
    $routes->post('empresas/(:any)/enderecos/(:num)/excluir',    'EmpresaEnderecos::excluir/$1/$2',['as' => 'admin.empresas.enderecos.excluir']);

    // Empresa Contatos
    $routes->get('empresas/(:any)/contatos',                     'EmpresaContatos::index/$1',    ['as' => 'admin.empresas.contatos']);
    $routes->get('empresas/(:any)/contatos/novo',                'EmpresaContatos::novo/$1',     ['as' => 'admin.empresas.contatos.novo']);
    $routes->get('empresas/(:any)/contatos/(:num)/editar',       'EmpresaContatos::editar/$1/$2',['as' => 'admin.empresas.contatos.editar']);
    $routes->post('empresas/(:any)/contatos/salvar',              'EmpresaContatos::salvar/$1',   ['as' => 'admin.empresas.contatos.salvar']);
    $routes->post('empresas/(:any)/contatos/(:num)/excluir',     'EmpresaContatos::excluir/$1/$2',['as' => 'admin.empresas.contatos.excluir']);

    // Empresa editar/excluir (deve vir DEPOIS das sub-rotas para evitar que (:any) capture "usuarios" ou "servicos")
    $routes->get('empresas/(:any)',          'Empresas::editar/$1',    ['as' => 'admin.empresas.editar']);
    $routes->post('empresas/(:any)/excluir', 'Empresas::excluir/$1', ['as' => 'admin.empresas.excluir']);

    // Planos (UUID nas URLs)
    $routes->get('planos',                            'Planos::index',             ['as' => 'admin.planos']);
    $routes->get('planos/novo',                       'Planos::novo',              ['as' => 'admin.planos.novo']);
    $routes->get('planos/visualizar/(:any)',          'Planos::visualizar/$1',    ['as' => 'admin.planos.visualizar']);
    $routes->get('planos/editar/(:any)',              'Planos::editar/$1',        ['as' => 'admin.planos.editar']);
    $routes->post('planos/salvar',                     'Planos::salvar',           ['as' => 'admin.planos.salvar']);
    $routes->post('planos/(:any)/excluir',            'Planos::excluir/$1',       ['as' => 'admin.planos.excluir']);

    // Situações
    $routes->get('situacoes',        'Situacoes::index',   ['as' => 'admin.situacoes']);
    $routes->get('situacoes/novo',   'Situacoes::novo',    ['as' => 'admin.situacoes.novo']);
    $routes->get('situacoes/(:any)', 'Situacoes::editar/$1', ['as' => 'admin.situacoes.editar']);
    $routes->post('situacoes/salvar',  'Situacoes::salvar',  ['as' => 'admin.situacoes.salvar']);
    $routes->post('situacoes/(:any)/excluir', 'Situacoes::excluir/$1', ['as' => 'admin.situacoes.excluir']);

    // Tipos
    $routes->get('tipos',        'Tipos::index',   ['as' => 'admin.tipos']);
    $routes->get('tipos/novo',   'Tipos::novo',    ['as' => 'admin.tipos.novo']);
    $routes->get('tipos/(:any)', 'Tipos::editar/$1', ['as' => 'admin.tipos.editar']);
    $routes->post('tipos/salvar',  'Tipos::salvar',  ['as' => 'admin.tipos.salvar']);
    $routes->post('tipos/(:any)/excluir', 'Tipos::excluir/$1', ['as' => 'admin.tipos.excluir']);

    // Menu (UUID nas URLs; sub-rotas específicas antes de (:any))
    $routes->get('menu',                          'Menu::index',             ['as' => 'admin.menu']);
    $routes->get('menu/modulos/novo',             'Menu::moduloNovo',        ['as' => 'admin.menu.modulo.novo']);
    $routes->post('menu/modulos/salvar',           'Menu::moduloSalvar',      ['as' => 'admin.menu.modulo.salvar']);
    $routes->post('menu/modulos/(:any)/excluir',  'Menu::moduloExcluir/$1',  ['as' => 'admin.menu.modulo.excluir']);
    $routes->get('menu/modulos/(:any)',           'Menu::moduloEditar/$1',   ['as' => 'admin.menu.modulo.editar']);

    $routes->get('menu/servicos/novo/(:any)',     'Menu::servicoNovo/$1',    ['as' => 'admin.menu.servico.novo']);
    $routes->get('menu/servicos/editar/(:any)',   'Menu::servicoEditar/$1',  ['as' => 'admin.menu.servico.editar']);
    $routes->post('menu/servicos/salvar',          'Menu::servicoSalvar',     ['as' => 'admin.menu.servico.salvar']);
    $routes->post('menu/servicos/(:any)/excluir', 'Menu::servicoExcluir/$1', ['as' => 'admin.menu.servico.excluir']);
    $routes->post('menu/servicos/(:any)/copiar',  'Menu::servicoCopiar/$1',  ['as' => 'admin.menu.servico.copiar']);
    $routes->get('menu/servicos/(:any)',          'Menu::servicos/$1',       ['as' => 'admin.menu.servicos']);

    $routes->get('menu/funcionalidades/novo/(:any)',  'Menu::funcionalidadeNovo/$1',    ['as' => 'admin.menu.funcionalidade.novo']);
    $routes->get('menu/funcionalidades/editar/(:any)', 'Menu::funcionalidadeEditar/$1',  ['as' => 'admin.menu.funcionalidade.editar']);
    $routes->post('menu/funcionalidades/salvar',       'Menu::funcionalidadeSalvar',     ['as' => 'admin.menu.funcionalidade.salvar']);
    $routes->post('menu/funcionalidades/(:any)/excluir', 'Menu::funcionalidadeExcluir/$1', ['as' => 'admin.menu.funcionalidade.excluir']);
    $routes->get('menu/funcionalidades/(:any)',       'Menu::funcionalidades/$1',       ['as' => 'admin.menu.funcionalidades']);
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
        $routes->get('clientes/visualizar/(:any)', 'Clientes::visualizar/$1', ['as' => 'painel.clientes.visualizar']);
        $routes->post('clientes/salvar',      'Clientes::salvar',       ['as' => 'painel.clientes.salvar']);

        // Endereços de Clientes
        $routes->get('clientes/(:any)/enderecos/novo', 'Clientes::enderecoNovo/$1', ['as' => 'painel.clientes.endereco.novo']);
        $routes->get('clientes/(:any)/enderecos/(:num)/editar', 'Clientes::enderecoEditar/$1/$2', ['as' => 'painel.clientes.endereco.editar']);
        $routes->post('clientes/(:any)/enderecos/salvar', 'Clientes::enderecoSalvar/$1', ['as' => 'painel.clientes.endereco.salvar']);
        $routes->post('clientes/(:any)/enderecos/(:num)/excluir', 'Clientes::enderecoExcluir/$1/$2', ['as' => 'painel.clientes.endereco.excluir']);

        // Contatos de Clientes
        $routes->get('clientes/(:any)/contatos/novo', 'Clientes::contatoNovo/$1', ['as' => 'painel.clientes.contato.novo']);
        $routes->get('clientes/(:any)/contatos/(:num)/editar', 'Clientes::contatoEditar/$1/$2', ['as' => 'painel.clientes.contato.editar']);
        $routes->post('clientes/(:any)/contatos/salvar', 'Clientes::contatoSalvar/$1', ['as' => 'painel.clientes.contato.salvar']);
        $routes->post('clientes/(:any)/contatos/(:num)/excluir', 'Clientes::contatoExcluir/$1/$2', ['as' => 'painel.clientes.contato.excluir']);

        // Clientes editar/excluir (deve vir DEPOIS das sub-rotas de enderecos/contatos)
        $routes->get('clientes/(:any)',       'Clientes::editar/$1',    ['as' => 'painel.clientes.editar']);
        $routes->post('clientes/(:any)/excluir', 'Clientes::excluir/$1', ['as' => 'painel.clientes.excluir']);

        $routes->get('fornecedores',              'Fornecedores::index',        ['as' => 'painel.fornecedores']);
        $routes->get('fornecedores/novo',         'Fornecedores::novo',         ['as' => 'painel.fornecedores.novo']);
        $routes->get('fornecedores/(:any)',       'Fornecedores::editar/$1',     ['as' => 'painel.fornecedores.editar']);
        $routes->post('fornecedores/salvar',      'Fornecedores::salvar',        ['as' => 'painel.fornecedores.salvar']);
        $routes->post('fornecedores/(:any)/excluir', 'Fornecedores::excluir/$1', ['as' => 'painel.fornecedores.excluir']);

        $routes->get('funcionarios',              'Funcionarios::index',        ['as' => 'painel.funcionarios']);
        $routes->get('funcionarios/novo',         'Funcionarios::novo',         ['as' => 'painel.funcionarios.novo']);
        $routes->get('funcionarios/(:any)',       'Funcionarios::editar/$1',    ['as' => 'painel.funcionarios.editar']);
        $routes->post('funcionarios/salvar',      'Funcionarios::salvar',       ['as' => 'painel.funcionarios.salvar']);
        $routes->post('funcionarios/(:any)/excluir', 'Funcionarios::excluir/$1', ['as' => 'painel.funcionarios.excluir']);

        $routes->get('produtos',                  'Produtos::index',            ['as' => 'painel.produtos']);
        $routes->get('produtos/novo',             'Produtos::novo',             ['as' => 'painel.produtos.novo']);
        $routes->get('produtos/(:any)',           'Produtos::editar/$1',        ['as' => 'painel.produtos.editar']);
        $routes->post('produtos/salvar',          'Produtos::salvar',           ['as' => 'painel.produtos.salvar']);
        $routes->post('produtos/(:any)/excluir',  'Produtos::excluir/$1',       ['as' => 'painel.produtos.excluir']);

        $routes->get('servicos-cadastro',                    'ServicosCadastro::index',        ['as' => 'painel.servicos-cadastro']);
        $routes->get('servicos-cadastro/novo',               'ServicosCadastro::novo',         ['as' => 'painel.servicos-cadastro.novo']);
        $routes->get('servicos-cadastro/(:any)',             'ServicosCadastro::editar/$1',     ['as' => 'painel.servicos-cadastro.editar']);
        $routes->post('servicos-cadastro/salvar',            'ServicosCadastro::salvar',        ['as' => 'painel.servicos-cadastro.salvar']);
        $routes->post('servicos-cadastro/(:any)/excluir',    'ServicosCadastro::excluir/$1',   ['as' => 'painel.servicos-cadastro.excluir']);
    });

    $routes->get('(:any)/(:any)', 'Pagina::servico/$1/$2');
    $routes->get('(:any)',        'Pagina::modulo/$1');
});
