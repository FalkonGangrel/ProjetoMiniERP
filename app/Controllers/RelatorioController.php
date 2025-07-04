<?php

namespace App\Controllers;

use App\Models\Relatorio;
use function App\Helpers\view;

class RelatorioController
{
    public function index()
    {
        view('relatorios/index', [
            'title' => 'Relatórios',
            'filtros' => [],
            'resultados' => []
        ]);
    }

    public function filtrar()
    {
        $filtros = [
            'data_inicio' => $_POST['data_inicio'] ?? '',
            'data_fim' => $_POST['data_fim'] ?? '',
            'status' => $_POST['status'] ?? '',
        ];

        $relatorio = new Relatorio();
        $resultados = $relatorio->pedidosPorPeriodo($filtros);

        view('relatorios/index', [
            'title' => 'Relatórios',
            'filtros' => $filtros,
            'resultados' => $resultados
        ]);
    }

    public function exportarCSV()
    {
        // Simples checagem de permissão (provisória)
        if (!$this->isAdmin()) {
            http_response_code(403);
            echo "Acesso negado!";
            return;
        }

        $filtros = [
            'data_inicio' => $_GET['data_inicio'] ?? '',
            'data_fim' => $_GET['data_fim'] ?? '',
            'status' => $_GET['status'] ?? '',
        ];

        $relatorio = new \App\Models\Relatorio();
        $resultados = $relatorio->pedidosPorPeriodo($filtros);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=relatorio_pedidos.csv');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Cliente', 'Total', 'Status', 'Data']);

        foreach ($resultados as $pedido) {
            fputcsv($output, [
                $pedido['id'],
                $pedido['cliente_nome'],
                number_format($pedido['total'], 2, ',', '.'),
                $pedido['status'],
                $pedido['data']
            ]);
        }

        fclose($output);
    }

    private function isAdmin(): bool
    {
        // Simulação de proteção (substitua por uma session real)
        return true; // Troque por $_SESSION['is_admin'] === true;
    }
}
