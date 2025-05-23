<?php
// Inclui o carregador de variáveis de ambiente
require_once __DIR__ . '/clDotEnv.php';
// Inclui a classe clDB com PDO
require_once __DIR__ . '/clDB.php';
// Inclui funções auxiliares
require_once __DIR__ . '/../helpers/functions.php';

// Carrega o .env
$dotenv = new clDotEnv(__DIR__ . '/.env');
$dotenv->load();

// Define variáveis com base no .env
$host    = env('DB_HOST', 'localhost');
$dbname  = env('DB_NAME', 'meubanco');
$usuario = env('DB_USER', 'root');
$senha   = env('DB_PASS', '');
$charset = env('DB_CHARSET', 'utf8mb4');

// Instancia a classe de banco de dados personalizada com PDO
$db = new clDB($host, $usuario, $senha, $dbname, $charset);
