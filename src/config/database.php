<?php

return [
    'connections' => [
        'default_mysql' => [
            'driver' => 'mysql',
            'host' => $_ENV['MYSQL_DATABASE_HOST'],
            'database' => $_ENV['MYSQL_DATABASE_NAME'],
            'username' => $_ENV['MYSQL_DATABASE_USER'],
            'password' => $_ENV['MYSQL_DATABASE_PASS'],
        ]
    ],

    'default_connection' => 'default_mysql'
];