<?php

namespace App\Models;

use function App\Helpers\db;

class Produto
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = db(); // Retorna uma instância de clDB
    }

    public function salvar(array $dados): ?int
    {
        $sql = "INSERT INTO produtos (nome, descricao, preco, categoria) VALUES (?, ?, ?, ?)";
        $params = [
            $dados['nome'] ?? '',
            $dados['descricao'] ?? '',
            $dados['preco'] ?? 0,
            $dados['categoria'] ?? ''
        ];

        if ($this->conexao->query($sql, ...$params)) {
            return (int)$this->conexao->lastInsertID();
        }

        return null;
    }

    public function listarTodos(): array
    {
        $sql = "SELECT * FROM produtos";
        if ($this->conexao->query($sql)) {
            return $this->conexao->fetchAll();
        }

        return [];
    }

    public function buscarPorId(int $id): ?array
    {
        $sql = "SELECT * FROM produtos WHERE id = ?";
        if ($this->conexao->query($sql, $id)) {
            return $this->conexao->fetchArray();
        }

        return null;
    }

    public function atualizar(int $id, array $dados): bool
    {
        $sql = "UPDATE produtos SET nome = ?, descricao = ?, preco = ?, categoria = ? WHERE id = ?";
        $params = [
            $dados['nome'] ?? '',
            $dados['descricao'] ?? '',
            $dados['preco'] ?? 0,
            $dados['categoria'] ?? '',
            $id
        ];

        return $this->conexao->query($sql, ...$params);
    }
}
