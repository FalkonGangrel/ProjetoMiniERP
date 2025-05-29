<?php

namespace App\Models;

use function App\Helpers\db;

class Pedido
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = db();
    }

    public function salvar(array $dados): ?int
    {
        $sql="INSERT INTO pedidos (cliente, total, frete, endereco) VALUES (?, ?, ?, ?)";
        $params = [
            $dados['cliente'] ?? '',
            $dados['total'] ?? '',
            $dados['frete'] ?? '',
            $dados['endereco'] ?? 0
        ];

        $stmt = $this->conexao->query($sql, $params);

        if ($stmt) {
            return $this->conexao->lastInsertID();
        }

        return null;
    }
}
