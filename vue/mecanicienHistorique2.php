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



    <table class="table table-striped" id="historiqueTable">
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
                <th scope="row"> <?= $alias ?></th>
                <td> types </td>
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
    <div class="d-grid gap-2">
        <button class="btn btn-primary" type="button" id="ajouterLigne">Ajouter une ligne d'information</button>
        <button class="btn btn-primary" type="button" id="ajouterLigne" onclick="sendDataToServerHistorique()">Enregistrer</button>
    </div>

    <script>
        document.getElementById('ajouterLigne').addEventListener('click', function() {
            var tableBody = document.querySelector('#historiqueTable tbody');
            var newRow = document.createElement('tr');
            var newIndex = tableBody.getElementsByTagName('tr').length + 1; // Calcul de l'index pour l'ID de la ligne

            newRow.id = 'ligne' + newIndex;

            newRow.innerHTML = `
            <td contenteditable="true"></td>
            <td contenteditable="true"><?= date('d M Y') ?></td>
            <td contenteditable="true"><?= $immatriculation ?></td>
            <td contenteditable="true"></td>
            <td contenteditable="true"></td>
            <td contenteditable="true"></td>
            <td contenteditable="true"></td>
            <td contenteditable="true"></td>
            <td contenteditable="true"></td>
            <td contenteditable="true"></td>
            <td contenteditable="true"></td>
            <td contenteditable="true"></td>
            <td contenteditable="true"></td>
        `;

            tableBody.appendChild(newRow);
        });

        // Fonction pour envoyer les données au serveur via AJAX
        function enregistrerLigne(id) {
            var ligne = document.getElementById(id);
            var cells = ligne.getElementsByTagName('td');
            var data = {};

            for (var i = 0; i < cells.length; i++) {
                data['colonne' + i] = cells[i].innerText;
            }

            // Envoi des données au serveur via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'enregistrer.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Réponse du serveur
                    console.log(xhr.responseText);
                }
            };
            xhr.send(JSON.stringify(data));
        }
    </script>
</body>

</html>