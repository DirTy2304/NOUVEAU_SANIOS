<?php
require('../model/connexion.php');


function getDataVehicule($immatriculation){
    $bd = connectBd();
    $sql = $bd->prepare("SELECT * from sanios_vehicule JOIN sanios_marque on fk_marque = id_marque 
    JOIN sanios_societe ON fk_societe = id_societe where plaque = :immat ");
    $sql->bindParam('immat',$immatriculation);
    $sql->execute();
    $retourSql = $sql->fetch(PDO::FETCH_ASSOC);
    return $retourSql;
}

function fetchLastHygiene($vehiculeId){
    $bd = connectBd();
    $sql = $bd->prepare("SELECT date, sanios_hygiene_type.nom as hygieneNom, sanios_utilisateur.nom as userName FROM `sanios_hygiene`
    JOIN sanios_hygiene_type ON fk_type = id_hygiene_type
    JOIN sanios_utilisateur on fk_user = id_user
    WHERE ( date between date_sub(now(),INTERVAL 5 WEEK) and now() )
     AND fk_vehicule = :idVehicule");
    $sql->bindParam('idVehicule',$vehiculeId);
    $sql->execute();
    $retourSql = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $retourSql;
}


?>