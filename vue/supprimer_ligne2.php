
<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'dbs6406676');

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn === false) {
    die("ERREUR : Impossible de se connecter. " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM sanios_vehicule_pneus WHERE id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            if (mysqli_stmt_execute($stmt)) {
                echo "success";
            } else {
                echo "Erreur : Impossible d'exécuter la requête $sql. " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
    }
}

mysqli_close($conn);
?>
