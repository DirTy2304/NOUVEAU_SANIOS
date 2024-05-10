<?php

(!isset($_SESSION)) ? session_start() : session_abort();

if ($_SESSION['fk_emploi'] != 4 && $_SESSION['fk_emploi'] != 3) {
    header('location: ../index.php');
}

if ($_SESSION['fk_emploi'] == 4) {
    (!isset($_SESSION)) ? session_start() : session_abort();
    $accueil = 1;
    $colorBtn = "secondary";
    $returnProfil = "gestionnaireForm.php";
    require __DIR__ . '/gestionnaire.php';
}
if ($_SESSION['fk_emploi'] == 3) {
    (!isset($_SESSION)) ? session_start() : session_abort();
    $accueil = 1;
    $colorBtn = "primary";
    $returnProfil = "reguleForm.php";
    require __DIR__ . '/regule.php';
}
require('../vuemodel/formulaireVueModel.php');



// Assurez-vous d'avoir une connexion à la base de données valide ici
$connection = mysqli_connect("localhost", "root", "", "dbs6406676");

if (!$connection) {
    die("Erreur de connexion à la base de données: " . mysqli_connect_error());
}

// Vos requêtes SQL pour récupérer les marques et les modèles
$queryMarques = "SELECT * FROM sanios_marque";
$resultMarques = mysqli_query($connection, $queryMarques);

$queryModeles = "SELECT * FROM sanios_modele";
$resultModeles = mysqli_query($connection, $queryModeles);

$queryTypes = "SELECT * FROM sanios_type";
$resultTypes = mysqli_query($connection, $queryTypes);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="media/css/asset.css">
    <title>Véhicules</title>
</head>

<body>

    <div class="card m-4">

        <?php if (isset($_POST['modify'])) :

            $currentAlias =  $_POST['alias']; ?>

            <div class="card-header pt-4 text-<?= $colorBtn ?>">
                <h1> MODIFIER LE VEHICULE - <?= $currentAlias ?> </h1>
            </div>

            <div class="card-body pt-4">

                <div class="container">

                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row pt-4 pb-3 ">
                            <?php if ($_SESSION['fk_emploi'] == 4) : ?>
                                <div class="col-lg-3 col-md-6">
                                    <label for="societe">Société du véhicule</label>
                                    <select class="form-select" name="societe" id="">
                                        <option selected> <?= $currentVehicule['societe_nom'] ?></option>
                                        <?php foreach ($societes as $societe) : ?>
                                            <option value="<?= $societe['societe_nom']; ?>">
                                                <?= $societe['societe_nom']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php else : ?>
                                <h2><?= $currentVehicule['societe_nom'] ?></h2>
                            <?php endif; ?>

                            <div class="col-lg-3 col-md-6">
                                <label for="marque">Marque du véhicule</label>
                                <select class="form-select" name="marque" id="">
                                    <option selected disabled><?= $currentVehicule['marque_nom'] ?></option>
                                    <?php while ($marque = mysqli_fetch_assoc($resultMarques)) : ?>
                                        <option value="<?= $marque['marque_nom']; ?>"><?= $marque['marque_nom']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <label for="modele">Modèle du véhicule</label>
                                <select class="form-select" name="modele" id="">
                                    <option selected disabled> <?= $currentVehicule['modele_nom'] ?></option>
                                    <?php while ($modele = mysqli_fetch_assoc($resultModeles)) : ?>
                                        <option value="<?= $modele['modele_nom']; ?>"><?= $modele['modele_nom']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <label for="type">Type du véhicule</label>
                                <select class="form-select" name="type" id="">
                                    <option selected disabled><?= $currentVehicule['type_nom'] ?></option>
                                    <?php while ($type = mysqli_fetch_assoc($resultTypes)) : ?>
                                        <option value="<?= $type['type_nom']; ?>"><?= $type['type_nom']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>


                        <div class="row pt-4 pb-3">

                            <div class="col-lg-3 col-md-6">
                                <div class="form-group <?= $immatriculationFalse ?>">
                                    <label for="plaqueImmatriculation">Plaque d'Immatriculation</label>
                                    <input type="text" name="plaqueImmatriculation" pattern="^[A-Z]{2}+[0-9]{3}+[A-Z]{2}+$" class="form-control" placeholder="" value="<?= $currentVehicule['plaque']; ?>">
                                </div>
                            </div>
                            <?php if ($_SESSION['fk_emploi'] == 4) : ?>
                                <div class="col-lg-3 col-md-6">

                                    <label for="InventairePosition">Inventaire Position</label>
                                    <select class="form-select" name="inventairePosition" id="">
                                        <option selected> <?= $inventairePosition['societe_nom'] ?></option>
                                        <?php foreach ($societes as $societe) : ?>
                                            <option value="<?= $societes['societe_nom']; ?>"><?= $societe['societe_nom']; ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>
                            <?php endif; ?>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="datemisecirculation">Date de mise en circulation</label>
                                    <input class="form-control" id="date" name="datemisecirculation" type="date" value="<?= $currentVehicule['date_mise_circulation']; ?>" />
                                </div>
                            </div>
                            <?php if ($_SESSION['fk_emploi'] == 4) : ?>
                                <div class="col-lg-3 col-md-6">

                                    <label for="InventairePosition">Cession du véhicule</label>
                                    <select class="form-select" name="cession" id="">
                                        <option selected value="En activité">En activité </option>
                                        <option value="A céder">A céder </option>
                                    </select>




                                </div>

                            <?php endif; ?>


                            <footer class="footer container pb-4 text-end mt-4">

                                <div class="row ">

                                    <div class="col-md-12 mt-4">
                                        <div class="form-group ">
                                            <!-- Submit button -->
                                            <button class="btn btn-<?= $colorBtn ?> " name="modifyGestionnaire" type="submit">Je valide mes modifications </button>
                                        </div>
                                    </div>


                                </div>


                        </div>


                        </footer>


                    </form>
                </div>
            <?php endif; ?>



            <!-- CREATION VEHICULE -->

            <?php if (isset($_POST['create'])) : ?>

                <!-- REMAQUE FORMULAIRE -->


                <div class="card">
                    <div class="card-header">
                        <h1 class="  text-<?= $colorBtn ?>">Créer un Véhicule</h1>
                    </div>
                    <div class="card-body">

                        <form method="POST" class="was-validated" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">


                            <div class="container ">
                                <div class="row justify-content-between">

                                    <div class="border bg-whiteBlue p-3 col-md-5">
                                        <!-- FIRST CARD -->
                                        <h2 class="display-3">
                                            <?php $userSoc =  getSocieteById($_SESSION['fk_societe']) ?>
                                            <?= ($_SESSION['fk_emploi'] == 4) ?  $_SESSION['createCurrentSociete'] : $userSoc['societe_nom'] ?></h2>
                                        <h4 class="mt-5">
                                            <?php if ($_SESSION['fk_emploi'] == 4) : ?>
                                                <?= $_SESSION['marqueVehicule'] ?>
                                            <?php else : ?>
                                                <?= $_SESSION['marqueVehicule']; ?>
                                            <?php endif; ?>
                                        </h4>
                                        <div class="mt-3 ">
                                            <label class="form-label" for="modele">Modele du véhicule</label>
                                            <select class="form-select" required aria-label="select example" id="validationTextarea" name="modele">
                                                <option value="">Choisir un modèle</option>
                                                <?php foreach ($modeles as $modele) : ?>
                                                    <option value="<?= $modele['modele_nom']; ?>">
                                                        <?= $modele['modele_nom']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mt-3">
                                            <label for="type">Type du véhicule</label>
                                            <select class="form-select" required aria-label="select example" name="type" id="">
                                                <option value="">Choisir un type</option>
                                                <?php foreach ($types as $type) : ?>
                                                    <?php if (!is_array($type)) : ?>
                                                        <option value="<?= htmlspecialchars($type) ?>">
                                                            <?= htmlspecialchars($type) ?>
                                                        </option>
                                                    <?php elseif (!array_key_exists('type_nom', $type)) : ?>
                                                        <option value="">
                                                            La clé 'type_nom' n'existe pas dans le tableau <?= print_r($type, true) ?>
                                                        </option>
                                                    <?php elseif (!is_string($type['type_nom'])) : ?>
                                                        <option value="">
                                                            La valeur de 'type_nom' dans le tableau <?= print_r($type, true) ?> n'est pas une chaîne de caractères
                                                        </option>
                                                    <?php else : ?>
                                                        <option value="<?= htmlspecialchars($type['type_nom']) ?>">
                                                            <?= htmlspecialchars($type['type_nom']) ?>
                                                        </option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="mt-3">
                                            <label for="type">Alias du véhicule</label>
                                            <input class="form-control is-invalid" id="alias" aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required type="text" name="alias" placeholder="Alias du véhicule">
                                        </div>


                                    </div>

                                    <!-- SECOND CARD -->
                                    <div class="border p-2 col-md-6">


                                        <div class="mt-5">
                                            <label class="form-label" for="plaqueImmatriculation">Plaque d'Immatriculation</label>
                                            <input type="text" class="form-control is-invalid" id="validationImmatriculation" aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required name="plaqueImmatriculation" pattern="[A-Z]{2}[0-9]{3}[A-Z]{2}" placeholder="immatriculation">
                                        </div>


                                        <div class="mt-3">
                                            <label for="kilometrage">Kilometrage</label>
                                            <input class="form-control is-invalid" id="validationImmatriculation" aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required type="text" name="kilometrage" pattern="[0-9]*" placeholder="Kilometrage">
                                        </div>

                                        <div class="mt-3">
                                            <?php if ($_SESSION['fk_emploi'] == 4) : ?>
                                                <label for="InventairePosition">Inventaire Position</label>
                                                <select class="form-select" name="inventairePosition" id="">
                                                    <option selected> <?= $_SESSION['createCurrentSociete'] ?></option>
                                                    <?php foreach ($societes as $societe) : ?>
                                                        <option value="<?= $societe['societe_nom']; ?>"><?= $societe['societe_nom']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            <?php endif; ?>
                                        </div>

                                        <div class="mt-3">
                                            <div class="form-group">
                                                <!-- Date input -->
                                                <label class="control-label" for="datemisecirculation">Date de mise en circulation </label>
                                                <input class="form-control" id="date" name="datemisecirculation" type="date" value="<?= $currentDate ?>" />
                                            </div>
                                        </div>

                                        <div class="mt-4 ">
                                            <div class="form-group">
                                                <!-- Date input -->
                                                <label class="control-label" for="dateControleTechnique">Date dernier controle technique </label>
                                                <input class="form-control" id="date" name="dateControleTechnique" type="date" value="" />
                                            </div>
                                        </div>



                                        <!-- Submit button -->
                                        <div class="w-95 mt-3">
                                            <button class="btn btn-<?= $colorBtn ?> w-100 " name="createGestionnaire" type="submit">Créer le
                                                véhicule</button>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            <?php endif; ?>

            <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
            <script type="text/javascript">


            </script>
</body>

</html>