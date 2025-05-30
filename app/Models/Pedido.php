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
        $sql = "INSERT INTO pedidos (cliente_nome, total, status, data) VALUES (?, ?, ?, ?)";
        $params = [
            $dados['cliente_nome'] ?? '',
            $dados['total'] ?? 0,
            $dados['status'] ?? 'pendente',
            $dados['data'] ?? date('Y-m-d H:i:s')
        ];

        if ($this->conexao->query($sql, ...$params)) {
            return (int)$this->conexao->lastInsertID();
        }

        return null;
    }

    public function buscarPorId(int $id): ?array
    {
        $sql = "SELECT * FROM pedidos WHERE id = ?";
        if ($this->conexao->query($sql, $id)) {
            return $this->conexao->fetchArray();
        }

        return null;
    }

    public function atualizarStatus(int $id, string $status): bool
    {
        $sql = "UPDATE pedidos SET status = ? WHERE id = ?";
        return $this->conexao->query($sql, $status, $id);
    }
}