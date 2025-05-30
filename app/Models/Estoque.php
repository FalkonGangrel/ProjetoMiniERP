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

    public function buscarPorProduto(int $produtoId): array
    {
        $sql = "SELECT * FROM estoques WHERE produto_id = ?";
        if ($this->conexao->query($sql, $produtoId)) {
            return $this->conexao->fetchAll();
        }

        return [];
    }

    public function atualizarPorProduto(int $produtoId, array $dados): bool
    {
        $sql = "UPDATE estoques SET quantidade = ? WHERE produto_id = ?";
        $params = [
            $dados['quantidade'] ?? 0,
            $produtoId
        ];

        return $this->conexao->query($sql, ...$params);
    }
}
