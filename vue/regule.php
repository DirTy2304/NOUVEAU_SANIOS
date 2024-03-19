<?php 
ob_start();
session_start();
// attention la régule ne doit arriver que sur la page de SA societe 
if($_SESSION['fk_emploi'] != 3){
    header('location: ../index.php');
}
$userSociete = $_SESSION['fk_societe'];
require __DIR__. '/../vuemodel/ReguleVueModel.php';

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
  <title>REGULE</title>
</head>

<body>
  <header>

    <div class="px-3 py-2 bg-light text-dark">
      <div class="container">
        <div class="d-flex flex-wrap align-items-center my-2 justify-content-between mx-3">
          <div class="text-start">
            <ul class="nav col-12 col-lg-auto  text-small">
              <li class="nav-item pr-2">
                <h1>
                  <h1 class="text-primary">
                  <i class="fa-solid fa-star-of-life"></i>
                    <?php 
                  $names = nameFetch('societe');
                  foreach ($names as $key => $name): ?>
                    <?php if($key+11 == $_SESSION['fk_societe']) : ?>
                    <?=$name ?>
                    <?php endif; ?>
                    <?php endforeach; ?>
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

<nav class="navbar navbar-expand-lg navbar-light bg-light">


  <div class="navbar" id="navbarNavAltMarkup">
    <div class="navbar-nav flex-nowrap p-3">
    <a class="nav-link mx-5 "></a>

    <?php (isset($accueil) && $accueil == 2)? $activeNav = "bg-lightBlue" : $activeNav = ""; ?> 
    <a type="submit" class="nav-link mx-1 p-2  btn btn-outline-lightBlue <?=$activeNav ?>" href="../vue/reguleVehicules.php" >Voir les véhicules </a>
    <?php (isset($accueil) && $accueil == 1)? $activeNav = "bg-lightBlue" : $activeNav = ""; ?> 
    <a type="submit" class="nav-link mx-1 p-2 btn btn-outline-lightBlue <?=$activeNav ?>" href="../vue/reguleForm.php" >Modifier / Créer un véhicule </a>
   <?php if(isset($accueil) && $accueil=='QRCODE'):?>
  <p class="nav-link mx-1 p-2 btn btn-outline-lightBlue bg-lightBlue  "> Bienvenue sur le générateur de QR CODE </p>
  <?php endif ?> </div>
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


<?php

if(isset($accueil)): ?>
  <?php else : ?>

    <section id="banniere"> 
  <div id="blocg"> 
    
  
  <video class="video" loop autoplay muted> 
  <source src="media/images/sanios1.mp4" type="video/mp4">
  </video>

  
  </div>
   <!--<div id="blocd"> <h1 class="saniosTitle" data-target="SANIOS">SANIOS</h1></div>-->


</section>

<?php endif; ?>

<?php ob_end_flush(); ?>