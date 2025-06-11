<?php

/** @var array|null $estoque */
/** @var array $produtos */

$editando = isset($estoque);
$action = $editando ? '/estoques/atualizar' : '/estoques/salvar';
$titulo = $editando ? 'Editar Estoque' : 'Novo Estoque';

?>

<h2><?= $titulo ?></h2>

<form method="post" action="<?= $action ?>">
    <?php if ($editando): ?>
        <input type="hidden" name="id" value="<?= $estoque['id'] ?>">
    <?php endif; ?>

    <label for="produto_id">Produto:</label>
    <select name="produto_id" required>
        <option value="">-- Selecione --</option>
        <?php foreach ($produtos as $produto): ?>
            <option value="<?= $produto['id'] ?>" <?= ($editando && $estoque['produto_id'] == $produto['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($produto['nome']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="quantidade">Quantidade:</label>
    <input type="number" name="quantidade" required value="<?= $editando ? $estoque['quantidade'] : '' ?>">

    <label for="localizacao">Localização:</label>
    <input type="text" name="localizacao" value="<?= $editando ? htmlspecialchars($estoque['localizacao']) : '' ?>">

    <button type="submit">Salvar</button>
</form>
