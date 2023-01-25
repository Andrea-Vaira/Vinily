<?php 
    require("MySQLi.php");
    header('Content-Type: application/json; charset=utf-8'); 
    $con = openConnection();

    $id_prodotto = $_REQUEST['idProdotto'];

    checkSession();

    $id_utente = $_SESSION['id_utente'];
    
    //$cCorrentista = $_SESSION['cCorrentista'];
    $sql = "SELECT * FROM acquisti WHERE acquisti.id_utente = $id_utente AND acquisti.id_prodotto = $id_prodotto AND acquisti.carrello = 1";
    /*$sql = "INSERT INTO acquisti (id_prodotto, id_utente, carrello)
    VALUES ($id_prodotto, $id_utente, 1);";*/
    $rs = eseguiQuery($con, $sql);
    if(count($rs) == 0){
        $sql = "INSERT INTO acquisti (id_prodotto, id_utente, carrello, qta_acquisto)
        VALUES ($id_prodotto, $id_utente, 1, 1);";
        $rs = eseguiQuery($con, $sql);
        if($rs){
            http_response_code(200);
            echo('{"ris":"ok"}');
        }
        else{
            http_response_code(500);
            echo('Errore inserimento record');
        }
    }
    else{
        $id_ordine = $rs[0]["id_ordine"];
        $sql = "UPDATE acquisti SET qta_acquisto = qta_acquisto + 1  WHERE id_ordine = $id_ordine;";
        $rs = eseguiQuery($con, $sql);
        if($rs){
            http_response_code(200);
            echo('{"ris":"ok"}');
        }
        else{
            http_response_code(500);
            echo('Errore inserimento record');
        }
    }

    $con->close();
?>