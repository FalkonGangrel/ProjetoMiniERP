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

    public function salvar(int $produtoId, array $variacoes): bool
    {
        $sql = "INSERT INTO estoques (produto_id, variacao, quantidade) VALUES (?, ?, ?)";

        $this->conexao->begin();
        try {
            foreach ($variacoes as $variacao) {
                $variacaoNome = trim($variacao['variacao'] ?? '');
                $quantidade = (int)($variacao['quantidade'] ?? 0);

                if (strlen($variacaoNome) < 3 || $quantidade < 0) {
                    continue; // Ignora entradas inválidas
                }

                $this->conexao->query($sql, $produtoId, $variacaoNome, $quantidade);
            }
            $this->conexao->commit();
            return true;
        } catch (\Exception $e) {
            $this->conexao->rollback();
            return false;
        }
    }

    public function atualizar(int $produtoId, array $variacoes): bool
    {
        $this->conexao->begin();
        try {
            $this->conexao->query("DELETE FROM estoques WHERE produto_id = ?", $produtoId);
            $this->salvar($produtoId, $variacoes);
            $this->conexao->commit();
            return true;
        } catch (\Exception $e) {
            $this->conexao->rollback();
            return false;
        }
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
        // Verifica se já existe um estoque para o produto
        $estoqueExistente = $this->buscarPorProduto($produtoId);

        if ($estoqueExistente) {
            $sql = "UPDATE estoques SET variacao = ?, quantidade = ? WHERE produto_id = ?";
            $params = [
                $dados['variacao'] ?? '',
                $dados['quantidade'] ?? 0,
                $produtoId
            ];
            return $this->conexao->query($sql, ...$params);
        } else {
            // Se não existir, insere
            return $this->salvar($produtoId, $dados) !== null;
        }

    }
}
