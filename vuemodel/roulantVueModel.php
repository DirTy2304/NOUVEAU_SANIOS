<?php
ob_start();

require __DIR__.'/../model/roulantModel.php';

setlocale(LC_TIME, 'fr_FR');
date_default_timezone_set('Europe/Paris');
$dateDuJour = date('Y-m-d');
// Gestion de la deconnexion de l'utilisateur. 

if (isset($_POST['deconnexion'])) {
    disconnectSession();
  }  


/** Récupération de l'Alias du véhicule */
if (isset($_SESSION['aliasQr'])) {
    $alias = $_SESSION['aliasQr'];
}else{
    header('location: ../index.php');
}

if (isset($_POST['roulantHygienes'])) {
   header('location: ../vue/roulantHygienes.php');
}

// if (isset($_POST['roulantMateriel'])) {
//     header("location: ../vue/roulantMateriel.php?type=$datasVehicule['fk_type']");
// }

if (isset($_POST['statutRoulant'])) {
   if ($_POST['statutRoulant'] == "debut") {
       // début de l'intervention
   }else{
       // statutRoulant == "fin"
   }
}

/*** FONCTIONS DE roulantHygienes.php  */

// Récupération des données du véhicule via son alias. 
$datasVehicule = dataVehiculeFetch($alias);

if (isset($_POST["sendHygiene"])) {
  
// création d'une hygiène : 
 $vehicule = $datasVehicule['id_vehicule'];
 $dateDuJour = date('Y-m-d');
 $fkUser = $_SESSION['id_user'];
 $fkUserSociete = $_SESSION['fk_societe'];
 $fkVehiculeSociete = $datasVehicule['fk_societe'];
 $type = typeHygieneFetch($_POST["typeHygiene"]);
 

 createHygiene($vehicule,$fkUser,$dateDuJour,$fkUserSociete,$fkVehiculeSociete,$type['id_hygiene_type']);

  // Retour sur l'acceuil du profil roulant
  //  unset($accueil);
   // header('location: roulant.php');
}


/*** FONCTIONS DE roulantMateriel.php  */

// Fonctions relatives aux ambulances ambulance : 
    $ambuMaterielName = dataNameAmbuInventaire();
    function getInventaireAmbuRelai($idProduit, $vehicule){ 
        $inventaireAmbuVehicule = getInventaireAmbu($idProduit, $vehicule);
         if($inventaireAmbuVehicule[0]){
            return $inventaireAmbuVehicule; 
        }else{
         return '';
          }
        }
// Fonctions relatives aux ambulances assu : 
    $assuMaterielName = dataNameAssuInventaire();

    // Récupère un tableau avec en tab[0] - le nombre de produit actuels en tab[1] la date de péremption du produit
     function getInventaireAssuRelai($idProduit, $vehicule){ 
        $inventaireAssuVehicule = getInventaireAssu($idProduit, $vehicule);
        if(empty($inventaireAssuVehicule[0])){
            return '';
        }else{
         return $inventaireAssuVehicule;  
          }
        }
        

// Fonctions relatives au vsl :

$vslMaterielName = dataNameVslInventaire();

// Récupère un tableau avec en tab[0] - le nombre de produit actuels en tab[1] la date de péremption du produit
 function getInventaireVslRelai($idProduit, $vehicule){ 
    $inventaireVslVehicule = getInventaireVsl($idProduit, $vehicule);
    if(empty($inventaireVslVehicule[0])){
        return '';
    }else{
     return $inventaireVslVehicule;  
      }
    }

$SocieteCurrentUser = $_SESSION['fk_societe'];
$names =  roulantNameFetch($SocieteCurrentUser);

//Alerte materiel 


// VALIDATE INVENTORY : 
function startsWith ($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}


if (isset($_POST['validateInventoryAmbu'])) {

    $vehicule = $datasVehicule['id_vehicule'];
    $fkUser = $_SESSION['id_user'];
    // Récupérer la liste des inventaire et les ranger correctement dans un tableau. 
    $data = [];
    for ($i=0; $i<count($_POST)-1; $i++){
        $temporaire = [];
       
        if (!empty($_POST[$i.'P'])) {
            $keyBinding = $i.'P';
            $temporaire[$keyBinding] =  $_POST[$i.'P'];
          
           
        }
        if (!empty($_POST[$i.'NewD'])) {
            $keyBinding = $i.'D';
            $temporaire[$keyBinding] =  $_POST[$i.'NewD'];
            
        }else{
            if (!empty($_POST[$i.'D'])) {
            $keyBinding = $i.'D';
            $temporaire[$keyBinding] =  $_POST[$i.'D'];
            }
        }

    (array_filter($temporaire)) ? array_push($data,$temporaire) : "" ;
  
    } 
        $dateActuelle = date('Y-m-d');
        $collaborateur = getIdUser($_POST['collaborateurAssu']);

        updateEntretien($data,$vehicule,$dateActuelle, $fkUser,$collaborateur['id_user'],'assu');

}



if (isset($_POST['validateInventoryAssu'])) {
   
    $vehicule = $datasVehicule['id_vehicule'];
    $fkUser = $_SESSION['id_user'];
    // Récupérer la liste des inventaire et les ranger correctement dans un tableau. 
    $data = [];
    for ($i=0; $i<count($_POST)-1; $i++){
        $temporaire = [];
       
        if (!empty($_POST[$i.'P'])) {
            $keyBinding = $i.'P';
            $temporaire[$keyBinding] =  $_POST[$i.'P'];
          
           
        }
        if (!empty($_POST[$i.'NewD'])) {
            $keyBinding = $i.'D';
            $temporaire[$keyBinding] =  $_POST[$i.'NewD'];
            
        }else{
            if (!empty($_POST[$i.'D'])) {
            $keyBinding = $i.'D';
            $temporaire[$keyBinding] =  $_POST[$i.'D'];
            }
        }

    (array_filter($temporaire)) ? array_push($data,$temporaire) : "" ;
  
    } 
        $dateActuelle = date('Y-m-d');
        $collaborateur = getIdUser($_POST['collaborateurAssu']);

        updateEntretien($data,$vehicule,$dateActuelle, $fkUser,$collaborateur['id_user'],'assu');
        
}

if (isset($_POST['validateInventoryVsl'])) {
    $vehicule = $datasVehicule['id_vehicule'];
    $fkUser = $_SESSION['id_user'];
    // Récupérer la liste des inventaire et les ranger correctement dans un tableau. 
    $data = [];
    for ($i=0; $i<count($_POST)-1; $i++){
        $temporaire = [];
       
        if (!empty($_POST[$i.'P'])) {
            $keyBinding = $i.'P';
            $temporaire[$keyBinding] =  $_POST[$i.'P'];
          
           
        }
        if (!empty($_POST[$i.'NewD'])) {
            $keyBinding = $i.'D';
            $temporaire[$keyBinding] =  $_POST[$i.'NewD'];
            
        }else{
            if (!empty($_POST[$i.'D'])) {
            $keyBinding = $i.'D';
            $temporaire[$keyBinding] =  $_POST[$i.'D'];
            }
        }

    (array_filter($temporaire)) ? array_push($data,$temporaire) : "" ;
  
    } 
        $dateActuelle = date('Y-m-d');
        $collaborateur = getIdUser($_POST['collaborateurAssu']);

        updateEntretien($data,$vehicule,$dateActuelle, $fkUser,$collaborateur['id_user'],'assu');
}


/** CONDUITE */

/**if (isset($_POST['latitude'])){
    
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];
    $user = $_SESSION['id_user'];
    $vehicule = $datasVehicule['id_vehicule'];
    sleep(1);
    createConduite($user,$vehicule,$latitude,$longitude);
}
*/



ob_end_flush();

