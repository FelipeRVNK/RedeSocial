<?php
    include('db.php'); 
    
    if(isset($_GET['query'])) {
        $query = $_GET['query'];
        $min_length = 3; 
        
        if(strlen($query) >= $min_length){
            $raw_results = $banco->query("SELECT * FROM usuarios WHERE usuario LIKE '%".$query."%'");
            
            if($raw_results->num_rows > 0){
                echo "<h2>Resultados da Pesquisa:</h2>";
                while($results = $raw_results->fetch_assoc()){
                    echo '<div>
                            <h3><a href="profile.php?id='.$results["id"].'">'.$results["usuario"].'</a></h3>
                        </div>';
                }
            } else {
                echo "<p>Nenhum resultado encontrado.</p>";
            }
        } else {
            echo "<p>A consulta deve ter pelo menos ".$min_length." caracteres.</p>";
        }
    }
?>
