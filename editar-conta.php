<?php 
include ('db.php');

if(!isset($_SESSION)){
    session_start();
}

if (isset ($_POST['alterar'])){
    $id = $_SESSION['id'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $confirm_senha = $_POST['confirm-senha'];

    if($senha != $confirm_senha){
        echo"as senhas não coincidem";
    }
    else{ 
        $validacao_usuario = $banco -> query("SELECT usuario FROM usuarios WHERE usuario='$usuario'") or die("falha na execução do codigo");
        $fazer_validacao_usuario = mysqli_num_rows($validacao_usuario);
        if($fazer_validacao_usuario >=1 or empty($usuario)){
            echo'<h3>Este usuario já está sendo utilizado ou está vazio</h3>';
        }
        else{
            
            $query = "UPDATE `usuarios` SET `usuario` = '$usuario', `senha` = '$senha' WHERE `id` = '$id'";
            $data = $banco -> query($query) or die ("falha na execução do codigo");
            if($data){
                header("Location: painel.php");
            }
            else{
                echo'<h3>Erro ao alterar dados</h3>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/editar-conta.css">
</head>

<body>
    <h1 class="logo">Social <span>Net</span></h1>
    <div class="main">
        <div class="alterar">
            <form class="form" method="POST">
                <label for="">Editar conta</label>
                <input class="input" type="text" name="usuario" placeholder="Usuario" required="">
                <input class="input" type="password" name="senha" placeholder="Nova senha" required="">
                <input class="input" type="password" name="confirm-senha" placeholder="Confirmar nova senha"
                    required="">
                <input type="submit" value="Alterar" name="alterar">
                <a href="perfil.php">cancelar</a>
            </form>
        </div>
    </div>


</body>

</html>