<?php
require __DIR__.'/../model/arsModel.php';


$vehicule = getDataVehicule($immatriculation);
$hygienesDatas = fetchLastHygiene($vehicule['id_vehicule']);

if(isset($_POST['arsPdf'])) {
   header('location: ../vue/arsPdfGenerator.php?immatriculation='.$immatriculation);
}
?>