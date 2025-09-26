<?php

include_once 'configs/database.php';
include_once 'usuario.php';

class UsuariosController {

    private $bd;
    private $usuario;

    public function __construct() {
        $banco = new Database();
        $this->bd = $banco->conectar();
        $this->usuario = new Usuario($this->bd);
    }

    // Listar todos os usuários
    public function indexUsuario(){
        return $this->usuario->lerTodos();
    }

    // Pesquisar por nome
    public function pesquisarUsuario($nome){
        return $this->usuario->lerUsuario($nome);
    }

    // Buscar por ID
    public function localizarUsuario($id){
        return $this->usuario->pesquisaUsuario($id);
    }

    // Cadastrar usuário
    public function cadastrarUsuario($dados){
        $this->usuario->nome = $dados['nome']; 
        $this->usuario->email = $dados['email'];
        $this->usuario->senha = password_hash($dados['senha'], PASSWORD_DEFAULT);
        $this->usuario->telefone = $dados['telefone'];
        $this->usuario->tipo = $dados['tipo'] ?? 'CLIENTE'; // Default CLIENTE
        $this->usuario->ativo = $dados['ativo'] ?? true;

        if($this->usuario->cadastrar()){
            header("Location: index.php");
            exit();
        }
        return false;
    }

    // Atualizar usuário
    public function atualizarUsuario($dados){
        $this->usuario->id = $dados['id'];
        $this->usuario->nome = $dados['nome'];
        $this->usuario->email = $dados['email'];
        $this->usuario->telefone = $dados['telefone'];

        // Atualizar senha apenas se foi informada
        if(!empty($dados['senha'])){
            $this->usuario->senha = password_hash($dados['senha'], PASSWORD_DEFAULT);
        } else {
            $this->usuario->senha = $this->usuario->pesquisaUsuario($dados['id'])->senha;
        }

        $this->usuario->tipo = $dados['tipo'] ?? 'CLIENTE';
        $this->usuario->ativo = $dados['ativo'] ?? true;

        if($this->usuario->atualizar()){
            header("Location: listaUsuario.php");
            exit();
        }
        return false;
    }

    // Excluir usuário
    public function excluirUsuario($id){
        $this->usuario->id = $id;

        if($this->usuario->excluir()){
            header("Location: login.php");
            exit();
        }
        return false;
    }

    // Login
    public function login($email, $senha){
        $this->usuario->email = $email;
        $this->usuario->senha = $senha;

        if($this->usuario->login()){
            return true;
        } else {
            return false;
        }
    }
}
?>
