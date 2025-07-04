<?php

namespace App\Models;

use function App\Helpers\db;

class Relatorio
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = db();
    }

    public function pedidosPorPeriodo(array $filtros): array
    {
        $sql = "SELECT id, cliente_nome, total, status, data
                FROM pedidos
                WHERE 1 ";

        $params = [];

        if (!empty($filtros['data_inicio'])) {
            $sql .= " AND DATE(data) >= ? ";
            $params[] = $filtros['data_inicio'];
        }
        if (!empty($filtros['data_fim'])) {
            $sql .= " AND DATE(data) <= ? ";
            $params[] = $filtros['data_fim'];
        }
        if (!empty($filtros['status'])) {
            $sql .= " AND status = ? ";
            $params[] = $filtros['status'];
        }

        $sql .= " ORDER BY data DESC ";

        $this->conexao->query($sql, ...$params);
        return $this->conexao->fetchAll();
    }

    public function vendasPorProduto(array $filtros): array
    {
        $sql = "SELECT prd.nome as produto, SUM(pi.quantidade) as total_vendido, SUM(pi.quantidade * pi.preco_unitario) as faturamento
                FROM pedido_itens pi
                INNER JOIN produtos prd ON pi.produto_id = prd.id
                INNER JOIN pedidos p ON pi.pedido_id = p.id
                WHERE 1 ";

        $params = [];

        if (!empty($filtros['data_inicio'])) {
            $sql .= " AND DATE(p.data) >= ? ";
            $params[] = $filtros['data_inicio'];
        }
        if (!empty($filtros['data_fim'])) {
            $sql .= " AND DATE(p.data) <= ? ";
            $params[] = $filtros['data_fim'];
        }

        $sql .= " GROUP BY prd.nome ORDER BY faturamento DESC";

        $this->conexao->query($sql, ...$params);
        return $this->conexao->fetchAll();
    }
}
