<?php

namespace App\Models;

use function App\Helpers\db;

class Produto
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = db();
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

        $stmt = $this->conexao->query($sql, $params);

        if ($stmt) {
            return $this->conexao->lastInsertID();
        }

        return null;
    }

    public function listarTodos(): array
    {
        $sql = "SELECT * FROM produtos";
        $result = $this->conexao->query($sql);

        if ($result instanceof \mysqli_result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        return [];
    }
}
