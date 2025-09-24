<?php

include_once 'configs/database.php';
include_once 'cliente.php';

Class AlunoController {

    private $bd;
    private $client;

    private $img_name;

    public function __construct(){
        $banco = new Database();
        $this->bd = $banco->conectar();
        $this->cliente = new clientes($this->bd);
    }

    public function index(){
        return $this->aluno->lerTodos();
    }
    

    public function cadastrarCliente($dados, $arquivo){

       if ($this->upload($arquivo)){

           $this->aluno->nome = $dados['nome'];
           $this->aluno->email = $dados['email'];
           $this->aluno->senha = $dados['senha'];
           $this->aluno->telefone = $dados['telefone'];
           $this->aluno->imagem = $this->img_name;

           if ($this->aluno->cadastrar()){
               header("Location: index.php");
               exit();
           }

       }

    return false;

    }

    public function upload($arquivo){
        $target_dir = "uploads/";
        $uploadOk = 1;
        $target_file = $target_dir . $arquivo["name"]["fileToUpload"];
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $random_name = uniqid('img_', true) . '.' . pathinfo($arquivo["name"]["fileToUpload"], PATHINFO_EXTENSION);
        $this->img_name = $random_name;
        $upload_file = $target_dir . $random_name;

       $check = getimagesize($arquivo["tmp_name"]["fileToUpload"]);

       //verifica se é uma imagem
       if ($check !== false) {
           $uploadOk = 1;
       } else {
           $uploadOk = 0;
       }

       //verifica se o arquivo  está no servidor
        if (file_exists($upload_file)) {
            $uploadOk = 0;
        }

        //verificar o tamanho da imagem - limite 4MB
        if ($arquivo["size"]["fileToUpload"] > 5000000) {
            $uploadOk = 0;
        }

        //permitir somente determinados tipos de imagem como jpg, png jpeg e gif
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $uploadOk = 0;
        }

        if ($uploadOk = 0) {
            return false;
        } else {
            if (move_uploaded_file($arquivo["tmp_name"]["fileToUpload"], $upload_file)) {
                return true;
            } else {
                return false;
            }
        }

        return false;

    }

    public function atualizarAluno($dados){
        $this->aluno->ra = $dados['ra'];
        $this->aluno->nome = $dados['nome'];
        $this->aluno->email = $dados['email'];
        $this->aluno->senha = $dados['senha'];
        $this->aluno->telefone = $dados['telefone'];

        if ($this->aluno->atualizar()){
        header("Location: index.php");
        exit();
    }

    return false;

    }

    public function excluirAluno($id){
       $this->aluno->ra = $id;
       
       if ($this->aluno->excluir()) {
        header("Location: index.php");
        exit();
       }
       
    }

    public function login($email, $senha){
        $this->aluno->email = $email;
        $this->aluno->senha = $senha;
        $this->aluno->login();
    }

}

?>