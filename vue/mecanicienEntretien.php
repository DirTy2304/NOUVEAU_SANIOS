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

    <title>Entretien</title>
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
                <h3 class="p-1"> Kilometrage : <?= $kilometreVehicules['kilometrage'] ?> </h3>
            </div>
        </div>
    </div>



    <div class="container mt-3">
        <div class="row ">

            <div class="col-12">


                <div class="card">
                    <div class="card-header h4">
                        Renseigner un entretien :
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="container">
                                <div class="row ">

                                    <div class="col-md-12">
                                        <div class="form-radio h3 ">
                                            <div class="d-flex mt-2 align-items-start flex-nowrap">
                                                <input type="radio" class=" pt-2 btn-check w-100 " value="Vidange" id="vidange" name="typeEntretien">
                                                <label class="btn btn-outline-primary mb-2 w-100 " for="vidange">Vidange
                                                </label>
                                            </div>
                                            <div class="d-flex mt-2 align-items-start flex-nowrap">
                                                <input type="radio" class=" pt-2 btn-check w-100 " value="Distribution" id="distribution" name="typeEntretien">
                                                <label class="btn btn-outline-primary mb-2 w-100 " for="distribution">Distribution</label>
                                            </div>
                                            <div class="d-flex mt-2 align-items-start flex-nowrap">
                                                <input type="radio" class=" pt-2 btn-check w-100 " value="Carrosserie" id="carrosserie" name="typeEntretien">
                                                <label class="btn btn-outline-primary mb-2 w-100 " for="carrosserie">Carrosserie</label>
                                            </div>

                                            <div class="d-flex mt-2 align-items-start flex-nowrap">
                                                <input type="radio" class=" pt-2 btn-check w-100 " value="Pare brise" id="parebrise" name="typeEntretien">
                                                <label class="btn btn-outline-primary  mb-2 w-100 " for="parebrise">Pare
                                                    brise</label>
                                            </div>

                                            <div class="d-flex mt-2 align-items-start flex-nowrap">
                                                <input type="radio" class=" pt-2 btn-check w-100 " value="Plaquettes de freins" id="PlaquettesDeFreins" name="typeEntretien">
                                                <label class="btn btn-outline-primary  mb-2 w-100 " for="PlaquettesDeFreins">Plaquettes de freins</label>
                                            </div>

                                            <div class="d-flex mt-2 align-items-start flex-nowrap">
                                                <input type="radio" class=" pt-2 btn-check w-100 " value="Disque de freins" id="DisqueDeFreins" name="typeEntretien">
                                                <label class="btn btn-outline-primary  mb-2 w-100 " for="DisqueDeFreins">Disque de freins </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="container mt-3 mb-4">
                                <div class="row ">

                                    <div class="col-12">
                                        <label for="kmsReleve" class="text-primary"> Relevé du kilometrage </label>
                                        <input type="text" class="form-control" name="kmsReleve" pattern="[0-9]+" class="form-control" id="validationCustom03"  placeholder= "<?= $kilometreVehicules['kilometrage'] ?>" required>
                                    </div>

                                </div>
                            </div>

                            <div class="container mt-3">
                                <div class="row ">

                                    <div class="col-12">
                                        <label for="remarque" class="text-primary"> Ajouter une remarque </label>
                                        <textarea class="form-control textArea" name="remarque" id="remarque"> </textarea>
                                    </div>

                                </div>
                            </div>

                            <div class="container mt-3">
                                <div class="row ">

                                    <div class="col-12">
                                        <input type="submit" class="btn btn-warning w-100" name="entretienValidate" value="Je valide ">
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