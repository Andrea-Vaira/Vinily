<?php
    /*COSTANTI PER ACCEDERE AL DB*/
    define("DBHOST", "localhost");  //costante su dove è localizzato il database
    define("DBUSER", "root");  //costante per gli utenti: root --> è quello amministratore
    define("DBPASS", "");  //costante per la pass dell'utente del DB
    define("DBNAME", "4b_vinili");  //costante nome del database

    define("SCADENZA", 86400); // definisco tempo della session ==> 600 s

    function openConnection(){
        //funzione che apre la connessione al DB
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $connection = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME); //vuole 4 define il costruttore di mysqli 
            $connection-> set_charset("utf8"); //Impostiamo il charset UTF8
			return $connection ;    
        } catch (Exception $ex) {
            http_response_code(503); // Errore di connessione al db
            die("<b>Errore di connessione al DB: </b>" . $ex->getMessage());
        }
        
    }

    function eseguiQuery($conn, $sql){
        try {
            $rs = $conn->query($sql);
            if(is_bool($rs)){
                $data = $rs;
            }
            else{
                //converto il recordset restituito dalla query in un vettore enumerativo di record
                $data = $rs->fetch_all(MYSQLI_ASSOC);
            }
            return $data;
        } catch (Exception $ex) {
            $conn->close();
            http_response_code(500);
            die("<b>Errore esecuzione query</b>".$ex->getMessage());
        }
    }

    function checkSession(){
        session_start();
        if(!isset($_SESSION['scadenza']) || time()>$_SESSION['scadenza']){
            session_unset();
            session_destroy();
            http_response_code(403); //sessione scaduta
            die("sessione scaduta");
        }
        else{
            //aggiorno la scadenza e rigenero il cookie
            $_SESSION['scadenza']=time()+SCADENZA;
            setcookie(session_name(), session_id(), time()+SCADENZA, "/");
        }
    }
?>