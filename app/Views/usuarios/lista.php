<?php

/** @var array $usuario */

use function App\Helpers\e;

?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><?= $title ?? 'Usuários' ?></h2>
    <a href="/usuarios/novo" class="btn btn-primary">Novo Usuário</a>
</div>

<div class="container mt-4">
    <h2><?= $title ?? 'Usuários' ?></h2>
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Nome</th>
                <th>Login</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Telefone</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= e($usuario['nome']) ?></td>
                        <td><?= e($usuario['login']) ?></td>
                        <td><?= e($usuario['email']) ?></td>
                        <td><?= e($usuario['perfil']) ?></td>
                        <td><?= e($usuario['telefone1']) ?> / <?= e($usuario['telefone2']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Nenhum produto encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
