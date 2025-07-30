<?php

namespace App\Controllers;

use App\Models\Usuario;
use function App\Helpers\view;
use function App\Helpers\redirect;


class AuthController
{
    public function loginForm()
    {
        view('auth/login');
    }

    public function login()
    {
        $login = $_POST['login'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->autenticar($login, $senha);

        if ($usuario) {
            $_SESSION['usuario'] = $usuario;
            redirect('Location: /');
        } else {
            view('auth/login', ['erro' => 'Login ou senha inválidos']);
        }
    }

    public function logout()
    {
        unset($_SESSION['usuario']);
        session_destroy();
        redirect('Location: /login');
    }
}
