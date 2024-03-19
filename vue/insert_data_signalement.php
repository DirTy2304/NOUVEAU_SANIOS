<?php
require('config.php');


$vehicule = $_POST['vehicule'];
$id_user = $_POST['id_user'];
$date = date("Y-m-d");
$message = $_POST['message'];
$lieu = $_POST['lieu'];
$sql = "INSERT INTO sanios_signalement VALUES ('','$id_user','$vehicule','$date','$message', '$lieu')";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
?>