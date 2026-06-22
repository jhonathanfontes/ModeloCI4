<?php

namespace Config;

use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /**
     * Twig service.
     */
    public static function twig(bool $getShared = true): \Twig\Environment
    {
        if ($getShared) {
            return static::getSharedInstance('twig');
        }

        return \App\Services\TwigService::create();
    }

    /**
     * Intervention Image service (v3+).
     */
    public static function imageManager(bool $getShared = true): \Intervention\Image\ImageManager
    {
        if ($getShared) {
            return static::getSharedInstance('imageManager');
        }

        return \App\Services\ImageManagerService::create();
    }

    /**
     * Redis (Predis) service.
     */
    public static function redis(bool $getShared = true): \Predis\Client
    {
        if ($getShared) {
            return static::getSharedInstance('redis');
        }

        return \App\Services\RedisService::create();
    }

    /**
     * Situacao service.
     */
    public static function situacao(bool $getShared = true): \App\Modulos\Sistema\Services\SituacaoService
    {
        if ($getShared) {
            return static::getSharedInstance('situacao');
        }

        return \App\Services\SituacaoService::create();
    }

    /**
     * Cliente repository.
     */
    public static function clienteRepository(bool $getShared = true): \App\Modulos\Cadastro\Repositories\ClienteRepository
    {
        if ($getShared) {
            return static::getSharedInstance('clienteRepository');
        }

        return \App\Services\ClienteRepositoryService::create();
    }

    /**
     * Menu service.
     */
    public static function menu(bool $getShared = true): \App\Modulos\Menu\Services\MenuService
    {
        if ($getShared) {
            return static::getSharedInstance('menu');
        }

        return \App\Services\MenuService::create();
    }

    /**
     * Empresa service.
     */
    public static function empresa(bool $getShared = true): \App\Modulos\Cadastro\Services\EmpresaService
    {
        if ($getShared) {
            return static::getSharedInstance('empresa');
        }

        return \App\Services\EmpresaService::create();
    }

    /**
     * Usuario service.
     */
    public static function usuario(bool $getShared = true): \App\Modulos\Seguranca\Services\UsuarioService
    {
        if ($getShared) {
            return static::getSharedInstance('usuario');
        }

        return \App\Services\UsuarioService::create();
    }

    /**
     * Usuario repository.
     */
    public static function usuarioRepository(bool $getShared = true): \App\Modulos\Seguranca\Repositories\UsuarioRepository
    {
        if ($getShared) {
            return static::getSharedInstance('usuarioRepository');
        }

        return \App\Services\UsuarioRepositoryService::create();
    }
}
