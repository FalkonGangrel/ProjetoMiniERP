<?php

namespace App\Controllers;

use App\Models\Pedido;
use function App\Helpers\view;

class PedidoController
{
    public function listar()
    {
        $pedidoModel = new Pedido();
        $pedidos = $pedidoModel->listarTodos();

        view('pedidos/lista', [
            'title' => 'Pedidos Realizados',
            'pedidos' => $pedidos
        ]);
    }

    public function criar()
    {
        view('pedidos/carrinho', [
            'title' => 'Novo Pedido'
        ]);
    }

    public function salvar()
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        if (!$dados || empty($dados['cliente']) || empty($dados['itens'])) {
            http_response_code(400);
            echo 'Dados incompletos.';
            return;
        }

        $pedidoModel = new Pedido();
        $pedidoId = $pedidoModel->salvar([
            'cliente_nome' => $dados['cliente'],
            'total' => $dados['total'] ?? 0,
            'frete' => $dados['frete'] ?? 0,
            'cep' => $dados['cep'] ?? '',
            'endereco' => $dados['endereco'] ?? '',
            'status' => 'pendente',
            'data' => date('Y-m-d H:i:s')
        ],
        [
            'itens' => $dados['itens']
        ]);

        if ($pedidoId) {
            echo "Pedido #$pedidoId salvo com sucesso.";
        } else {
            http_response_code(500);
            echo "Erro ao salvar o pedido.";
        }
    }

    public function ver($id)
    {
        $id = (int)$id;
        $pedidoModel = new Pedido();
        $pedido = $pedidoModel->buscarComItens($id);

        if (!$pedido) {
            echo "Pedido não encontrado.";
            return;
        }

        return view('pedidos/ver', ['pedido' => $pedido]);
    }

}
