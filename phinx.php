<?php

use App\Config;
require_once __DIR__ . '/src/Config.php';

return [
    'paths' => [
        'migrations' => 'database/migrations'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => Config::DB_HOST,
            'name' => Config::DB_NAME,
            'user' => Config::DB_USER,
            'pass' => Config::DB_PASS,
            'charset' => Config::DB_CHAR,
        ],
    ],
];