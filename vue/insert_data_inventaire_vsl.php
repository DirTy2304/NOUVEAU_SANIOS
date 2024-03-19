<?php
require('config.php');
        $name =$_POST['name'];
        $name2 = $_POST['name2'];
        $idVehicule = $_POST['idVehicule'];
        $date = date("Y-m-d");      
        $P10 = $_POST['P10'];
        $D10 = $_POST['D10'];
        $P20 = $_POST['P20'];
        $D20 = $_POST['D20'];
        $P30 = $_POST['P30'];
        $P40 = $_POST['P40'];
        $P50 = $_POST['P50'];
        $P60 = $_POST['P60'];
        $D60 = $_POST['D60'];
        $P70 = $_POST['P70'];
        $D70 = $_POST['D70'];
        $P80 = $_POST['P80'];
        $D80 = $_POST['D80'];
        $P90 = $_POST['P90'];
        $D90 = $_POST['D90'];
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
        $P210 = $_POST['P210'];
        $P220 = $_POST['P220'];
        $P230 = $_POST['P230'];
        $P240 = $_POST['P240'];
        $P320 = $_POST['P320'];
        $P330 = $_POST['P330'];
 

        $sql = "SELECT * FROM sanios_utilisateur WHERE nom = '$name2'";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        while($data = mysqli_fetch_assoc($result)){
                $collab = $data['id_user'];	
           }

        $sql = "INSERT INTO sanios_inventaire_vsl VALUES ('','$date','$idVehicule','$name','$collab','$P10', '$D10','$P20', '$D20','$P30', '$P40','$P50','$P60', '$D60','$P70', '$D70','$P80', '$D80','$P90', '$D90','$P100','$P110', '$P120','$P130','$P140','$P150','$P160','$P170','$P180','$P190','$P200','$P210','$P220','$P230','$P240','$P320','$P330')";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

?>





