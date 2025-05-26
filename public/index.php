<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Core\clDotEnv;

// Carrega variáveis de ambiente
try {
    $dotenv = new clDotEnv(__DIR__ . '/../.env');
    $dotenv->load();
} catch (Exception $e) {
    die('Erro ao carregar o arquivo .env: ' . $e->getMessage());
}

// Captura a URI da requisição
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Roteia a requisição
Router::dispatch($uri);