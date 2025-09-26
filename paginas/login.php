<?php

include_once "objetos/usuarioController.php";

if($_SERVER['REQUEST_METHOD'] === "POST") {
    if(isset($_POST['email']) && isset($_POST['senha'])) {
        $controller = new usuariosController();
        $controller->login($_POST['email'], $_POST['senha']);
    }
}

?>

<!DOCTYPE html>
<html lang="pr-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form method="POST" action="login.php">
        <label for="Nome">E-mail</label>
        <input type="text" name="email" id="email" required>

        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha" required>

        <?php if(isset($_SESSION['Erro'])) :?>

        <h1><?= $_SESSION['Erro ao logar'] ?></h1>

        <?php endif ?>

        <button>Entrar</button>
    </form>

    <p>Clique aqui para cadastrar<a href="cadastroUsuario.php">Cadastrar</a></p>
    
</body>
</html>