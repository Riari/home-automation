<?php

return [
    'auth' => [
        'basic_user' => $_ENV['BASIC_AUTH_USER'],
        'basic_pass' => $_ENV['BASIC_AUTH_PASS'],
    ],
    'lifx' => [
        'token' => $_ENV['LIFX_API_TOKEN'],
    ],
    'hue' => [
        'app_name' => $_ENV['HUE_APP_NAME'],
        'client_id' => $_ENV['HUE_CLIENT_ID'],
        'client_secret' => $_ENV['HUE_CLIENT_SECRET'],
    ],
    'lights' => [
        'wake_duration' => $_ENV['LIGHTS_WAKE_DURATION'],
    ]
];