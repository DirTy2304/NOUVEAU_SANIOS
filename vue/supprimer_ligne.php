<?php
require_once 'config.php'; // Inclure le fichier de configuration de la base de données

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Requête pour supprimer la ligne dans la base de données
    $sql = "DELETE FROM sanios_vehicule_pneus WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo "success"; // Envoyer une réponse réussie
    } else {
        echo "error"; // Envoyer une réponse d'erreur
    }
} else {
    echo "error"; // Envoyer une réponse d'erreur si l'identifiant est manquant
}

?>
