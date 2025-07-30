<?php

namespace App\Controllers;

use App\Models\Estoque;
use App\Models\Produto;
use function App\Helpers\view;

class EstoqueController
{
    public function listar()
    {
        $estoqueModel = new Estoque();
        $estoques = $estoqueModel->listarComProduto();

        $produtoModel = new Produto();
        $produtos = $produtoModel->listarTodos();

        return view('estoques/lista', [
            'estoques' => $estoques,
            'produtos' => $produtos,
        ]);
    }

    public function atualizar($id)
    {
        $id = (int) $id;
        $dados = json_decode(file_get_contents('php://input'), true);

        if (!$dados || !isset($dados['variacao'], $dados['quantidade'], $dados['preco'])) {
            http_response_code(400);
            echo 'Dados inválidos.';
            return;
        }

        $estoque = new Estoque();
        $estoque->atualizarVariação($id, $dados);

        http_response_code(200);
    }

    public function excluir($id)
    {
        $id = (int) $id;

        $estoque = new Estoque();
        $estoque->excluirVariação($id);

        http_response_code(200);
    }

    public function salvar()
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        if (!$dados || !isset($dados['produto_id'], $dados['variacao'], $dados['quantidade'], $dados['preco'])) {
            http_response_code(400);
            echo 'Dados incompletos.';
            return;
        }

        $produtoModel = new Produto();
        $produto = $produtoModel->buscarPorId($dados['produto_id']);

        if (!$produto) {
            http_response_code(404);
            echo 'Produto não encontrado.';
            return;
        }

        $estoque = new Estoque();
        $estoque->salvar($produto['id'], [ $dados ]);

        http_response_code(201);
    }
}
