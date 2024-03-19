<?php 
$accueil = 1;
require('regule.php');
?>



<form class="mt-3" method="POST" action="formulaire.php">


<div class="container w-100 mx-auto my-3">
  <div class="row text-center">

    <div class="col-md-6">


    <div class="card pb-4 w-100" style="width: 18rem;">
 <h1 class="display-6 bg-blueWhite p-2 "> Modifier un véhicule </h1>
  <div class="card-body pt-5 ">



  <select class="form-select "  name="alias" aria-label="Alias">
  <option selected> Selectionner votre véhicule </option>
                                        <?php foreach ($getAllInfos as $getInfo): ?>
                                        <option value="<?=$getInfo['ancien_id']?>"> <?=$getInfo['ancien_id']?> - <?=$getInfo['marque_nom']?> - <?=$getInfo['modele_nom']?>
                                        </option>
                                        <?php endforeach; ?>
  </select>
  </div>
  <div class="pb-4 pt-4 card-footer bg-white border-0 text-end">  
     <input class="btn btn-secondary" type="submit" value="Selectionner" name="modify"> </div>

</div>
    </div>

  <div class="col-md-6">



<div class="card pb-4 w-100" style="width: 18rem;">
<h1 class="display-6 bg-blueWhite p-2 "> Créer un véhicule </h1>
<div class="card-body pt-5 ">
<div class="col-md-12 ">

<select class="form-select ms-1 " required  name="marqueCreate" aria-label="marque">
<option selected> Selectionner une marque </option>
                                        <?php foreach ($marques as $marque): ?>
                                        <option value="<?=$marque?>"> <?=$marque?> </option>
                                        <?php endforeach; ?>
                              
                            </select>
                        
                        </div>

</div>
<div class="pb-4 pt-4 card-footer bg-white border-0 text-end">   <input class="btn btn-secondary" type="submit" value="Création de véhicule"
                                name="create"></div>

</div>


</div>
</div>

</div>
</div>
</form>






































<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>