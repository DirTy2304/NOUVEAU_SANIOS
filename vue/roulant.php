<?php
session_start();
if ($_SESSION['fk_emploi'] != 1) {
  header('location: ../index.php');
}
require __DIR__ . '/../vuemodel/roulantVueModel.php';

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-latest.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="media/css/asset.css">

  <title>Sanios - Ambulancier</title>
</head>

<body id="cadre">


  <header>
    <div class="container bg-lightBlue text-dark pt-2">
      <div class="row ">

        <div class="col-12">
          <div class="row mb-4 ">



            <div class="col-12 mb-4">
              <div class="row text-center">
                <h1> Bonjour <?= $_SESSION['nom'] ?> <?= $_SESSION['prenom'] ?> </h1>
              </div>
            </div>


            <div class="d-flex justify-content-evenly">

              <div>
                <?php if (isset($accueil)) : ?>
                  <a href="roulant.php"> <i class="fa fa-solid fa-arrow-left h2 border rounded px-4 py-2 bg-light text-primary"></i></a>
                <?php endif; ?>
              </div>


              <div>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                  <input type="submit" class="p-2 btn btn-light text-primary" name="deconnexion" value="Me deconnecter" />
                </form>

              </div>
            </div>



          </div>

        </div>
      </div>

    </div>
    </div>
  </header>


  <?php if (isset($accueil)) : ?>
  <?php else : ?>

    <div class="container mt-5 w-90">
      <form method="POST" class="delimiter" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="row justify-content-center">

          <div class="col-12 m-auto mt_2" style="text-align: center;">
            <label>Renseigner un nettoyage / une desinfection<label>
                <button class="btn btn-primary w-100 btn-lg btn-block" id="bouton" name="roulantHygienes">NETTOYAGE / DESINFECTION</button>
          </div>

        </div>

        <div class="row justify-content-center mt-5">

          <div class="col-12 m-auto" style="text-align: center;">
            <label> Renseigner l'inventaire du matériel <label>
                <a href="roulantInventaire.php" class="btn btn-primary w-100 btn-lg btn-block" id="bouton" name="roulantMateriel">INVENTAIRE</a>
          </div>

          <div class="row justify-content-center mt-5">

          <div class="col-12 m-auto mt_2" style="text-align: center;">
            <label>Pour déclarer une panne ou une casse<label>
                <a href="roulantSignalement.php" class="btn btn-primary w-100 btn-lg btn-block" id="bouton" name="roulantMateriel">SIGNALEMENT VEHICULE</a>
          </div>


        </div>

        <div class="row bg-whiteBlue pb-4 justify-content-around mt-5">
          <span class="border-bottom"></span>
          <label class="bg-lightBlue mb-4 ">
            <h2 class="h2  py-2 text-center">Conduite</h2>
          </label>






          <div class="col-6 mt-2">
            <!-- 0 correspond à un début de conduite   -->
            <button type="button" class="btn btn-primary p-1 w-100" id="btnDebut" onclick="getGeoLocation('début', <?php echo $datasVehicule['id_vehicule']; ?> , <?php echo  $_SESSION['id_user']; ?> ) ">Début</button>
          </div>

          <div class="col-6 mt-2">
            <!-- 1 correspond à une fin de conduite   -->
            <button type="button" class="btn btn-primary p-1 w-100" id="btnFin" onclick="getGeoLocation('fin',<?php echo $datasVehicule['id_vehicule']; ?> , <?php echo  $_SESSION['id_user']; ?> )">Fin</button>
          </div>







          <!-- The Modal -->

          <div id="ModalValidate" class="modal_Box hidden">
            <!-- Modal content -->
            <div class="modalInside display-5">
              <p>Merci d'avoir validé votre <span id="innerText"> </span> de conduite </p>
              <div class="iconSucess"> <i class="fa-solid fa-circle-check"></i> </div>

            </div>

          </div>


        </div>

      </form>
    </div>



    <script>
      /** Création d'une modale avec des évènements au click. Ajout d'un texte spécifique à l'action effectuée dans la modale.  */
      /*
      var modale = document.getElementById("ModalValidate");
      var StartToggle = document.getElementById('btnDebut');
      var EndToggle = document.getElementById('btnFin');
      var innerText = document.getElementById("innerText");

      StartToggle.addEventListener('click', function(){
        modale.classList.toggle("hidden");
        var textBox = " début ";
        innerText.innerHTML = textBox;

        setTimeout(() => {modale.classList.toggle("hidden");	}, 1000); 
      });

      EndToggle.addEventListener('click', function(){
        modale.classList.toggle("hidden");
        var textBox= " fin ";
        innerText.innerHTML = textBox;
        setTimeout(() => {modale.classList.toggle("hidden");	}, 1000); 
      });
      */
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

    <script>
      function getGeoLocation(action, vehicule, id_user) {
        if ("geolocation" in navigator) {
          if (action == "début") {
            var etat = "0";
          } else {
            var etat = "1";
          }
          navigator.geolocation.getCurrentPosition(function(position) {
            // Récupérer les coordonnées de latitude et de longitude
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            // Afficher les coordonnées
            console.log("Latitude : " + latitude);
            console.log("Longitude : " + longitude);

            // Envoyer les coordonnées au serveur (vous pouvez personnaliser cette partie)
            sendDataToServer(latitude, longitude, etat, vehicule, id_user);
          });
        }
      }


      function sendDataToServer(latitude, longitude, etat, vehicule, id_user) {
        $.ajax({
          url: "insert_data.php", // Le nom du script PHP qui insérera les données
          type: "POST",
          data: 'longitude=' + longitude + '&latitude=' + latitude + '&etat=' + etat + '&vehicule=' + vehicule + '&id_user=' + id_user,
        });
      }
    </script>
</body>

</html>


<?php endif; ?>