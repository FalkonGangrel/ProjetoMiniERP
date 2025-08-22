<?php

namespace App\Helpers;

use App\Core\clDB;

// Verifica se a função ainda não foi declarada
if (!function_exists('env')) {
    /**
     * Recupera uma variável de ambiente com valor padrão opcional.
     *
     * @param string $key     Nome da variável de ambiente.
     * @param mixed  $default Valor padrão retornado caso a variável não exista.
     * @return mixed
     */
    function env(string $key, $default = null)
    {
        // Verifica se a variável está definida no ambiente
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }

        // Retorna valor padrão caso não esteja definida
        return $default;
    }
}

function db(): clDB
{
    return new clDB(
        $_ENV['DB_HOST'] ?? 'localhost',
        $_ENV['DB_USER'] ?? 'root',
        $_ENV['DB_PASS'] ?? '',
        $_ENV['DB_NAME'] ?? 'db_mini_erp'
    );
}

function logErro($mensagem) {
    $logFile = __DIR__ . '/../../storage/logs/errors.log';;
    file_put_contents($logFile, "[" . date('Y-m-d H:i:s') . "] $mensagem" . PHP_EOL, FILE_APPEND);
}
