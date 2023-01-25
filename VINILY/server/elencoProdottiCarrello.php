<?php 
    require("MySQLi.php");
    header('Content-Type: application/json; charset=utf-8'); 
    

    checkSession();

    $con = openConnection();

    $id_utente = $_SESSION['id_utente'];

    $sql = "SELECT prodotti.foto_prodotto, prodotti.nome_prodotto, prodotti.prezzo_prodotto, acquisti.id_ordine, acquisti.qta_acquisto FROM prodotti, acquisti, utenti 
    WHERE prodotti.id_prodotto = acquisti.id_prodotto 
    AND acquisti.id_utente = utenti.id_utente
    AND utenti.id_utente = $id_utente
    AND acquisti.carrello = 1";
    $rs = eseguiQuery($con, $sql);
    $json = json_encode($rs);
    http_response_code(200);
    echo($json);

    $con->close();
?>