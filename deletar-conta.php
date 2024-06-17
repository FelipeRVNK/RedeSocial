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