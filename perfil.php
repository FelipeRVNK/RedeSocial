<?php 
    include('protect-logout.php');
    include ('db.php');

    if(!isset($_SESSION)){
        session_start();
    }

    $id = $_SESSION['id'];
    $usuario = $_SESSION['usuario'];

    if(isset($_POST['Salvar'])){
        if(isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
            $img = $_FILES["file"]["name"];
            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/".$img);
            $query = "UPDATE `usuarios` SET `foto` = '$img' WHERE `usuarios`.`id` = '$id'";
            if ($banco->query($query) === TRUE) {
            } else {
                echo 'Falha na execução do código: ' . $banco->error;
            }
        } else {
            echo 'Erro no upload do arquivo.';
        }
    }
    if (isset ($_POST['deletar'])){

            $query = "DELETE FROM usuarios WHERE `usuarios`.`id` = '$id'";
            $banco->query($query) or die("falha na execução do código ao deletar usuário");
        
            header("Location: login.php");
        

    }

    if (isset ($_POST['deletar-pub'])){
        $idPublicacao = $_POST['idPublicacao'];
        $query = "DELETE FROM `pubs` WHERE `pubs`.`id` = '$idPublicacao'";
        $banco->query($query) or die("falha na execução do codigo");
    }
    
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/perfil.css">
    <link rel="stylesheet" href="./css/painel.css">
    <script src="rolagem.js"></script>
</head>

<body>
    <header>
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

                    <a class="logout" href="logout.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24">
                            <path d="m13 16 5-4-5-4v3H4v2h9z"></path>
                            <path
                                d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z">
                            </path>
                        </svg>
                    </a>
                </ul>
            </nav>
        </header>
    </header>
    <form method="POST" enctype="multipart/form-data">
        <div class="foto-perfil">
            <div class="imagem-perfil">
                <label for="file-input">
                    <?php
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
                    <div class="hover-icon">
                        <i class="fas fa-camera"></i>
                    </div>
                </label>
                <input type="file" name="file" id="file-input" hidden>
            </div>
            <?php
                echo '<h2>' . "@" . $usuario . '</h2>';
            ?>
            <input class="salvar_foto" type="submit" name="Salvar" value="Salvar">
        </div>
    </form>
    <div class="editar-excluir">
        <a href="editar-conta.php"><button class="editar">Editar conta</button></a>
        <form method="POST">
            <button class="excluir" type="submit" name="deletar">Deletar conta</button>
        </form>
    </div>

    <?php
        include ('db.php');       

        $busca = $banco->query("SELECT * FROM pubs WHERE usuario='$id' ORDER BY data DESC");
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
                     <div class="cima_apagar">
                        <p><a href="#"> @'.$nomeUsuario.'</a></p>
                        <form method="POST">
                            <input type="hidden" name="idPublicacao" value="'.$publicacao->id.'">
                            <button class="excluir-pub" type="submit" name="deletar-pub"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path><path d="M9 10h2v8H9zm4 0h2v8h-2z"></path></svg></button>
                        </form>
                    </div>
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
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="pub">
                    <div class="cima_apagar">
                        <p><a href="#"> @'.$nomeUsuario.'</a></p>
                        <form method="POST">
                            <input type="hidden" name="idPublicacao" value="'.$publicacao->id.'">
                            <button class="excluir-pub" type="submit" name="deletar-pub"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path><path d="M9 10h2v8H9zm4 0h2v8h-2z"></path></svg></button>
                        </form>
                    </div>
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