<?php

/** @var array $produtos */

$editando = isset($produto);
$action = $editando ? '/produtos/atualizar?id=' . $produto['id'] : '/produtos/salvar';
$titulo = $editando ? 'Editar Produto' : 'Novo Produto';

?>

<h2><?= $titulo ?></h2>

<form method="post" action="<?= $action ?>">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="<?= $produto['nome'] ?? '' ?>" required><br>

    <label for="descricao">Descrição:</label>
    <textarea id="descricao" name="descricao" required><?= $produto['descricao'] ?? '' ?></textarea><br>

    <label for="preco">Preço:</label>
    <input type="number" step="0.01" id="preco" name="preco" value="<?= $produto['preco'] ?? '' ?>" required><br>

    <label for="categoria">Categoria:</label>
    <input type="text" id="categoria" name="categoria" value="<?= $produto['categoria'] ?? '' ?>"><br>

    <button type="submit">Salvar</button>
</form>

<?php if (isset($produto)): ?>
    <p><a href="/produtos">Cancelar</a></p>
<?php endif; ?>
