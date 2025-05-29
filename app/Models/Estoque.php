<?php

namespace App\Models;

use function App\Helpers\db;

class Estoque
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = db();
    }

    public function salvar(array $dados): ?int
    {
        $sql="INSERT INTO estoques (produto_id, quantidade, variacao) VALUES (?, ?, ?)";
        $params = [
            $dados['produto_id'] ?? '',
            $dados['quantidade'] ?? '',
            $dados['variacao'] ?? 0
        ];

        $stmt = $this->conexao->query($sql, $params);

        if ($stmt) {
            return $this->conexao->lastInsertID();
        }

        return null;
    }
}
