<?php
    use App\Helpers\Util;
?>

<h2>Produto não encontrado</h2>
<p>Produto não encontrado com o ID <?= Util::e($id) ?>.</p>
<a href="/produtos" class="btn">Voltar para a listagem</a>