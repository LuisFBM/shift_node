<?php

Class Usuario{

    public $id;

    public $nome

    public $email

    public $senha;

    public $telefone;

    public $cpf;

    public $bd;

    public function __construct($bd) {
        $this->bd = $bd;
    }

     public function cadastrar(){
        
        $sql = "INSERT INTO usuario (nome, email, senha, telefone, cpf) VALUES (:nome, :email, :senha, :telefone, :cpf)";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(':nome', $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $this->senha, PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $this->telefone, PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $this->cpf, PDO::PARAM_STR);

        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function atualizar(){
        $senha_hash = password_hash($this->senha, PASSWORD_DEFAULT);
        
        $sql = "UPDATE usuario SET nome = :nome, email = :email, senha = :senha, telefone = :telefone, cpf = :cpf WHERE id = :id";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(':nome', $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $this->senha_hash, PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $this->telefone, PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $this->cpf, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if($stmt->execute()){
            return true;
        } else {
            return false;
        }

           public function excluir(){
        $sql = "DELETE FROM usuario WHERE id = :id";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    }

       public function login(){
        $sql = "SELECT * FROM usuario WHERE email = :email";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_OBJ);

        if($resultado){
        if(password_verify($this->senha, $resultado->senha)){
            session_start();
            $_SESSION['usuario'] = $resultado;
            header("Location: index.php");
            exit();
        } else {
            header("Location: login.php");
            exit();
            }
        } 
    }
    

}

?>