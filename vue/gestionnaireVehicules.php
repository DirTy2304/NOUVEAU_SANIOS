<?php
$accueil = 2;
 require __DIR__.'/gestionnaire.php';

 ?>

<div class="accordion m-4" id="accordionExample">

    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <div class="p-3 text-primary bg-blueWhite" >
            
                <h2> Véhicules   - 
            <?php  if ($idSociete != 0) : ?>
           <?php $retourVehicule = getVehicules($idSociete); ?><?=$retourVehicule[0]['societe_nom']?> <?php else: ?> 
           <?php  $retourVehicule = getVehicules(11); ?> <?=$retourVehicule[0]['societe_nom']?><?php endif ?></h2>
               
            </button>
            </div>
        </h2>
        <div id="collapseVehicules" class="accordion-collapse collapse show" aria-labelledby="headingOne"
            data-bs-parent="#accordionExample">
            <div class="accordion-body">

                <!-- accordion navbar : voir tous les véhicules  -->
                <div class="container m-0 p-0" style="max-width: 100%;">
                    <div class="row mx-auto">
                        <nav class="navbar mx-auto navbar-expand-lg navbar-light bg-light">

                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                <div class="collapse justify-content-around navbar-collapse "
                                    id="navbarSupportedContent">
                                    <ul class="navbar-nav ">
                                        <li class="nav-item active ">
                                            <input type="submit" name="tableauBord" class="btn btn-secondary mx-3"
                                                value="Tableau de Bord">
                                            <span class="sr-only">(current)</span></input>
                                        </li>
                                        <li class="nav-item dropdown ">
                                            <button class="btn btn-secondary mx-3 dropdown-toggle" href="#"
                                                id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                societées
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <?php foreach ($societes as $societe): ?>
                                                <input type="submit" value="<?=$societe['societe_nom']?>"
                                                    id="<?=$societe['id_societe']?>" class="dropdown-item"
                                                    name="societeLabel">
                                                <?php endforeach; ?>


                                            </div>
                            </form>

                            </ul>
                            <form class="form-inline d-inline-flex p-2 bd-highlight " method="POST"
                                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                <input class="form-control " type="search" name="searchVehiculeByAliasInput" placeholder="Chercher par Alias" aria-label="Search">
                                <button class="btn btn-outline-success " name="searchVehiculeByAlias" type="submit">Chercher</button>
                            </form>
                    </div>
                    </nav>
                </div>


                <!-- InnerCollapse -->

                <!-- accordion : voir tous les véhicules  -->

                <div class="container mb-4 mw-100 m-1 text-center">
                    <div class="row gx-1 w-100 mb-2 h4">


                        <div class="col-lg-3 col-md-12 ">Alias</div>
                        <div class="col-lg col-md-4">Véhicule</div>
                        <div class="col-lg col-md-4">Immatriculation</div>
                        <div class="col-lg col-md-4">societé</div>
                        <div class="col-lg col-md-4"> QRcode </div>

                        <div class="col-lg col-md-4"> </div>


                    </div>


                    <?php

                    
          if ($idSociete != 0) {
            $retourVehicule = getVehicules($idSociete);
          }else if (isset($_POST['searchVehiculeByAlias'])) {
            if(!empty($_POST['searchVehiculeByAliasInput'])){
      
                    
                     $cleanAlias =  $_POST['searchVehiculeByAliasInput'];
                     $cleanAlias = strtoupper($cleanAlias);
                     $cleanAlias =trim($cleanAlias);
                     $cleanAlias = htmlspecialchars($cleanAlias);
        
                     if(count(getVehiculeByAlias($cleanAlias))!=0){
                        $retourVehicule = getVehiculeByAlias($cleanAlias);
                     } else {
                        $retourVehicule = getVehicules(11);
                     }
             
            }
          }else{ $retourVehicule = getVehicules(11);}
          

        foreach ($retourVehicule as $vehicule) : ?>

      <?php  


if (file_exists('media/qrCode/QrcodeIdRoulant'.$vehicule['plaque'].'.png')) {
     unlink('media/qrCode/QrcodeIdRoulant'.$vehicule['plaque'].'.png');
    unlink('media/qrCode/QrcodeIdARS'.$vehicule['plaque'].'.png');
}

?>

                    <?php $warningLocation = getVehiculeLocation($vehicule['fk_societe'], $vehicule['id_vehicule']); ?>
                    <?php if($warningLocation != ""){
            $WarningSociete = $warningLocation[1];
            $warningMessage = $warningLocation[0];
          } else { $warningMessage=false; }?>


<?php 


?>




                    <?php $warningControlTechnique = getControleTechnique($vehicule['id_vehicule']);
            $WarningDateTechnique = $warningControlTechnique[1];
            $warningMessageTechnique = $warningControlTechnique[0]; ?>



                    <div class="row border-top w-100 p-2  <?=$warningMessage ?> <?=$warningMessageTechnique ?>"
                        data-bs-toggle="collapse" data-bs-target="#collapseVehicule<?=$vehicule['id_vehicule']?>"
                        aria-expanded="false" aria-controls="collapseVehicule<?=$vehicule['id_vehicule']?>"
                        id="CollapseBar">



                        <div class="col-lg-3 col-md-12">
                            <?= $vehicule['ancien_id'] ?> </br>
                        </div>

                        <div class="col-lg col-md-4">
                            <?= $vehicule['marque_nom'] ?>
                        </div>

                        <div class="col-lg col-md-4">
                            <?= $vehicule['plaque'] ?>
                        </div>

                        <div class="col-lg col-md-4">
                            <?= $vehicule['societe_nom'] ?>
                        </div>


                            <div class="col-lg col-md-4 h4 ">
                                <form method="POST" action="../model/QrCodeConstruct.php">
                                <button type="submit" name="qrCodeShow" class="btn btn-primary">
                                <input type="hidden" value="<?=  $vehicule['plaque'];?>" name="vehiculeId">
                                <i class="fa-solid fa-qrcode "></i>
                                </button>
                                </form>
                                </div>


                                <div id="btnCollapse" class="col-lg col-md-4">
                            <i class="fa-solid fa-circle-plus text-secondary h2"></i>
                            <i class="fa-solid fa-circle-minus text-secondary h2"></i>
                        </div>

                    </div>

                    <div class="container mw-100 m-1 collapse" id="collapseVehicule<?=$vehicule['id_vehicule']?>">
                        <div class="row gx-1 w-100">


                            <div class="col-md-6 bg-light mb-2">

                                <!-- Informations sur le véhicule : Hygiene et Entretient -->
                                <h3 class="h3 text-align-center my-3 "> Hygienes </h3>
                                <?php 
                                $desinfectionApprofondie = hygieneDataVehicule('Désinfection approfondie',$vehicule['id_vehicule']);
                                $desinfectionCourante = hygieneDataVehicule('Désinfection courante',$vehicule['id_vehicule']);
                                $nettoyageExterieur =  hygieneDataVehicule('Nettoyage Extérieur',$vehicule['id_vehicule']);
                                $nettoyageInterieur =  hygieneDataVehicule('Nettoyage Intérieur',$vehicule['id_vehicule']);
                                ?>
                                <div class="row gx-1 mt-1 mb-1   w-100">
                                    <div class="col-lg-4 col-md-12">
                                        Désinfection approfondie
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <?php echo ($desinfectionApprofondie) ? $desinfectionApprofondie['nom'] : "N/A"; ?>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <?php //echo ($desinfectionApprofondie) ? $desinfectionApprofondie['heure'] : "N/A"; ?>
                                    </div>
                                </div>


                                <div class="row gx-1 mt-1 mb-1   w-100">
                                    <div class="col-lg-4 col-md-12">
                                        Désinfection courante
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <?php echo ($desinfectionCourante) ? $desinfectionCourante['nom'] : "N/A"; ?>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <?php //echo ($desinfectionCourante) ? $desinfectionCourante['heure'] : "N/A"; ?>
                                    </div>
                                </div>

                                <div class="row gx-1 mt-1 mb-1 w-100">
                                    <div class="col-lg-4 col-md-12">
                                        Nettoyage Extérieur
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <?php echo ($nettoyageExterieur) ? $nettoyageExterieur['nom'] : "N/A"; ?>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <?php //echo ($nettoyageExterieur) ? $nettoyageExterieur['heure'] : "N/A"; ?>
                                    </div>
                                </div>
                                <div class="row gx-1 mt-1 mb-1 w-100">
                                    <div class="col-lg-4 col-md-12">
                                        Nettoyage Intérieur
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <?php echo ($nettoyageInterieur) ? $nettoyageInterieur['nom'] : "N/A"; ?>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <?php //echo ($nettoyageInterieur) ? $nettoyageInterieur['heure'] : "N/A"; ?>
                                    </div>
                                </div>


                                <!--Entretien -->

                                <h3 class="h3 text-align-center bg-white pt-2 my-3"> Entretiens </h3>



                                <?php 
                                $vidange = entretienDataVehicule('Vidange',$vehicule['id_vehicule']);
                                $distribution = entretienDataVehicule('Distribution',$vehicule['id_vehicule']);
                                $carrosserie =  entretienDataVehicule('Carrosserie',$vehicule['id_vehicule']);
                                $parebrise =  entretienDataVehicule('Pare brise',$vehicule['id_vehicule']);
                                $plaquetteFreins =  entretienDataVehicule('Plaquettes de freins',$vehicule['id_vehicule']);
                                $disqueFreins =  entretienDataVehicule('Disque de freins',$vehicule['id_vehicule']);

                                $warningVidange = warningEntretien($vehicule['id_vehicule'],"Vidange");
                                $warningDistrib = warningEntretien($vehicule['id_vehicule'],"Distribution");
                                $warningCarrosserie = warningEntretien($vehicule['id_vehicule'],"Carrosserie");
                                $warningParebrise = warningEntretien($vehicule['id_vehicule'],"Pare brise");
                                $warningPlaquette = warningEntretien($vehicule['id_vehicule'],"Plaquettes de freins");
                                $warningDisque = warningEntretien($vehicule['id_vehicule'],"Disque de freins");
                                ?>
                                <div class="row gx-1 mt-1 mb-1 <?=$warningVidange ?>  w-100">
                                    <div class="col-lg-3 col-md-12 h6">
                                        Vidange
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <?php echo ($vidange) ? $vidange['nom'] : "N/A"; ?>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <?php echo ($vidange) ? $vidange['heure'] : "N/A"; ?>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <?php echo ($vidange) ? $vidange['autre'] : "N/A"; ?>
                                    </div>
                                </div>


                                <div class="row gx-1 mt-1 mb-1 <?=$warningDistrib ?>   w-100">
                                    <div class="col-lg-3 col-md-12 h6">
                                        Distribution
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <?php echo ($distribution) ? $distribution['nom'] : "N/A"; ?>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <?php echo ($distribution) ? $distribution['heure'] : "N/A"; ?>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <?php echo ($distribution) ? $distribution['autre'] : "N/A"; ?>
                                    </div>
                                </div>

                                <div class="row gx-1 mt-1 mb-1 <?=$warningCarrosserie ?> w-100">
                                    <div class="col-lg-3 col-md-12 h6">
                                        Carrosserie
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <?php echo ($carrosserie) ? $carrosserie['nom'] : "N/A"; ?>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <?php echo ($carrosserie) ? $carrosserie['heure'] : "N/A"; ?>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <?php echo ($carrosserie) ? $carrosserie['autre'] : "N/A"; ?>
                                    </div>

                                </div>
                                <div class="row gx-1 mt-1 <?=$warningParebrise ?> mb-1 w-100">
                                    <div class="col-lg-3 col-md-12 h6">
                                        Pare Brise
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <?php echo ($parebrise) ? $parebrise['nom'] : "N/A"; ?>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <?php echo ($parebrise) ? $parebrise['heure'] : "N/A"; ?>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <?php echo ($parebrise) ? $parebrise['autre'] : "N/A"; ?>
                                    </div>
                                </div>

                                <div class="row gx-1 mt-1 <?=$warningPlaquette ?> mb-1 w-100">
                                    <div class="col-lg-3 col-md-12 h6">
                                        Plaquette de Freins
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <?php echo ($plaquetteFreins) ? $plaquetteFreins['nom'] : "N/A"; ?>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <?php echo ($plaquetteFreins) ? $plaquetteFreins['heure'] : "N/A"; ?>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <?php echo ($plaquetteFreins) ? $plaquetteFreins['autre'] : "N/A"; ?>
                                    </div>

                                </div>
                                <div class="row gx-1 mt-1 <?=$warningDisque ?> mb-1 w-100">
                                    <div class="col-lg-3 col-md-12 h6">
                                        Disque de Freins
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <?php echo ($disqueFreins) ? $disqueFreins['nom'] : "N/A"; ?>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <?php echo ($disqueFreins) ? $disqueFreins['heure'] : "N/A"; ?>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <?php echo ($disqueFreins) ? $disqueFreins['autre'] : "N/A"; ?>
                                    </div>

                                </div>


                            </div>


                            <div class="col-md-6 border-left">
                                <?php if ($warningLocation):?>
                                <div class="col-md-4 display-1 text-danger mx-auto pt-4">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </div>

                                <div class="h3 mx-auto pt-4 col-md-8">
                                    Le véhicule se trouve : <?=$WarningSociete ; ?>
                                </div>
                                <?php endif; ?>

                                <?php if ($warningMessageTechnique):?>
                                <div class="col-md-4 display-1 text-danger mx-auto pt-4">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </div>

                                <?php endif; ?>

                                <div class="h3 mx-auto pt-4 col-md-8">
                                    Date du prochain controle Technique <?=$WarningDateTechnique; ?>
                                </div>
                            </div>


                        </div>
                    </div>

                    <?php endforeach; ?>
                </div>





            </div>
        </div>
    </div>
    <script>
    var btnWarning = document.getElementById('warning');
    var selectWarning = document.querySelectorAll('#CollapseBar');
    btnWarning.addEventListener('click', function(){
        for(var i = 0; i < selectWarning.length; i++){
            if(selectWarning.classList.contains('bg-danger')){
                selectWarning.classList.add('hidden'); }
            if(selectWarning.classList.contains('bg-dark')){
                selectWarning.classList.add('hidden');}
            if(selectWarning.classList.contains('bg-white')){
                selectWarning.classList.add('hidden');}}
                    });
    </script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>