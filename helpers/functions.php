<?php
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
?>