<?php


require __DIR__ . '/vendor/autoload.php';
(Dotenv\Dotenv::createImmutable(__DIR__))->load();
if (!function_exists('env')) {
    function env($key): string
    {
        return $_ENV[$key];
    }
}

return [
    'paths'        => [
        'migrations' => 'database/migrations',
        'seeds'      => 'database/seeds',
    ],
    'environments' => [
        'default_environment'     => 'testing',
        'default_migration_table' => 'migrations',
        'default'                 => [
            'adapter' => 'mysql',
            'host'    => env('DB_HOST'),
            'name'    => env('DB_DATABASE'),
            'user'    => env('DB_USERNAME'),
            'pass'    => env('DB_PASSWORD'),
            'port'    => 3306,
            'charset' => 'utf8mb4',
        ],
        'testing'                 => [
            'adapter' => 'sqlite',
            'name'    => env('DB_DATABASE'),
        ],
    ]
];
