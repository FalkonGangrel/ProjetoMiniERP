<?php

namespace App\Controllers;

use App\Models\Pedido;
use function App\Helpers\view;

class ProdutoController
{

    public function criar()
    {
        return view('pedidos/carrinho');
    }

    public function salvar()
    {
        $cliente = $_POST['cliente'];
        $total = $_POST['total'];
        $frete = $_POST['frete'];
        $endereco = $_POST['endereco'];

        $pedidoModel = new \App\Models\Pedido();
        $pedidoModel->salvar($cliente, $total, $frete, $endereco);

        header('Location: /pedidos');
        exit;
    }

}