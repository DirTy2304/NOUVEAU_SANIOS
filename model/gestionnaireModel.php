<?php
require('connexion.php');



/****************************************************************************************************************************************/
/****************************************************************************************************************************************/
/****************************************************************************************************************************************/
/********************************************************** VOIR TOUS LES VEHICULES *****************************************************/
/****************************************************************************************************************************************/
/****************************************************************************************************************************************/
/****************************************************************************************************************************************/




/**
 * getVehiculesFetch function
 * Retourne  un tableau d'informations sur les véhicules de toutes les sociétées.
 * @return itterable
 */
function getVehiculesFetch()
{
  $bd = connectBd();
  $getVehiculesSql = $bd->prepare("SELECT * FROM sanios_vehicule as sv
    JOIN sanios_societe as ss on sv.fk_societe = ss.id_societe
    JOIN sanios_marque as sm on sv.fk_marque = sm.id_marque
    JOIN sanios_type as st on sv.fk_type = st.id_type
    JOIN sanios_modele as smo on sv.fk_modele = smo.id_modele
    where cession = 0
    ");
  $getVehiculesSql->execute();
  $getVehicules = $getVehiculesSql->fetchAll(PDO::FETCH_ASSOC);
  return $getVehicules;
}

/**
 * getVehiculeBySociete function
 * Retourne un tableau d'informations sur les véhicules d'une societée.
 * @param [int] $idSociete
 * @return itterable
 */
function getVehiculeBySociete($idSociete)
{
  $bd = connectBd();
  $getVehiculesSql = $bd->prepare("SELECT * from sanios_vehicule
    JOIN sanios_societe on fk_societe = id_societe
    JOIN sanios_marque on fk_marque = id_marque
    WHERE fk_societe = :idSociete and  cession = 0
    ");
  $getVehiculesSql->BindParam('idSociete', $idSociete, PDO::PARAM_INT);
  $getVehiculesSql->execute();
  $getVehiculesSociete = $getVehiculesSql->fetchAll(PDO::FETCH_ASSOC);
  return $getVehiculesSociete;
}

/**
 * getVehiculeByAlias function
 * Retourne un véhicule en fonction de son Alias
 * @param [string] $userName
 * @return array
 */
function getVehiculeByAlias($aliasVehicule)
{
  $bd = connectBd();
  $sql = $bd->prepare("SELECT * from sanios_vehicule
      JOIN sanios_societe on fk_societe = id_societe
      JOIN sanios_marque on fk_marque = id_marque
      where ancien_id = :alias ");
  $sql->bindParam('alias', $aliasVehicule, PDO::PARAM_STR);
  $sql->execute();
  $retourSql = $sql->fetchAll(PDO::FETCH_ASSOC);
  return $retourSql;
}




/**
 * searchLocation function
 *
 * @param [int] $idVehicule
 * @return string
 */
function searchLocation($idVehicule)
{
  $bd = connectBd();
  $sql = $bd->prepare("SELECT se.heure as EHeure,
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


/**
 * hygieneDataVehiculeFetch function
 * Retourne les informations relative à un véhicule par rapport à un type d'hygiène
 * @param [string] $nomHygiene
 * @param [int] $idVehicule
 * @return itterable
 */
function hygieneDataVehiculeFetch($nomHygiene, $idVehicule)
{
  $bd = connectBd();
  $sql = $bd->prepare("SELECT fk_vehicule, date,  sanios_utilisateur.nom FROM sanios_hygiene_type
    LEFT JOIN sanios_hygiene on id_hygiene_type = fk_type
    JOIN sanios_utilisateur on fk_user = id_user
    where sanios_hygiene_type.nom=:nomHygiene AND fk_vehicule = :idVehicule");
  $sql->BindParam('nomHygiene', $nomHygiene, PDO::PARAM_STR);
  $sql->BindParam('idVehicule', $idVehicule, PDO::PARAM_INT);
  $sql->execute();
  $retourSql = $sql->fetch(PDO::FETCH_ASSOC);
  return $retourSql;
}


/**
 * entretienDataVehiculeFetch function
 *Retourne les informations relative à un véhicule par rapport à un type d'entretien
 * @param [string] $nomEntretien
 * @param [int] $idVehicule
 * @return itterable
 */
function entretienDataVehiculeFetch($nomEntretien, $idVehicule)
{
  $bd = connectBd();
  $sql = $bd->prepare("SELECT fk_vehicule, date, heure, sanios_utilisateur.nom,fk_kms,autre FROM sanios_entretien_type
    LEFT JOIN sanios_entretien on id_entretien_type = fk_type
    JOIN sanios_utilisateur on fk_user = id_user
    where sanios_entretien_type.nom=:nomEntretien AND fk_vehicule = :idVehicule");
  $sql->BindParam('nomEntretien', $nomEntretien, PDO::PARAM_STR);
  $sql->BindParam('idVehicule', $idVehicule, PDO::PARAM_INT);
  $sql->execute();
  $retourSql = $sql->fetch(PDO::FETCH_ASSOC);
  return $retourSql;
}

/**
 * allSocietees function
 * Retourne toutes les sociétées. 
 * @return itterable
 */
function allSocietees()
{
  $db = connectBd();
  $sql = $db->prepare("SELECT * FROM sanios_societe");
  $sql->execute();
  $sqlReturn = $sql->fetchAll(PDO::FETCH_ASSOC);
  return $sqlReturn;
}

/**
 * locateSocieteVehiculeFetch function
 * Retourne le nom d'une société par rapport à son id.
 * @param [int] $fk_user_societe
 * @return itterable
 */
function locateSocieteVehiculeFetch($fk_user_societe)
{
  $bd = connectBd();
  $userSocieteSql = $bd->prepare("SELECT societe_nom from sanios_societe where id_societe = :idSociete ");
  $userSocieteSql->bindParam('idSociete', $fk_user_societe, PDO::PARAM_INT);
  $userSocieteSql->execute();
  $userSociete = $userSocieteSql->fetch();
  return $userSociete;
}
/**
 * getSocieteIdFetch function
 * Retourne l'id d'une sociétée par rapport à son nom.
 * @param [int] $getSocieteIdFetch
 * @return itterable
 */
function getSocieteIdFetch($societeNom)
{
  $bd = connectBd();
  $sql = $bd->prepare("SELECT id_societe FROM sanios_societe where societe_nom = :societeNom");
  $sql->bindParam('societeNom', $societeNom, PDO::PARAM_STR);
  $sql->execute();
  $returnSql = $sql->fetch(PDO::FETCH_ASSOC);
  return $returnSql;
}
/**
 * nbrKms function
 * Récupère les kilomètres d'un véhicule
 * @param [int] $idVehicule
 * @return int
 */
function nbrKms($idVehicule)
{
  $bd = connectBd();
  $sql = $bd->prepare("SELECT kilometrage from sanios_vehicule WHERE id_vehicule = :idVehicule");
  $sql->bindParam('idVehicule', $idVehicule, PDO::PARAM_INT);
  $sql->execute();
  $returnSql = $sql->fetch(PDO::FETCH_ASSOC);
  return $returnSql;
}

/**
 * warningEntretienFetch function
 * Retourne un tableau de trois éléments avec en premier : le nombre de kms du véhicule
 * en second : le nombre de kilomètres pour l'alerte
 * en troisième : un count des entretients effectués pour le nom de l'alerte et l'id du véhicule.
 * @param [int] $idVehicule
 * @param [string] $alerte
 * @return array
 */
function warningEntretienFetch($idVehicule, $alerte)
{
  $bd = connectBd();
  $tabAlerte = [];

  $sqlKms = $bd->prepare("SELECT kilometrage FROM sanios_vehicule WHERE id_vehicule = :idVehicule");
  $sqlKms->bindValue('idVehicule', $idVehicule, PDO::PARAM_INT);
  $sqlKms->execute();
  $returnKms = $sqlKms->fetch(PDO::FETCH_ASSOC);

  $sqlAlerte = $bd->prepare("SELECT alerte FROM sanios_entretien_type
      WHERE nom = :alerte");
  $sqlAlerte->bindParam('alerte', $alerte, PDO::PARAM_STR);
  $sqlAlerte->execute();
  $returnAlerte = $sqlAlerte->fetch(PDO::FETCH_ASSOC);

  $sqlEntretien = $bd->prepare("SELECT count(date) from sanios_entretien
      JOIN sanios_entretien_type on fk_type = id_entretien_type
      where nom = :alerte
      and fk_vehicule = :idVehicule");
  $sqlEntretien->bindValue('alerte', $alerte);
  $sqlEntretien->bindValue('idVehicule', $idVehicule);
  $sqlEntretien->execute();
  $count = $sqlEntretien->fetchAll();


  array_push($tabAlerte, $returnKms['kilometrage']);
  array_push($tabAlerte, $returnAlerte['alerte']);
  array_push($tabAlerte, $count[0]['count(date)']);

  return $tabAlerte;
}

function getDatesTechnique($idVehicule, $date)
{
  $bd = connectBd();
  $sql = $bd->prepare("SELECT $date FROM sanios_vehicule
      WHERE id_vehicule = :idVehicule ");
  $sql->bindValue('idVehicule', $idVehicule, PDO::PARAM_INT);
  $sql->execute();
  $returnSql = $sql->fetch(PDO::FETCH_ASSOC);
  return $returnSql;
}

/** Requettes Personnel */

function getPersonnelsFetch($profil, $idSoc)
{
  $db = connectBd();
  switch ($profil) {
    case 0:
      $sql = $db->prepare("SELECT id_user,nom,prenom,date_naissance,societe_nom,emploi_nom from sanios_utilisateur 
          JOIN sanios_societe on fk_societe = id_societe
          JOIN sanios_emploi on fk_emploi = id_emploi
          where (fk_emploi = 1 or fk_emploi = 2  or fk_emploi = 3) and fk_societe = :idSoc
          ");
      $sql->bindParam('idSoc', $idSoc);
      $sql->execute();
      $returnSql = $sql->fetchAll(PDO::FETCH_ASSOC);
      return $returnSql;
      break;

    case 1:
      $sql = $db->prepare("SELECT id_user,nom,prenom,date_naissance,societe_nom,emploi_nom from sanios_utilisateur 
          JOIN sanios_societe on fk_societe = id_societe
          JOIN sanios_emploi on fk_emploi = id_emploi
          where fk_emploi = 1 and fk_societe = :idSoc
          ");

      $sql->bindParam('idSoc', $idSoc);
      $sql->execute();
      $returnSql = $sql->fetchAll(PDO::FETCH_ASSOC);
      return $returnSql;
      break;

    case 2:
      $sql = $db->prepare("SELECT id_user,nom,prenom,date_naissance,societe_nom,emploi_nom from sanios_utilisateur 
          JOIN sanios_societe on fk_societe = id_societe
          JOIN sanios_emploi on fk_emploi = id_emploi
          where fk_emploi = 2 and fk_societe = :idSoc
          ");

      $sql->bindParam('idSoc', $idSoc);
      $sql->execute();
      $returnSql = $sql->fetchAll(PDO::FETCH_ASSOC);
      return $returnSql;
      break;

    case 3:
      $sql = $db->prepare("SELECT id_user,nom,prenom,date_naissance,societe_nom,emploi_nom from sanios_utilisateur 
            JOIN sanios_societe on fk_societe = id_societe
            JOIN sanios_emploi on fk_emploi = id_emploi
            where fk_emploi = 3 and fk_societe = :idSoc
          ");
      $sql->bindParam('idSoc', $idSoc);
      $sql->execute();
      $returnSql = $sql->fetchAll(PDO::FETCH_ASSOC);
      return $returnSql;
      break;
  }
}
function getPersonnelBySociete($societeName)
{
  $bd = connectBd();
  $sql = $bd->prepare("SELECT id_user,nom,prenom,date_naissance,societe_nom,emploi_nom from sanios_utilisateur 
    JOIN sanios_societe on fk_societe = id_societe
    JOIN sanios_emploi on fk_emploi = id_emploi
    where( fk_emploi = 1 or fk_emploi = 2  or fk_emploi = 3 ) AND id_societe = :socName ");
  $sql->bindParam('socName', $societeName, PDO::PARAM_STR);
  $sql->execute();
  $retourSql = $sql->fetchAll(PDO::FETCH_ASSOC);
  return $retourSql;
}

/**
 * getPersonnelByNameFetch function
 *
 * @param [string] $userName
 * @return array
 */
function getPersonnelByNameFetch($userName)
{
  $bd = connectBd();
  $sql = $bd->prepare("SELECT id_user,nom,prenom,date_naissance,societe_nom,emploi_nom from sanios_utilisateur 
    JOIN sanios_societe on fk_societe = id_societe
    JOIN sanios_emploi on fk_emploi = id_emploi
    where nom = :userName ");
  $sql->bindParam('userName', $userName, PDO::PARAM_STR);
  $sql->execute();
  $retourSql = $sql->fetchAll(PDO::FETCH_ASSOC);
  return $retourSql;
}



function getNbrHygienesFetch($idUser, $date)
{
  $bd = connectBd();
  $sql = $bd->prepare("SELECT id_user, count(fk_user) from sanios_utilisateur
      left join sanios_hygiene on fk_user = id_user
      where fk_emploi = 1 and id_user = :idUser AND MONTH(date) = :dateMonth
      group by id_user");
  $sql->bindParam('idUser', $idUser, PDO::PARAM_INT);
  $sql->bindParam('dateMonth', $date);
  $sql->execute();
  $returnSql = $sql->fetch();
  return $returnSql;
}

function getEntretienNbrFetch($userId, $idEntretien, $lastMonth)
{
  $bd = connectBd();
  $sql = $bd->prepare("SELECT id_user, count(id_mecanique) from sanios_utilisateur
       left join sanios_entretien on fk_user = id_user
      where fk_emploi = 2 and id_user = :idUser AND MONTH(date) = :dateMonth AND fk_type = :typeEntretien
      group by id_user");
  $sql->bindParam('idUser', $userId, PDO::PARAM_INT);
  $sql->bindParam('dateMonth', $lastMonth);
  $sql->bindParam('typeEntretien', $idEntretien);
  $sql->execute();
  $returnSql = $sql->fetch();
  return $returnSql;
}


/* *********************************************** */
/* *********************************************** */
/* *********************************************** */
/* *********************************************** */
/* ***************** FORMULAIRES : *************** */
/* *********************************************** */
/* *********************************************** */
/* *********************************************** */
/* *********************************************** */
/* *********************************************** */

/** A long terme elle doit remplacer la selection par alias  */
function getVehiculeInfosModify()
{
  $bd = connectBd();
  $sql = $bd->prepare("SELECT ancien_id, marque_nom, modele_nom, societe_nom from sanios_vehicule
  JOIN sanios_marque on fk_marque = id_marque
  JOIN sanios_modele on fk_modele = id_modele
  JOIN sanios_societe on fk_societe = id_societe
  ORDER BY `sanios_vehicule`.`fk_societe` ASC");
  $sql->execute();
  $returnSql = $sql->fetchAll(PDO::FETCH_ASSOC);
  return $returnSql;
}



/**
 * nameFetch function
 * Retourne une requette qui récupère tous les noms de marque / modele / type
 * @param [string] $param_nom : concaténation pour reconstituer la requette
 * @param [string] $param : "marque" OU "modele" OU "type"
 * @return itterable
 */
function nameFetch($param)
{
  $bd = connectBd();
  $param_nom = $param . "_nom";
  $getParamSql = $bd->prepare("SELECT $param_nom from sanios_$param ");
  $getParamSql->execute();
  $getParam = $getParamSql->fetchAll(PDO::FETCH_ASSOC);
  return $getParam;
}


/************************************************* */
/*       CESSIONS :         */
/************************************************* */

function getVehiculesCessionFetch($param)
{
  $bd = connectBd();
  if ($param == '') {
    $sql = $bd->prepare("SELECT * FROM sanios_vehicule as sv
    JOIN sanios_societe as ss on sv.fk_societe = ss.id_societe
    JOIN sanios_marque as sm on sv.fk_marque = sm.id_marque
    JOIN sanios_type as st on sv.fk_type = st.id_type
    JOIN sanios_modele as smo on sv.fk_modele = smo.id_modele
    where cession = 1;
    ");
  } else {
    $sql = $bd->prepare("SELECT * FROM sanios_vehicule as sv
    JOIN sanios_societe as ss on sv.fk_societe = ss.id_societe
    JOIN sanios_marque as sm on sv.fk_marque = sm.id_marque
    JOIN sanios_type as st on sv.fk_type = st.id_type
    JOIN sanios_modele as smo on sv.fk_modele = smo.id_modele
    where cession = 1 and sanios_vehicule.fk_societe = :idsociete ;
    ");
    $sql->bindParam('idSociete', $param);
  }

  $sql->execute();
  $retourSql = $sql->fetchAll(PDO::FETCH_ASSOC);
  return $retourSql;
}
