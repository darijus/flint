<?php

namespace Flint\Provider;

use Symfony\Component\HttpKernel\EventListener\ExceptionListener;
use Flint\Controller\ControllerResolver;
use Silex\Application;

/**
 * @package Flint
 */
class FlintServiceProvider implements \Silex\ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function register(Application $app)
    {
        $app['exception_handler'] = $app->share(function ($app) {
            return new ExceptionListener('Flint\\Controller\\ExceptionController::showAction', $app['logger']);
        });

        $app->extend('resolver', function ($resolver, $app) {
            return new ControllerResolver($resolver, $app);
        });

        $app->extend('twig.loader.filesystem', function ($loader, $app) {
            $loader->addPath(__DIR__ . '/../Resources/views', 'Flint');

            return $loader;
        });
    }

    /**
     * {@inheritDoc}
     */
    public function boot(Application $app)
    {
    }
}
