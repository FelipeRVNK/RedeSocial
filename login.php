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
            $sql_query = $banco->query($sql_code) or die("falha na execuçaõ do codigo");

            $quant = $sql_query->num_rows;

            if($quant == 1){
                $usuario = $sql_query->fetch_assoc();

                if(!isset($_SESSION)){
                    session_start();
                }

                $_SESSION['id'] = $usuario['id'];
                $_SESSION['name'] = $usuario['name'];

                header(("Location: painel.php"));


            }else{
                echo "email ou senha incorreto";
            }


        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login rede</title>
</head>
<body>
    <h1>Social <span>Net</span></h1>
    <h2>Login</h2>
    <form action="" method="POST">
        <input type="email" name="email" id="email" placeholder="Digite seu email"><br>
        <input type="password" name="senha" id="senha" placeholder="Digite sua senha"><br>
        <input type="submit" value="Entrar" name="entrar">
    </form>
</body>
</html>