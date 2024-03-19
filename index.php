<?php
ob_start();
include('vuemodel/indexVueModel.php');
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>SANIOS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vue/media/css/breakpointIndex.css">
</head>
<body> 

<div class="container my-5">
    <div class="row ">
        <div id="cadre" class="card"> 
    <!-- Switch : permet d'afficher un formulaire relatif uniquement au statut selectionné. -->
    <?php

     switch ($profil) :
     
        case 0 :?>
        
        <!-- Case 0 indique qu'aucun statut n'as été selectionné.  -->
            <div class="card-body">
              <img src="vue/media/images/logo.jpg" width="900" height="200" alt="logo" class="img-fluid" id="logo">
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class=" m-5" method="post">
               <div class="form-group" id="form_index">
              
                <label for="nom" class="card-text"> VOTRE NOM </label>
                <input type="text" class="card-text form-control mb-2" name="nom" id="nom" placeholder="NOM">
                <label for="birthdate" class="card-text js-date"> VOTRE DATE DE NAISSANCE </label>
                <input type="date" class="card-text form-control mb-2" maxlength="10" name="birthdate" id="birthdate">
                <input type="submit" class="btn btn-primary mt-3" name="send" value="Envoyer">  
              
        ,     </form>
          <?php if (isset($_GET['erreur']) && $_GET['erreur']=="login" ) 
		             {
                        echo "<p></p><p><b>Indentifiants invalides</b></p>";
					  } ?></div>
            <?php break; 

            case 1: ?>
            <!-- Case 1 indique que le statut ROULANT à été identifié.  -->

           <?php  
		              if (!empty($_POST['birthdate'])){
					  redirectProfil($_POST['birthdate'],'roulant');}
					  else {
						  
						   if (!empty($_SESSION['date_naissance'])){
					  redirectProfil($_SESSION['date_naissance'],'roulant');}
					  }
							 


        break;

        case 2 : ?>
        <!-- Case 2 indique que le statut MECANICIEN à été identifié.  -->
        <div class="card-body">
         <img src="vue/media/images/logo.jpg" width="900" height="200" alt="logo" class="img-fluid" id="logo">
         <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class=" m-5" method="post">
        <div class="form-group" id="form_index">
         <h2 class="my-3 card-title">MECANICIEN</h2>
         <h4><?= $_SESSION['nom'] ?>&nbsp;<?= $_SESSION['prenom'] ?></h4>
         <label for="password" class="card-text"> VOTRE MOT DE PASSE </label>
         <input type="password" class="card-text form-control" name="password" id="password">
         <input type="submit" class="btn btn-primary mt-3" name="validatemecanicien" value="Valider">
        </form>
        </div>
            <?php

        if(isset($_POST['validatemecanicien'])){ 
            redirectProfil($_POST['password'],'mecanicien');
        }
    ?>
            <?php break;

        case 3 : ?>
        <!-- Case 3 indique que le statut REGULE à été identifié.  -->
        <div class="card-body">
        <img src="vue/media/images/logo.jpg" width="900" height="200" alt="logo" class="img-fluid" id="logo">
         <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class=" m-5" method="post">
        <div class="form-group" id="form_index">
         <h2 class="card-title">REGULATION</h2>
         <h4><?= $_SESSION['nom'] ?>&nbsp;<?= $_SESSION['prenom'] ?></h4>
        </br>
         <label for="password" class="card-text"> VOTRE MOT DE PASSE </label>
         <input type="password" class="card-text form-control" name="password" id="password">
         <input type="submit" class="btn btn-primary mt-3" name="validateregule" value="envoyer">
        </form>
        </div>
         <?php
             if(isset($_POST['validateregule'])){ 
                redirectProfil($_POST['password'],'regule');
            }
         break;

        case 4 : ?>
        <!-- Case 4 indique que le statut GESTIONNAIRE à été identifié.  -->
        <div class="card-body">
        <img src="vue/media/images/logo.jpg" width="900" height="200" alt="logo" class="img-fluid" id="logo">
         <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class=" m-5" method="post">
         <div class="form-group" id="form_index">
        <h2 class="card-title">GESTIONNAIRE</h2>
        <h4><?= $_SESSION['nom'] ?>&nbsp;<?= $_SESSION['prenom'] ?></h4>
         </br>
        <label for="password" class="card-text"> VOTRE MOT DE PASSE </label>
         <input type="password" class="card-text form-control" name="password" id="password">
         <input type="submit" class="btn btn-primary mt-3" name="validateGestionnaire" value="envoyer">
        </form>
        </div>
         <?php 
                      if(isset($_POST['validateGestionnaire'])){ 
                        redirectProfil($_POST['password'],'gestionnaire');
                    }
                    break; ?>
    <?php endswitch; ?>

        </div>
            </form>
        </div>
        </div>
</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script><script  src="./script.js"></script>
</body>


</html>
<?php ob_end_flush(); ?>