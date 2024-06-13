<?php 
    include ('db.php');
    
    if(!isset($_SESSION)){
        session_start();
    }

    if (isset ($_POST['Postar'])){
        
        $id = $_SESSION['id'];
        $imagem = $_POST['file'];
        $texto = $_POST['texto'];

        echo "<p>feffeefeffe</p>";
        
        
            $query = "INSERT INTO pubs ('imagem', 'texto', 'usuario') VALUES ('$imagem', '$texto', '$id')";
            $banco -> query($query) or die ("falha na execução do codigo");    
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

    <div class="postagem">
        <form method="POST">
            <h2>Faça sua postagem: </h2>
            <textarea name="texto" id="post-text" placeholder="No que você está pensando?"></textarea>
            <div class="postagem-baixo">
                <label for="file-input">
                    <img src="./camera-regular-36.png" alt="">
                </label>
                <input type="file" name="file" id="file-input" hidden>
                <input type="submit" value="Postar">
            </div>
        </form>
    </div>
</body>

</html>