<?php

namespace App\Controllers;

use App\Models\Produto;
use App\Models\Estoque;
use function App\Helpers\view;

class ProdutoController
{
    public function listar()
    {
        // Simulação de dados
        $produtos = [
            ['id' => 1, 'nome' => 'Produto A', 'preco' => 10.99, 'estoque' => 20],
            ['id' => 2, 'nome' => 'Produto B', 'preco' => 20.49, 'estoque' => 10],
        ];

        view('produtos/lista', [
            'title' => 'Lista de Produtos',
            'produtos' => $produtos
        ]);
    }

    public function criar()
    {
        return view('produtos/cadastro');
    }

    public function editar($id)
    {
        $produtoModel = new Produto();
        $produto = $produtoModel->buscarPorId($id);

        $estoqueModel = new Estoque();
        $estoque = $estoqueModel->buscarPorProduto($id);

        return view('produtos/cadastro', compact('produto', 'estoque'));
    }

    public function atualizar()
    {
        $id = $_POST['id'];
        $dados = $_POST;

        $produtoModel = new Produto();
        $estoqueModel = new Estoque();

        $produtoModel->atualizar($id, $dados);
        $estoqueModel->atualizarPorProduto($id, $dados);

        header('Location: /produtos');
        exit;
    }

}
