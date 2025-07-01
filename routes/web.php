<?php

return [
    '/' => 'HomeController@index',

    // Produtos
    '/produtos' => 'ProdutoController@listar',
    '/produtos/novo' => 'ProdutoController@cadastro',
    '/produtos/salvar' => 'ProdutoController@salvar',
    '/produtos/editar/{id}' => 'ProdutoController@editar',
    '/produtos/atualizar' => 'ProdutoController@atualizar',
    '/produtos/excluir/{id}' => 'ProdutoController@excluir',
    '/produtos/reativar/{id}' => 'ProdutoController@reativar',

    // Estoques
    '/estoques' => 'EstoqueController@listar',
    '/estoques/atualizar/{id}' => 'EstoqueController@atualizar',
    '/estoques/excluir/{id}' => 'EstoqueController@excluir',
    '/estoques/salvar' => 'EstoqueController@salvar',
    '/api/estoques/por-produto/{id}' => 'Api\EstoqueApiController@porProduto',

    // Pedidos
    '/pedidos' => 'PedidoController@listar',
    '/pedidos/novo' => 'PedidoController@criar',
    '/pedidos/salvar' => 'PedidoController@salvar',
    '/pedidos/ver/{id}' => 'PedidoController@ver',

    // Cupons (opcional)
    '/cupons/validar/{codigo}' => 'CupomController@validar',

    // Relatórios
    '/relatorios' => 'RelatorioController@exibir',
];
