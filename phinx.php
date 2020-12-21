<?php

define('BIGINTEGER', 'biginteger');
define('BINARY', 'binary');
define('BOOLEAN', 'boolean');
define('DATE', 'date');
define('DATETIME', 'datetime');
define('DECIMAL', 'decimal');
define('FLOAT', 'float');
define('INTEGER', 'integer');
define('SMALL_INTEGER', 'smallinteger');
define('STRING', 'string');
define('TEXT', 'text');
define('TIME', 'time');
define('TIMESTAMP', 'timestamp');
define('UUID', 'uuid');
define('LIMIT', 'limit');
define('LENGTH', 'length');
define('DEFAULT', 'default');
define('NULL', 'null');
define('AFTER', 'after');
define('COMMENT', 'comment');
define('PRECISION', 'precision');
define('SCALE', 'scale');
define('SIGNED', 'signed');
define('VALUES', 'values');
define('IDENTITY', 'identity');
define('UPDATE', 'update');
define('TIMEZONE', 'timezone');
define('COLLATION', 'collation');
define('ENCODING', 'encoding');
define('DELETE', 'delete');
define('UNIQUE', 'unique');

require __DIR__ . '/vendor/autoload.php';
(Dotenv\Dotenv::createImmutable(dirname(__DIR__)))->load();

return [
    'paths'        => [
        'migrations' => 'database/migrations',
        'seeds'      => 'database/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default'                 => [
            'adapter' => 'mysql',
            'host'    => $_ENV['DB_HOST'],
            'name'    => $_ENV['DB_DATABASE'],
            'user'    => $_ENV['DB_USERNAME'],
            'pass'    => $_ENV['DB_PASSWORD'],
            'port'    => $_ENV['DB_PORT'],
            'charset' => $_ENV['DB_CHARSET'],
        ]
    ]
];
