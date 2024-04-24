<?php
$accueil = 1;
require __DIR__ . '/mecanicien.php';

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'dbs6406676');

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn === false) {
    die("ERREUR : Impossible de se connecter. " . mysqli_connect_error());
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assurez-vous que toutes les données requises ont été envoyées
    if (isset($_POST['alias']) && isset($_POST['date']) && isset($_POST['immatriculation']) && isset($_POST['modele']) && isset($_POST['km_compteur'])) {
        // Récupérer les données du formulaire
        $alias = $_POST['alias'];
        $date = $_POST['date'];
        $immatriculation = $_POST['immatriculation'];
        $modele = $_POST['modele'];
        $km_compteur = $_POST['km_compteur'];
        $km_etiquette = $_POST['km_etiquette'];
        $vidange = $_POST['vidange'];
        $distribution = $_POST['distribution'];
        $pare_brise = $_POST['pare_brise'];
        $plaquette_frein = $_POST['plaquette_frein'];
        $disque_frein = $_POST['disque_frein'];
        $commentaire = $_POST['commentaire'];
        // Vous pouvez récupérer d'autres données de la même manière

        // Insérer les données dans la base de données
        $sql = "INSERT INTO sanios_vehicule_entretien (alias, date, immatriculation, modele, km_compteur, km_etiquette, vidange, distribution, pare_brise, plaquette_frein, disque_frein, commentaire) VALUES ('$alias', '$date', '$immatriculation', '$modele', '$km_compteur','$km_etiquette','$vidange','$distribution', '$pare_brise', '$plaquette_frein','$disque_frein','$commentaire')";
        // Exécutez la requête
        if (mysqli_query($conn, $sql)) {
            echo "Données insérées avec succès.";
            // Redirection vers la page actuelle pour éviter la réinscription des données lors du rechargement de la page
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        } else {
            echo "Erreur : Impossible d'exécuter la requête $sql. " . mysqli_error($conn);
        }
    } else {
        echo "Tous les champs requis ne sont pas remplis.";
    }
}

// Récupérer les données depuis la base de données
$result = mysqli_query($conn, "SELECT * FROM sanios_vehicule_entretien");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entretien</title>
</head>

<body>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table class="table table-striped" id="historiqueTable">
            <!-- Vos en-têtes de tableau -->
            <thead>
                <tr>
                    <th scope="col">ALIAS</th>
                    <th scope="col">DATE</th>
                    <th scope="col">IMMATRICULATION</th>
                    <th scope="col">MODELE</th>
                    <th scope="col">KM COMPTEUR</th>
                    <th scope="col">KM ETIQUETTE</th>
                    <th scope="col">VIDANGE</th>
                    <th scope="col">DISTRIBUTION</th>
                    <th scope="col">PARE BRISE</th>
                    <th scope="col">PLAQUETTE FREIN</th>
                    <th scope="col">DISQUE FREIN</th>
                    <th scope="col">COMMENTAIRE</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Afficher les données récupérées dans le tableau
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td contenteditable='true'>" . $row['alias'] . "</td>";
                    echo "<td contenteditable='true'>" . $row['date'] . "</td>";
                    echo "<td contenteditable='true'>" . $row['immatriculation'] . "</td>";
                    echo "<td contenteditable='true'>" . $row['modele'] . "</td>";
                    echo "<td contenteditable='true'>" . $row['km_compteur'] . "</td>";
                    echo "<td contenteditable='true'>" . $row['km_etiquette'] . "</td>";
                    echo "<td contenteditable='true'>" . $row['vidange'] . "</td>";
                    echo "<td contenteditable='true'>" . $row['distribution'] . "</td>";
                    echo "<td contenteditable='true'>" . $row['pare_brise'] . "</td>";
                    echo "<td contenteditable='true'>" . $row['plaquette_frein'] . "</td>";
                    echo "<td contenteditable='true'>" . $row['disque_frein'] . "</td>";
                    echo "<td contenteditable='true'>" . $row['commentaire'] . "</td>";
                    echo "<td>
                    <button onclick='supprimerLigne(" . $row['id'] . ")'>
                        <i class='fa-solid fa-trash'></i> <!-- Icône de la corbeille -->
                    </button>
                </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="d-grid gap-2">
            <button class="btn btn-primary" type="button" id="ajouterLigne">Ajouter une ligne d'information</button>
            <button class="btn btn-primary" type="submit" id="ajouterLigne">Enregistrer</button> <!-- Changement de type à "submit" -->
        </div>
    </form>
    <script>
        document.getElementById('ajouterLigne').addEventListener('click', function() {
            var tableBody = document.querySelector('#historiqueTable tbody');
            var newRow = document.createElement('tr');
            var newIndex = tableBody.getElementsByTagName('tr').length + 1; // Calcul de l'index pour l'ID de la ligne

            newRow.id = 'ligne' + newIndex;

            newRow.innerHTML = `
            <td contenteditable="true"><input type="text" name="alias"></td>
            <td contenteditable="true"><input type="date" name="date" value="<?= date('Y-m-d') ?>"></td>
            <td contenteditable="true"><input type="text" name="immatriculation"></td>
            <td contenteditable="true"><input type="text" name="modele"></td>
            <td contenteditable="true"><input type="number" name="km_compteur"></td>
            <td contenteditable="true"><input type="number" name="km_etiquette"></td>
            <td contenteditable="true"><input type="text" name="vidange"></td>
            <td contenteditable="true"><input type="text" name="distribution"></td>
            <td contenteditable="true"><input type="text" name="pare_brise"></td>
            <td contenteditable="true"><input type="text" name="plaquette_frein"></td>
            <td contenteditable="true"><input type="text" name="disque_frein"></td>
            <td contenteditable="true"><input type="text" name="commentaire"></td>
            <td>
                        <button onclick="supprimerLigne(this)">
                            <i class="fa-solid fa-trash"></i> <!-- Icône de la corbeille -->
                        </button>
            </td>
        `;

            tableBody.appendChild(newRow);
        });

        function supprimerLigne(id) {
            // Envoyer une requête AJAX pour supprimer la ligne correspondante dans la base de données
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "supprimer_ligne.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Supprimer la ligne du tableau HTML si la suppression dans la base de données a réussi
                    if (xhr.responseText.trim() === "success") {
                        var row = document.getElementById("ligne" + id);
                        row.parentNode.removeChild(row);
                        alert("Ligne supprimée avec succès !");
                    } else {
                        alert("Erreur lors de la suppression de la ligne !");
                    }
                }
            };
            xhr.send("id=" + id);
        }
    </script>
</body>

</html>