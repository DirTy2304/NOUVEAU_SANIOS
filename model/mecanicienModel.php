<?php
require('connexion.php');


function getDataVehicule($alias){

    $bd = connectBd();
    $sql = $bd->prepare("SELECT * FROM sanios_vehicule
    JOIN sanios_marque on fk_marque = id_marque
    JOIN sanios_modele ON fk_modele = id_modele
    WHERE plaque = :alias");
    $sql->bindParam('alias',$alias);
    $sql->execute();
    $retourSql = $sql->fetch(PDO::FETCH_ASSOC);
    return $retourSql; 
}

function getIdByAlias($alias){
    $bd = connectBd();
    $sql = $bd->prepare("SELECT id_vehicule FROM sanios_vehicule WHERE plaque = :alias ");
    $sql->bindParam('alias', $alias, PDO::PARAM_STR);
    $sql->execute();
    $retourSql = $sql->fetch(PDO::FETCH_ASSOC);
    return $retourSql;
}
function getSocieteVehiculeByAlias($alias){
    $bd = connectBd();
    $sql = $bd->prepare("SELECT fk_societe FROM sanios_vehicule WHERE plaque = :alias ");
    $sql->bindParam('alias', $alias, PDO::PARAM_STR);
    $sql->execute();
    $retourSql = $sql->fetch(PDO::FETCH_ASSOC);
    return $retourSql;
}


function  getTypeByName($typeEntretien){
   $bd = connectBd();
   $sql = $bd->prepare("SELECT `id_entretien_type` FROM `sanios_entretien_type` WHERE `nom` = :typeEntretien "); 
   $sql->bindParam('typeEntretien',$typeEntretien, PDO::PARAM_STR);
   $sql->execute();
   $retourSql = $sql->fetch(PDO::FETCH_ASSOC);
   return $retourSql;
}

function insertEntretien($vehiculeId , $user, $currentDate, $currentTime ,$VehiculeSociete,  $userSociete , $kms, $typeId, $remarque){
    $bd=connectBd();
    if (checkDoublonEntretien ($vehiculeId, $typeId) == false ){
    $sql = $bd->prepare("INSERT INTO sanios_entretien VALUES 
    (NULL, :vehiculeID, :userId, :currentDate , :currentTime , :userSociete, :vehiculeSociete , :kms , :idEntretien , :autre , '' )");   

 
}
    else{
        $sql = $bd->prepare(" UPDATE sanios_entretien SET 
        `fk_user` = :userId, `date` = :currentDate , `heure` = :currentTime , `fk_user_societe` = :userSociete, `fk_vehicule_societe` =  :vehiculeSociete , `fk_kms` = :kms , `autre`=:autre where fk_vehicule = :vehiculeID AND fk_type = :idEntretien ");
   

}
    $sql->bindParam('vehiculeID',$vehiculeId);
    $sql->bindParam('idEntretien',$typeId);
    $sql->bindParam('userId',$user);
    $sql->bindParam('currentDate',$currentDate);
    $sql->bindParam('currentTime',$currentTime);
    $sql->bindParam('userSociete',$userSociete);
    $sql->bindParam('vehiculeSociete',$VehiculeSociete);
    $sql->bindParam('kms',$kms);
    $sql->bindParam('autre',$remarque);
    $sql->execute();

}

function checkDoublonEntretien ($vehiculeId, $typeId){
    $bd = connectBd();
    $sql = $bd->prepare("SELECT * FROM `sanios_entretien` WHERE fk_vehicule = :vehiculeID and fk_type = :idEntretien ");
    $sql->bindParam('idEntretien',$typeId);
    $sql->bindParam('vehiculeID',$vehiculeId);
    $sql->execute();
    $retourSql = $sql->fetch();
    return $retourSql;
}


function getKms($alias){
    $bd = connectBd();
    $sql = $bd->prepare("SELECT `kilometrage` FROM `sanios_vehicule` WHERE `plaque` = :alias ");
    $sql->bindParam('alias',$alias);
    $sql->execute();
    $retourSql = $sql->fetch(PDO::FETCH_ASSOC);
    return $retourSql;
}


function  updateKms($idVehicule, $kms){
    $bd = connectBd();
    $sql = $bd->prepare("UPDATE `sanios_vehicule` SET `kilometrage` = :kms WHERE sanios_vehicule.id_vehicule = :idVehicule");
    $sql->bindParam('idVehicule',$idVehicule);
    $sql->BindParam('kms',$kms);
    $sql->execute();
}

?>