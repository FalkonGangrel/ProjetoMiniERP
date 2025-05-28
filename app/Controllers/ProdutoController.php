<?php

namespace App\Controllers;

class ProdutoController
{
    public function listar()
    {
        // Simulação de dados
        $produtos = [
            ['id' => 1, 'nome' => 'Produto A'],
            ['id' => 2, 'nome' => 'Produto B'],
        ];

        view('produtos.lista', compact('produtos'));
    }
}
