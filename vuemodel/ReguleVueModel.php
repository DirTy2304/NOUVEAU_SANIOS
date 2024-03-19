<?php
require('../model/reguleModel.php');


 
/**
 * function getVehicules
 * Récupère tous les véhicules ou tous les noms de marque / modele / type 
 * @param [string] $param
 * @return array $tab
 * @return array $getVehicules
 */
function getVehicules($param){
    if($param != ''){
        $tab = nameFetch($param);
        return($tab);
    }else{
        $getVehicules = getVehiculesFetch();
        return $getVehicules;
    }    
  }


  /**
   * function getVehiculeLocation
   *
   * @param [int] $idSociete
   * @param [int] $idVehicule
   * @return string
   */
  function getVehiculeLocation($idSociete,$idVehicule){

    $ActualDate = date('Y-m-d');
    $dates = [];
    $location = searchLocation($idVehicule);

  
    foreach ($location as $locateDate) {
      array_push($dates, $locateDate['EHeure']);
      array_push($dates, $locateDate['HHeure']);
    }

     if(count($dates)>1){
      $lastEntry = findClosestDate($dates);
     }elseif(count($dates)==1){
      $lastEntry = $dates[0];
     } else{
      $lastEntry = $ActualDate;
     }
      if (isset($locateDate) && ($locateDate['HHeure'] == $lastEntry || $locateDate['EHeure'] == $lastEntry) ) {
        if ($locateDate['EUserSoc'] != $locateDate['fk_societe']  ) {
          $userSoc = LocateSocieteVehicule($locateDate['EUserSoc'] );
          return ["text-dark bg-warning",$userSoc];
        } elseif ( $locateDate['HUserSoc'] != $locateDate['fk_societe'] ){
          $userSoc = LocateSocieteVehicule($locateDate['HUserSoc'] );
          return ["text-dark bg-warning",$userSoc];
        } 
        
      }else{
       return '';
      }
    
  }
  

  function findClosestDate($array)
  {
    $result = "";
    for ($i=0; $i < count($array)-1 ; $i++) { 

        $DateFirst = $array[$i];
        $DateLast = $array[$i+1];

      if ($DateFirst > $DateLast ) {
        $result = $DateFirst;
      }else{
        $result = $DateLast;
      }
    }
    return $result;
}



  function LocateSocieteVehicule($fk_user_societe){
    $bd = connectBd();
    $userSocieteSql = $bd->prepare("SELECT societe_nom from sanios_societe where id_societe = :idSociete ");
    $userSocieteSql->bindParam('idSociete', $fk_user_societe, PDO::PARAM_INT);
    $userSocieteSql->execute();
    $userSociete=$userSocieteSql->fetch();
    return $userSociete['societe_nom'];
  }



  /**
   * function validateVehicule
   * @param int $vehicule
   * @param int $verif
   * @param string $type
   * @return string $resultEntretien
   */
  function validateVehicule($vehicule, $verif, $type){
    $bd = connectBd();
    $type_type = $type.'_type';
    $requettePrepare = " SELECT id_$type_type from sanios_$type 
    JOIN sanios_$type_type on sanios_$type.fk_type = id_$type_type
    WHERE fk_vehicule=?";
    $sqlEntretien = $bd->prepare($requettePrepare);
    $sqlEntretien->BindParam(1, $vehicule, PDO::PARAM_INT);
    $sqlEntretien->execute();
    $returnSql = $sqlEntretien->fetchAll(PDO::FETCH_ASSOC);
  
    $cpt = 0;
      foreach ($returnSql as $entretien) {
       for ($i=1; $i < 5 ; $i++) { 
         if (in_array($verif,$entretien)) {
          $cpt =+ 1;
         }
         }
      }
      if($cpt>0){
        $resultEntretien = "fa-solid fa-circle-check h2 text-success";
        return $resultEntretien;
        }else{
        $resultEntretien = "fa-solid fa-circle-xmark h2 text-danger";
        return $resultEntretien;
        }
  }

  function hygieneDataVehicule($nomHygiene,$idVehicule){
  $hygieneData = hygieneDataVehiculeFetch($nomHygiene,$idVehicule);
  return $hygieneData;
  }


  /**
   * function recuparitonVehicule
   * @param int idVehicule
   * @param string $type
   * @return array $retourAllInfos
   */
  function recuperationVehicule ($idVehicule){
    $db = connectBd();
   $selectAllInfos= $db->prepare(" SELECT sanios_hygiene_type.nom as hygiene_nom, sanios_hygiene.date, sanios_utilisateur.nom from sanios_hygiene_type
   LEFT JOIN sanios_hygiene on sanios_hygiene.fk_type = sanios_hygiene_type.id_hygiene_type
   LEFT JOIN sanios_vehicule on sanios_vehicule.id_vehicule = sanios_hygiene.fk_vehicule
   LEFT JOIN sanios_utilisateur on sanios_hygiene.fk_user = sanios_utilisateur.id_user
   WHERE id_vehicule = :idVehicule;");
  $selectAllInfos->bindParam('idVehicule', $idVehicule, PDO::PARAM_INT);
   $selectAllInfos->execute();
   $retourAllInfos = $selectAllInfos->fetchAll(PDO::FETCH_ASSOC);
   return $retourAllInfos;
  }
  
  /* Je sais plus ce que tu fait mais tu est hors function sooooo ..... 
  $bd = connectBd();
  $sql = "SELECT fk_vehicule, date, sht.nom, su.nom from sanios_hygiene as sh
  JOIN sanios_hygiene_type as sht on fk_type = id_hygiene_type
  JOIN sanios_utilisateur as su on id_user = fk_user";
  */
  
  function modelesByMarques(){
    $bd = connectBd();
    $sql = $bd->prepare("SELECT fk_marque, marque_nom, modele_nom FROM sanios_marque
    JOIN sanios_modele ON id_marque = fk_marque
    GROUP BY modele_nom
    ORDER BY marque_nom ASC
    ");
    $sql->execute();
    $sqlRetour = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $sqlRetour;
  }
  
  
// Gestion de la deconnexion de l'utilisateur. 

if (isset($_POST['deconnexion'])) {
    disconnectSession();
  }  


/****************************** VEHICULES DE LA REGULE *******************************/

/**
 * entretienDataVehicule function
 *  Retourne les 
 * @param [string] $nomEntretien
 * @param [int] $idVehicule
 * @return array
 */
function entretienDataVehicule($nomEntretien,$idVehicule){
  $entretienData = entretienDataVehiculeFetch($nomEntretien,$idVehicule);
  return $entretienData;
  }

  /**
   * getVehiculesByMarques function
   * Retourne les véhicules grâce à leurs marques
   * @param [string] $marqueDropdown
   * @param [int] $idSociete
   * @return array
   */
function getVehiculesByMarques($marqueDropdown,$idSociete){
  $vehiculesByMarque = getVehiculesByMarquesFetch($marqueDropdown,$idSociete);
   return $vehiculesByMarque;
}


$alias = getAllVehiculesByAlias($_SESSION['fk_societe']);
$getAllInfos = getVehiculeInfos($_SESSION['fk_societe']);
$marques = nameFetch('marque');


/**
 * getVehiculeByAlias function
 * Retourne un véhicule grâce à son alias
 * @param [string] $alias
 * @param [int] $idSociete
 * @return array
 */
function getVehiculeByAlias($alias, $idSociete){
  $vehiculeByAlias = getVehiculeByAliasFetch($alias,$idSociete);
  return $vehiculeByAlias;
}



      /**
     * warningEntretien function
     * Récupère un tableau de longeur 3. 
     * $tabAlerte[0] = les kilomètres du véhicule.
     * $tabAlerte[1] = la valeur du seuil de l'alerte.
     * $tabAlerte[2] = les kilomètres au dernier relevé (entretien)
     * retourne un string qui affiche un background coloré en fonction de l'alerte. 
     * @param [int] $idVehicule
     * @param [string] $alerte
     * @return string
     */
    function warningEntretien($idVehicule,$alerte){
      $tabAlerte = warningEntretienFetch($idVehicule,$alerte); 
      $initialKms = $tabAlerte[0];
      $seuil = $tabAlerte[1];
      $dernierKms = $tabAlerte[2];

      if (($alerte == "Pare brise" || $alerte == "Carrosserie") && $dernierKms != 0 ) {
        return "text-dark bg-lightGreen";
      }
      if(($dernierKms-$initialKms) < 0 || $dernierKms == 0  ){
        return "text-dark bg-lightYellow";
      }else{
        if (($dernierKms - $initialKms) >= $seuil ) {
          return "text-dark bg-lightRed";
        }else{
          return "text-dark bg-lightGreen";
        }
      }



}


  /**
   * getControleTechnique function
   * Récupère les dates relatives au controle technique et compare pour déclancher des alertes 
   * $warningDate[0] = booléen ou string relatif au background color relatif à l'alerte
   * $warningDate[1] = date du controle technique à venir
   * @param [int] $idVehicule
   * @param [int]
   * @return array
   */
  function getControleTechnique($idVehicule){
    $dateMiseCirculation = getDatesTechnique($idVehicule,'date_mise_circulation');
    $dateControleTechnique = getDatesTechnique($idVehicule,'date_controle_technique');
    $dateActuelle = date('Y-m-d');
    $dateActuelleTimestamp = strtotime($dateActuelle);
    // Date du jour + 15 Jours. 
    $dateActuellePlus = date('Y-m-d', strtotime('+ 15 days', $dateActuelleTimestamp ));
    $warningDate = [];

    // Existe t'il une date pour le controle technique 
    if ($dateControleTechnique['date_controle_technique'] == '2000-01-01' ) {

    // Calcul de la date du prochain controle technique ( date + 4 ans ).
    $dateDepart =  $dateMiseCirculation['date_mise_circulation'] ;
    $dateDepartTimestamp = strtotime($dateDepart);
    $dateFin  = date('Y-m-d', strtotime('+ 4 years', $dateDepartTimestamp ));

    //date de fin -15 jours
    $dateDepartLess = $dateFin;
    $dateDepartTimestampLess = strtotime($dateDepartLess);
    $dateFinLess  = date('Y-m-d', strtotime('-15 days', $dateDepartTimestampLess ));

    // date actuelle +15 est inferieur à la date du controle technique : success 
    if ($dateActuellePlus < $dateFin ) {
      array_push($warningDate, 'text-dark bg-lightOrange');
      array_push($warningDate, $dateFin);
      return $warningDate;
    }
    // date actuelle est comprise entre date du controle technique -15 jours et date du controle technique : danger 
    elseif ($dateFinLess < $dateActuelle && $dateActuelle < $dateFin) {
      array_push($warningDate, 'text-dark bg-danger');
      array_push($warningDate, $dateFin);
      return $warningDate;
    }else{
      array_push($warningDate, 'text-light bg-dark');
      array_push($warningDate, $dateFin);
      return $warningDate;
    } 
  }else {
    
    // Calcul de la date du prochain controle technique ( date + 2 ans ).
    $dateDepart =  $dateControleTechnique['date_controle_technique'] ;
    $dateDepartTimestamp = strtotime($dateDepart);
    $dateFin  = date('Y-m-d', strtotime('+ 2 years', $dateDepartTimestamp ));

    //date de fin -15 jours
    $dateDepartLess = $dateFin;
    $dateDepartTimestampLess = strtotime($dateDepartLess);
    $dateFinLess  = date('Y-m-d', strtotime('-15 days', $dateDepartTimestampLess ));

    // date actuelle +15 est inferieur à la date du controle technique : success 
    if ($dateActuellePlus < $dateFin ) {
      array_push($warningDate, false);
      array_push($warningDate, $dateFin);
      return $warningDate;
    }
    // date actuelle est comprise entre date du controle technique -15 jours et date du controle technique : danger 
    elseif ($dateFinLess < $dateActuelle && $dateActuelle < $dateFin) {
      array_push($warningDate, 'text-dark bg-danger');
      array_push($warningDate, $dateFin);
      return $warningDate;
    }else{
      array_push($warningDate, 'text-light bg-dark');
      array_push($warningDate, $dateFin);
      return $warningDate;
    }
  }

  }

?>
