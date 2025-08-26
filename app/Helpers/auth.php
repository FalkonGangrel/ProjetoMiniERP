<?php

namespace App\Helpers;

function usuarioLogado()
{
    return isset($_SESSION['usuario']);
}

function usuarioAtual()
{
    return $_SESSION['usuario'] ?? null;
}

function temPermissao($requisitos)
{
    $usuario = usuarioAtual();
    return $usuario && in_array($usuario['perfil'], (array) $requisitos);
}
