<?php
require_once 'config.php';

$ambuMaterielName = $_POST['ambuMaterielName'];
$id_vehicule = $_POST['id_vehicule'];
$nom = $_POST['nom'];
$id_collab = $_POST['id_collab'];

$P10 = $_POST['P10'];
$D10 = $_POST['D10'];
$P20 = $_POST['P20'];
$D20 = $_POST['D20'];
$P30 = $_POST['P30'];
$D30 = $_POST['D30'];
$P40 = $_POST['P40'];
$D40 = $_POST['D40'];
$P50 = $_POST['P50'];
$D50 = $_POST['D50'];
$P60 = $_POST['P60'];
$P70 = $_POST['P70'];
$P80 = $_POST['P80'];
$D80 = $_POST['D80'];
$P90 = $_POST['P90'];
$P100 = $_POST['P100'];
$P110 = $_POST['P110'];
$P120 = $_POST['P120'];
$P130 = $_POST['P130'];
$P140 = $_POST['P140'];
$P150 = $_POST['P150'];
$P160 = $_POST['P160'];
$P170 = $_POST['P170'];
$P180 = $_POST['P180'];
$P190 = $_POST['P190'];
$P200 = $_POST['P200'];
$D200 = $_POST['D200'];
$P210 = $_POST['P210'];
$P220 = $_POST['P220'];
$P230 = $_POST['P230'];
$P240 = $_POST['P240'];
$P250 = $_POST['P250'];
$P260 = $_POST['P260'];
$P270 = $_POST['P270'];
$P280 = $_POST['P280'];
$P290 = $_POST['P290'];
$P300 = $_POST['P300'];
$P310 = $_POST['P310'];
$P320 = $_POST['P320'];
$P330 = $_POST['P330'];
$P340 = $_POST['P340'];
$P350 = $_POST['P350'];
$P360 = $_POST['P360'];
$P370 = $_POST['P370'];
$P380 = $_POST['P380'];
$P390 = $_POST['P390'];
$P400 = $_POST['P400'];
$D400 = $_POST['D400'];
$P410 = $_POST['P410'];
$P420 = $_POST['P420'];
$P430 = $_POST['P430'];
$P440 = $_POST['P440'];
$P450 = $_POST['P450'];
$P460 = $_POST['P460'];
$P470 = $_POST['P470'];
$P480 = $_POST['P480'];


$sql = "SELECT * FROM sanios_utilisateur WHERE nom = '$name2'";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
while ($data = mysqli_fetch_assoc($result)) {
        $collab = $data['id_user'];
}



$sql = "INSERT INTO sanios_inventaire_ambu VALUES ('','$date','$idVehicule','$name','$collab','$P10', '$D10','$P20', '$D20','$P30','$D30','$P40','$D40','$P50','$D50','$P60', '$P70','$P80', '$D80','$P90','$P100','$P110', '$P120','$P130','$P140','$P150','$P160','$P170','$P180','$P190','$P200','$D200', '$P210','$P220','$P230','$P240', '$P250','$P260','$P270','$D270','$P280','$P290','$P300','$P310','$D310','$P320', '$D320','$P330','$D330','$P340', '$D340','$P350', '$D350','$P360', '$D360','$P370','$P380', '$D380','$P390', '$D390','$P400','$D400','$P410','$D410','$P420','$P430','$P440','$P450','$D450', '$P460','$D460','$P470','$P480')";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

?>

