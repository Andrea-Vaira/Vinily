<?php 
    require("MySQLi.php");
    header('Content-Type: application/json; charset=utf-8'); 

    checkSession();

    $con = openConnection();

    $id_utente = $_SESSION['id_utente'];
    $indirizzo = $_REQUEST['indirizzo'];
    
    //$cCorrentista = $_SESSION['cCorrentista'];

    $sql = "UPDATE utenti
    SET indirizzo_utente = '$indirizzo'
    WHERE id_utente = $id_utente;";
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