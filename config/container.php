<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    Twig::class => function (ContainerInterface $container) {
        $settings     = $container->get('settings');
        $twigSettings = $settings['twig'];

        $options          = $twigSettings['options'];
        $options['cache'] = $options['cache_enabled'] ? $options['cache_path'] : false;

        $twig = Twig::create($twigSettings['paths'], $options);

        // Add extension here
        // ...

        return $twig;
    },

    TwigMiddleware::class => function (ContainerInterface $container) {
        return TwigMiddleware::createFromContainer(
            $container->get(App::class),
            Twig::class
        );
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app      = $container->get(App::class);
        $settings = $container->get('settings')['error'];

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$settings['display_error_details'],
            (bool)$settings['log_errors'],
            (bool)$settings['log_error_details']
        );
    },

    BasePathMiddleware::class => function (ContainerInterface $container) {
        return new BasePathMiddleware($container->get(App::class));
    },

    LoggerInterface::class => function (ContainerInterface $c) {
        $settings = $c->get('settings');

        $loggerSettings = $settings['logger'];
        $logger         = new Logger($loggerSettings['name']);

        $processor = new UidProcessor();
        $logger->pushProcessor($processor);

        $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
        $logger->pushHandler($handler);

        return $logger;
    },

    PDO::class => function (ContainerInterface $container) {
        $database = 'sqlite';
        $settings = $container->get('settings')[$database];
        $username = $settings['username'];
        $password = $settings['password'];
        $flags    = $settings['flags'];
        if ($database == 'mysql') {
            $dbname  = $settings['database'];
            $host    = $settings['host'];
            $charset = $settings['charset'];
            $dsn     = "mysql:host=$host;dbname=$dbname;charset=$charset";
        } else {
            $path  = $settings['path'];
            $dsn = "sqlite:$path";
        }


        return new PDO($dsn, $username, $password, $flags);
    },
];
