<?php
require('../model/gestionnaireModel.php');


/**
 * isset $_POST['tableauBord'] 
 * Permet l'affichage de tous les véhicules (initialise une variable pour première connexion)
 */
$idSociete = 0;
if (isset($_POST['tableauBord'])) { $idSociete = 0 ;}  

/**
 * isset $_POST['societeLabel'] 
 * Permet le tri des véhicules par sociétées. 
 */
if (isset($_POST['societeLabel'])) { $idSociete = getSocieteId($_POST['societeLabel']);}

/**
 * isset $_POST['deconnexion'] 
 * Permet l'accès à la fonction de déconnexion. 
 */
  if (isset($_POST['deconnexion'])) { disconnectSession();}
  

/** Appel à la fonction allSocietees() */
$societes = allSocietees();  



    //Navbar selection par Alias du Vehicule : $_POST['searchVehiculeByAlias'];
    if (isset($_POST['searchVehiculeByAlias'])) {
      if(!empty($_POST['searchVehiculeByAliasInput'])){

              
               $cleanAlias =  $_POST['searchVehiculeByAliasInput'];
               $cleanAlias = strtoupper($cleanAlias);
               $cleanAlias =trim($cleanAlias);
               $cleanAlias = htmlspecialchars($cleanAlias);
               if(count(getVehiculeByAlias($cleanAlias))!=0){
                  $retourVehicule = getVehiculeByAlias($cleanAlias);
               } 
      }
    }


/**
 * function getVehicules
 * Récupère tous les véhicules ou tous les noms de marque / modele / type 
 * @param [string] $param
 * @return array $tab
 * @return array $getVehicules
 */
function getVehicules($idSociete){
    if($idSociete != ''){
        $vehiculeBySociete = getVehiculeBySociete($idSociete);    
        return($vehiculeBySociete);
    }else{
        $getVehicules = getVehiculesFetch();
        return $getVehicules;
    }    
  }

  /**
   * getVehiculeLocation function
   * Compare l'id d'une société et celui d'un intervenant pour déterminer la position du véhicule.
   * @param [int] $idSociete
   * @param [int] $idVehicule
   * @return array
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
       return false;
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





/**
 * LocateSocieteVehicule function
 * Retourne le nom de la société ou se trouve le véhicule
 * @param [int] $fk_user_societe
 * @return string
 */
function LocateSocieteVehicule($fk_user_societe){
    $userSociete = locateSocieteVehiculeFetch($fk_user_societe);
    return $userSociete['societe_nom'];
  }


  function hygieneDataVehicule($nomhygiene,$idVehicule){
    $hygienenData = hygieneDataVehiculeFetch($nomhygiene,$idVehicule);
    return $hygienenData;
    }
  function entretienDataVehicule($nomEntretien,$idVehicule){
    $entretienData = entretienDataVehiculeFetch($nomEntretien,$idVehicule);
    return $entretienData;
    }
  

    function getSocieteId($societeNom){
        $returnSql = getSocieteIdFetch($societeNom);
        $societeInt = intval($returnSql['id_societe']);
        return $societeInt;
    }

    /**
     * warningEntretien function
     * Récupère un tableau de longeur 3. 
     * $tabAlerte[0] = les kilomètres du véhicule.
     * $tabAlerte[1] = la valeur du seuil de l'alerte.
     * $tabAlerte[2] = si != 0 alors un entretien à été effectué. 
     * retourne un string qui affiche un background coloré en fonction de l'alerte. 
     * @param [int] $idVehicule
     * @param [string] $alerte
     * @return string
     */
    function warningEntretien($idVehicule,$alerte){
        $tabAlerte = warningEntretienFetch($idVehicule,$alerte); 

  
        // Si l'alerte n'as pas été dépassée. 
        if ($tabAlerte[0]<$tabAlerte[1]){
            if ($tabAlerte[2] != 0 ){
              return "text-dark bg-lightGreen";
          }else{
              return "text-dark bg-lightYellow";
          }     
         } 
        // Si l'alerte à été dépassée.
        elseif ($tabAlerte[0]>= $tabAlerte[1]){
              if ($tabAlerte[2] != 0 ){
                return "text-dark bg-lightGreen";
            }else{
                return "text-dark bg-lightRed";
            }    
          } 

  }

    /**
     * getControleTechnique function
     * Récupère les dates relatives au controle technique et compare pour déclancher des alertes 
     * $warningDate[0] = booléen ou string relatif au background color relatif à l'alerte
     * $warningDate[1] = date du controle technique à venir
     * @param [int] $idVehicule
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

    /** Gestion du collapsePersonnel */

    //Initialisation pour récuperer tout le personnel. 
   /** Gestion du collapsePersonnel */

    //Initialisation pour récuperer tout le personnel. 
    $profil = 0;

    (isset($_SESSION['idSoc'])) ? $idSoc = $_SESSION['idSoc'] : $idSoc = 11;
    $personnels = getPersonnels($profil,$idSoc);
    //Navbar selection des personnel profil "roulant"
    if (isset($_POST['hygieneLabel'])) {
      $personnels = getPersonnels(1,$idSoc);
    }

    //Navbar selection des personnels profil "mecanicien"
    if (isset($_POST['mecanicienLabel'])) {
      $personnels = getPersonnels(2,$idSoc);
    }
        //Navbar selection des personnels profil "mecanicien"
        if (isset($_POST['reguleLabel'])) {
          $personnels = getPersonnels(3,$idSoc);
        }

    //Navbar selection tous le personnel
    if (isset($_POST['tableauBordPersonnel'])) {
      $personnels = getPersonnels(0,$idSoc);
      $idSocietePersonnel = 0 ;
    }

    if (isset($_POST['societeLabel'])) {
      $idSoc = getSocieteId($_POST['societeLabel']);
      $personnels = getPersonnelBySociete($idSoc);
      $_SESSION['idSoc'] = $idSoc;
    }

    


    //Navbar selection par NOM du personnel : $_POST['searchPersonnelByName'];
    if (isset($_POST['searchPersonnelByName'])) {
      if(!empty($_POST['searchPersonnelByNameInput'])){
               $cleanName =  cleanString($_POST['searchPersonnelByNameInput']);
               if(count(getPersonnelByNameFetch($cleanName))!=0){
                  $personnels = getPersonnelByNameFetch($cleanName);
               } else {
                $personnels = getPersonnels(0,$idSoc);
                $idSocietePersonnel = 0 ;
               }
       
      }
    }

    //NavBar selection du parsonnel par societe : $_POST['societeLabelPersonnel'];


    function getPersonnels($profil, $idSoc){
      $personnels = getPersonnelsFetch($profil,$idSoc);
      return $personnels;
    }
    function getNbrHygienes($idUser){
$lastMonth = date("m-d",strtotime("-1 month"));
      $nbrHygienes = getNbrHygienesFetch($idUser,$lastMonth);
      return $nbrHygienes;
    }

    
function getEntretienNbr($userId,$idEntretien){
  $lastMonth = date("m-d",strtotime("-1 month"));
  $nbrEntretien = getEntretienNbrFetch($userId,$idEntretien,$lastMonth);
  return $nbrEntretien;

}


    /**
 * Function cleanString
 * @param string $str
 * @param string $format
 * @return string $str
 */
function cleanString($str)
{
    $str = htmlspecialchars($str);
    $str = html_entity_decode(preg_replace('/&([a-zA-Z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);/i', '$1', htmlentities($str, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8');
    $str = trim(preg_replace('/[^A-Za-z]+/i', '-', $str), '-');
    $str =  mb_strtoupper($str);
    return $str;
}


/************************************************* */
    /*       CESSIONS :         */
/************************************************* */

function getVehiculesCession($param){
  $retour = getVehiculesCessionFetch($param);
  return $retour;
}

/************************************************* */
    /*       FORMULAIRES :         */
/************************************************* */

$modifierAll = getVehiculeInfosModify();
$marques = nameFetch('marque');

?>