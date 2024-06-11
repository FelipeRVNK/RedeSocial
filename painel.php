<?php 
    if(!isset($_SESSION)){
        session_start();
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
                <a href=""><li>Perfil</li></a>
                <a href=""><li>Pesquisa</li></a>
                <h1>Social <span>Net</span></h1>
                <a href=""><li>Home</li></a>
                <a href="logout.php"><li>LogOut</li></a>
            </ul>
        </nav>
    </header>
    
    <div class="postagem">
        <h2>Faça sua postagem: </h2>
        <input type="file" name="" id="">
        <input type="text" name="" id="" placeholder="O que você está pensando hoje?">
        <input type="submit" value="Enviar">
    </div>
</body>
</html>