<?php
session_start();
if($_SESSION['fk_emploi'] != 4) {
    header('location: ../index.php');
}

require('../vuemodel/gestionnaireVueModel.php');

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
    <title>Gestionnaire Header</title>
</head>
<body>
    

<div class="px-3 py-2 bg-light text-dark">
      <div class="container">
        <div class="d-flex flex-wrap align-items-center my-2 justify-content-between mx-3">
          <div class="text-start">
            <ul class="nav col-12 col-lg-auto  text-small">
              <li class="nav-item pr-2">
                <h1>
                <h1 class=" text-primary" > 
        <i class="fa-solid fa-star-of-life"></i>
        Bonjour <?=$_SESSION['nom']; ?> 
        </h1>
                  </h1>
                </h1>
              </li>
            </ul>
          </div>

          <div class="text-end"> 
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
              <input type="submit" class="btn btn-primary" name="deconnexion" value="Me deconnecter" />
            </form>
          </div>
        </div>
      </div>
    </div>
  </header>


<nav class="navbar navbar-expand-sm px-3 py-2 navbar-light bg-light">

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-around" id="navbarsExample03">
        <ul class="navbar-nav mr-auto w-90">
          <li class="nav-item active p-3">
      <?php (isset($accueil) && $accueil == 2)? $activeNav = "bg-lightBlue" : $activeNav = ""; ?> 
            <a class="nav-link btn btn-outline-lightGrey <?=$activeNav ?> " href="../vue/gestionnaireVehicules.php" > Voir tous les véhicules </a>
                     
          </li>
          <li class="nav-item p-3">
          <?php (isset($accueil) && $accueil == 1)? $activeNav = "bg-lightBlue" : $activeNav = ""; ?> 
            <a type="submit" class="nav-link  btn btn-outline-lightGrey <?=$activeNav ?>" href="../vue/gestionnaireForm.php" >Modifier / Créer un véhicule </a>

          </li>
          <li class="nav-item p-3">
          <?php (isset($accueil) && $accueil == 3)? $activeNav = "bg-lightBlue" : $activeNav = ""; ?> 
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <a type="submit" class="nav-link  btn btn-outline-lightGrey <?=$activeNav ?>" href="../vue/gestionnaireCession.php"  >Voir les véhicules cédés </a>
            </form>
          </li>
          <li class="nav-item p-3">
          <?php (isset($accueil) && $accueil == 4)? $activeNav = "bg-lightBlue" : $activeNav = ""; ?> 
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <a type="submit" class="nav-link  btn btn-outline-lightGrey <?=$activeNav ?>" href="../vue/gestionnairePersonnel.php" > Voir le personnel </a>
          </form>
          </li>
        </ul> 

      </div>




      
  <?php if(isset($accueil)): ?>
<?php if($accueil == 2): ?>
  <div class="container mx-5 w-40 justify-content-end">
    <div class="row ">
        <div class="col-md-2 bg-white border rounded mt-2 mb-1 w-30"></div>
        <div class="col-md-10 p-2"> Véhicule conforme </div>
        <div class="col-md-2 bg-warning border rounded p-2 mt-2 mb-1 w-30"></div>
        <div class="col-md-10 p-2"> Véhicule localisé hors de votre sociétée </div>
        <div class="col-md-2 bg-danger border rounded mt-2 mb-1 w-30 "></div>
        <div class="col-md-10 p-2"> Date du controle technique à venir <small>( sous 15 Jours )</small> </div>
        <div class="col-md-2 bg-dark border rounded mt-2 mb-1 w-30 "></div>
        <div class="col-md-10 p-2"> Date du controle technique dépassé </div>
    </div>
</div>
<div class="container w-40 justify-content-end">
    <div class="row ">
        <div class="col-md-2 bg-lightGreen border rounded mt-2 mb-1 w-30"></div>
        <div class="col-md-10 p-2"> Entretien effectué </div>
        <div class="col-md-2 bg-lightYellow border rounded p-2 mt-2 mb-1 w-30"></div>
        <div class="col-md-10 p-2"> Aucune donnée valide </div>
        <div class="col-md-2 bg-lightRed border rounded mt-2 mb-1 w-30 "></div>
        <div class="col-md-10 p-2"> Entretien à effectuer en urgence  </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>
</nav>




    </nav>

  

   <?php if(isset($accueil)): ?>
    
  <?php else : ?>

  <section id="banniere"> 
  <div id="blocg"> 
  <video autoplay muted> 
  <source src="media/images/sanios1.mp4" type="video/mp4">
  </video>
  
  </div>



</section>

<?php endif; ?>