<?php
require('config.php');

$alias = $_POST['alias'];
$date = date("Y-m-d");
$immatriculation = $_POST['Immatriculation'];
$KM_Compteur = $_POST['KM_Compteur'];   
$KM_Etiquette = $_POST['KM_Etiquette'];
$Pneus_Avant = $_POST['Pneus_Avant'];
$Pneus_Arriere = $_POST['Pneus_Arriere'];
$Commentaire = $_POST['Commentaire'];
$Modele = $_POST['Modele'];

$sql = "SELECT * FROM sanios_utilisateur WHERE nom = '$name2'";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
if(mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);    
}

$sql = "INSERT INTO historique_vehicules (alias, date, immatriculation, name2, id_collab, KM_Compteur, KM_Etiquette, Pneus_Avant, Pneus_Arriere, Commentaire, Modele) 
        VALUES ('$alias', '$date', '$immatriculation', '$KM_Compteur', '$KM_Etiquette', '$Pneus_Avant', '$Pneus_Arriere', '$Commentaire', '$Modele')";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

mysqli_close($conn)
?>