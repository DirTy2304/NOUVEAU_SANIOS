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
                <th scope="col">DATE</th>
                <th scope="col">IMMATRICULATION</th>
                <th scope="col">MODELE</th>
                <th scope="col">KM COMPTEUR</th>
                <th scope="col">KM ETIQUETTE</th>
                <th scope="col">PNEUS AVANT</th>
                <th scope="col">PNEUS ARRIERE</th>
                <th scope="col">COMMENTAIRE</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">AA11</th>
                <td><?= date('d M Y') ?></td>
                <td><?= $immatriculation ?></td>
                <td><?= $modele ?></td>
                <td><?= $kilometreVehicules['kilometrage'] ?></td>
                <td>Exemple: 1500000</td>
                <td>Exemple</td>
                <td>Exemple</td>
                <td>Exemple</td>
                <td>
                    <button onclick="supprimerLigne(this)">
                        <i class="fa-solid fa-trash"></i> <!-- Icône de la corbeille -->
                    </button>
                </td>
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
                <td>
                    <button onclick="supprimerLigne(this)">Supprimer</button> <!-- Bouton de suppression -->
                </td>
            `;

            tableBody.appendChild(newRow);
        });

        // Fonction pour supprimer une ligne
        function supprimerLigne(button) {
            var row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }
    </script>
</body>

</html>