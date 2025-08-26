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
        $sql = "INSERT INTO produtos (nome, descricao, categoria) VALUES (?, ?, ?)";
        $params = [
            $dados['nome'] ?? '',
            $dados['descricao'] ?? '',
            $dados['categoria'] ?? ''
        ];

        if ($this->conexao->query($sql, ...$params)) {
            return (int)$this->conexao->lastInsertID();
        }

        return null;
    }

    public function listarTodos(): array
    {
        $sql = "SELECT p.*, COALESCE(SUM(e.quantidade), 0) AS estoque_total, COALESCE(AVG(e.preco), 0) AS preco_medio
                FROM produtos p
                LEFT JOIN estoques e ON e.produto_id = p.id
                GROUP BY p.id";
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
    
    public function buscarPorCategoria(string $categoria): array
    {
        $sql = "SELECT * FROM produtos WHERE categoria = ?";
        if ($this->conexao->query($sql, $categoria)) {
            return $this->conexao->fetchAll();
        }

        return [];
    }

    public function buscarPorNome(string $nome): ?array
    {
        $sql = "SELECT * FROM produtos WHERE nome = ?";
        if ($this->conexao->query($sql, $nome)) {
            return $this->conexao->fetchArray();
        }
        return null;
    }

    public function atualizar(int $id, array $dados): bool
    {
        $sql = "UPDATE produtos SET nome = ?, descricao = ?, categoria = ? WHERE id = ?";
        $params = [
            $dados['nome'] ?? '',
            $dados['descricao'] ?? '',
            $dados['categoria'] ?? '',
            $id
        ];

        return $this->conexao->query($sql, ...$params);
    }

    public function deletar(int $id): bool
    {
        $sql = "UPDATE produtos SET ativo = 0 WHERE id = ?";
        return $this->conexao->query($sql, $id);
    }

    public function reativar(int $id): bool
    {
        $sql = "UPDATE produtos SET ativo = 1 WHERE id = ?";
        return $this->conexao->query($sql, $id);
    }
}