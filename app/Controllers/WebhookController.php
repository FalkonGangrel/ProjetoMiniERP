<?php
namespace App\Controllers;

use App\Models\Pedido;
use function App\Helpers\db;

class WebhookController {
    public function receberPedido() {
        $dados = json_decode(file_get_contents('php://input'), true);
        $id = (int)($dados['id'] ?? 0);
        $status = $dados['status'] ?? '';

        if (!$id || !$status) {
            http_response_code(400);
            echo 'ID ou status inválido.';
            return;
        }

        $pedidoModel = new Pedido();

        if ($status === 'cancelado') {
            $pedido = $pedidoModel->buscarComItens($id);
            if ($pedido) {
                foreach ($pedido['itens'] as $item) {
                    // Reverte estoque
                    db()->query(
                        "UPDATE estoques SET quantidade = quantidade + ? WHERE id = ?",
                        $item['quantidade'],
                        $item['variacao_id']
                    );
                }
                db()->query("DELETE FROM pedidos WHERE id = ?", $id);
                echo "Pedido #$id cancelado e removido.";
            } else {
                echo "Pedido não encontrado.";
            }
        } else {
            db()->query("UPDATE pedidos SET status = ? WHERE id = ?", $status, $id);
            echo "Status do pedido #$id atualizado para $status.";
        }
    }

    public function atualizarStatus() {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = (int)($data['id'] ?? 0);
        $status = trim($data['status'] ?? '');

        if ($id < 1 || !$status) {
            http_response_code(400);
            echo "ID ou status inválido.";
            return;
        }

        $pedidoModel = new Pedido();
        if ($status === 'cancelado') {
            $pedidoModel->excluir($id); // Reverter estoque
        } else {
            $pedidoModel->atualizarStatus($id, $status);
        }
        echo "Webhook recebido!";
    }
}
