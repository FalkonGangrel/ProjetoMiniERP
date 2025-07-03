<?php

namespace App\Models;

use function App\Helpers\db;
use function App\Helpers\logErro;

class Pedido
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = db();
    }

    public function salvar(array $pedidoData, array $itens): int
    {
        $this->conexao->begin();
        try {
            $sqlPedido = "INSERT INTO pedidos (cliente_nome, cliente_email, total, frete, cep, endereco, status, data) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $paramsPedido = [
                $pedidoData['cliente_nome'] ?? '',
                $pedidoData['cliente_email'] ?? '',
                $pedidoData['total'] ?? 0,
                $pedidoData['frete'] ?? 0,
                $pedidoData['cep'] ?? '',
                $pedidoData['endereco'] ?? '',
                $pedidoData['status'] ?? 'pendente',
                date('Y-m-d H:i:s')
            ];
            if (!$this->conexao->query($sqlPedido, ...$paramsPedido)) {
                throw new \Exception('Erro ao salvar pedido');
            }

            $pedidoId = $this->conexao->lastInsertID();

            foreach ($itens['itens'] as $item) {
                // 1) Verifica estoque disponível
                $sqlCheck = "SELECT quantidade FROM estoques WHERE id = ?";
                $this->conexao->query($sqlCheck, $item['variacao']);
                $estoque = $this->conexao->fetchArray();
                if (!$estoque) {
                    throw new \Exception('Variação inválida.');
                }
                if ($estoque['quantidade'] < $item['quantidade']) {
                    throw new \Exception('Estoque insuficiente para variação.');
                }

                // 2) Abate estoque
                $sqlUpdate = "UPDATE estoques SET quantidade = quantidade - ? WHERE id = ?";
                $this->conexao->query($sqlUpdate, $item['quantidade'], $item['variacao']);

                // 3) Insere item
                $sqlItem = "INSERT INTO pedido_itens (pedido_id, produto_id, variacao, quantidade, preco_unitario) VALUES (?, ?, ?, ?, ?)";
                $this->conexao->query(
                    $sqlItem,
                    $pedidoId,
                    $item['produto_id'],
                    $item['variacao'],
                    $item['quantidade'],
                    $item['preco']
                );
            }

            $this->conexao->commit();
            return $pedidoId;

        } catch (\Exception $e) {
            $this->conexao->rollback();
            logErro($e->getMessage());
            throw $e; // Opcional: para log
        }
    }

    public function listarTodos(): array
    {
        $sql = "SELECT id, cliente_nome, total, status, data FROM pedidos ORDER BY data DESC";
        $this->conexao->query($sql);
        return $this->conexao->fetchAll();
    }

    public function buscarComItens(int $id): ?array
    {
        $sql = "SELECT p.*, prd.nome as produto_nome, e.variacao, e.preco, pi.preco_unitario, pi.quantidade
                FROM pedidos p
                LEFT JOIN pedido_itens pi ON pi.pedido_id = p.id
                INNER JOIN produtos prd ON prd.id = pi.produto_id
                INNER JOIN estoques e ON e.produto_id = prd.id AND e.id=pi.variacao
                WHERE p.id = ?";
        if ($this->conexao->query($sql, $id)) {
            $resultados = $this->conexao->fetchAll();
            if (empty($resultados)) return null;

            $pedido = $resultados[0];
            $itens = array_map(function ($linha) {
                return [
                    'produto_nome' => $linha['produto_nome'],
                    'variacao' => $linha['variacao'],
                    'quantidade' => $linha['quantidade'],
                    'preco' => $linha['preco'],
                    'preco_unitario' => $linha['preco_unitario'],
                    'subtotal' => $linha['quantidade'] * $linha['preco_unitario'],
                ];
            }, $resultados);

            return [
                'id' => $pedido['id'],
                'cliente_nome' => $pedido['cliente_nome'],
                'cliente_email' => $pedido['cliente_email'],
                'total' => $pedido['total'],
                'frete' => $pedido['frete'],
                'status' => $pedido['status'],
                'data' => $pedido['data'],
                'itens' => $itens
            ];
        }

        return null;
    }

    public function atualizarStatus(int $id, string $status): bool
    {
        $sql = "UPDATE pedidos SET status = ? WHERE id = ?";
        return $this->conexao->query($sql, $status, $id);
    }

    public function excluir(int $id): bool
    {
        // 1) Reverte estoque dos itens
        $sql = "SELECT variacao, quantidade FROM pedido_itens WHERE pedido_id = ?";
        $this->conexao->query($sql, $id);
        $itens = $this->conexao->fetchAll();

        foreach ($itens as $item) {
            $this->conexao->query(
                "UPDATE estoques SET quantidade = quantidade + ? WHERE id = ?",
                $item['quantidade'],
                $item['variacao']
            );
        }

        // 2) Deleta itens e pedido
        $this->conexao->query("DELETE FROM pedido_itens WHERE pedido_id = ?", $id);
        $this->conexao->query("DELETE FROM pedidos WHERE id = ?", $id);

        return true;
    }
}