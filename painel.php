<?php 
    include ('db.php');

    if (!isset($_SESSION)) {
        session_start();
    }

    if(isset($_POST['Postar'])){
        $id = $_SESSION['id'];

        if($_FILES["file"]["error"] > 0){
            $texto = $_POST["texto"];
            
            if($texto == ""){
                echo "<h3> Escreva algo </h3>";
            }else{
                $query = "INSERT INTO pubs (usuario,texto) VALUES ('$id','$texto')";
                if ($banco->query($query) === TRUE) {
                    echo 'Postagem realizada com sucesso.';
                    header("Location: painel.php");
                    exit();
                }else {
                    echo 'Falha na execução do código: ' . $banco->error;
                }
            }
        }else{

            $img = $_FILES["file"]["name"];

            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/".$img);
            $texto = $_POST['texto'];

            if($texto == ""){
                echo "<h3> Escreva algo </h3>";
            }else{
                $query = "INSERT INTO pubs (imagem,texto,usuario) VALUES ('$img','$texto','$id')";
                if ($banco->query($query) === TRUE) {
                    echo 'Postagem realizada com sucesso.';
                    header("Location: painel.php");
                    exit();

                }else {
                    echo 'Falha na execução do código: ' . $banco->error;
                }
            }
        }
    }

    ?>

<!DOCTYPE html>
<html lang="pt-br">
    
    <head>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Net</title>
    <link rel="stylesheet" href="painel.css">
</head>

<body>
    <header class="container">
        <nav>
            <ul>
                <a href="perfil.php"><li>Perfil</li></a>
                <a href=""><li>Pesquisa</li></a>
                <h1>Social <span>Net</span></h1>
                <a href="painel.php"><li>Home</li></a>
                <a href="logout.php"><li>LogOut</li></a>
            </ul>
        </nav>
    </header>

    <div class="postagem">
        <form method="POST" enctype="multipart/form-data">
            <h2>Faça sua postagem: </h2>
            <textarea name="texto" id="post-text" placeholder="No que você está pensando?"></textarea>
            <div class="postagem-baixo">
                <label for="file-input">
                    <img src="./camera-regular-36.png" alt="">
                </label>
                <input type="file" name="file" id="file-input" hidden>
                <input type="submit" name="Postar" value="Postar">
            </div>
        </form>
    </div>
    <?php

        $busca = $banco->query("SELECT * FROM pubs ORDER BY data DESC");
        while($publicacao = $busca->fetch_object()){
            $idPublicacao = $publicacao->usuario;
            $buscaUsuario = $banco->query("SELECT usuario FROM usuarios WHERE id = '$idPublicacao'");
            $nomeUsuario = $buscaUsuario->fetch_object()->usuario;
            $curtidas = $banco->query("SELECT curtidas FROM pubs");
            if($publicacao->imagem == ""){
                echo '<div class="pub">
                    <p><a href="#"> @'.$nomeUsuario.'</a></p>
                    <span class = "span_pub"> '.$publicacao->texto.'</span>
                    <span class = "span_curtidas"> '.$publicacao->curtidas.'</span>
                    </div>';
            }else{
                echo '<div class="pub">
                    <p><a href="#"> @'.$nomeUsuario.'</a></p>
                    <span class = "span_pub"> '.$publicacao->texto.'</span>
                    <img src="upload/'.$publicacao->imagem.'" />
                    <span class = "span_curtidas"> '.$publicacao->curtidas.'</span>
                    </div>';
            }
        }
    ?>
</body>

</html>
