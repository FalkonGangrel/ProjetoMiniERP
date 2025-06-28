<?php

namespace App\Controllers\Api;

use App\Models\Estoque;

class EstoqueApiController
{
    public function porProduto($produtoId)
    {
        header('Content-Type: application/json');

        $estoque = new Estoque();
        $variacoes = $estoque->listarPorProdutoComEstoque($produtoId);

        echo json_encode($variacoes);
    }
}
