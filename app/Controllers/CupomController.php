<?php

namespace App\Controllers;

use App\Models\Cupom;

class CupomController
{
    public function validar($codigo)
    {
        $codigo = trim($codigo);
        $subtotal = isset($_GET['subtotal']) ? (float)$_GET['subtotal'] : 0;

        if (empty($codigo)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Código de cupom não informado.']);
            return;
        }

        $cupomModel = new Cupom();
        $cupom = $cupomModel->buscarPorCodigo($codigo);

        if (!$cupom) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Cupom inválido.']);
            return;
        }

        if ($cupom['validade'] < date('Y-m-d')) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Cupom expirado.']);
            return;
        }

        if ($subtotal < $cupom['valor_minimo']) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => "Subtotal insuficiente. Valor mínimo para usar o cupom: R$ " . number_format($cupom['valor_minimo'], 2, ',', '.')
            ]);
            return;
        }

        echo json_encode([
            'success' => true,
            'desconto' => $cupom['desconto'],
            'valor_minimo' => $cupom['valor_minimo'],
            'message' => 'Cupom válido!',
        ]);
    }
}
