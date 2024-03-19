<?php
$accueil = 1;
require __DIR__ . '/roulant.php';

?>

<div class="container mb-5">
    <div class="row ">
        <div class="card" style="text-align: center;">
            <form class="col-md-12" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                <div class="container bg-whiteBlue px-0">
                    <div class="row ">

                        <div class="col-12 bg-whiteBlue">
                            <ul class="list-group bg-whiteBlue list-group-flush h4">
                                <li class="list-group-item bg-whiteBlue h5"> Véhicule <?= $datasVehicule['ancien_id'] ?> </li>
                                <li class="list-group-item bg-whiteBlue h5 ">Modèle : <?= $datasVehicule['marque_nom'] ?> <?= $datasVehicule['modele_nom'] ?></li>
                                <li class="list-group-item bg-whiteBlue h5"> Immatriculation : <?= $datasVehicule['plaque'] ?> </li>
                                <li class="list-group-item bg-whiteBlue h5"> Date du jour : <?= strftime('%d/%m/%Y', strtotime($dateDuJour)) ?> </li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="h2  w-100 p-4 my-3 rounded"> Signalement </div>


                <div class="form-floating mb-3">
                    <textarea class="form-control" id="message" style="height: 100px"></textarea>
                    <label for="commentairesignalement">Commentaire sur le signalement</label>
                </div>
                <div class="form-floating">
                    <select class="form-select" id="lieu" aria-label="Floating label disabled select example">
                        <option selected></option>
                        <option value="1">Intérieur</option>
                        <option value="2">Exterieur</option>
                        <option value="3">Moteur</option>
                    </select>
                    <label for="floatingSelectDisabled">Séléctionné l'Emplacement</label>
                </div>

                <div class="col-md-12 py-4">
                    <!--<input type="submit" class="btn btn-primary p-1 w-100" value="valider mon inventaire" name="validateInventoryAssu">--->
                    <button type="button" class="btn btn-primary p-1 w-100" id="btnDebut" data-toggle="modal" data-target="#exampleModalAssu">Valider</button>
                </div>
        </div>
    </div>
    </form>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalAssu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation Inventaire</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Etes-vous sûr de vouloir continuer ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" onclick="sendDataToServerSign(<?php echo $_SESSION['id_user']; ?>,<?php echo $datasVehicule['id_vehicule']; ?>)">Confirmer</button>
                </div>

            </div>
        </div>
    </div>
    <script>
        function sendDataToServerSign(vehicule, id_user) {

            var lieu = document.getElementById("lieu").value;
            var message = document.getElementById("message").value;


            $.ajax({
                url: "insert_data_signalement.php", // Le nom du script PHP qui insérera les données
                type: "POST",
                data: 'vehicule=' + vehicule + '&id_user=' + id_user + '&lieu=' + lieu + '&message=' + message,
            });

            var delayInMilliseconds = 1000;
            setTimeout(function() {
                window.location = "roulant.php";
            }, delayInMilliseconds);
        }
    </script>