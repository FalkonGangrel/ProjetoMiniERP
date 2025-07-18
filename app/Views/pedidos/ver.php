<?php /** @var array $pedido */ ?>

<h2>Pedido #<?= $pedido['id'] ?></h2>
<p><strong>Cliente:</strong> <?= e($pedido['cliente_nome']) ?></p>
<p><strong>Data:</strong> <?= $pedido['data'] ?></p>
<p><strong>Status:</strong> <?= $pedido['status'] ?></p>

<h4>Itens do Pedido</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Produto</th>
            <th>Variação</th>
            <th>Valor Cadastrado</th>
            <th>Quantidade</th>
            <th>Valor Pago</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pedido['itens'] as $item): ?>
            <tr>
                <td><?= e($item['produto_nome']) ?></td>
                <td><?= e($item['variacao']) ?></td>
                <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                <td><?= $item['quantidade'] ?></td>
                <td>R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?></td>
                <td>R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p><strong>Frete:</strong> R$ <?= number_format($pedido['frete'], 2, ',', '.') ?></p>
<p><strong>Total:</strong> R$ <?= number_format($pedido['total'], 2, ',', '.') ?></p>
<a href="/pedidos" class="btn btn-secondary">Voltar</a>
