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
        $sql = "INSERT INTO estoques (produto_id, quantidade) VALUES (?, ?)";
        $params = [
            $dados['produto_id'] ?? 0,
            $dados['quantidade'] ?? 0
        ];

        if ($this->conexao->query($sql, ...$params)) {
            return (int)$this->conexao->lastInsertID();
        }

        return null;
    }

    public function buscarPorProdutoId(int $produtoId): ?array
    {
        $sql = "SELECT * FROM estoques WHERE produto_id = ?";
        if ($this->conexao->query($sql, $produtoId)) {
            return $this->conexao->fetchArray();
        }

        return null;
    }

    public function atualizar(int $produtoId, int $quantidade): bool
    {
        $sql = "UPDATE estoques SET quantidade = ? WHERE produto_id = ?";
        return $this->conexao->query($sql, $quantidade, $produtoId);
    }
}
