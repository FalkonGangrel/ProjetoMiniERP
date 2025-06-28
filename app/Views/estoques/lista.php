<?php /** @var array $estoques */ /** @var array $produtos */ ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Gerenciar Estoque</h2>
    <button class="btn btn-primary" id="btn-nova-variacao">Nova Variação</button>
</div>

<table class="table table-bordered table-striped" id="tabela-estoque">
    <thead class="table-light">
        <tr>
            <th>Produto</th>
            <th>Variação</th>
            <th>Quantidade</th>
            <th>Preço (R$)</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($estoques)): ?>
            <?php foreach ($estoques as $estoque): ?>
                <tr data-id="<?= $estoque['id'] ?>">
                    <td><?= htmlspecialchars($estoque['produto']) ?></td>
                    <td><span class="view-mode"><?= htmlspecialchars($estoque['variacao']) ?></span><input type="text" class="form-control edit-mode d-none" name="variacao" value="<?= htmlspecialchars($estoque['variacao']) ?>"></td>
                    <td><span class="view-mode"><?= htmlspecialchars($estoque['quantidade']) ?></span><input type="number" class="form-control edit-mode d-none" name="quantidade" value="<?= (int)$estoque['quantidade'] ?>"></td>
                    <td><span class="view-mode"><?= number_format($estoque['preco'], 2, ',', '.') ?></span><input type="number" class="form-control edit-mode d-none" name="preco" value="<?= (float)$estoque['preco'] ?>" step="0.01"></td>
                    <td>
                        <button class="btn btn-warning btn-sm btn-editar">Editar</button>
                        <button class="btn btn-success btn-sm btn-salvar d-none">Salvar</button>
                        <button class="btn btn-danger btn-sm btn-excluir">Excluir</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">Nenhuma variação encontrada.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-editar').forEach(btn => {
            btn.addEventListener('click', function () {
                const row = this.closest('tr');
                row.querySelectorAll('.view-mode').forEach(e => e.classList.add('d-none'));
                row.querySelectorAll('.edit-mode').forEach(e => e.classList.remove('d-none'));
                row.querySelector('.btn-salvar').classList.remove('d-none');
                this.classList.add('d-none');
            });
        });

        document.querySelectorAll('.btn-salvar').forEach(btn => {
            btn.addEventListener('click', function () {
                const row = this.closest('tr');
                const id = row.dataset.id;
                const variacao = row.querySelector('input[name="variacao"]').value;
                const quantidade = row.querySelector('input[name="quantidade"]').value;
                const preco = row.querySelector('input[name="preco"]').value;

                if (variacao.length < 3) {
                    alert("A variação deve ter pelo menos 3 caracteres.");
                    return;
                }
                if (isNaN(quantidade) || quantidade < 0) {
                    alert("Quantidade deve ser um número maior ou igual a 0.");
                    return;
                }
                if (isNaN(preco) || preco < 0) {
                    alert("Preço deve ser um número maior ou igual a 0.");
                    return;
                }

                fetch(`/estoques/atualizar/${id}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ variacao, quantidade, preco })
                }).then(res => res.ok && location.reload());
            });
        });

        document.querySelectorAll('.btn-excluir').forEach(btn => {
            btn.addEventListener('click', function () {
                const row = this.closest('tr');
                const id = row.dataset.id;
                if (confirm('Deseja realmente excluir esta variação?')) {
                    fetch(`/estoques/excluir/${id}`, { method: 'POST' })
                        .then(res => res.ok && location.reload());
                }
            });
        });

        document.getElementById('btn-nova-variacao').addEventListener('click', function () {
            const tbody = document.querySelector('#tabela-estoque tbody');
            const novaLinha = document.createElement('tr');
            novaLinha.innerHTML = `
                <td>
                    <select class="form-control select-produto" name="produto_id">
                        <option value="">Selecione um produto</option>
                        <?php foreach ($produtos as $produto): ?>
                            <option value="<?= $produto['id'] ?>"><?= htmlspecialchars($produto['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="variacao"></td>
                <td><input type="number" class="form-control" name="quantidade" min="0" value="0"></td>
                <td><input type="number" class="form-control" name="preco" step="0.01" value="0.00"></td>
                <td>
                    <button class="btn btn-primary btn-sm btn-salvar-novo">Salvar</button>
                </td>
            `;
            tbody.appendChild(novaLinha);

            const select2Field = novaLinha.querySelector('.select-produto');
            $(select2Field).select2({ width: '100%' });

            novaLinha.querySelector('.btn-salvar-novo').addEventListener('click', function () {
                const produto_id = novaLinha.querySelector('select[name="produto_id"]').value;
                const variacao = novaLinha.querySelector('input[name="variacao"]').value;
                const quantidade = novaLinha.querySelector('input[name="quantidade"]').value;
                const preco = novaLinha.querySelector('input[name="preco"]').value;

                if (variacao.length < 3) {
                    alert("A variação deve ter pelo menos 3 caracteres.");
                    return;
                }
                if (isNaN(quantidade) || quantidade < 0) {
                    alert("Quantidade deve ser um número maior ou igual a 0.");
                    return;
                }
                if (isNaN(preco) || preco < 0) {
                    alert("Preço deve ser um número maior ou igual a 0.");
                    return;
                }

                fetch('/estoques/salvar', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ produto_id, variacao, quantidade, preco })
                }).then(res => res.ok && location.reload());
            });
        });
    });
</script>
