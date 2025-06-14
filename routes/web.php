<?php

return [
    '/' => 'HomeController@index',

    // Produtos
    '/produtos' => 'ProdutoController@listar',
    '/produtos/novo' => 'ProdutoController@cadastro',
    '/produtos/salvar' => 'ProdutoController@salvar',
    '/produtos/editar/{id}' => 'ProdutoController@editar',
    '/produtos/atualizar' => 'ProdutoController@atualizar',

    // Estoques
    '/estoques' => 'EstoqueController@listar',
    '/estoques/novo' => 'EstoqueController@cadastro',
    '/estoques/salvar' => 'EstoqueController@salvar',

    // Pedidos
    '/pedidos' => 'PedidoController@listar',
    '/pedidos/adicionar/{id}' => 'PedidoController@adicionarCarrinho',
    '/pedidos/remover/{id}' => 'PedidoController@removerCarrinho',
    '/pedidos/carrinho' => 'PedidoController@carrinho',
    '/pedidos/finalizar' => 'PedidoController@finalizar',
    '/pedidos/confirmar' => 'PedidoController@confirmar',

    // Cupons (opcional)
    '/cupons/validar/{codigo}' => 'CupomController@validar',

    // Relatórios
    '/relatorios' => 'RelatorioController@exibir',
];
