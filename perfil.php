<?php 

    include ('db.php');

    if(!isset($_SESSION)){
        session_start();
    }

    $id = $_SESSION['id'];

    if (isset ($_POST['deletar'])){

        $query = "DELETE FROM usuarios WHERE `usuarios`.`id` ='$id'";
        $banco->query($query) or die("falha na execução do codigo");
        header(("Location: login.php"));

    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="painel.css">
</head>

<body>
    <header class="container">
        <nav>
            <ul>
                <a href="perfil.php">
                    <li>Perfil</li>
                </a>
                <a href="">
                    <li>Pesquisa</li>
                </a>
                <h1>Social <span>Net</span></h1>
                <a href="painel.php">
                    <li>Home</li>
                </a>
                <a href="logout.php">
                    <li>LogOut</li>
                </a>
            </ul>
        </nav>
    </header>
</body>

<div>
    <form action="" method="POST">
        <input type="submit" value="Deletar conta" name="deletar">
    </form>
</div>

</html>