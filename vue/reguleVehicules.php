<?php
$accueil = 2;
require('regule.php');


?>


<!-- accordeon menu -->


<div class="accordion m-4" id="accordionPrimary">
    <div class="accordion-item">

        <div class="p-3 text-primary bg-blueWhite">
            <h2> Véhicules
            </h2>
        </div>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionPrimary">
            <div class="accordion-body m-0 p-0">


                <!-- accordion navbar : voir tous les véhicules  -->
                <div class="container m-0 p-0" style="max-width: 100%;">
                    <div class="row mx-auto">
                        <nav class="navbar mx-auto navbar-expand-lg navbar-light bg-light">


                            <div class="collapse justify-content-around navbar-collapse " id="navbarSupportedContent">
                                <form method="POST" action="">
                                    <ul class="navbar-nav ">
                                        <li class="nav-item active ">
                                            <button class="btn btn-primary mx-3" name="tableauBord" href="#">Tableau de Bord <span class="sr-only">(current)</span></button>
                                        </li>
                                        <li class="nav-item dropdown ">
                                            <button class="btn btn-primary mx-3 dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Marques
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <?php $marques = getVehicules('marque'); ?>
                                                <?php foreach ($marques as $marque) : ?>
                                                    <input type="submit" class="dropdown-item" name="marqueDropdown" value="<?= $marque ?>">
                                                <?php endforeach; ?>
                                            </div>
                                        </li>
                                    </ul>
                                </form>
                                <form class="form-inline d-inline-flex p-2 bd-highlight " method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <input class="form-control " name="searchByNameInput" type="search" placeholder="Chercher par Alias" aria-label="Search">
                                    <button class="btn btn-outline-success" name="searchByName" type="submit">Chercher</button>
                                </form>
                            </div>

                        </nav>
                    </div>
                </div>




                <!-- accordion : voir tous les véhicules  -->

                <div class="container mb-4 mw-100 m-1 text-center">
                    <div class="row gx-1 w-100">
                        <div class="col-12 d-flex h5 justify-content-around">

                            <div class="col-lg col-md-4">Alias</div>

                            <div class="col-lg col-md-4">Véhicule</div>

                            <div class="col-lg col-md-4">Immatriculation</div>

                            <div class="col-lg col-md-4">Désinfection Approfondie</div>

                            <div class="col-lg col-md-4">Désinfection Courante</div>

                            <div class="col-lg col-md-4">Nettoyage Exterieur</div>

                            <div class="col-lg col-md-4">Nettoyage Interieur</div>

                            <div class="col-lg col-md-4"> QRcode </div>
                            <div class="col-lg col-md-4"> </div>

                        </div>
                    </div>


                    <?php
                    if (isset($_POST['marqueDropdown'])) {
                        $marqueSelectionnee = $_POST['marqueDropdown'];
                        $retourVehicule = getVehiculesByMarques($marqueSelectionnee, $_SESSION['fk_societe']);
                    } elseif (isset($_POST['tableauBord'])) {
                        $retourVehicule = getVehicules('');
                    } elseif (isset($_POST['searchByName'])) {
                        $retourVehicule = getVehiculeByAlias($_POST['searchByNameInput'], $_SESSION['fk_societe']);
                    } else {
                        $retourVehicule = getVehicules('');
                    }


                    foreach ($retourVehicule as $vehicule) { ?>
                        <?php

                        if (isset($_POST['unsetRedirect'])) {

                            if (file_exists('media/qrCode/QrcodeIdRoulant' . $vehicule['plaque'] . '.png')) {
                                unlink('media/qrCode/QrcodeIdRoulant' . $vehicule['plaque'] . '.png');
                                unlink('media/qrCode/QrcodeIdARS' . $vehicule['plaque'] . '.png');
                            }
                        }

                        ?>


                        <div class="row border-top w-100 p-2" data-bs-toggle="collapse" data-bs-target="#collapseVehicule<?= $vehicule['id_vehicule'] ?>" aria-expanded="false" aria-controls="collapseVehicule<?= $vehicule['id_vehicule'] ?>" id="CollapseBar">


                            <div class="col-lg col-md-4"> <?= $vehicule['ancien_id'] ?></div>

                            <div class="col-lg col-md-4"><?= $vehicule['marque_nom'] ?></div>

                            <div class="col-lg col-md-4"><?= $vehicule['plaque'] ?></div>

                            <?php for ($i = 1; $i <         5; $i++) : ?>
                                <div class="col-lg col-md-4"> <i class="<?= $vehiculeHygiene = validateVehicule($vehicule['id_vehicule'], $i, 'hygiene') ?>">
                                    </i>
                                </div>
                            <?php endfor; ?>





                            <!-- QR CODE GESTION -->
                            <div class="col-lg col-md-4 h4 ">
                                <form method="POST" action="../model/QrCodeConstruct.php">
                                    <button type="submit" name="qrCodeShow" class="btn btn-primary">
                                        <input type="hidden" value="<?= $vehicule['plaque']; ?>" name="vehiculeId">
                                        <i class="fa-solid fa-qrcode "></i>
                                    </button>
                                </form>
                            </div>


                            <div id="btnCollapse" class="col-lg col-md-4">
                                <i class="fa-solid fa-circle-plus text-secondary h2"></i>
                                <i class="fa-solid fa-circle-minus text-secondary h2"></i>

                            </div>


                        </div>

                        <!--Nouvelle table -->

                        <div class="container mw-100 m-1 collapse" id="collapseVehicule<?= $vehicule['id_vehicule'] ?>">
                            <div class="row gx-1 w-100">

                                <div class="col-md-6 text-left">
                                    <h3 class="h3 text-align-center my-3"> Hygiènes </h3>
                                    <?php
                                    $typesHygiene = ['Désinfection approfondie', 'Désinfection courante', 'Nettoyage Extérieur', 'Nettoyage Intérieur'];
                                    foreach ($typesHygiene as $typeHygiene) {
                                        $hygieneData = hygieneDataVehicule($typeHygiene, $vehicule['id_vehicule']);
                                        if ($hygieneData) {
                                            $date = new DateTime($hygieneData['date']);
                                            $hygieneData['date'] = $date->format('d/m/Y');
                                        }
                                    ?>
                                        <div class="row gx-1 mt-3 mb-1 border-bottom w-100">
                                            <div class="col-lg-4 col-md-12">
                                                <?= $typeHygiene ?>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <?= ($hygieneData) ? $hygieneData['nom'] : "N/A" ?>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <?= ($hygieneData) ? $hygieneData['date'] : "N/A" ?>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                    <!-- ENTRETIENS -->
                                    <div>
                                        <h3 class="h3 text-align-center my-3"> Entretiens </h3>



                                        <?php
                                        $vidange = entretienDataVehicule('Vidange', $vehicule['id_vehicule']);
                                        $distribution = entretienDataVehicule('Distribution', $vehicule['id_vehicule']);
                                        $carrosserie =  entretienDataVehicule('Carrosserie', $vehicule['id_vehicule']);
                                        $parebrise =  entretienDataVehicule('Pare brise', $vehicule['id_vehicule']);
                                        $plaquetteFreins =  entretienDataVehicule('Plaquettes de freins', $vehicule['id_vehicule']);
                                        $disqueFreins =  entretienDataVehicule('Disque de freins', $vehicule['id_vehicule']);

                                        $warningVidange = warningEntretien($vehicule['id_vehicule'], "Vidange");
                                        $warningDistrib = warningEntretien($vehicule['id_vehicule'], "Distribution");
                                        $warningCarrosserie = warningEntretien($vehicule['id_vehicule'], "Carrosserie");
                                        $warningParebrise = warningEntretien($vehicule['id_vehicule'], "Pare brise");
                                        $warningPlaquette = warningEntretien($vehicule['id_vehicule'], "Plaquettes de freins");
                                        $warningDisque = warningEntretien($vehicule['id_vehicule'], "Disque de freins");
                                        ?>
                                        <div class="row gx-1 mt-1 mb-1 <?= $warningVidange ?>  w-100">
                                            <div class="col-lg-3 col-md-12 h6">
                                                Vidange
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <?php echo ($vidange) ? $vidange['nom'] : "N/A"; ?>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <?php echo ($vidange) ? (new DateTime($vidange['date']))->format('d/m/Y') : "N/A"; ?>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <?php echo ($vidange) ? $vidange['autre'] : "N/A"; ?>
                                            </div>
                                        </div>


                                        <div class="row gx-1 mt-1 mb-1 <?= $warningDistrib ?>   w-100">
                                            <div class="col-lg-3 col-md-12 h6">
                                                Distribution
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <?php echo ($distribution) ? $distribution['nom'] : "N/A"; ?>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <?php echo ($distribution) ? (new DateTime($distribution['date']))->format('d/m/Y') : "N/A"; ?>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <?php echo ($distribution) ? $distribution['autre'] : "N/A"; ?>
                                            </div>
                                        </div>

                                        <div class="row gx-1 mt-1 mb-1 <?= $warningCarrosserie ?> w-100">
                                            <div class="col-lg-3 col-md-12 h6">
                                                Carrosserie
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <?php echo ($carrosserie) ? $carrosserie['nom'] : "N/A"; ?>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <?php echo ($carrosserie) ? (new DateTime($carrosserie['date']))->format('d/m/Y') : "N/A"; ?>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <?php echo ($carrosserie) ? $carrosserie['autre'] : "N/A"; ?>
                                            </div>

                                        </div>
                                        <div class="row gx-1 mt-1 <?= $warningParebrise ?> mb-1 w-100">
                                            <div class="col-lg-3 col-md-12 h6">
                                                Pare Brise
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <?php echo ($parebrise) ? $parebrise['nom'] : "N/A"; ?>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <?php echo ($parebrise) ? (new DateTime($parebrise['date']))->format('d/m/Y') : "N/A"; ?>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <?php echo ($parebrise) ? $parebrise['autre'] : "N/A"; ?>
                                            </div>
                                        </div>

                                        <div class="row gx-1 mt-1 <?= $warningPlaquette ?> mb-1 w-100">
                                            <div class="col-lg-3 col-md-12 h6">
                                                Plaquette de Freins
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <?php echo ($plaquetteFreins) ? $plaquetteFreins['nom'] : "N/A"; ?>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <?php echo ($plaquetteFreins) ? (new DateTime($plaquetteFreins['date']))->format('d/m/Y') : "N/A"; ?>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <?php echo ($plaquetteFreins) ? $plaquetteFreins['autre'] : "N/A"; ?>
                                            </div>

                                        </div>
                                        <div class="row gx-1 mt-1 <?= $warningDisque ?> mb-1 w-100">
                                            <div class="col-lg-3 col-md-12 h6">
                                                Disque de Freins
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <?php echo ($disqueFreins) ? $disqueFreins['nom'] : "N/A"; ?>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <?php echo ($disqueFreins) ? (new DateTime($disqueFreins['date']))->format('d/m/Y') : "N/A"; ?>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <?php echo ($disqueFreins) ? $disqueFreins['autre'] : "N/A"; ?>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>










                    <?php } ?>







                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>