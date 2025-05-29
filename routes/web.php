<?php

return [
    '/' => 'HomeController@index',

    '/produtos' => 'ProdutoController@listar',
    '/produtos/novo' => 'ProdutoController@cadastro',
    '/produtos/salvar' => 'ProdutoController@salvar',

    '/estoques' => 'EstoqueController@listar',
    '/estoques/novo' => 'EstoqueController@cadastro',
    '/estoques/salvar' => 'EstoqueController@salvar',

    '/pedidos' => 'PedidoController@listar',
    '/pedidos/criar' => 'PedidoController@carrinho',

    '/relatorios' => 'RelatorioController@exibir',
];
