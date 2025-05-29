<h1><?= $title ?></h1>

<ul class="list-group">
    <?php foreach ($produtos as $p): ?>
        <li class="list-group-item"><?= $p['nome'] ?> - R$ <?= number_format($p['preco'], 2, ',', '.') ?></li>
    <?php endforeach; ?>
</ul>