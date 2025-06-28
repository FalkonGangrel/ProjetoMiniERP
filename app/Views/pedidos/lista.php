<?php /** @var array $pedido */ ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><?= $title ?? 'Pedidos' ?></h2>
    <a href="/pedidos/novo" class="btn btn-primary">Novo Pedido</a>
</div>

<div class="container mt-4">
    <h2><?= $title ?? 'Pedidos' ?></h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Status</th>
                <th>Data</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= $pedido['id'] ?></td>
                    <td><?= $pedido['cliente_nome'] ?></td>
                    <td>R$ <?= number_format($pedido['total'], 2, ',', '.') ?></td>
                    <td><?= ucfirst($pedido['status']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($pedido['data'])) ?></td>
                    <td>
                        <a href="/pedidos/ver/<?= $pedido['id'] ?>" class="btn btn-sm btn-primary">Ver</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
