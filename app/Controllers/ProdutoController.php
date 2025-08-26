<?php

namespace App\Controllers;

use App\Models\Produto;
use App\Models\Estoque;
use App\Helpers\Util;

class ProdutoController
{
    public function listar()
    {
        $produtoModel = new Produto();
        $produtos = $produtoModel->listarTodos();

        Util::view('produtos/lista', [
            'title' => 'Lista de Produtos',
            'produtos' => $produtos
        ]);
    }

    public function cadastro()
    {
        Util::view('produtos/form', [
            'title' => 'Novo Produto',
            'produto' => [],
            'estoque' => []
        ]);
    }

    public function editar($id)
    {
        $produtoModel = new Produto();
        $produto = $produtoModel->buscarPorId((int)$id);

        if (!$produto) {
            return Util::view('produtos/erro', ['id' => $id]);
        }

        $estoqueModel = new Estoque();
        $estoque = $estoqueModel->buscarPorProduto($id);

        return Util::view('produtos/form', compact('produto', 'estoque'));
    }

    public function atualizar()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id) {
            echo "ID do produto não informado.";
            return;
        }

        $produtoModel = new Produto();
        $estoqueModel = new Estoque();

        $variacoes = $_POST['variacao'] ?? [];
        $quantidades = $_POST['quantidade'] ?? [];
        $precos = $_POST['preco'] ?? [];

        $dadosEstoque = [];
        foreach ($variacoes as $index => $variacao) {
            $dadosEstoque[] = [
                'variacao' => $variacao,
                'quantidade' => $quantidades[$index] ?? 0,
                'preco' => $precos[$index] ?? 0
            ];
        }
        $produtoModel->atualizar($id, $_POST);
        $estoqueModel->atualizar($id, $dadosEstoque);

        header('Location: /produtos');
        exit;
    }

    public function salvar()
    {
        $produtoModel = new Produto();
        $estoqueModel = new Estoque();

        $dadosProduto = [
            'nome' => $_POST['nome'] ?? '',
            'descricao' => $_POST['descricao'] ?? '',
            'categoria' => $_POST['categoria'] ?? ''
        ];

        $variacoes = [];
        if (!empty($_POST['variacao']) && is_array($_POST['variacao'])) {
            foreach ($_POST['variacao'] as $i => $nome) {
                $nome = trim($nome);
                $quantidade = (float) ($_POST['quantidade'][$i] ?? 0);
                $preco = (float) ($_POST['preco'][$i] ?? 0);
                if ($nome !== '') {
                    $variacoes[] = [
                        'variacao' => $nome,
                        'preco' => $preco ?? 0,
                        'quantidade' => $quantidade
                    ];
                }
            }
        }

        $idProduto = $produtoModel->salvar($dadosProduto);

        if ($idProduto && !empty($variacoes)) {
            $estoqueModel->salvar($idProduto, $variacoes);
            header('Location: /produtos');
            exit;
        }

        echo "Erro ao salvar o produto.";
    }

    public function excluir($id)
    {
        $id = (int)$id;

        if (!$id) {
            echo "ID do produto não informado.";
            return;
        }

        $produtoModel = new Produto();
        $produtoModel->deletar($id);

        header('Location: /produtos');
        exit;
    }

    public function reativar($id)
    {
        $id = (int)$id;

        if (!$id) {
            echo "ID do produto não informado.";
            return;
        }

        $produtoModel = new Produto();
        $produtoModel->reativar($id);

        header('Location: /produtos');
        exit;
    }

}