<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/protect.css">
</head>

<body>

    <?php 

    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['id'])){
        die("<div class = 'protect'><h1><div class = 'span'> - ERROR - </div>Você não pode acessar esta página porque não está logado.</h1> <h2 class = 'botao-logar'><a href=\"login.php\">Logar</a></h2></div>");
    }

?>
</body>

</html>