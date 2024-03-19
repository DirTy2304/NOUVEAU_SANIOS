<?php

if ($_SESSION['fk_emploi'] == 3) {
    $redirectPath = 'reguleForm.php';
}
if ($_SESSION['fk_emploi'] == 4) {
    $redirectPath = 'gestionnaireForm.php';
}


/**
 * getVehiculeData function
 * Retourne toutes les data concenant un véhicule par rapport à son alias. 
 * @param [string] $alias
 * @return itterable
 */
  function getVehiculeData($alias){
    $bd = connectBd();
    $sql = $bd->prepare("SELECT * from sanios_vehicule
    JOIN sanios_societe on fk_societe = id_societe
    JOIN sanios_marque on fk_marque = id_marque
    JOIN sanios_modele on fk_modele = id_modele
    JOIN sanios_type on fk_type = id_type
    where ancien_id = :alias");
    $sql->bindParam('alias',$alias, PDO::PARAM_STR);
    $sql -> execute();
    $retourSql = $sql->fetch(PDO::FETCH_ASSOC);
    return $retourSql;
}

function getInventairePosition($alias){
    $bd = connectBd();
    $sql = $bd->prepare("SELECT fk_inventaire_position FROM sanios_vehicule WHERE ancien_id = :alias");
    $sql->bindParam('alias', $alias);
    $sql->execute();
    $returnSql = $sql->fetch(PDO::FETCH_ASSOC);
    return $returnSql;
}

/**
 * getSocieteById function
 *  Récupère toutes les informations d'une sociétée par son id
 * @param [int] $idSociete
 * @return array
 */
function getSocieteById($idSociete){
    $bd = connectBd();
    $sql = $bd->prepare("SELECT * FROM sanios_societe WHERE id_societe = :idSociete ");
    $sql->bindParam('idSociete', $idSociete, PDO::PARAM_INT);
    $sql->execute();
    $retournSql = $sql->fetch(PDO::FETCH_ASSOC);
    return $retournSql;
}

/**
 * getSocieteByName function
 * Retourne l'id de la sociétée par son nom
 * @param [string] $NomSociete
 * @return int
 */
function getSocieteByName($NomSociete){
    $bd = connectBd();
    $sql = $bd->prepare("SELECT `id_societe` from sanios_societe where societe_nom = :NomSociete ");
    $sql->bindParam('NomSociete', $NomSociete, PDO::PARAM_STR);
    $sql->execute();
    $retournSql = $sql->fetch(PDO::FETCH_ASSOC);
    return $retournSql;
}

/**
 * getMarqueByName function
 * Récupère l'id d'une marque par rapport à son nom
 * @param [string] $NomMarque
 * @return int
 */
function getMarqueByName($NomMarque){
    $bd = connectBd();
    $sql = $bd->prepare("SELECT id_marque FROM sanios_marque WHERE marque_nom = :NomMarque ");
    $sql->bindParam('NomMarque', $NomMarque, PDO::PARAM_STR);
    $sql->execute();
    $retournSql = $sql->fetch(PDO::FETCH_ASSOC);
    return $retournSql;
}

/**
 * getModeleByName function
 *  Récupère l'id d'un modele par rapport à son nom
 * @param [string] $NomModele
 * @return int
 */
function getModeleByName($NomModele){
    $bd = connectBd();
    $sql = $bd->prepare("SELECT id_modele FROM sanios_modele WHERE modele_nom = :NomModele ");
    $sql->bindParam('NomModele', $NomModele, PDO::PARAM_STR);
    $sql->execute();
    $retournSql = $sql->fetch(PDO::FETCH_ASSOC);
    return $retournSql;
}
/**
 * getTypeByName function
 * Récupère l'id d'un type par rapport à son nom
 * @param [string] $NomType
 * @return int
 */
function getTypeByName($NomType){
    $bd = connectBd();
    $sql = $bd->prepare("SELECT id_type FROM sanios_type WHERE type_nom = :NomType ");
    $sql->bindParam('NomType', $NomType, PDO::PARAM_STR);
    $sql->execute();
    $retournSql = $sql->fetch(PDO::FETCH_ASSOC);
    return $retournSql;
}

/**
 * getModelByMarque function
 * Récupère les modèles affiliés à une marque 
 * @param [string] $nomMarque
 * @return array
 */
function getModelByMarque($nomMarque){
    $bd = connectBd();
    $sql= $bd->prepare("SELECT modele_nom FROM `sanios_modele` join sanios_marque on fk_marque = id_marque where marque_nom = :nomMarque");
    $sql->bindParam('nomMarque', $nomMarque, PDO::PARAM_STR);
    $sql->execute();
    $retourSql = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $retourSql;
}

/**
 * getAliasDoublon function
 *  Vérifie les doublons d'ancien_id
 * @param [string] $alias
 * @return boolean
 */
function getAliasDoublon($alias){
    $bd = connectBd();
    $sql=$bd->prepare('SELECT ancien_id from sanios_vehicule where ancien_id = :alias ');
    $sql->bindParam('alias',$alias,PDO::PARAM_STR);
    $sql->execute();
    $retournSql = $sql->fetch(PDO::FETCH_ASSOC);
    if ($retournSql == false ) {
       return $alias;
    }else{
        return $retournSql;
    }
    
}

/**
 * updateVehicule function
 * Modification d'un véhicule
 * @param [string] $alias
 * @param [int] $societe
 * @param [int] $marque
 * @param [int] $modele
 * @param [int] $type
 * @param [string] $plaqueImmatriculation
 * @param [string] $inventairePosition
 * @param [string] $datemisecirculation
 * @param [bool] $cession
 * @return header
 */
function updateVehicule($Emploi, $alias, $societe, $marque, $modele, $type, $plaqueImmatriculation, $inventairePosition, $datemisecirculation, $cession){
    $bd = connectBd();
    $sql = $bd->prepare("UPDATE `sanios_vehicule` 
    SET `plaque` = :immatriculation , `fk_marque` = :idMarque, `fk_modele` = :idModele, `fk_type` = :idType, `fk_societe` = :idSociete, 
    `fk_inventaire_position` = :inventairePosition, `date_mise_circulation` = :dateMiseCirculation, `cession` = :cession 
    WHERE `ancien_id` = :alias");

    $sql->bindParam('alias',$alias);
    $sql->bindParam('idSociete',$societe);
    $sql->bindParam('immatriculation',$plaqueImmatriculation);
    $sql->bindParam('idMarque',$marque);
    $sql->bindParam('idModele',$modele);
    $sql->bindParam('idType',$type);
    $sql->bindParam('inventairePosition',$inventairePosition);
    $sql->bindParam('dateMiseCirculation',$datemisecirculation);     
    $sql->bindParam('cession',$cession);  
    
    $sql ->execute();
    return ($Emploi == 3) ? header('location:reguleForm.php') : header('location:gestionnaireForm.php');
}


/**
 * insertIntoVehicule function
 *  Insertion dans la bdd d'un véhicule
 * @param [int] $societe
 * @param [int] $marque
 * @param [int] $modele
 * @param [int] $type
 * @param [string] $immatriculation
 * @param [int] $inventaire
 * @param [string] $dateMiseCirculation
 * @param [string] $dateControleTechnique
 * @param [int] $kilometrage
 * @param [string] $alias
 * @return header
 */
function insertIntoVehicule($Emploi,$societe, $marque, $modele, $type,$immatriculation,$inventaire,$dateMiseCirculation,$dateControleTechnique, $kilometrage,$alias){
    $bd = connectBd();
    $sql = $bd->prepare("INSERT INTO `sanios_vehicule` 
    (`id_vehicule`,`plaque`, `fk_marque`, `fk_modele`, `fk_type`, `fk_societe`, `fk_inventaire_position`, `date_mise_circulation`, `date_controle_technique`, `kilometrage`, `cession`, `ancien_id`)
     VALUES  (NULL, :immatriculation, :marque, :modele, :typev, :societe, :inventaire,  :dateCirculation, :dateControleTechnique,  :kilometrage, '0', :alias);");

    $sql->bindParam('societe',$societe);
    $sql->bindParam('marque',$marque);
    $sql->bindParam('modele',$modele);
    $sql->bindParam('typev',$type);
    $sql->bindParam('immatriculation',$immatriculation);
    $sql->bindParam('inventaire',$inventaire);
    $sql->bindParam('dateCirculation',$dateMiseCirculation);
    $sql->bindParam('dateControleTechnique',$dateControleTechnique);
    $sql->bindParam('kilometrage',$kilometrage);
    $sql->bindParam('alias', $alias);

    $validate = ($sql ->execute()) ? true : false ;
    return $validate;

}

  ?>