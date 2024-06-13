<?php 
    include ('db.php');

    if(isset($_POST['email']) || isset($_POST['senha'])){

        if(strlen($_POST['email']) == 0 ){
            echo "Preencha seu email";
        }else if(strlen($_POST['senha']) == 0){
            echo "preencha sua senha";
        }else{

            $email = $banco->real_escape_string($_POST['email']);
            $senha = $banco->real_escape_string($_POST['senha']);

            $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
            $sql_query = $banco->query($sql_code) or die("falha na execução do codigo");

            $quant = $sql_query->num_rows;

            if($quant == 1){
                $usuario = $sql_query->fetch_assoc();

                if(!isset($_SESSION)){
                    session_start();
                }

                $_SESSION['id'] = $usuario['id'];
                $_SESSION['usuario'] = $usuario['usuario'];

                header(("Location: painel.php"));


            }else{
                echo "email ou senha incorreto";
            }


        }
    }

    if (isset ($_POST['criar'])){
        $usuario = $_POST['usuario'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $validacao_email = $banco -> query("SELECT email FROM usuarios WHERE email='$email'") or die("falha na execução do codigo");
        $fazer_validacao_email = mysqli_num_rows($validacao_email);
        $validacao_usuario = $banco -> query("SELECT usuario FROM usuarios WHERE usuario='$usuario'") or die("falha na execução do codigo");
        $fazer_validacao_usuario = mysqli_num_rows($validacao_usuario);
        if($fazer_validacao_usuario >=1 or empty($usuario)){
            echo'<h3>Este usuario já está sendo utilizado ou está vazio</h3>';
        }
        elseif ($fazer_validacao_email >= 1 or strlen($email)<0) {
            echo '<h3>Este email já está sendo utilizado ou está vazio</h3>';
        }
        else{
            $query = "INSERT INTO `usuarios` (`id`, `usuario`, `email`, `senha`) VALUES (NULL, '$usuario', '$email', '$senha')";
            $data = $banco -> query($query) or die ("falha na execução do codigo");
            if($data){
                if(!isset($_SESSION)){
                    session_start();
                }
                echo "<h2>Conta criada com sucesso!</h2>";  
            }
            else{
                echo'<h3>Erro ao registrar</h3>';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login rede</title>
</head>

<body>
    <h1 class="logo">Social <span>Net</span></h1>
    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="login">
            <form class="form" method="POST">
                <label for="chk" aria-hidden="true">Entrar</label>
                <input class="input" type="email" name="email" placeholder="Email" required="">
                <input class="input" type="password" name="senha" placeholder="Senha" required="">
                <input type="submit" value="Entrar" name="entrar">
            </form>
        </div>

        <div class="register">
            <form class="form" method="POST">
                <label for="chk" aria-hidden="true">Cadastrar</label>
                <input class="input" type="text" name="usuario" placeholder="Usuario" required="">
                <input class="input" type="email" name="email" placeholder="Email" required="">
                <input class="input" type="password" name="senha" placeholder="Senha" required="">
                <input type="submit" value="Criar conta" name="criar">
            </form>
        </div>
    </div>


</body>

</html>