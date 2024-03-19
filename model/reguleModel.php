<?php
require('connexion.php');

/**
 * nameFetch function
 * Retourne une requette qui récupère tous les noms de marque / modele / type
 * @param [string] $param_nom : concaténation pour reconstituer la requette
 * @param [string] $param : "marque" OU "modele" OU "type"
 * @return void
 */
function nameFetch($param){
  $bd = connectBd();
  $param_nom = $param.'_nom';
  $getParamSql = $bd->prepare("SELECT $param_nom from sanios_$param ");
  $getParamSql->execute();
  $getParam = $getParamSql->fetchAll(PDO::FETCH_ASSOC);
  $tab = [];
        foreach ($getParam as $parametre) {
            foreach ($parametre as $key => $value) {
                  array_push($tab,$value);
            }
          }   return $tab;
}

/**
 * getVehiculesFetch function
 * Retourne la liste de tous les véhicules appartenants à la societée.
 * @return void
 */
function getVehiculesFetch(){
  $bd = connectBd();
  $getVehiculesSql = $bd->prepare("SELECT * FROM sanios_vehicule as sv
  JOIN sanios_societe as ss on sv.fk_societe = ss.id_societe
  JOIN sanios_marque as sm on sv.fk_marque = sm.id_marque
  JOIN sanios_type as st on sv.fk_type = st.id_type
  JOIN sanios_modele as smo on sv.fk_modele = smo.id_modele
  where id_societe = :idSociete ");
  $getVehiculesSql->bindParam(':idSociete',$_SESSION['fk_societe'],PDO::PARAM_INT);
  $getVehiculesSql->execute();
  $getVehicules = $getVehiculesSql->fetchAll(PDO::FETCH_ASSOC);
  return $getVehicules;
}


function searchLocation($idVehicule){
  $bd = connectBd();
  $sql = $bd->prepare("SELECT se.heure as EHeure ,
   sh.heure as HHeure,
    se.fk_user_societe as EUserSoc,
     se.fk_user_societe as HUserSoc,
      sv.fk_societe FROM sanios_entretien as se
  LEFT JOIN sanios_vehicule as sv on se.fk_vehicule =id_vehicule
  LEFT JOIN sanios_hygiene as sh on sh.fk_vehicule = id_vehicule
  WHERE sv.id_vehicule = :idvehicule");
    $sql->bindParam('idvehicule', $idVehicule, PDO::PARAM_INT);
    $sql->execute();
    $retourSql = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $retourSql;
}


function hygieneDataVehiculeFetch($nomHygiene,$idVehicule){
$bd = connectBd(); 
$sql = $bd->prepare("  SELECT fk_vehicule, date, sanios_utilisateur.nom FROM sanios_hygiene_type
LEFT JOIN sanios_hygiene on id_hygiene_type = fk_type
JOIN sanios_utilisateur on fk_user = id_user
where sanios_hygiene_type.nom=:nomHygiene AND fk_vehicule = :idVehicule");
$sql->BindParam('nomHygiene',$nomHygiene,PDO::PARAM_STR);
$sql->BindParam('idVehicule',$idVehicule,PDO::PARAM_INT);
$sql->execute();
$retourSql = $sql->fetch(PDO::FETCH_ASSOC);
return $retourSql;
}

/**********************************************VEHICULES**************************************/


/**  Navbar véhicules  **/

/**
 * getVehiculesByMarquesFetch function
 * Retourne les véhicules par marque
 * @param [string] $marqueDropdown
 * @param [int] $idSociete
 * @return array
 */
function getVehiculesByMarquesFetch($marqueDropdown,$idSociete){
  $bd = connectBd();
  $sql = $bd->prepare("SELECT * FROM sanios_vehicule as sv
  JOIN sanios_societe as ss on sv.fk_societe = ss.id_societe
  JOIN sanios_marque as sm on sv.fk_marque = sm.id_marque
  JOIN sanios_type as st on sv.fk_type = st.id_type
  JOIN sanios_modele as smo on sv.fk_modele = smo.id_modele
  where marque_nom = :marqueDropdown and id_societe = :idSociete ");
  $sql->bindParam('marqueDropdown', $marqueDropdown, PDO::PARAM_STR);
  $sql->bindParam('idSociete', $idSociete, PDO::PARAM_INT);
  $sql->execute();
  $sqlReturn = $sql->fetchAll(PDO::FETCH_ASSOC);
  return $sqlReturn;
}

/**
 * getAllVehiculesByAlias function
 * Retourne la liste des alias des véhicules afféctés à la societée. 
 * @param [int] $idSociete
 * @return array
 */
function getAllVehiculesByAlias($idSociete){
  $bd = connectBd();
  $sql = $bd->prepare("SELECT ancien_id 
    FROM sanios_vehicule 
    WHERE fk_societe = :idSociete ");
  $sql->bindParam('idSociete',$idSociete,PDO::PARAM_INT);
  $sql->execute();
  $returnSql = $sql->fetchAll(PDO::FETCH_ASSOC);
  return $returnSql;
}

/**
 * getVehiculeByAliasFetch function
 * Retourne un véhicule grâce à son alias
 * @param [string] $alias
 * @param [int] $idSociete
 * @return array
 */
function getVehiculeByAliasFetch($alias,$idSociete){
  $bd = connectBd();
  $sql = $bd->prepare("SELECT * FROM sanios_vehicule as sv
  JOIN sanios_societe as ss on sv.fk_societe = ss.id_societe
  JOIN sanios_marque as sm on sv.fk_marque = sm.id_marque
  JOIN sanios_type as st on sv.fk_type = st.id_type
  JOIN sanios_modele as smo on sv.fk_modele = smo.id_modele
  where ancien_id = :alias and id_societe = :idSociete");
  $sql->bindParam('alias', $alias, PDO::PARAM_STR);
  $sql->bindParam('idSociete', $idSociete, PDO::PARAM_INT);
  $sql->execute();
  $sqlReturn = $sql->fetchAll(PDO::FETCH_ASSOC);
  return $sqlReturn;
}


function getVehiculeInfos($idSociete){
  $bd = connectBd();
  $sql = $bd->prepare("SELECT * FROM sanios_vehicule as sv
  JOIN sanios_societe as ss on sv.fk_societe = ss.id_societe
  JOIN sanios_marque as sm on sv.fk_marque = sm.id_marque
  JOIN sanios_type as st on sv.fk_type = st.id_type
  JOIN sanios_modele as smo on sv.fk_modele = smo.id_modele
  where  id_societe = :idSociete
  ORDER BY ancien_id ASC");
  $sql->bindParam('idSociete', $idSociete, PDO::PARAM_INT);
  $sql->execute();
  $sqlReturn = $sql->fetchAll(PDO::FETCH_ASSOC);
  return $sqlReturn;
}
    /**
     * entretienDataVehiculeFetch function
     *Retourne les informations relative à un véhicule par rapport à un type d'entretien
     * @param [string] $nomEntretien
     * @param [int] $idVehicule
     * @return itterable
     */
    function entretienDataVehiculeFetch($nomEntretien,$idVehicule){
      $bd = connectBd(); 
      $sql = $bd->prepare("SELECT fk_vehicule, date, heure, sanios_utilisateur.nom,fk_kms,autre FROM sanios_entretien_type
      LEFT JOIN sanios_entretien on id_entretien_type = fk_type
      JOIN sanios_utilisateur on fk_user = id_user
      where sanios_entretien_type.nom=:nomEntretien AND fk_vehicule = :idVehicule");
      $sql->BindParam('nomEntretien',$nomEntretien,PDO::PARAM_STR);
      $sql->BindParam('idVehicule',$idVehicule,PDO::PARAM_INT);
      $sql->execute();
      $retourSql = $sql->fetch(PDO::FETCH_ASSOC);
      return $retourSql;
      }
  
      function getDatesTechnique($idVehicule, $date){
        $bd = connectBd();
        $sql = $bd->prepare("SELECT $date FROM sanios_vehicule
        WHERE id_vehicule = :idVehicule");
        $sql->bindValue('idVehicule', $idVehicule, PDO::PARAM_INT);
        $sql->execute();
        $returnSql = $sql->fetch(PDO::FETCH_ASSOC);
        return $returnSql;
      }


    /**
     * warningEntretienFetch function
     * Retourne un tableau de trois éléments avec en premier : le nombre de kms du véhicule
     * en second : le nombre de kilomètres pour l'alerte
     * en troisième :le dernier relevé des kilomètres sur le véhicule lors de l'entretien.
     * @param [int] $idVehicule
     * @param [string] $alerte
     * @return array
     */
    function warningEntretienFetch($idVehicule, $alerte){
      $bd = connectBd();
      $tabAlerte = []; 
      
      $sqlKms = $bd->prepare("SELECT kilometrage FROM sanios_vehicule WHERE id_vehicule = :idVehicule");
      $sqlKms->bindValue('idVehicule',$idVehicule,PDO::PARAM_INT);
      $sqlKms->execute();
      $returnKms = $sqlKms->fetch(PDO::FETCH_ASSOC);
  
      $sqlAlerte = $bd->prepare("SELECT alerte FROM sanios_entretien_type
      WHERE nom = :alerte");
      $sqlAlerte->bindParam('alerte', $alerte, PDO::PARAM_STR);
      $sqlAlerte->execute();
      $returnAlerte = $sqlAlerte->fetch(PDO::FETCH_ASSOC);

      $sqlEntretien = $bd->prepare("SELECT fk_kms from sanios_entretien
      JOIN sanios_entretien_type on fk_type = id_entretien_type
      where nom = :alerte
      and fk_vehicule = :idVehicule");
      $sqlEntretien->bindValue('alerte',$alerte);
      $sqlEntretien->bindValue('idVehicule',$idVehicule);
      $sqlEntretien->execute();
      $count = $sqlEntretien->fetch();
      

      array_push($tabAlerte,$returnKms['kilometrage']);
      array_push($tabAlerte,$returnAlerte['alerte']);
      ($count != false) ? array_push($tabAlerte,$count['fk_kms']) : array_push($tabAlerte,0);


      return $tabAlerte;

    }
?>
