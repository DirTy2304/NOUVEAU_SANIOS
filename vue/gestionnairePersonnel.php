<?php
$accueil = 4;
 require_once('gestionnaire.php');
 ?>

<div class="accordion-item">
      <h2 class="accordion-header">
      <div class="p-3 text-primary bg-blueWhite" >
            
            <h2> Personnel  </h2>
        </div>
      </h2>
      <div id="collapsePersonnel" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo"
        data-bs-parent="#accordionExample">
        <div>


          <!-- accordion navbar : voir liste du personnel  -->




          <div class="container m-0 p-0" style="max-width: 100%;">
            <div class="row mx-auto">
              <nav class="navbar mx-auto navbar-expand-lg navbar-light bg-light">

                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                  <div class="collapse justify-content-around navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ">
                      <li class="nav-item active ">
                        <input type="submit" name="tableauBordPersonnel" class="btn btn-secondary mx-3"
                          value="Tableau de Bord"> <span class="sr-only">(current)</span></input>
                      </li>
                      <li class="nav-item dropdown ">
                        <button class="btn btn-secondary mx-3 dropdown-toggle" href="#" id="navbarDropdown"
                          role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Personnel
                        </button>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                          <input type="submit" value="Hygiène" class="dropdown-item bg-whiteBlue mb-2" name="hygieneLabel">
                          <input type="submit" value="Mecanicien" class="dropdown-item bg-primary text-white" name="mecanicienLabel">
                          <input type="submit" value="Régule" class="dropdown-item bg-blue text-white mt-2" name="reguleLabel">
                        </div>

                      </li>
                      <li class="nav-item dropdown ">
                      <button class="btn btn-secondary mx-3 dropdown-toggle" href="#" id="navbarDropdown"
                          role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Societées
                        </button>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <?php foreach ($societes as $societe): ?>
                                                <input type="submit" value="<?=$societe['societe_nom']?>"
                                                    id="<?=$societe['id_societe']?>" class="dropdown-item"
                                                    name="societeLabel">
                                                <?php endforeach; ?>

                      </li>
                </form>

                </form>

                </ul>
                <form class="form-inline d-inline-flex p-2 bd-highlight " method="POST"
                  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                  <input class="form-control " type="search" name='searchPersonnelByNameInput'
                    placeholder="Rechercher par Nom" aria-label="Chercher">
                  <button class="btn btn-outline-secondary" name="searchPersonnelByName" type="submit">Chercher</button>
                </form>
            </div>

            </nav>
          </div>


          <!-- accordion navbar : Fin de la navbar   -->
          <!---------------------------------------------------------------------->
          <!---------------------------------------------------------------------->
          <!---------------------------------------------------------------------->
          <!---------------------------------------------------------------------->



          <div class="col-12">
            <div class="container mb-4 mw-100 m-1 text-center">
              <div class="row gx-1 w-100 mb-2 h4 ">

                <div class="col-lg-2 col-md-12"> Profil </div>
                <div class="col-lg-2 col-md-6"> Nom </div>
                <div class="col-lg-2 col-md-6"> Prenom </div>
                <div class="col-lg-2 col-md-6"> Societe </div>
                <div class="col-lg-2 col-md-6"> </div>

              </div>
            </div>
          </div>

          <?php 
foreach ($personnels as $personnel): ?>
          <?php $nbrHygienes = getNbrHygienes($personnel['id_user']); ?>
          <div class="col-12">
            <div class="container mw-100 m-1 text-center">
              <div class="row border-top w-100 p-2 " data-bs-toggle="collapse"
                data-bs-target="#collapsePersonnel<?=$personnel['id_user']?>" aria-expanded="false"
                aria-controls="collapsePersonnel<?=$personnel['id_user']?>" id="CollapseBar">


<?php 
/** code couleur */ 

($personnel['emploi_nom']=='AMBULANCIER') ? $colorEmploi = "text-whiteBlue" : '' ;
($personnel['emploi_nom']=='REGULATION') ? $colorEmploi = "text-blue" : '' ;
($personnel['emploi_nom']=='MECANICIEN') ? $colorEmploi = "text-primary" : '' ;  

($personnel['emploi_nom']=='AMBULANCIER') ? $IconPersonnel = "<i class='fa-solid fa-truck-medical'></i>" : '' ;
($personnel['emploi_nom']=='REGULATION') ? $IconPersonnel = "<i class='fa-solid fa-headphones-simple'></i>" : '' ;
($personnel['emploi_nom']=='MECANICIEN') ? $IconPersonnel = "<i class='fa-solid fa-screwdriver-wrench'></i>" : '' ;   ?>

                <div class="col-lg-2 col-md-12 d-flex ms-4 flex-nowrap justify-content-start"> 
                  <p class=" ms-5 boxEmploi <?= $colorEmploi ?>" ><?= $IconPersonnel ?></p> 
                  <p class="ms-4"><?=$personnel['emploi_nom'] ?> </p> 
                </div>
                <div class="col-lg-2 col-md-6"> <?=$personnel['nom'] ?> </div>
                <div class="col-lg-2 col-md-6"> <?=$personnel['prenom'] ?> </div>
                <div class="col-lg-2 col-md-6"> <?=$personnel['societe_nom'] ?> </div>

                <div id="btnCollapse" class="col-lg-2 col-md-6">
                  <i class="fa-solid fa-circle-plus text-secondary h2"></i>
                  <i class="fa-solid fa-circle-minus text-secondary h2"></i>
                </div>

              </div>


              <div class="container bg-whiteBlue  pb-4  py-3 mw-100 m-1 collapse" id="collapsePersonnel<?=$personnel['id_user']?>">
                <div class="row ">
                  <?php if($personnel['emploi_nom'] == "AMBULANCIER") : ?>
                  <?php 
                 ($nbrHygienes == false)? $nbrH = 0 :   $nbrH = $nbrHygienes['count(fk_user)']  ;  ?>
              
                   
                  <div class="col-lg-4 col-md-12"> <strong> Hygienes effectuées sur le mois passé : </strong> </div>
                  <div class="col-lg-2 col-md-6"> <?=$nbrH ?> hygiènes </div>
                  <?php endif; ?>
                </div>


                <?php if($personnel['emploi_nom'] == "MECANICIEN") : ?>
                  <?php 
                  $nbrVidange = getEntretienNbr($personnel['id_user'],1); // 1 = VIDANGE
                  $nbrDistribution = getEntretienNbr($personnel['id_user'],2); // 2 = DISTRIBUTION
                  $nbrCarosserie = getEntretienNbr($personnel['id_user'],3); // 3 = CAROSSERIE
                  $nbrPareBrise = getEntretienNbr($personnel['id_user'],4); // 4 = PARE BRISE
                  $nbrPlaquette = getEntretienNbr($personnel['id_user'],5); // 5 = PLAQUETTES DE FREINS 
                  $nbrDisques = getEntretienNbr($personnel['id_user'],6); // 6 = DISQUES DE FREINS

                 ($nbrVidange == false)? $nbrEV = 0 :   $nbrEV = $nbrVidange['count(id_mecanique)']  ;  
                  ($nbrDistribution == false)? $nbrED = 0 :   $nbrED = $nbrDistribution['count(id_mecanique)']  ;  
                  ($nbrCarosserie == false)? $nbrEC = 0 :   $nbrEC = $nbrCarosserie['count(id_mecanique)']  ; 
                  ($nbrPareBrise == false)? $nbrEPb = 0 :   $nbrEPb = $nbrPareBrise['count(id_mecanique)']  ;  
                  ($nbrPlaquette == false)? $nbrEPl = 0 :   $nbrEPl = $nbrPlaquette['count(id_mecanique)']  ;  
                  ($nbrDisques == false)? $nbrEDs = 0 :   $nbrEDs = $nbrDisques['count(id_mecanique)']  ;  ?>


                  <div class="row ">
                  <div class="col-md-6">
  <h6> Nombres de vidanges effectuées sur le dernier mois : </h6>
                  </div>

                  <div class="col-md-4">
                  <?=$nbrEV ?>
                  </div>

                  </div>
                   
                  <div class="row ">
                  <div class="col-md-6">
  <h6> Nombres de Distributions effectuées sur le dernier mois : </h6>
                  </div>

                  <div class="col-md-4">
                  <?=$nbrED ?>
                  </div>

                  </div> <div class="row ">
                  <div class="col-md-6">
  <h6> Nombres de réparassions de Carosseries effectuées sur le dernier mois : </h6>
                  </div>

                  <div class="col-md-4">
                  <?=$nbrEC ?>
                  </div>

                  </div> <div class="row ">
                  <div class="col-md-6">
  <h6> Nombres de réparations de  Pare Brises effectuées sur le dernier mois : </h6>
                  </div>

                  <div class="col-md-4">
                  <?=$nbrEV ?>
                  </div>

                  </div> <div class="row ">
                  <div class="col-md-6">
  <h6> Nombres de remplacements de Plaquettes effectuées sur le dernier mois : </h6>
                  </div>

                  <div class="col-md-4">
                  <?=$nbrEPl ?>
                  </div>

                  </div> <div class="row ">
                  <div class="col-md-6">
  <h6> Nombres remplacements de disques de freins effectuées sur le dernier mois : </h6>
                  </div>

                  <div class="col-md-4">
                  <?=$nbrEDs ?>
                  </div>

                  </div>


                  <?php endif; ?>
                </div>


              </div>


            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>