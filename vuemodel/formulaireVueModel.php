<?php

require ('../model/formulaireModel.php');

if ($_SESSION['fk_emploi'] == 3) {
    $redirectPath = 'reguleForm.php';
}
if ($_SESSION['fk_emploi'] == 4) {
    $redirectPath = 'gestionnaireForm.php';
}


/**
* Function cleanStringForm
* @param string $str
* @param string $format
* @return string $str
*/
function cleanStringForm($str){
    $str = htmlspecialchars($str);
    if(preg_match ('/^[A-Z]{2}+[0-9]{3}+[A-Z]{2}+$/', $str)) {
        return $str;
    }else{
        return false; }
}

/*********************************************************************************************/
/*********************************************************************************************/
/**********************************   MODIFIER UN VEHICULE EXISTANT  *************************/
/*********************************************************************************************/
/*********************************************************************************************/

 if (isset($_POST['modify'])) {
     if($_POST['alias']!='Selectionner votre véhicule'){
    $currentAlias =  $_POST['alias'];

    $currentVehicule = getVehiculeData($currentAlias);
    $marques = nameFetch('marque');
    $modeles = nameFetch('modele');
    $societes = nameFetch('societe');
    $types = nameFetch('type');
    $_SESSION['alias'] = $currentVehicule['ancien_id'];
    //$inventairePosition = getSocieteById($currentVehicule['fk_inventaire_position']);
    
    
    $immatriculationFalse = "";
    
    }else{

    ($_SESSION['fk_emploi'] == 3) ? header('location:reguleForm.php') : header('location:gestionnaireForm.php');
   
}
 }



if (isset($_POST['modifyGestionnaire'])) {


$plaqueImmatriculation = $_POST['plaqueImmatriculation'];

   if (cleanStringForm($plaqueImmatriculation) == false){
    $immatriculationFalse = " bg-danger ";
    }else{ 

$immatriculationFalse = "";
$alias = $_SESSION['alias'];
    if ($_SESSION['fk_emploi'] == 3){
        $societe =$_SESSION['fk_societe'];
    } else { 
        $societeStr = $_POST['societe'];
        $societe = (getSocieteByName($societeStr));
    }

$marqueStr = $_POST['marque'];
$marque = getMarqueByName($marqueStr);
$modeleStr = $_POST['modele'];
$modele = getModeleByName($modeleStr);
$typeStr = $_POST['type'];
$type = getTypeByName($typeStr);

    //if ($_SESSION['fk_emploi'] == 3){
    //    $inventairePosition = getInventairePosition($alias);
   // }else{ 
    //    $inventairePositionStr = trim($_POST['inventairePosition']);
    //    $inventairePosition = getSocieteByName($inventairePositionStr);
   // }

$datemisecirculation = $_POST['datemisecirculation'];
$cessionStr = $_POST['cession'];
($cessionStr == "En activité") ? $cession = 0 : $cession = 1 ;

 updateVehicule(
     $Emploi = $_SESSION['fk_emploi'],
     $alias, 
 ($_SESSION['fk_emploi'] == 3) ? $societe : $societe['id_societe'], 
    $marque, 
    $modele, 
    $type, 
    $plaqueImmatriculation, 
    //($_SESSION['fk_emploi'] == 3) ? $inventairePosition['fk_inventaire_position'] : $inventairePosition['id_societe'], 
    $datemisecirculation, 
    $cession
);

}
}


/*********************************************************************************************/
/*********************************************************************************************/
/***********************************  CREER UN VEHICULE **************************************/
/*********************************************************************************************/
/*********************************************************************************************/
/*********************************************************************************************/


if (isset($_POST['create'])) {
    //Si le profil est celui du gestionnaire
if ( $_SESSION['fk_emploi'] == 4) {
        if($_POST['marqueCreate']!='Selectionner une marque' && $_POST['societeCreate']!='Selectionner une societée' ){

            $_SESSION['createCurrentSociete'] = $_POST['societeCreate'];
            $_SESSION['marqueVehicule'] = $_POST['marqueCreate'];
            $modeles = getModelByMarque($_POST['marqueCreate']);

            $societes = nameFetch('societe');
            $types = nameFetch('type');
            $currentDate = date('Y-m-d');


        }else{
    
            ($_SESSION['fk_emploi'] == 3) ? header('location:reguleForm.php') : header('location:gestionnaireForm.php');
            
    
    }
} else {
    $modeles = getModelByMarque($_POST['marqueCreate']);
    $types = nameFetch('type');
    $currentDate = date('Y-m-d');
    $_SESSION['marqueVehicule'] = $_POST['marqueCreate'];

}
}



if(isset($_POST['createGestionnaire'])){

    if ($_SESSION['fk_emploi'] == 3){
        $societe =$_SESSION['fk_societe'];
        $marque =  getMarqueByName($_SESSION['marqueVehicule']);
       
    }else{
        $societeStr= $_SESSION['createCurrentSociete'];
        $societe = getSocieteByName($societeStr); 
        $marqueStr = trim($_SESSION['marqueVehicule']);
        $marque = getMarqueByName($marqueStr);
    }
        
        // CHECK ALIAS IN BDD
        $alias = htmlspecialchars(trim($_POST['alias']));
        $fetchDoublon = getAliasDoublon($alias);
        $checkDoublon = ($fetchDoublon == $alias )?true:false;
        if ($checkDoublon == false) {
            echo "<div class='text-center my-5 py-3'";
           echo "<h2 class='mt-5 text-center mx-auto h3 '> ERREUR ALIAS EXISTANT <h2>";
           echo "<br/>";
           echo "<a class='btn btn-secondary h3 mx-auto' href=".$redirectPath."> Retourner sur mon profil </a>";
           echo "</div>";
        }

        $modeleStr = trim($_POST['modele']);
        $modele = getModeleByName($modeleStr);
        $typeStr = trim($_POST['type']);
        $type = getTypeByName($typeStr);
    
        $immatriculation= htmlspecialchars($_POST['plaqueImmatriculation']);

        if ($_SESSION['fk_emploi'] == 3){
            $inventaire = $societe;
        }else{ 
            $inventaire = trim($_POST['inventairePosition']);
            $inventaire = getSocieteByName($inventaire);
        }
    
        $dateMiseCirculation= $_POST['datemisecirculation'];
        $dateControleTechnique= $_POST['dateControleTechnique'];
        
        $kilometrage= htmlspecialchars($_POST['kilometrage']);

    if (strlen($dateControleTechnique) == 0 || strlen($dateControleTechnique) > 10 ) {
            $dateControleTechnique = '2000-01-01';
        }
        if ($dateMiseCirculation == '') {
            $dateMiseCirculation = "2000-01-01";
        }

        $Emploi =  $_SESSION['fk_emploi'];
 
        $validate = false;
        if ($_SESSION['fk_emploi'] == 3 &&  $checkDoublon != false){
        $validate = insertIntoVehicule(
                $Emploi,
                $societe,
               $marque['id_marque'],
                $modele['id_modele'],
                $type['id_type'],
                $immatriculation,
                $inventaire,
                $dateMiseCirculation,
                $dateControleTechnique,
                $kilometrage,
                $alias
        );
        }elseif ($_SESSION['fk_emploi'] == 4 &&  $checkDoublon != false){
        $validate = insertIntoVehicule(
                $Emploi,
                $societe['id_societe'],
                $marque['id_marque'],
                $modele['id_modele'],
                $type['id_type'],
                $immatriculation,
                $inventaire['id_societe'],
                $dateMiseCirculation,
                $dateControleTechnique,
                $kilometrage,
                $alias
            );
        }




    /** CREATION DU QR CODE :  */
    
    if ( $validate == true) {
        $_SESSION['newVehiculeImmat'] = $immatriculation;
        header('location: ../model/QrCodeConstruct.php');
    }else{
        header('location: ../vue/erreur.php');
    }


}



?>
