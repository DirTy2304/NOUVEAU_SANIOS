<?php
$accueil = 1;
require __DIR__ . '/mecanicien.php';



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique Véhicule</title>
</head>

<body>



    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ALIAS</th>
                <th scope="col">TYPE</th>
                <th scope="col">IMMATRICULATION</th>
                <th scope="col">MODELE</th>
                <th scope="col">KM COMPTEUR</th>
                <th scope="col">KM ETIQUETTE</th>
                <th scope="col">VIDANGE</th>
                <th scope="col">DISTRIBUTION</th>
                <th scope="col">CARROSSERIE</th>
                <th scope="col">PARE BRISE</th>
                <th scope="col">PLAQUETTES DE FREIN</th>
                <th scope="col">DISQUE DE FREIN</th>
                <th scope="col">COMMENTAIRE</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row"> <?= $currentalias ?></th>
                <td> <?= $type ?> </td>
                <td><?= $immatriculation ?></td>
                <td><?= $modele ?> </td>
                <td><?= $kilometreVehicules['kilometrage'] ?></td>
                <td></td>
                <td>Otto</td>
                <td>Otto</td>
                <td>Otto</td>
                <td>Otto</td>
                <td>Otto</td>
                <td>Otto</td>
                <td>Otto</td>
            </tr>
            <tr>
            </tr>
            <tr>

            </tr>
        </tbody>
    </table>

</body>

</html>