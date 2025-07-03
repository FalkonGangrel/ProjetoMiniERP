<?php

namespace App\Models;

use function App\Helpers\db;

class Cupom
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = db();
    }

    public function buscarPorCodigo(string $codigo): ?array
    {
        $sql = "SELECT * FROM cupons WHERE codigo = ?";
        $this->conexao->query($sql, $codigo);
        $row = $this->conexao->fetchArray();

        return $row ?: null;
    }
}
