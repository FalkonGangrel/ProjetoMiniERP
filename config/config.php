<?php

use App\Core\clDotEnv;
use App\Core\clDB;

// Inclui funções auxiliares
require_once __DIR__ . '/../helpers/functions.php';

// Carrega o .env
$dotenv = new clDotEnv(__DIR__ . '/../.env');
$dotenv->load();

// Define variáveis com base no .env
$host    = env('DB_HOST', 'localhost');
$dbname  = env('DB_NAME', 'meubanco');
$usuario = env('DB_USER', 'root');
$senha   = env('DB_PASS', '');
$charset = env('DB_CHARSET', 'utf8mb4');

// Instancia a classe de banco de dados personalizada com PDO
$db = new clDB($host, $usuario, $senha, $dbname, $charset);
