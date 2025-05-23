<?php
/**
 * Classe clDotEnv
 * Carrega variáveis de ambiente a partir de um arquivo .env
 * Utilização:
 *   $dotenv = new clDotEnv(__DIR__ . '/.env');
 *   $dotenv->load();
 */

class clDotEnv {
    private $path;

    /**
     * Construtor
     * @param string $path Caminho para o arquivo .env
     */
    public function __construct($path) {
        if (!file_exists($path)) {
            throw new InvalidArgumentException(sprintf('%s não encontrado', $path));
        }

        $this->path = $path;
    }

    /**
     * Carrega as variáveis de ambiente do arquivo .env
     */
    public function load() {
        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Ignora comentários
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Divide a linha em chave=valor
            list($name, $value) = explode('=', $line, 2);

            $name = trim($name);
            $value = trim($value);

            // Remove aspas se existirem
            $value = trim($value, '"\'');

            // Define a variável no ambiente se ainda não estiver definida
            if (!array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}
