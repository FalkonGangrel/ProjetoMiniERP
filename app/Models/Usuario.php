<?php

namespace App\Models;

use function App\Helpers\db;

class Usuario
{
    private $db;

    public function __construct()
    {
        $this->db = db();
    }

    public function autenticar($login, $senha)
    {
        $sql = "SELECT * FROM usuarios WHERE login = ? AND ativo = 1 LIMIT 1";
        $this->db->query($sql, $login);
        $usuario = $this->db->fetchArray();

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }

        return false;
    }

    public function listarTodos()
    {
        $sql = "SELECT id, nome, login, email, perfil FROM usuarios ORDER BY nome";
        $this->db->query($sql);
        $usuarios = $this->db->fetchAll();
        return $usuarios;
    }

    public function salvar(array $dados)
    {
        $sql = "INSERT INTO usuarios (nome, login, senha, email, telefone1, telefone2, perfil) VALUES (?, ?, ?, ?, ?, ?, ?)";
        return $this->db->query(
            $sql,
            $dados['nome'],
            $dados['login'],
            password_hash($dados['senha'], PASSWORD_DEFAULT),
            $dados['email'],
            $dados['telefone1'],
            $dados['telefone2'],
            $dados['perfil']
        );
    }

    public function listarClientes()
    {
        $this->db->query("SELECT id, nome, email FROM usuarios WHERE perfil = 'cliente'");
        return $this->db->fetchAll();
    }

    public function buscarPorLogin($login)
    {
        $this->db->query("SELECT * FROM usuarios WHERE login = ?", $login);
        return $this->db->fetchArray();
    }

    public function buscarPorId($id)
    {
        $this->db->query("SELECT * FROM usuarios WHERE id = ?", $id);
        return $this->db->fetchArray();
    }
}
