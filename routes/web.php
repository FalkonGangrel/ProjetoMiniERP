<?php

return [
    '/' => 'HomeController@index',

    '/produtos' => 'ProdutoController@listar',
    '/produtos/novo' => 'ProdutoController@cadastro',
    '/produtos/salvar' => 'ProdutoController@salvar',
    '/produtos/editar' => 'ProdutoController@editar',
'/produtos/atualizar' => 'ProdutoController@atualizar',

    '/estoques' => 'EstoqueController@listar',
    '/estoques/novo' => 'EstoqueController@cadastro',
    '/estoques/salvar' => 'EstoqueController@salvar',

    '/pedidos' => 'PedidoController@listar',
    '/pedidos/criar' => 'PedidoController@carrinho',

    '/relatorios' => 'RelatorioController@exibir',
];
