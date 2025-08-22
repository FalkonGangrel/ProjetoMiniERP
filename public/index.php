<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Core\clDotEnv;

$dotenv = new clDotEnv(__DIR__ . '/../.env');
$dotenv->load();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
Router::dispatch($uri);