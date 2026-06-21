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

        $loader = new \Twig\Loader\FilesystemLoader(APPPATH . 'Views');
        
        return new \Twig\Environment($loader, [
            'cache' => WRITEPATH . 'cache/twig',
            'debug' => ENVIRONMENT !== 'production',
            'auto_reload' => ENVIRONMENT !== 'production',
        ]);
    }

    /**
     * Intervention Image service (v3+).
     */
    public static function imageManager(bool $getShared = true): \Intervention\Image\ImageManager
    {
        if ($getShared) {
            return static::getSharedInstance('imageManager');
        }

        // Defaulting to GD driver. Use \Intervention\Image\Drivers\Imagick\Driver if available.
        return new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
    }

    /**
     * Redis (Predis) service.
     */
    public static function redis(bool $getShared = true): \Predis\Client
    {
        if ($getShared) {
            return static::getSharedInstance('redis');
        }

        $config = config('Queue'); // Reuse connection info from Queue config
        return new \Predis\Client($config->predis);
    }

    /**
     * Situacao service.
     */
    public static function situacao(bool $getShared = true): \App\Modulos\Sistema\Services\SituacaoService
    {
        if ($getShared) {
            return static::getSharedInstance('situacao');
        }

        return new \App\Modulos\Sistema\Services\SituacaoService();
    }

    /**
     * Cliente repository.
     */
    public static function clienteRepository(bool $getShared = true): \App\Modulos\Cadastro\Repositories\ClienteRepository
    {
        if ($getShared) {
            return static::getSharedInstance('clienteRepository');
        }

        return new \App\Modulos\Cadastro\Repositories\ClienteRepository();
    }

    /**
     * Usuario service.
     */
    public static function usuario(bool $getShared = true): \App\Modulos\Seguranca\Services\UsuarioService
    {
        if ($getShared) {
            return static::getSharedInstance('usuario');
        }

        return new \App\Modulos\Seguranca\Services\UsuarioService();
    }

    /**
     * Usuario repository.
     */
    public static function usuarioRepository(bool $getShared = true): \App\Modulos\Seguranca\Repositories\UsuarioRepository
    {
        if ($getShared) {
            return static::getSharedInstance('usuarioRepository');
        }

        return new \App\Modulos\Seguranca\Repositories\UsuarioRepository();
    }
}
