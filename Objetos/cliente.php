<?php

Class Cliente {

    public $id;

    public $email;

    public $senha;

    public $telefone;

    public $cpf;

    public $imagem;

    public $bd;

    public function __construct($bd){
        $this->bd = $bd; 
    }

      public function lerTodos(){

        $sql = "SELECT * FROM clientes";
        $resultados = $this->bd->query($sql);
        $resultados->execute();

        return $resultados->fetchAll(PDO::FETCH_OBJ);
    }

     public function lerCliente($nome){
        $nome = "%" . $nome . "%"; 
        $sql = "SELECT * FROM cliente WHERE nome LIKE :nome";
        $resultado = $this->bd->prepare($sql); 
        $resultado->bindParam(':nome', $nome);
        $resultado->execute();
        
        return $resultado->fetchAll(PDO::FETCH_OBJ);
    }

     public function cadastrar(){
        $senha_hash = password_hash($this->senha, PASSWORD_DEFAULT); 
        $sql = "INSERT INTO cliente (nome, email, senha, telefone, cpf, imagem) VALUES (:nome, :email, :senha, :telefone, :imagem)";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(':nome', $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha_hash, PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $this->telefone, PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $this->cpf, PDO::PARAM_STR);
        $stmt->bindParam(':imagem', $this->imagem, PDO::PARAM_STR);
            
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        }

        public function atualizar(){
        $senha_hash = password_hash($this->senha, PASSWORD_DEFAULT);
        $sql = "UPDATE cliente SET nome = :nome, email = :email, senha = :senha, telefone = :telefone, cpf = :cpf WHERE id = :id";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(':nome', $this->nome, PDO::PARAM_STR); 
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha_hash, PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $this->telefone, PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $this->cpf, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT); 
            
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        }

        public function excluir(){
        $sql = "DELETE FROM cliente WHERE id = :id";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function pesquisaCliente($id){ 
        $sql = "SELECT * FROM cliente WHERE id LIKE :id;";
        $resultado = $this->bd->prepare($sql); 
        $resultado->bindParam(':id', $id);
        $resultado->execute();
        
        return $resultado->fetch(PDO::FETCH_OBJ);
    }

    public function Login(){
        $sql = "SELECT * FROM cliente WHERE email = :email";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if($result){
            if(password_verify($this->senha, $result->senha)){ 
                session_start();
                $_SESSION['cliente'] = $result;
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