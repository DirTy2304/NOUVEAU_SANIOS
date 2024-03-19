<?php
//Création des variables
/*
//connexion localhost
define ("SERVEUR", "localhost");
 define ("USER","root");
 define ("MDP","");
 define ("BD", "sanios");
*/
//connexion server
define ("SERVEUR", "localhost");
define ("USER","root");
define ("MDP","");
define ("BD", "dbs6406676");


   function connectBd(){
    try {
        $db = new PDO('mysql:host='.SERVEUR.';dbname='.BD,USER,MDP);
        $db->exec("SET CHARACTER SET utf8");
    }
    catch (Exception $e)
    {
        $bd ='Erreur : ' .$e->getMessage().'<br />';
        $bd = 'N° : ' .$e->getCode() ;
    }
    return $db;
    }
   

    function disconnectSession(){
        $_SESSION = array();
        session_destroy();
        header('location: ../index.php');
    }

?>

