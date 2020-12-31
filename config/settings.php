<?php

// Error reporting for production
use Monolog\Logger;

error_reporting(0);
ini_set('display_errors', '0');

// Timezone
date_default_timezone_set('Asia/Tehran');

// Settings
$settings = [];

// Path settings
$settings['root']   = dirname(__DIR__);
$settings['public'] = $settings['root'] . '/public';
$settings['src']    = $settings['root'] . '/src';

// Error Handling Middleware settings
$settings['error'] = [
    // Should be set to false in production
    'display_error_details' => env('APP_DEBUG'),

    // Parameter is passed to the default ErrorHandler
    // View in rendered output by enabling the "displayErrorDetails" setting.
    // For the console and unit tests we also disable it
    'log_errors'            => true,

    // Display error details in error log
    'log_error_details'     => true,
];

// Twig settings
$settings['twig'] = [
    // Template paths
    'paths'   => [
        $settings['src'] . '/View'
    ],
    // Twig environment options
    'options' => [
        // Should be set to true in production
        'cache_enabled' => false,
        'cache_path'    => $settings['root'] . '/cache/twig',
    ],
];

$settings['logger'] = [
    'name'  => env('APP_NAME'),
    'path'  => isset($_ENV['docker']) ? 'php://stdout' : $settings['root'] . '/storage/logs/app.log',
    'level' => Logger::DEBUG,
];


// Database settings
$settings['mysql'] = [
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'username'  => 'root',
    'database'  => 'test',
    'password'  => 'root',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_persian_ci',
    'flags'     => [
        // Turn off persistent connections
        PDO::ATTR_PERSISTENT         => false,
        // Enable exceptions
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        // Emulate prepared statements
        PDO::ATTR_EMULATE_PREPARES   => true,
        // Set default fetch mode to array
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Set character set
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_persian_ci'
    ],
];

$settings['sqlite'] = [
    'driver'    => 'sqlite',
    'path'      => __DIR__.'/../storage/db_file.sqlite3',
    'username'  => '',
    'password'  => '',
    'flags'     => [
        // Turn off persistent connections
        PDO::ATTR_PERSISTENT         => false,
        // Enable exceptions
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        // Emulate prepared statements
        PDO::ATTR_EMULATE_PREPARES   => true,
        // Set default fetch mode to array
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Set character set
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_persian_ci'
    ],
];

return $settings;
