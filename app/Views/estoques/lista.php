<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Lista de Estoques</h2>
    <a href="/estoques/novo" class="btn btn-primary">Novo Estoque</a>
</div>

<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>Produto</th>
            <th>Variação</th>
            <th>Quantidade</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($estoques)): ?>
            <?php foreach ($estoques as $estoque): ?>
                <tr>
                    <td><?= htmlspecialchars($estoque['produto']) ?></td>
                    <td><?= htmlspecialchars($estoque['variacao']) ?></td>
                    <td><?= htmlspecialchars($estoque['quantidade']) ?></td>
                    <td>
                        <a href="/estoques/editar/<?= $estoque['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="/estoques/excluir/<?= $estoque['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este estoque?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">Nenhum estoque encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
