<?php

// --------------------------
// Exibição de erros (apenas para desenvolvimento)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// --------------------------
// Autoload do Composer (caso use futuramente)
require_once __DIR__ . '/../vendor/autoload.php';

// --------------------------
// Carregamento das variáveis de ambiente
use App\Core\clDotEnv;

try {
    $dotenv = new clDotEnv(__DIR__ . '/../.env');
    $dotenv->load();
} catch (Exception $e) {
    die('Erro ao carregar o arquivo .env: ' . $e->getMessage());
}

// --------------------------
// Funções auxiliares globais (como view(), formatadores, etc.)
require_once __DIR__ . '/../app/helpers/functions.php';

// --------------------------
// Roteamento da requisição
use App\Core\Router;

// Captura a URI limpa (sem query string)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Despacha a rota correspondente
Router::dispatch($uri);