<?php

require '../vendor/autoload.php';

use Phase\App\App;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app = new App(__DIR__ . '/../');
$app->run();