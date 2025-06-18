<?php

namespace App\Controllers;

use App\Models\Produto;
use App\Models\Estoque;
use function App\Helpers\view;

class ProdutoController
{
    public function listar()
    {
        $produtoModel = new Produto();
        $produtos = $produtoModel->listarTodos();

        view('produtos/lista', [
            'title' => 'Lista de Produtos',
            'produtos' => $produtos
        ]);
    }

    public function cadastro()
    {
        view('produtos/form', [
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
            return view('produtos/erro', ['id' => $id]);
        }

        $estoqueModel = new Estoque();
        $estoque = $estoqueModel->buscarPorProduto($id);

        return view('produtos/form', compact('produto', 'estoque'));
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

        $dadosEstoque = [];
        foreach ($variacoes as $index => $variacao) {
            $dadosEstoque[] = [
                'variacao' => $variacao,
                'quantidade' => $quantidades[$index] ?? 0
            ];
        }

        $produtoModel->atualizar($id, $_POST);
        $estoqueModel->atualizarPorProduto($id, $dadosEstoque);

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
            'preco' => $_POST['preco'] ?? 0,
            'categoria' => $_POST['categoria'] ?? ''
        ];

        $idProduto = $produtoModel->salvar($dadosProduto);

        $variacoes = $_POST['variacao'] ?? [];
        $quantidades = $_POST['quantidade'] ?? [];

        $dadosEstoque = [];
        foreach ($variacoes as $index => $variacao) {
            $dadosEstoque[] = [
                'variacao' => $variacao,
                'quantidade' => $quantidades[$index] ?? 0
            ];
        }

        if ($idProduto) {
            $estoqueModel->salvar($idProduto,$dadosEstoque);

            header('Location: /produtos');
            exit;
        }

        echo "Erro ao salvar o produto.";
    }

}
