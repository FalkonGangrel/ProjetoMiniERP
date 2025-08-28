<?php
    /** @var array $produto */
    use App\Helpers\Util;
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><?= $title ?? 'Produtos' ?></h2>
    <a href="/produtos/novo" class="btn btn-primary">Novo Produto</a>
</div>

<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Preço Médio (R$)</th>
            <th>Estoque</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($produtos)): ?>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?= Util::e($produto['id']) ?></td>
                    <td><?= Util::e($produto['nome']) ?></td>
                    <td><?= number_format($produto['preco_medio'], 2, ',', '.') ?></td>
                    <td><?= Util::e($produto['estoque_total']) ?></td>
                    <td>
                        <?php if (!empty($produto['ativo'])): ?>
                            <a href="/produtos/editar/<?= $produto['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="/produtos/excluir/<?= $produto['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja inativar este produto?')">Inativar</a>
                        <?php else: ?>
                            <a href="/produtos/reativar/<?= $produto['id'] ?>" class="btn btn-sm btn-success">Reativar</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">Nenhum produto encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>