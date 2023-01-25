<?php 
    require("MySQLi.php");
    header('Content-Type: application/json; charset=utf-8'); 
    $con = openConnection();

    $nome_prodotto = $_REQUEST['nome'];
    $autore_prodotto = $_REQUEST['autore'];
    $prezzo_prodotto = $_REQUEST['prezzo'];
    $foto_prodotto = $_REQUEST['foto'];
    $genere_prodotto = $_REQUEST['genere'];

    checkSession();

    $sql = "INSERT INTO prodotti (nome_prodotto, foto_prodotto, prezzo_prodotto, autore_prodotto, genere_prodotto)
        VALUES ('$nome_prodotto', '$foto_prodotto', $prezzo_prodotto, '$autore_prodotto', $genere_prodotto);";
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