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

    if(isset($_POST['repostar'])){
        $id = $_SESSION['id'];
        $texto = $_POST['texto'];
        $imagem = isset($_POST['imagem']) ? $_POST['imagem'] : "";
    
        if($imagem == ""){
            $query = "INSERT INTO pubs (usuario, texto) VALUES ('$id', '$texto')";
        } else {
            $query = "INSERT INTO pubs (usuario, texto, imagem) VALUES ('$id', '$texto', '$imagem')";
        }
    
        if ($banco->query($query) === TRUE) {
            echo 'Postagem realizada com sucesso.';
            header("Location: painel.php");
            exit();
        } else {
            echo 'Falha na execução do código: ' . $banco->error;
        }
    }

    if(isset($_GET["like"])){
        like();
    }

    function like(){
        include ('db.php');
        $id = $_SESSION['id'];
        $pubId = $_GET['like'];
        
        $query = "INSERT INTO `curtidas` (`id`, `id_usuario`, `publicacao`) VALUES (NULL, '$id', '$pubId')";
        $banco->query($query) or die("falha na execução do codigo");
 
    }

    if(isset($_GET["dislike"])){
        dislike();
    }

    function dislike(){
        include ('db.php');
        $id = $_SESSION['id'];
        $pubId = $_GET['dislike'];
        
        $query = "DELETE FROM curtidas WHERE `curtidas`.`id_usuario` ='$id' AND `publicacao`='$pubId'";
        $banco->query($query) or die("falha na execução do codigo");
        
    }

    ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Net</title>
    <link rel="stylesheet" href="./css/painel.css">
    <script src="rolagem.js"></script>
</head>

<body>
    <header class="container">
        <nav>
            <ul>
                <a href="painel.php">
                    <li>
                        <h1>Social <span>Net</span></h1>
                    </li>
                </a>
                <li>
                    <form class="form_search" method="GET" action="pesquisar.php">
                        <label for="search" class="label_search">
                            <input class="input_search" type="text" required="" placeholder="Pesquise no SocialNet"
                                id="search" name="query">
                            <div class="fancy-bg"></div>
                            <div class="search">
                                <svg viewBox="0 0 24 24" aria-hidden="true"
                                    class="r-14j79pv r-4qtqp9 r-yyyyoo r-1xvli5t r-dnmrzs r-4wgw6l r-f727ji r-bnwqim r-1plcrui r-lrvibr">
                                    <g>
                                        <path
                                            d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z">
                                        </path>
                                    </g>
                                </svg>
                            </div>
                            <button class="close-btn" type="reset">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </label>
                    </form>
                </li>
                <a href="perfil.php">
                    <div class="imagem-perfil-botao">
                        <?php
                            $id = $_SESSION['id'];
                            $busca = $banco->query("SELECT foto FROM usuarios WHERE id='$id'");
                            if ($busca) {
                                $publicacao = $busca->fetch_object();
                                if ($publicacao && isset($publicacao->foto)) {
                                    echo '<img src="upload/'.$publicacao->foto.'" />';
                                } else {
                                    echo 'Foto não encontrada.';
                                }
                            } else {
                                echo 'Erro na consulta: ' . $banco->error;
                            }
                            ?>
                    </div>
                </a>
            </ul>
        </nav>
    </header>

    <div class="postagem">
        <form method="POST" enctype="multipart/form-data" class="postagem_form">
            <h2>Faça sua postagem: </h2>
            <textarea name="texto" id="post-text" placeholder="No que você está pensando?"></textarea>
            <div class="postagem-baixo">
                <label for="file-input">
                    <img src="./img/camera-regular-36.png" alt="">
                </label>
                <input type="file" name="file" id="file-input" hidden>
                <input class="postar" type="submit" name="Postar" value="Postar">
            </div>
        </form>
    </div>

    <?php
        include ('db.php');

        $busca = $banco->query("SELECT * FROM pubs ORDER BY data DESC");
        while ($publicacao = $busca->fetch_object()) {
            $id = $_SESSION['id'];
            $idPublicacao = $publicacao->usuario;
            $buscaUsuario = $banco->query("SELECT usuario FROM usuarios WHERE id = '$idPublicacao'");
            $nomeUsuario = $buscaUsuario->fetch_object()->usuario;
            $idBuscaPub = $publicacao->id;
            $buscaCurtidas = $banco->query("SELECT * FROM curtidas WHERE publicacao='$idBuscaPub'"); 
            $curtidas = mysqli_num_rows($buscaCurtidas);

            if ($publicacao->imagem == "") {
                echo '<div class="pub">
                    <p><a href="perfilpesq.php?id=' . $idPublicacao . '">@' . $nomeUsuario . '</a></p>
                    <span class="span_pub">' . $publicacao->texto . '</span>
                    <div class="pub_interacao">';
                    $validacao_idUsuario = $banco->query("SELECT id_usuario FROM curtidas WHERE publicacao='$idBuscaPub' AND id_usuario='$id'");
                    $fazer_validacao_idUsuario = mysqli_num_rows($validacao_idUsuario);
                    if($fazer_validacao_idUsuario >= 1){
                        echo'<p class="like"><a href="painel.php?dislike='.$idBuscaPub.'">
                        <svg id="Glyph" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M29.845,17.099l-2.489,8.725C26.989,27.105,25.804,28,24.473,28H11c-0.553,0-1-0.448-1-1V13
                            c0-0.215,0.069-0.425,0.198-0.597l5.392-7.24C16.188,4.414,17.05,4,17.974,4C19.643,4,21,5.357,21,7.026V12h5.002
                            c1.265,0,2.427,0.579,3.188,1.589C29.954,14.601,30.192,15.88,29.845,17.099z"></path>
                            <path d="M7,12H3c-0.553,0-1,0.448-1,1v14c0,0.552,0.447,1,1,1h4c0.553,0,1-0.448,1-1V13C8,12.448,7.553,12,7,12z M5,25.5
                            c-0.828,0-1.5-0.672-1.5-1.5c0-0.828,0.672-1.5,1.5-1.5c0.828,0,1.5,0.672,1.5,1.5C6.5,24.828,5.828,25.5,5,25.5z"></path>
                        </svg></a></p>';
                    } else {
                        echo'<p class="like"><a href="painel.php?like='.$idBuscaPub.'">
                        <svg id="Glyph" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M29.845,17.099l-2.489,8.725C26.989,27.105,25.804,28,24.473,28H11c-0.553,0-1-0.448-1-1V13
                            c0-0.215,0.069-0.425,0.198-0.597l5.392-7.24C16.188,4.414,17.05,4,17.974,4C19.643,4,21,5.357,21,7.026V12h5.002
                            c1.265,0,2.427,0.579,3.188,1.589C29.954,14.601,30.192,15.88,29.845,17.099z"></path>
                            <path d="M7,12H3c-0.553,0-1,0.448-1,1v14c0,0.552,0.447,1,1,1h4c0.553,0,1-0.448,1-1V13C8,12.448,7.553,12,7,12z M5,25.5
                            c-0.828,0-1.5-0.672-1.5-1.5c0-0.828,0.672-1.5,1.5-1.5c0.828,0,1.5,0.672,1.5,1.5C6.5,24.828,5.828,25.5,5,25.5z"></path>
                        </svg></a></p>';
                    }
                    echo'<div><span class="num-like">'.$curtidas.'</span></div>';
                    echo'<div>
                        <form method="POST">
                        <input type="hidden" name="texto" value="' . htmlspecialchars($publicacao->texto, ENT_QUOTES, 'UTF-8') . '">
                        <input type="hidden" name="imagem" value="' . htmlspecialchars($publicacao->imagem, ENT_QUOTES, 'UTF-8') . '">
                        <button class="repostar-pub" type="submit" name="repostar"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" style="fill: rgba(102, 102, 102, 1);transform: ;msFilter:;"><path d="M11 7.05V4a1 1 0 0 0-1-1 1 1 0 0 0-.7.29l-7 7a1 1 0 0 0 0 1.42l7 7A1 1 0 0 0 11 18v-3.1h.85a10.89 10.89 0 0 1 8.36 3.72 1 1 0 0 0 1.11.35A1 1 0 0 0 22 18c0-9.12-8.08-10.68-11-10.95zm.85 5.83a14.74 14.74 0 0 0-2 .13A1 1 0 0 0 9 14v1.59L4.42 11 9 6.41V8a1 1 0 0 0 1 1c.91 0 8.11.2 9.67 6.43a13.07 13.07 0 0 0-7.82-2.55z"></path></svg></button>
                        </form>
                    </div>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="pub">
                    <p><a href="perfilpesq.php?id=' . $idPublicacao . '">@' . $nomeUsuario . '</a></p>
                    <span class="span_pub">' . $publicacao->texto . '</span>
                    <img src="upload/' . $publicacao->imagem . '" />
                    <div class="pub_interacao">';
                $validacao_idUsuario = $banco->query("SELECT id_usuario FROM curtidas WHERE publicacao='$idBuscaPub' AND id_usuario='$id'");
                $fazer_validacao_idUsuario = mysqli_num_rows($validacao_idUsuario);
                if($fazer_validacao_idUsuario >= 1){
                    echo'<p class="like"><a href="painel.php?dislike='.$idBuscaPub.'">
                    <svg id="Glyph" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <path d="M29.845,17.099l-2.489,8.725C26.989,27.105,25.804,28,24.473,28H11c-0.553,0-1-0.448-1-1V13
                        c0-0.215,0.069-0.425,0.198-0.597l5.392-7.24C16.188,4.414,17.05,4,17.974,4C19.643,4,21,5.357,21,7.026V12h5.002
                        c1.265,0,2.427,0.579,3.188,1.589C29.954,14.601,30.192,15.88,29.845,17.099z"></path>
                        <path d="M7,12H3c-0.553,0-1,0.448-1,1v14c0,0.552,0.447,1,1,1h4c0.553,0,1-0.448,1-1V13C8,12.448,7.553,12,7,12z M5,25.5
                        c-0.828,0-1.5-0.672-1.5-1.5c0-0.828,0.672-1.5,1.5-1.5c0.828,0,1.5,0.672,1.5,1.5C6.5,24.828,5.828,25.5,5,25.5z"></path>
                    </svg></a></p>';
                } else {
                    echo'<p class="like"><a href="painel.php?like='.$idBuscaPub.'">
                    <svg id="Glyph" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <path d="M29.845,17.099l-2.489,8.725C26.989,27.105,25.804,28,24.473,28H11c-0.553,0-1-0.448-1-1V13
                        c0-0.215,0.069-0.425,0.198-0.597l5.392-7.24C16.188,4.414,17.05,4,17.974,4C19.643,4,21,5.357,21,7.026V12h5.002
                        c1.265,0,2.427,0.579,3.188,1.589C29.954,14.601,30.192,15.88,29.845,17.099z"></path>
                        <path d="M7,12H3c-0.553,0-1,0.448-1,1v14c0,0.552,0.447,1,1,1h4c0.553,0,1-0.448,1-1V13C8,12.448,7.553,12,7,12z M5,25.5
                        c-0.828,0-1.5-0.672-1.5-1.5c0-0.828,0.672-1.5,1.5-1.5c0.828,0,1.5,0.672,1.5,1.5C6.5,24.828,5.828,25.5,5,25.5z"></path>
                    </svg></a></p>';
                }
                echo'<div><span class="num-like">'.$curtidas.'</span></div>';
                echo'<div>
                        <form method="POST">
                        <input type="hidden" name="texto" value="' . htmlspecialchars($publicacao->texto, ENT_QUOTES, 'UTF-8') . '">
                        <input type="hidden" name="imagem" value="' . htmlspecialchars($publicacao->imagem, ENT_QUOTES, 'UTF-8') . '">
                        <button class="repostar-pub" type="submit" name="repostar"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" style="fill: rgba(102, 102, 102, 1);transform: ;msFilter:;"><path d="M11 7.05V4a1 1 0 0 0-1-1 1 1 0 0 0-.7.29l-7 7a1 1 0 0 0 0 1.42l7 7A1 1 0 0 0 11 18v-3.1h.85a10.89 10.89 0 0 1 8.36 3.72 1 1 0 0 0 1.11.35A1 1 0 0 0 22 18c0-9.12-8.08-10.68-11-10.95zm.85 5.83a14.74 14.74 0 0 0-2 .13A1 1 0 0 0 9 14v1.59L4.42 11 9 6.41V8a1 1 0 0 0 1 1c.91 0 8.11.2 9.67 6.43a13.07 13.07 0 0 0-7.82-2.55z"></path></svg></button>
                        </form>
                    </div>';
                echo '</div>';
                echo '</div>';
            }
        }
    ?>

    <footer>
        <p>&copy; Social<span>Net</span> | Todos os direitos reservados.</p>
    </footer>
    <button id="scrollToTopBtn">&#8593; Topo</button>
</body>

</html>