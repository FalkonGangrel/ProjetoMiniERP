<?php

/** @var array $produtos */

use App\Helpers\Util;
$editando = !empty($produto['id']);
$action = $editando ? '/produtos/atualizar?id=' . $produto['id'] : '/produtos/salvar';
$titulo = $editando ? 'Editar Produto' : 'Novo Produto';

?>

<h2><?= $titulo ?></h2>

<form method="post" action="<?= $action ?>">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" value="<?= Util::e($produto['nome'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea class="form-control" name="descricao" id="descricao"><?= Util::e($produto['descricao'] ?? '') ?></textarea>
    </div>

    <div class="mb-3">
        <label for="categoria" class="form-label">Categoria</label>
        <input type="text" class="form-control" name="categoria" id="categoria" value="<?= Util::e($produto['categoria'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label for="variacoes-container" class="form-label">Variações</label>
        <div class="row mb-2 variacao-label">
            <div class="col-md-5">
                <strong>Variação</strong>
            </div>
            <div class="col-md-3">
                <strong>Preço (R$)</strong>
            </div>
            <div class="col-md-2">
                <strong>Quantidade</strong>
            </div>
            <div class="col-md-2 d-flex align-items-center justify-content-center">
                <strong>Ação</strong>
            </div>
        </div>
        <div id="variacoes-container">
            <?php if (!empty($estoque)): ?>
                <?php foreach ($estoque as $index => $item): ?>
                    <div class="row mb-2 variacao-item">
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="variacao[]" placeholder="Nome da variação" value="<?= Util::e($item['variacao']) ?>" required>
                        </div>
                        <div class="col-md-3">
                            <input type="number" step="0.01" class="form-control" name="preco[]" placeholder="Preço" min="0" value="<?= (float)$item['preco'] ?>" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="quantidade[]" placeholder="Quantidade" min="0" value="<?= (int)$item['quantidade'] ?>" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <button type="button" class="btn btn-danger btn-sm remove-variacao" <?= count($estoque) === 1 ? 'disabled' : '' ?>>Remover</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="row mb-2 variacao-item">
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="variacao[]" placeholder="Nome da variação" value="Padrão" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" step="0.01" class="form-control" name="preco[]" placeholder="Preço" min="0" value="0" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" name="quantidade[]" placeholder="Quantidade" min="0" value="0" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-center">
                        <button type="button" class="btn btn-danger btn-sm remove-variacao" disabled>Remover</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <button type="button" class="btn btn-info btn-sm" id="adicionar-variacao">Adicionar Variação</button>
    </div>

    <div class="mb-3">
        <strong>Total de Quantidade:</strong> <span id="total-quantidade">0</span>
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <?php if ($editando && !empty($produto['ativo'])): ?>
        <a href="/produtos/excluir/<?= $produto['id'] ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja inativar este produto?')">Inativar</a>
    <?php endif; ?>
    <a href="/produtos" class="btn btn-secondary">Voltar</a>
</form>

<script>
    function atualizarTotal() {
        let total = 0;
        document.querySelectorAll('input[name="quantidade[]"]').forEach(input => {
            total += parseInt(input.value) || 0;
        });
        document.getElementById('total-quantidade').textContent = total;
    }

    document.addEventListener('DOMContentLoaded', function () {
        atualizarTotal();

        document.getElementById('variacoes-container').addEventListener('input', atualizarTotal);

        document.getElementById('adicionar-variacao').addEventListener('click', function () {
            const container = document.getElementById('variacoes-container');
            const div = document.createElement('div');
            div.className = 'row mb-2 variacao-item';
            div.innerHTML =
                `<div class="col-md-5">
                    <input type="text" class="form-control" name="variacao[]" placeholder="Nome da variação" required>
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" class="form-control" name="preco[]" placeholder="Preço" min="0" value="0" required>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="quantidade[]" placeholder="Quantidade" min="0" value="0" required>
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm remove-variacao">Remover</button>
                </div>`
            ;
            container.appendChild(div);
            atualizarTotal();
        });

        document.getElementById('variacoes-container').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-variacao')) {
                const item = e.target.closest('.variacao-item');
                if (document.querySelectorAll('.variacao-item').length > 1) {
                    item.remove();
                    atualizarTotal();
                }
            }
        });
    });
</script>