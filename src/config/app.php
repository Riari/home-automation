<?php

return [
    'auth' => [
        'basic_user' => $_ENV['BASIC_AUTH_USER'],
        'basic_pass' => $_ENV['BASIC_AUTH_PASS'],
    ],
    'lifx' => [
        'token' => $_ENV['LIFX_API_TOKEN'],
        'wake_duration' => $_ENV['LIFX_WAKE_DURATION'],
    ]
];