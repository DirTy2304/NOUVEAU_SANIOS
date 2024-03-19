<?php
$accueil = 1;
require __DIR__ . '/roulant.php';


?>
<div class="container bg-whiteBlue vw-100 ">
  <div class="row">

    <div class="col-12 bg-whiteBlue px-0">
      <ul class="bg-whiteBlue mb-0 px-0 h4">
        <li class=" bg-whiteBlue list-group-item  h5"> Véhicule <?= $datasVehicule['ancien_id'] ?> </li>
        <li class="bg-whiteBlue list-group-item h5"> Immatriculation : <?= $datasVehicule['plaque'] ?> </li>
        <?php if ($datasVehicule['fk_type'] == 1) : ?>
          <li class=" bg-whiteBlue list-group-item  mb-0 pb-2 h5"> Ambulance </li>
        <?php endif; ?>
        <?php if ($datasVehicule['fk_type'] == 2) : ?>
          <li class=" bg-whiteBlue list-group-item mb-0 pb-2 h5"> Ambulance Assu </li>
        <?php endif; ?>
        <?php if ($datasVehicule['fk_type'] == 21) : ?>
          <li class=" bg-whiteBlue list-group-item mb-0 pb-2 h5"> V.S.L </li>
        <?php endif; ?>
      </ul>
    </div>

  </div>
</div>



<div class="container vw-100">
  <div class="row border-bottom">
    <div class="col-6 border-end  bg-light py-1">
      <strong>Nom de l'inventaire</strong>
    </div>

    <div class="col-4 bg-light border-end py-1">
      <strong>Quantitée Obligatoire</strong>
    </div>

    <div class="col-2 bg-light py-1">
      <i class="fa-solid fa-truck-medical text-primary pt-2 h2"></i>
    </div>
  </div>


  <!------------------------------------------------------------------------------->
  <!------------------------------------------------------------------------------->
  <!------------------------------------- TYPE ASSU ------------------------------->
  <!------------------------------------------------------------------------------->
  <!------------------------------------------------------------------------------->





  <?php if ($datasVehicule['fk_type'] == 2) : ?>

    <!-- CONTENT -->
    <form method="POST" action="insert_data_inventaire.php">
      <?php foreach ($assuMaterielName as $materiel) : ?>
        <?php
        // Récupère un tableau avec en tab[0] : le nombre de produit ET en tab[1] : la date de pérenption du produit
        $retourAssuInventaire =  getInventaireAssuRelai($materiel['id_produit'], $datasVehicule['id_vehicule']); ?>

        <div class="row border-bottom " data-bs-toggle="collapse" data-bs-target="#collapseVehicule<?= $materiel['id_produit'] ?>" aria-expanded="false" aria-controls="collapseVehicule<?= $materiel['id_produit'] ?>" id="CollapseBar">

          <div class="col-6 border-end  bg-light py-1">
            <p><?= $materiel['nom'] ?></p>
          </div>

          <div class="col-4 bg-light border-end py-1">
            <p><?= $materiel['quantite'] ?></p>
          </div>

          <div class="col-2 bg-light py-1" id="btnCollapse">
            <i class="fa-solid fa-angle-down text-primary pt-2 h2"></i>
            <i class="fa-solid fa-angle-up text-primary pt-2 h2"></i>
          </div>

        </div>

        <div class="row collapse" id="collapseVehicule<?= $materiel['id_produit'] ?>">
          <div class="col-md-6 py-1" id="assuInventory">

            <?php if ($materiel['peremption'] == 1) {
              echo "<label> date de péremption</label>";
              echo "<input type='date' name='$materiel[id_produit]D' id='$materiel[id_produit]D'";
              if (isset($retourAssuInventaire[1])) {
                echo "value='$retourAssuInventaire[1]'";
              }
              echo ">";
            }
            ?>
            <div class="col-md-6">
              <label> Materiel </label>
              <select id="<?= $materiel['id_produit'] ?>P" name="<?= $materiel['id_produit'] ?>P">

                <?php for ($i = $materiel['quantite']; $i != -1; $i--) : ?>
                  <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>

              </select>
            </div>

          </div>
        </div>
      <?php endforeach; ?>

      <div class="container w-100 py-2 m-0 bg-lightBlue">
        <div class="row px-2 bg-lightBlue">

          <div class="col-md-6 mb-0 text-dark pb-0">
            <p class="mb-0"> Merci de choisir le nom de votre collaborateur.
          </div>

          <div class="col-md-6 mt-0">
            <select name="collaborateurAssu" id="collaborateurAssu" class="form-control">
              <?php foreach ($names as $name) : ?>
                <option><?= $name['nom'] ?></option>
              <?php endforeach; ?>
            </select>
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
            <button type="button" class="btn btn-primary" onclick="sendDataToServerAssu(<?php echo $_SESSION['id_user']; ?>,<?php echo $datasVehicule['id_vehicule']; ?>)">Confirmer</button>
          </div>

        </div>
      </div>
    </div>


  <?php endif; ?>

  <!------------------------------------------------------------------------------->
  <!------------------------------------------------------------------------------->
  <!-------------------------------- TYPE AMBULANCE ------------------------------->
  <!------------------------------------------------------------------------------->
  <!------------------------------------------------------------------------------->
  <?php if ($datasVehicule['fk_type'] == 1) : ?>

    <!-- CONTENT -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <?php foreach ($ambuMaterielName as $materiel) : ?>
        <?php
        // Récupère un tableau avec en tab[0] : le nombre de produit ET en tab[1] : la date de pérenption du produit
        $inventaireAmbuVehicule =  getInventaireAmbuRelai($materiel['id_produit'], $datasVehicule['id_vehicule']); ?>

        <div class="row border-bottom " data-bs-toggle="collapse" data-bs-target="#collapseVehicule<?= $materiel['id_produit'] ?>" aria-expanded="false" aria-controls="collapseVehicule<?= $materiel['id_produit'] ?>" id="CollapseBar">

          <div class="col-6 border-end  bg-light py-1">
            <p><?= $materiel['nom'] ?></p>
          </div>

          <div class="col-4 bg-light border-end py-1">
            <p><?= $materiel['quantite'] ?></p>
          </div>

          <div class="col-2 bg-light py-1" id="btnCollapse">
            <i class="fa-solid fa-angle-down text-primary pt-2 h2"></i>
            <i class="fa-solid fa-angle-up text-primary pt-2 h2"></i>
          </div>

        </div>
        <div class="row collapse" id="collapseVehicule<?= $materiel['id_produit'] ?>">
          <div class="col-md-6 py-1" id="assuInventory">

            <?php if ($materiel['peremption'] == 1) {
              echo "<label> date de péremption</label>";
              echo "<input type='date' name='$materiel[id_produit]D' id='$materiel[id_produit]D'";
              if (isset($inventaireAmbuVehicule[1])) {
                echo "value='$inventaireAmbuVehicule[1]'";
              }
              echo ">";
            }
            ?>
            <div class="col-md-6">
              <label> Materiel </label>
              <select id="<?= $materiel['id_produit'] ?>P" name="<?= $materiel['id_produit'] ?>P">

                <?php for ($i = $materiel['quantite']; $i != -1; $i--) : ?>
                  <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>

              </select>
            </div>

          </div>
        </div>
      <?php endforeach; ?>

      <div class="container w-100 py-2 m-0 bg-lightBlue">
        <div class="row px-2 bg-lightBlue">

          <div class="col-md-6 mb-0 text-dark pb-0">
            <p class="mb-0"> Merci de choisir le nom de votre collaborateur.
          </div>

          <div class="col-md-6 mt-0">
            <select name="collaborateurAssu" id="collaborateurAssu" class="form-control">
              <?php foreach ($names as $name) : ?>
                <option> <?= $name['nom'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-12 py-4">
            <!-- Bouton de validation avec modal de confirmation -->
            <button type="button" class="btn btn-primary p-1 w-100" id="btnDebut" data-toggle="modal" data-target="#exampleModalAmb">Valider</button>
          </div>
        </div>
      </div>
    </form>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalAmb" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <button type="button" class="btn btn-primary" onclick="sendDataToServerAmb(<?php echo $_SESSION['id_user']; ?>,<?php echo $datasVehicule['id_vehicule']; ?>)">Confirmer</button>
          </div>

        </div>
      </div>
    </div>

  <?php endif; ?>





  <!------------------------------------------------------------------------------->
  <!------------------------------------------------------------------------------->
  <!------------------------------------- TYPE VSL ------------------------------->
  <!------------------------------------------------------------------------------->
  <!------------------------------------------------------------------------------->





  <?php if ($datasVehicule['fk_type'] == 21) : ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <?php foreach ($vslMaterielName as $materiel) : ?>
        <?php
        $inventaireVslVehicule =  getInventaireVslRelai($materiel['id_produit'], $datasVehicule['id_vehicule']);
        ?>

        <div class="row border-bottom " data-bs-toggle="collapse" data-bs-target="#collapseVehicule<?= $materiel['id_produit'] ?>" aria-expanded="false" aria-controls="collapseVehicule<?= $materiel['id_produit'] ?>" id="CollapseBar">

          <div class="col-6 border-end  bg-light py-1">
            <p><?= $materiel['nom'] ?></p>
          </div>

          <div class="col-4 bg-light border-end py-1">
            <p><?= $materiel['quantite'] ?></p>
          </div>

          <div class="col-2 bg-light py-1" id="btnCollapse">
            <i class="fa-solid fa-angle-down text-primary pt-2 h2"></i>
            <i class="fa-solid fa-angle-up text-primary pt-2 h2"></i>
          </div>

        </div>

        <div class="row collapse" id="collapseVehicule<?= $materiel['id_produit'] ?>">
          <div class="col-md-6 py-1" id="assuInventory">

            <?php if ($materiel['peremption'] == 1) {
              echo "<label> date de péremption</label>";
              echo "<input type='date' name='$materiel[id_produit]D' id='$materiel[id_produit]D'";
              if (isset($inventaireVslVehicule[1])) {
                echo "value='$inventaireVslVehicule[1]'";
              }
              echo ">";
            }
            ?>
            <div class="col-md-6">
              <label> Materiel </label>
              <select id="<?= $materiel['id_produit'] ?>P" name="<?= $materiel['id_produit'] ?>P">

                <?php for ($i = $materiel['quantite']; $i != -1; $i--) : ?>
                  <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>

              </select>
            </div>

          </div>
        </div>
      <?php endforeach; ?>

      <div class="container w-100 py-2 m-0 bg-lightBlue">
        <div class="row px-2 bg-lightBlue">
          <div class="col-md-6 mb-0 text-dark pb-0">
            <p class="mb-0"> Merci de choisir le nom de votre collaborateur.</p>
          </div>
          <div class="col-md-6 mt-0">
            <select name="collaborateurAssu" id="collaborateurAssu" class="form-control">
              <?php foreach ($names as $name) : ?>
                <option><?= $name['nom'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-12 py-4">
            <!-- Bouton de validation avec modal de confirmation -->
            <button type="button" class="btn btn-primary p-1 w-100" id="btnDebut" data-toggle="modal" data-target="#exampleModalVsl">Valider</button>
          </div>
        </div>
      </div>
    </form>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalVsl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <button type="button" class="btn btn-primary" onclick="sendDataToServerVsl(<?php echo $_SESSION['id_user']; ?>,<?php echo $datasVehicule['id_vehicule']; ?>)">Confirmer</button>
          </div>

        </div>
      </div>
    </div>


  <?php endif; ?>

  <script>
    function sendDataToServerAssu(name, idVehicule) {
      var collab = $("#collaborateurAssu :selected").text();
      var P10 = document.getElementById("10P").value;
      var D10 = document.getElementById("10D").value;
      var P20 = document.getElementById("20P").value;
      var D20 = document.getElementById("20D").value;
      var P30 = document.getElementById("30P").value;
      var D30 = document.getElementById("30D").value;
      var P40 = document.getElementById("40P").value;
      var D40 = document.getElementById("40D").value;
      var P50 = document.getElementById("50P").value;
      var D50 = document.getElementById("50D").value;
      var P60 = document.getElementById("60P").value;
      var P70 = document.getElementById("70P").value;
      var P80 = document.getElementById("80P").value;
      var D80 = document.getElementById("80D").value;
      var P90 = document.getElementById("90P").value;
      var P100 = document.getElementById("100P").value;
      var P110 = document.getElementById("110P").value;
      var P120 = document.getElementById("120P").value;
      var P130 = document.getElementById("130P").value;
      var P140 = document.getElementById("140P").value;
      var P150 = document.getElementById("150P").value;
      var P160 = document.getElementById("160P").value;
      var P170 = document.getElementById("170P").value;
      var P180 = document.getElementById("180P").value;
      var P190 = document.getElementById("190P").value;
      var P200 = document.getElementById("200P").value;
      var P210 = document.getElementById("210P").value;
      var P220 = document.getElementById("220P").value;
      var P230 = document.getElementById("230P").value;
      var D230 = document.getElementById("230D").value;
      var P240 = document.getElementById("240P").value;
      var P250 = document.getElementById("250P").value;
      var P260 = document.getElementById("260P").value;
      var P270 = document.getElementById("270P").value;
      var P280 = document.getElementById("280P").value;
      var P290 = document.getElementById("290P").value;
      var D290 = document.getElementById("290D").value;
      var P300 = document.getElementById("300P").value;
      var P310 = document.getElementById("310P").value;
      var P320 = document.getElementById("320P").value;
      var D320 = document.getElementById("320D").value;
      var P330 = document.getElementById("330P").value;
      var P340 = document.getElementById("340P").value;
      var D340 = document.getElementById("340D").value;
      var P350 = document.getElementById("350P").value;
      var D350 = document.getElementById("350D").value;
      var P360 = document.getElementById("360P").value;
      var D360 = document.getElementById("360D").value;
      var P370 = document.getElementById("370P").value;
      var D370 = document.getElementById("370D").value;
      var P380 = document.getElementById("380P").value;
      var D380 = document.getElementById("380D").value;
      var P390 = document.getElementById("390P").value;
      var D390 = document.getElementById("390D").value;
      var P400 = document.getElementById("400P").value;
      var D400 = document.getElementById("400D").value;
      var P410 = document.getElementById("410P").value;
      var P420 = document.getElementById("420P").value;
      var D420 = document.getElementById("420D").value;
      var P430 = document.getElementById("430P").value;
      var P440 = document.getElementById("440P").value;
      var P450 = document.getElementById("450P").value;
      var P460 = document.getElementById("460P").value;
      var D460 = document.getElementById("460D").value;
      var P470 = document.getElementById("470P").value;
      var D470 = document.getElementById("470D").value;
      var P480 = document.getElementById("480P").value;
      var P490 = document.getElementById("490P").value;
      var P500 = document.getElementById("500P").value;
      var D500 = document.getElementById("500D").value;
      var P510 = document.getElementById("510P").value;
      var D510 = document.getElementById("510D").value;
      var P520 = document.getElementById("520P").value;
      var D520 = document.getElementById("520D").value;
      var P530 = document.getElementById("530P").value;
      var D530 = document.getElementById("530D").value;
      var P540 = document.getElementById("540P").value;
      var P550 = document.getElementById("550P").value;

      $.ajax({
        url: "insert_data_inventaire.php", // Le nom du script PHP qui insérera les données
        type: "POST",
        data: 'name=' + name + '&name2=' + collab + '&idVehicule=' + idVehicule + '&P10=' + P10 + '&D10=' + D10 + '&P20=' + P20 + '&D20=' + D20 + '&P30=' + P30 + '&D30=' + D30 + '&P40=' + P40 + '&D40=' + D40 + '&P50=' + P50 + '&D50=' + D50 + '&P60=' + P60 + '&P70=' + P70 + '&P80=' + P80 + '&D80=' + D80 + '&P90=' + P90 + '&P100=' + P100 + '&P110=' + P110 + '&P120=' + P120 + '&P130=' + P130 + '&P140=' + P140 + '&P150=' + P150 + '&P160=' + P160 + '&P170=' + P170 + '&P180=' + P180 + '&P190=' + P190 + '&P200=' + P200 + '&P210=' + P210 + '&P220=' + P220 + '&P230=' + P230 + '&D230=' + D230 + '&P240=' + P240 + '&P250=' + P250 + '&P260=' + P260 + '&P270=' + P270 + '&P280=' + P280 + '&P290=' + P290 + '&D290=' + D290 + '&P300=' + P300 + '&P310=' + P310 + '&P320=' + P320 + '&D320=' + D320 + '&P330=' + P330 + '&P340=' + P340 + '&D340=' + D340 + '&P350=' + P350 + '&D350=' + D350 + '&P360=' + P360 + '&D360=' + D360 + '&P370=' + P370 + '&D370=' + D370 + '&P380=' + P380 + '&D380=' + D380 + '&P390=' + P390 + '&D390=' + D390 + '&P400=' + P400 + '&D400=' + D400 + '&P410=' + P410 + '&P420=' + P420 + '&D420=' + D420 + '&P430=' + P430 + '&P440=' + P440 + '&P450=' + P450 + '&P460=' + P460 + '&D460=' + D460 + '&P470=' + P470 + '&D470=' + D470 + 'P480=' + P480 + '&P490=' + P490 + '&P500=' + P500 + '&D500=' + D500 + '&P510=' + P510 + '&D510=' + D510 + '&P520=' + P520 + '&D520=' + D520 + '&P530=' + P530 + '&D530=' + D530 + '&P540=' + P540 + '&P550=' + P550,
      });
      var delayInMilliseconds = 1000;
      setTimeout(function() {
        window.location = "roulant.php";
      }, delayInMilliseconds);
    }
  </script>

  <script>
    function sendDataToServerAmb(name, idVehicule) {
      var collab = $("#collaborateurAssu :selected").text();
      var P10 = document.getElementById("10P").value;
      var D10 = document.getElementById("10D").value;
      var P20 = document.getElementById("20P").value;
      var D20 = document.getElementById("20D").value;
      var P30 = document.getElementById("30P").value;
      var D30 = document.getElementById("30D").value;
      var P40 = document.getElementById("40P").value;
      var D40 = document.getElementById("40D").value;
      var P50 = document.getElementById("50P").value;
      var D50 = document.getElementById("50D").value;
      var P60 = document.getElementById("60P").value;
      var P70 = document.getElementById("70P").value;
      var P80 = document.getElementById("80P").value;
      var D80 = document.getElementById("80D").value;
      var P90 = document.getElementById("90P").value;
      var P100 = document.getElementById("100P").value;
      var P110 = document.getElementById("110P").value;
      var P120 = document.getElementById("120P").value;
      var P130 = document.getElementById("130P").value;
      var P140 = document.getElementById("140P").value;
      var P150 = document.getElementById("150P").value;
      var P160 = document.getElementById("160P").value;
      var P170 = document.getElementById("170P").value;
      var P180 = document.getElementById("180P").value;
      var P190 = document.getElementById("190P").value;
      var P200 = document.getElementById("200P").value;
      var D200 = document.getElementById("200D").value;
      var P210 = document.getElementById("210P").value;
      var P220 = document.getElementById("220P").value;
      var P230 = document.getElementById("230P").value;
      var P240 = document.getElementById("240P").value;
      var P250 = document.getElementById("250P").value;
      var P260 = document.getElementById("260P").value;
      var P270 = document.getElementById("270P").value;
      var D270 = document.getElementById("270D").value;
      var P280 = document.getElementById("280P").value;
      var P290 = document.getElementById("290P").value;
      var P300 = document.getElementById("300P").value;
      var P310 = document.getElementById("310P").value;
      var D310 = document.getElementById("310D").value;
      var P320 = document.getElementById("320P").value;
      var D320 = document.getElementById("320D").value;
      var P330 = document.getElementById("330P").value;
      var D330 = document.getElementById("330D").value;
      var P340 = document.getElementById("340P").value;
      var D340 = document.getElementById("340D").value;
      var P350 = document.getElementById("350P").value;
      var D350 = document.getElementById("350D").value;
      var P360 = document.getElementById("360P").value;
      var D360 = document.getElementById("360D").value;
      var P370 = document.getElementById("370P").value;
      var P380 = document.getElementById("380P").value;
      var D380 = document.getElementById("380D").value;
      var P390 = document.getElementById("390P").value;
      var D390 = document.getElementById("390D").value;
      var P400 = document.getElementById("400P").value;
      var D400 = document.getElementById("400D").value;
      var P410 = document.getElementById("410P").value;
      var D410 = document.getElementById("410D").value;
      var P420 = document.getElementById("420P").value;
      var P430 = document.getElementById("430P").value;
      var P440 = document.getElementById("440P").value;
      var P450 = document.getElementById("450P").value;
      var D450 = document.getElementById("450D").value;
      var P460 = document.getElementById("460P").value;
      var D460 = document.getElementById("460D").value;
      var P470 = document.getElementById("470P").value;
      var P480 = document.getElementById("480P").value;
 


      $.ajax({
        url: "insert_data_inventaire_amb.php", // Le nom du script PHP qui insérera les données
        type: "POST",
        data: 'name=' + name + '&name2=' + collab + '&idVehicule=' + idVehicule + '&P10=' + P10 + '&D10=' + D10 + '&P20=' + P20 + '&D20=' + D20 + '&P30=' + P30 + '&D30=' + D30 + '&P40=' + P40 + '&D40=' + D40 + '&P50=' + P50 + '&D50=' + D50 + '&P60=' + P60 + '&P70=' + P70 + '&P80=' + P80 + '&D80=' + D80 + '&P90=' + P90 + '&P100=' + P100 + '&P110=' + P110 + '&P120=' + P120 + '&P130=' + P130 + '&P140=' + P140 + '&P150=' + P150 + '&P160=' + P160 + '&P170=' + P170 + '&P180=' + P180 + '&P190=' + P190 + '&P200=' + P200 + '&D200=' + D200 + '&P210=' + P210 + '&P220=' + P220 + '&P230=' + P230 + '&P240=' + P240 + '&P250=' + P250 + '&P260=' + P260 + '&P270=' + P270 + '&D270=' + D270 + '&P280=' + P280 + '&P290=' + P290 + '&P300=' + P300 + '&P310=' + P310 + '&D310=' + D310 + '&P320=' + P320 + '&D320=' + D320 + '&P330=' + P330 + '&D330=' + D330 + '&P340=' + P340 + '&D340=' + D340 + '&P350=' + P350 + '&D350=' + D350 + '&P360=' + P360 + '&D360=' + D360 + '&P370=' + P370 + '&P380=' + P380 + '&D380=' + D380 + '&P390=' + P390 + '&D390=' + D390 + '&P400=' + P400 + '&D400=' + D400 + '&P410=' + P410 + '&D410=' + D410 + '&P420=' + P420 + '&P430=' + P430 + '&P440=' + P440 + '&P450=' + P450 + '&D450=' + D450 + '&P460=' + P460 + '&D460=' + D460 + '&P470=' + P470 + '&P480=' + P480,
      });
      var delayInMilliseconds = 1000;
      setTimeout(function() {
        window.location = "roulant.php";
      }, delayInMilliseconds);

    }
  </script>


  <script>
    function sendDataToServerVsl(name, idVehicule) {

      var collab = $("#collaborateurAssu :selected").text();
      var P10 = document.getElementById("10P").value;
      var D10 = document.getElementById("10D").value;
      var P20 = document.getElementById("20P").value;
      var D20 = document.getElementById("20D").value;
      var P30 = document.getElementById("30P").value;
      var P40 = document.getElementById("40P").value;
      var P50 = document.getElementById("50P").value;
      var P60 = document.getElementById("60P").value;
      var D60 = document.getElementById("60D").value;
      var P70 = document.getElementById("70P").value;
      var D70 = document.getElementById("70D").value;
      var P80 = document.getElementById("80P").value;
      var D80 = document.getElementById("80D").value;
      var P90 = document.getElementById("90P").value;
      var D90 = document.getElementById("90D").value;
      var P100 = document.getElementById("100P").value;
      var P110 = document.getElementById("110P").value;
      var P120 = document.getElementById("120P").value;
      var P130 = document.getElementById("130P").value;
      var P140 = document.getElementById("140P").value;
      var P150 = document.getElementById("150P").value;
      var P160 = document.getElementById("160P").value;
      var P170 = document.getElementById("170P").value;
      var P180 = document.getElementById("180P").value;
      var P190 = document.getElementById("190P").value;
      var P200 = document.getElementById("200P").value;
      var P210 = document.getElementById("210P").value;
      var P220 = document.getElementById("220P").value;
      var P230 = document.getElementById("230P").value;
      var P240 = document.getElementById("240P").value;
      var P320 = document.getElementById("320P").value;
      var P330 = document.getElementById("330P").value;
      
      $.ajax({
        url: "insert_data_inventaire_vsl.php", // Le nom du script PHP qui insérera les données
        type: "POST",
        data: 'name=' + name + '&name2=' + collab + '&idVehicule=' + idVehicule + '&P10=' + P10 + '&D10=' + D10 + '&P20=' + P20 + '&D20=' + D20 + '&P30=' + P30 + '&P40=' + P40 + '&P50=' + P50 + '&P60=' + P60 + '&D60=' + D60 + '&P70=' + P70 + '&D70=' + D70 + '&P80=' + P80 + '&D80=' + D80 + '&P90=' + P90 + '&D90=' + D90 + '&P100=' + P100 + '&P110=' + P110 + '&P120=' + P120 + '&P130=' + P130 + '&P140=' + P140 + '&P150=' + P150 + '&P160=' + P160 + '&P170=' + P170 + '&P180=' + P180 + '&P190=' + P190 + '&P200=' + P200 + '&P210=' + P210 + '&P220=' + P220 + '&P230=' + P230 + '&P240=' + P240 + '&P320=' + P320 + '&P330=' + P330,
      });

      var delayInMilliseconds = 1000;
      setTimeout(function() {
        window.location = "roulant.php";
      }, delayInMilliseconds);
    }
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  </body>


  </html>