<?php

namespace App\Controllers;

use App\Models\Estoque;
use function App\Helpers\view;

class EstoqueController
{
    public function criar()
    {
        return view('estoques/form');
    }

    public function salvar()
    {
        // Aqui você pode adicionar validação/sanitização
        $produtoId = $_POST['produto_id'];
        $variacao = $_POST['variacao'];
        $quantidade = $_POST['quantidade'];

        $estoqueModel = new \App\Models\Estoque();
        $estoqueModel->salvar($produtoId, $variacao, $quantidade);

        header('Location: /estoques');
        exit;
    }
}