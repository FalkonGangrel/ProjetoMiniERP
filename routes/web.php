<?php

return [
    '/' => 'HomeController@index',

    //Login
    '/login' => 'AuthController@loginForm',
    '/logout' => 'AuthController@logout',
    '/login' => ['POST' => 'AuthController@login'],

    //Usuários
    //'/usuarios' => ['UsuarioController@listar', 'admin'],
    '/usuarios' => 'UsuarioController@listar',
    '/usuarios/novo' => 'UsuarioController@cadastro',
    '/usuarios/salvar' => 'UsuarioController@salvar',

    // Produtos
    '/produtos' => 'ProdutoController@listar',
    //'/produtos/novo' => ['ProdutoController@cadastro', 'admin|colaborador'],
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
    //'/pedidos' => ['PedidoController@listar', 'admin|colaborador|cliente'],
    '/pedidos' => 'PedidoController@listar',
    '/pedidos/novo' => 'PedidoController@criar',
    '/pedidos/salvar' => 'PedidoController@salvar',
    '/pedidos/ver/{id}' => 'PedidoController@ver',

    // Cupons (opcional)
    '/cupons/validar/{codigo}' => 'CupomController@validar',

    //Webhook
    '/webhook/pedido' => 'WebhookController@receberPedido',
    '/webhook' => 'WebhookController@atualizarStatus',

    // Relatórios
    '/relatorios' => 'RelatorioController@index',
    '/relatorios/filtrar' => 'RelatorioController@filtrar',
    '/relatorios/exportar' => 'RelatorioController@exportarCSV',
];
