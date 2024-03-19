<?php
     require('connexion.php');

        // Compare le nom et le prénom de l'utilisateur puis renvoie les données de SESSION.
        /**
         * IndexFetch function
         *
         * @param [string] $name
         * @param [string] $lastname
         * @return void
         */
       function IndexFetch($name, $birthday){
        $db=connectBd();
        $sql=$db->prepare("SELECT * FROM sanios_utilisateur WHERE nom=:nom AND date_naissance=:datenaissance");
        $sql->bindParam(':nom',$name,PDO::PARAM_STR);
        $sql->bindParam(':datenaissance',$birthday,PDO::PARAM_STR);
        $sql->execute();
        $userData = $sql->fetch(PDO::FETCH_ASSOC);
        return $userData;
       }


?>