<?php
// Inclui a classe clDotEnv responsável por carregar as variáveis de ambiente do arquivo .env
require_once __DIR__ . '/../app/classes/clDotEnv.php';
require_once __DIR__ . '/../app/helpers/functions.php';

// Carrega as variáveis de ambiente do arquivo .env
$dotenv = new DotEnv\DotEnv(__DIR__ . '/../.env');
$dotenv->load();

// Define as variáveis de conexão com o banco usando o conteúdo do .env
$host     = env('DB_HOST', 'localhost');       // Endereço do servidor de banco de dados
$banco    = env('DB_NAME', 'meubanco');        // Nome do banco de dados
$usuario  = env('DB_USER', 'root');            // Usuário do banco de dados
$senha    = env('DB_PASS', '');                // Senha do banco de dados
$charset  = env('DB_CHARSET', 'utf8mb4');      // Charset da conexão (ex: utf8mb4)

// Define a Data Source Name (DSN) para o PDO
$dsn = "mysql:host=$host;dbname=$banco;charset=$charset";

// Configurações adicionais do PDO
$opcoes = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Ativa exceções em erros
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Define o modo padrão de fetch
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Desativa a emulação de prepared statements
];

try {
    // Cria uma instância PDO usando as configurações definidas
    $pdo = new PDO($dsn, $usuario, $senha, $opcoes);
} catch (PDOException $e) {
    // Em caso de erro na conexão, exibe uma mensagem de erro amigável
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
