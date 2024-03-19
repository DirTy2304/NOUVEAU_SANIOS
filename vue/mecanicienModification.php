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
    <title>Modifier un véhicule</title>
</head>

<body>




    <div class="container bg-whiteBlue">
        <div class="row ">

            <div class="col-md-12">
                <h3 class="p-1"> Alias : <?= $alias ?>  </h3>
            </div>
        </div>

        <div class="row ">
            <div class="col-md-12">
                <h3 class="p-1"> Immatriculation : <?= $immatriculation ?> </h3>
            </div>
        </div>

        <div class="row ">
            <div class="col-md-12">
                <h3 class="p-1"> Marque : <?= $marque ?> </h3>
            </div>
        </div>

        <div class="row ">
            <div class="col-md-12">
                <h3 class="p-1"> Kilometrage actuelle : <?= $kilometreVehicules['kilometrage'] ?> </h3>
            </div>
        </div>
    </div>


    <div class="container mt-3">
        <div class="row ">

            <div class="col-12">


                <div class="card">
                    <div class="card-header h4">
                        Suvis Pneumatique :
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="container">
                                <div class="row ">

                                    <div class="container mt-3 mb-4">
                                        <div class="row ">

                                            <div class="col-12">
                                                <label for="kmsNew" class="text-primary"> Relevé du kilometrage compteur</label>
                                                <input type="text" class="form-control" name="kmsNew"  class="form-control" id="kmsNew" placeholder= "<?= $kilometreVehicules['kilometrage'] ?>" required>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="container mt-3 mb-4">
                                        <div class="row ">

                                            <div class="col-12">
                                                <label for="RelevekmE" class="text-primary">Relevé kilométrage Etiquette </label>
                                                <input type="text" class="form-control" name="RelevekmE" class="form-control" id="RelevekmE" placeholder= "<?= $kilometreVehicules['kilometrage'] ?>" required>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="container mt-3 mb-4">
                                <div class="row ">

                                    <div class="col-12">
                                        <label for="PneuxAvant" class="text-primary"> Pneux Avant </label>
                                        <input type="text" class="form-control" name="PneuxAvant" class="form-control" id="PneuxAvant" required>
                                    </div>

                                </div>
                            </div>

                            <div class="container mt-3 mb-4">
                                <div class="row ">

                                    <div class="col-12">
                                        <label for="PneuxArière" class="text-primary"> Pneux Arière </label>
                                        <input type="text" class="form-control" name="PneuxArière" class="form-control" id="PneuxArière" required>
                                    </div>

                                </div>
                            </div>

                            <div class="container mt-3">
                                <div class="row ">

                                    <div class="col-12">
                                        <label for="commentaire" class="text-primary"> Commentaire </label>
                                        <textarea class="form-control textArea" name="commentaire" id="commentaire"> </textarea>
                                    </div>

                                </div>
                            </div>

                            <div class="container mt-3">
                                <div class="row ">

                                    <div class="col-12">
                                        <input type="submit" class="btn btn-primary w-100" name="PneuxValidate" value="Je valide ">
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>


            </div>

        </div>
    </div>



</body>

</html>