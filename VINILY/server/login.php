<?php 
    require("MySQLi.php");
    header('Content-Type: application/json; charset=utf-8'); 
    $user = $_REQUEST['email'];
    $pwd = $_REQUEST['password'];

    $con = openConnection();
    
    //il controllo del WHERE è caseUnsensitive quindi non posso controllare la password
    $sql = "SELECT * FROM utenti WHERE utenti.email_utente = '$user'";
    $rs = eseguiQuery($con, $sql);

    if(count($rs)==0){
        $con->close();
        http_response_code(401);
        die("username non valido");
    }
    else{
        // il controllo fatto da codice è case sensitive
        if(md5($pwd) == $rs[0]["password_utente"]){
            // settaggio variabile session
            session_start();
            $_SESSION["id_utente"] = $rs[0]["id_utente"];
            $_SESSION["scadenza"] = time()+SCADENZA;
            setcookie(session_name(), session_id(), time()+SCADENZA, "/");

            $nome = $rs[0]["nome_utente"];
            $str = array("nome" => $rs[0]["nome_utente"]);
            $json = json_encode($str);
            http_response_code(200);
            echo($json);
        
            $con->close();
        }
        else{
            $con->close();
            http_response_code(401);
            die("password non valida");
        }
        
    }
    
?>