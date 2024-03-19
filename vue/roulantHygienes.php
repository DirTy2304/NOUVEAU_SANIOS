<?php
$accueil = 1;
require __DIR__.'/roulant.php';

?>



  <div class="container mb-5">
    <div class="row ">
  <div class="card" style="text-align: center;"> 
  <form class="col-md-12" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
   
      <div class="container bg-whiteBlue px-0">
  <div class="row ">

    <div class="col-12 bg-whiteBlue">
          <ul class="list-group bg-whiteBlue list-group-flush h4">
              <li class="list-group-item bg-whiteBlue h5"> Véhicule <?= $datasVehicule['ancien_id'] ?> </li>
              <li class="list-group-item bg-whiteBlue h5 ">Modèle : <?= $datasVehicule['marque_nom'] ?> <?= $datasVehicule['modele_nom'] ?></li>
              <li class="list-group-item bg-whiteBlue h5"> Immatriculation : <?= $datasVehicule['plaque'] ?> </li>
              <li class="list-group-item bg-whiteBlue h5"> Date du jour : <?= strftime('%d/%m/%Y',strtotime($dateDuJour)) ?> </li>
          </ul>
          </div>

</div>
</div>

<div class="container"  >
  <div class="row">

    <div id="bouton" class="col-md-12" style="display:block;/* text-align: center; */margin-left: auto;margin-right: auto;">
  <div id="tab_hygiene" class="form-radio h3  my-3">
    <div class="h2  w-100 p-4 my-3 rounded"> Types d'Hygiènes </div>
<div class="d-flex mt-2 align-items-start flex-nowrap" >
    <input type="radio" class=" pt-2 btn-check w-100 " value="Nettoyage Extérieur" id="nettoyageE" name="typeHygiene" >
    <label class="btn btn-outline-primary mb-2 w-100 " for="nettoyageE">Nettoyage Exterieur </label>
</div>
<div class="d-flex mt-2 align-items-start flex-nowrap">
    <input type="radio" class=" pt-2 btn-check w-100 " value="Nettoyage Intérieur" id="nettoyageI" name="typeHygiene" >
    <label class="btn btn-outline-primary mb-2 w-100 " for="nettoyageI">Nettoyage Interieur </label>
</div>
    <div class="d-flex mt-2 align-items-start flex-nowrap" >
    <input type="radio" class=" pt-2 btn-check w-100 " value="Désinfection courante" id="desinfectionC" name="typeHygiene" for="radioDesinfection">
    <label class="btn btn-outline-primary mb-2 w-100 " for="desinfectionC">Desinfection Courante</label></div>

    <div class="d-flex mt-2 align-items-start flex-nowrap" >
    <input type="radio" class=" pt-2 btn-check w-100 " value="Désinfection approfondie" id="desinfectionA" name="typeHygiene" for="radioDesinfection">
    <label class="btn btn-outline-primary  mb-2 w-100 " for="desinfectionA">Desinfection Approfondie</label></div>

  </div>
    </div>
	    <div id="ok" class="col-md-12" style="display:none;">
  <div id="tab_hygiene" class="form-radio h3  my-3">
    <div class="h2  w-100 p-4 my-3 rounded">Desinfection / Nettoyage enregistrée</div>
  </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-12">
    <button type="button" class="btn btn-primary" onclick="checkValidation()">Je Valide</button>
    </div>
</div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  
<div class="modal-dialog" role="document">
    <div class="modal-content">
      
     
<div class="modal-header">

<h5 class="modal-title" id="exampleModalLabel">Validation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        
       
</button>
      
</div>

<div class="modal-body">
        Etes vous sur de vouloir valider ?
</div>
<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="submit" name="sendHygiene" id="btnvalid" class="btn btn-primary my-3 w-50 px-5" value="valid" >Valider</button>
</div>
</div>
</div>



<script>
/** Création d'une modale avec des évènements au click. Ajout d'un texte spécifique à l'action effectuée dans la modale.  */
var modale = document.getElementById("ModalValidate");
var fermer = document.getElementById('bouton_fermer');
fermer.addEventListener('click', function(){
  modale.classList.add("hidden"); 
});
function checkValidation() {
    var typeHygieneElements = document.getElementsByName('typeHygiene');
    var selectedTypeHygiene = false;

    for (var i = 0; i < typeHygieneElements.length; i++) {
      if (typeHygieneElements[i].checked) {
        selectedTypeHygiene = true;
        break;
      }
    }

    if (!selectedTypeHygiene) {
      // Aucun type d'hygiène sélectionné, afficher un message
      alert("Aucun élément sélectionné. Veuillez choisir un nettoyage ou une désinféction ");
      return false;
    }

    // Au moins un type d'hygiène est sélectionné, ouvrir la modale
    $('#exampleModal').modal('show');
  }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>