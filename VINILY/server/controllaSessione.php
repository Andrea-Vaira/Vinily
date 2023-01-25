<?php 
    require("MySQLi.php");
    header('Content-Type: application/json; charset=utf-8'); 

    //checkSession();

    $con = openConnection();

    try {
        $id_utente = $_SESSION['id_utente'];
    } catch (\Throwable $th) {
        throw $th;
    }


    $sql = "SELECT * FROM utenti WHERE id_utente = $id_utente";
    $rs = eseguiQuery($con, $sql);
    if(count($rs) == 0){
        http_response_code(200);
        echo('{"ris":"login"}');
    }
    else if(count($rs) != 0){
        http_response_code(200);
        echo('{"ris":"logout"}');
    }
    $con->close();
?>