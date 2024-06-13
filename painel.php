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
    <title>e</title>
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
        <form action="" method="post" enctype="multipart/form-data">
            <h2>Faça sua postagem: </h2>
            <textarea name="texto" id="post-text" placeholder="No que você está pensando?"></textarea>
            <div class="postagem-baixo">
                <label for="file-input">
                    <img src="./camera-regular-36.png" alt="">
                </label>
                <input type="submit" value="Enviar">
                <input type="file" name="file" id="file-input" hidden>
            </div>
        </form>
    </div>
</body>
</html>