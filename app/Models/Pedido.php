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

    private function validarEAtualizarEstoque(int $variacaoId, int $quantidade): bool
    {
        $sql = "SELECT quantidade FROM estoques WHERE id = ?";
        if (!$this->conexao->query($sql, $variacaoId)) {
            return false; // Variação não encontrada
        }

        $estoque = $this->conexao->fetchArray();
        if (!$estoque || $estoque['quantidade'] < $quantidade) {
            return false; // Estoque insuficiente
        }

        // Atualiza o estoque
        $novaQuantidade = $estoque['quantidade'] - $quantidade;
        return $this->conexao->query(
            "UPDATE estoques SET quantidade = ? WHERE id = ?",
            $novaQuantidade,
            $variacaoId
        );
    }

    public function salvar(array $pedidoData, array $itens): bool
    {
        $this->conexao->begin();
        try {
            $sqlPedido = "INSERT INTO pedidos (cliente_nome, total, frete, cep, endereco, status, data) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $paramsPedido = [
                $pedidoData['cliente_nome'] ?? '',
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

            $sqlItem = "INSERT INTO pedido_itens (pedido_id, produto_id, variacao, quantidade, preco_unitario) VALUES (?, ?, ?, ?, ?)";

            foreach ($itens as $item) {
                $variacaoId = $item['variacao'];
                $quantidade = $item['quantidade'];

                // Valida variação e estoque
                if (!$this->validarEAtualizarEstoque($variacaoId, $quantidade)) {
                    throw new \Exception("Variação inválida ou estoque insuficiente");
                }

                // Insere item no pedido
                $this->conexao->query(
                    $sqlItem,
                    $pedidoId,
                    $item['produto_id'],
                    $variacaoId,
                    $quantidade,
                    $item['preco']
                );
            }

            $this->conexao->commit();
            return true;
        } catch (\Exception $e) {
            $this->conexao->rollback();
            return false;
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
                'total' => $pedido['total'],
                'frete' => $pedido['frete'],
                'status' => $pedido['status'],
                'data' => $pedido['data'],
                'itens' => $itens
            ];
        }

        return null;
    }

}