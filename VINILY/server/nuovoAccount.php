<?php 
    require("MySQLi.php");
    header('Content-Type: application/json; charset=utf-8'); 
    $con = openConnection();

    $username = $_REQUEST['username'];
    $mail = $_REQUEST['email'];
    $pwd = $_REQUEST['password'];

    $pwd = md5($pwd);
    //checkSession();

    //$id_utente = $_SESSION['id_utente'];
    
    $sql = "INSERT INTO utenti (nome_utente, email_utente, password_utente)
        VALUES ('$username', '$mail', '$pwd');";
    $rs = eseguiQuery($con, $sql);
    if($rs){
        http_response_code(200);
        echo('{"ris":"ok"}');
    }
    else{
        http_response_code(500);
        echo('Errore creazione account');
    }
    $con->close();
?>