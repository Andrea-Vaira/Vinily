<?php 
    require("MySQLi.php");
    header('Content-Type: application/json; charset=utf-8'); 

    //checkSession();

    $con = openConnection();

    //$id_utente = $_SESSION['id_utente'];
    $email = $_REQUEST['email'];
    $phone = $_REQUEST['phone'];
    $pwd = md5($_REQUEST['pwd']) ;
    
    //$cCorrentista = $_SESSION['cCorrentista'];

    $sql = "UPDATE utenti
    SET password_utente = '$pwd'
    WHERE phone_utente = '$phone' AND email_utente = '$email';";
    $rs = eseguiQuery($con, $sql);
    if($rs){
        http_response_code(200);
        echo(json_encode(array('pwd' => $pwd)) );
    }
    else{
        http_response_code(500);
        echo('Errore inserimento record');
    }

    $con->close();
?>