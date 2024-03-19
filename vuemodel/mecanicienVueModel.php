<?php
require('../model/mecanicienModel.php');

if (isset($_POST['deconnexion'])) {
    disconnectSession();
  }  

  /** Récupération de l'Alias du véhicule */
if (isset($_SESSION['aliasQr'])) {
    $alias = $_SESSION['aliasQr'];
}else{
    header('location: ../index.php');
}

$data = getDataVehicule($alias);
$immatriculation = $data['plaque'];
$marque = $data['marque_nom'];
$modele = $data['modele_nom'];


/***   ENTRETIENS   ******/


if (isset($_POST['entretienValidate'])) {
   $typeEntretien = $_POST['typeEntretien'];
   $kms = $_POST['kmsReleve'];
   $remarque = $_POST['remarque'];
   $vehiculeId = getIdByAlias($alias);
   $VehiculeSociete = getSocieteVehiculeByAlias($alias);
   $typeId = getTypeByName($typeEntretien);
   $user = $_SESSION['id_user'];
   $currentDate = date('Y-m-d');
   $currentTime = date('Y-m-d H:i:s');
   $userSociete = $_SESSION['fk_societe'];

  insertEntretien($vehiculeId['id_vehicule'] , $user, $currentDate, $currentTime ,$VehiculeSociete['fk_societe'], $userSociete , $kms, $typeId['id_entretien_type'], $remarque);
  
  // Retour sur l'acceuil du profil mecanicien
  unset($accueil);
  header('location: mecanicien.php');

}

/***** MODIFIER LE KILOMETRAGE  ******/
$kilometreVehicules = getKms($alias);

if (isset($_POST['kmsVehicule'])){
    $kms = $_POST['kmsNew'];
    $vehiculeId = getIdByAlias($alias);
    updateKms($vehiculeId['id_vehicule'], $kms);

 // Retour sur l'acceuil du profil mecanicien
  unset($accueil);
  header('location: mecanicien.php');

}
?>