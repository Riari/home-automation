<?php

require '../vendor/autoload.php';

use App\App;
use App\Config;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app = new App(__DIR__ . '/../');
$app->run();