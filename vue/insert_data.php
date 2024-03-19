<?php
require('config.php');

$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$fkUser = $_SESSION['id_user'];
$date = date("Y-m-d");
$etat = $_POST['etat'];
$vehicule = $_POST['vehicule'];
$id_user = $_POST['id_user'];
$sql = "INSERT INTO sanios_conduite VALUES ('','$id_user','$vehicule','$date','$etat', '$latitude', '$longitude')";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
?>