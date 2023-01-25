<?php 
    require("MySQLi.php");
    header('Content-Type: application/json; charset=utf-8'); 

    $categoria = $_REQUEST['categoria'];

    //checkSession();
    $con = openConnection();

    $sql = "SELECT prodotti.* FROM prodotti WHERE prodotti.genere_prodotto = $categoria";
    $rs = eseguiQuery($con, $sql);
    $json = json_encode($rs);
    http_response_code(200);
    echo($json);

    $con->close();
?>