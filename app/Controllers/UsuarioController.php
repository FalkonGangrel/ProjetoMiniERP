<?php

namespace App\Controllers;

use App\Models\Usuario;
use function App\Helpers\view;
use function App\Helpers\redirect;

class UsuarioController
{
    public function listar()
    {
        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->listarTodos();
        view('usuarios/lista', compact('usuarios'));
    }

    public function cadastro()
    {
        view('usuarios/cadastro');
    }

    public function salvar()
    {
        $dados = $_POST;
        $obrigatorios = ['nome', 'login', 'senha', 'email', 'telefone1', 'telefone2', 'perfil'];

        foreach ($obrigatorios as $campo) {
            if (empty(trim($dados[$campo] ?? ''))) {
                $_SESSION['erro'] = "Campo obrigatório: $campo";
                redirect('/usuarios/cadastro');
                return;
            }
        }

        $usuarioModel = new Usuario();
        if ($usuarioModel->salvar($dados)) {
            $_SESSION['sucesso'] = "Usuário cadastrado com sucesso.";
            redirect('/usuarios');
        } else {
            $_SESSION['erro'] = "Erro ao salvar usuário.";
            redirect('/usuarios/cadastro');
        }
    }
}
