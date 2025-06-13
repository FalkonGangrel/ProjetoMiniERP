<?php

/** @var array $produtos */

$editando = !empty($produto['id']);
$action = $editando ? '/produtos/atualizar?id=' . $produto['id'] : '/produtos/salvar';
$titulo = $editando ? 'Editar Produto' : 'Novo Produto';

?>

<h2><?= $titulo ?></h2>

<form method="post" action="<?= $action ?>">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" value="<?= htmlspecialchars($produto['nome'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea class="form-control" name="descricao" id="descricao"><?= htmlspecialchars($produto['descricao'] ?? '') ?></textarea>
    </div>

    <div class="mb-3">
        <label for="preco" class="form-label">Preço</label>
        <input type="number" step="0.01" class="form-control" name="preco" id="preco" value="<?= htmlspecialchars($produto['preco'] ?? 0) ?>" required>
    </div>

    <div class="mb-3">
        <label for="categoria" class="form-label">Categoria</label>
        <input type="text" class="form-control" name="categoria" id="categoria" value="<?= htmlspecialchars($produto['categoria'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label for="variacao" class="form-label">Variação</label>
        <input type="text" class="form-control" name="variacao" id="variacao" value="<?= htmlspecialchars($estoque['variacao'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label for="quantidade" class="form-label">Quantidade</label>
        <input type="number" class="form-control" name="quantidade" id="quantidade" value="<?= htmlspecialchars($estoque['quantidade'] ?? 0) ?>" required>
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="/produtos" class="btn btn-secondary">Voltar</a>
</form>