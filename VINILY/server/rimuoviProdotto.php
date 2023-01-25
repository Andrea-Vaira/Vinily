<?php 
    require("MySQLi.php");
    header('Content-Type: application/json; charset=utf-8'); 
    

    $id_ordine = $_REQUEST['idOrdine'];

    checkSession();

    $con = openConnection();

    //$id_utente = $_SESSION['id_utente'];
    
    //$cCorrentista = $_SESSION['cCorrentista'];

    $sql = "DELETE FROM acquisti WHERE id_ordine = $id_ordine;";
    $rs = eseguiQuery($con, $sql);
    if($rs){
        http_response_code(200);
        echo('{"ris":"ok"}');
    }
    else{
        http_response_code(500);
        echo('Errore inserimento record');
    }

    $con->close();
?>