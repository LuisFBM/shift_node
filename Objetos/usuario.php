<?php

class Usuario {
    public $id;
    public $nome;
    public $email;
    public $senha;
    public $telefone;
    public $whatsapp;
    public $cpf;
    public $tipo; // CLIENTE, ATENDENTE, MECANICO, ADMIN
    public $ativo;
    private $bd;

    public function __construct($bd) {
        $this->bd = $bd;
    }

    // Ler todos os usuários ou filtrar por tipo
    public function lerTodos($tipo = null){
        $sql = "SELECT * FROM usuarios";
        if($tipo){
            $sql .= " WHERE tipo = :tipo";
            $stmt = $this->bd->prepare($sql);
            $stmt->bindParam(':tipo', $tipo);
        } else {
            $stmt = $this->bd->prepare($sql);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Buscar usuário pelo nome
    public function lerUsuario($nome){
        $nome = "%" . $nome . "%";
        $sql = "SELECT * FROM usuarios WHERE nome LIKE :nome";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Buscar por ID
    public function pesquisaUsuario($id){
        $sql = "SELECT * FROM usuarios WHERE id_usuario = :id";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Cadastrar usuário
    public function cadastrar(){
        $sql = "INSERT INTO usuarios (nome, email, senha, telefone, whatsapp, cpf, tipo, ativo) 
                VALUES (:nome, :email, :senha, :telefone, :whatsapp, :cpf, :tipo, :ativo)";
        $stmt = $this->bd->prepare($sql);

        $senha_hash = password_hash($this->senha, PASSWORD_DEFAULT);

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':senha', $senha_hash);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':whatsapp', $this->whatsapp);
        $stmt->bindParam

?>