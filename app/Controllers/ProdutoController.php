<?php

namespace App\Controllers;

class ProdutoController
{
    public function listar()
    {
        // Simulação de dados
        $produtos = [
            ['id' => 1, 'nome' => 'Produto A', 'preco' => 10.99],
            ['id' => 2, 'nome' => 'Produto B', 'preco' => 20.49],
        ];

        view('produtos/lista', [
            'title' => 'Lista de Produtos',
            'produtos' => $produtos
        ]);
    }
}
