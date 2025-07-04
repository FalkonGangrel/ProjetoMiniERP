<div class="container mt-4">
    <h2>Relatórios</h2>

    <form action="/relatorios/filtrar" method="POST" class="row g-3 mb-4">
        <div class="col-md-3">
            <label>Data início</label>
            <input type="date" name="data_inicio" value="<?= $filtros['data_inicio'] ?? '' ?>" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Data fim</label>
            <input type="date" name="data_fim" value="<?= $filtros['data_fim'] ?? '' ?>" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="">Todos</option>
                <option value="pendente" <?= ($filtros['status'] ?? '') === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                <option value="finalizado" <?= ($filtros['status'] ?? '') === 'finalizado' ? 'selected' : '' ?>>Finalizado</option>
                <option value="cancelado" <?= ($filtros['status'] ?? '') === 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
            </select>
        </div>
        <div class="col-md-3 align-self-end">
            <button class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>

    <?php if (!empty($resultados)): ?>
        <div class="col-md-3 align-self-end">
            <a href="/relatorios/exportar?data_inicio=<?= $filtros['data_inicio'] ?? '' ?>&data_fim=<?= $filtros['data_fim'] ?? '' ?>&status=<?= $filtros['status'] ?? '' ?>" class="btn btn-success w-100">Exportar CSV</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $pedido): ?>
                    <tr>
                        <td><?= $pedido['id'] ?></td>
                        <td><?= $pedido['cliente_nome'] ?></td>
                        <td>R$ <?= number_format($pedido['total'], 2, ',', '.') ?></td>
                        <td><?= ucfirst($pedido['status']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($pedido['data'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif (!empty($filtros)): ?>
        <p>Nenhum resultado encontrado.</p>
    <?php endif; ?>
</div>
