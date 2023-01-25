<?php 
    require("MySQLi.php");
    header('Content-Type: application/json; charset=utf-8'); 
    $con = openConnection();

    //checkSession();

    
    //$cCorrentista = $_SESSION['cCorrentista'];

    $sql = "SELECT * FROM prodotti";
    $rs = eseguiQuery($con, $sql);
    $json = json_encode($rs);
    http_response_code(200);
    echo($json);

    $con->close();
?>