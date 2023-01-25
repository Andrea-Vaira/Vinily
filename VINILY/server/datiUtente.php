<?php 
    require("MySQLi.php");
    header('Content-Type: application/json; charset=utf-8'); 
    
    
    checkSession();
    $id_utente = $_SESSION['id_utente'];
    $con = openConnection();

    $sql = "SELECT * FROM utenti WHERE id_utente = $id_utente";
    $rs = eseguiQuery($con, $sql);
    $json = json_encode($rs);
    http_response_code(200);
    echo($json);

    $con->close();
?>