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
    if ($_POST['alias'] != 'Selectionner votre véhicule') {
        $currentAlias = $_POST['alias'];
        $currentVehicule = getVehiculeData($currentAlias);
        $marques = nameFetch('marque');
        $modeles = nameFetch('modele');
        $societes = nameFetch('societe');
        $types = nameFetch('type');
        $_SESSION['alias'] = $currentVehicule['ancien_id'];
        $_SESSION['currentVehicule'] = $currentVehicule; // Stocker les données actuelles du véhicule dans la session
        $immatriculationFalse = "";
    } else {
        ($_SESSION['fk_emploi'] == 3) ? header('location:reguleForm.php') : header('location:gestionnaireForm.php');
    }
}

if (isset($_POST['modifyGestionnaire'])) {
    if (!isset($_SESSION['currentVehicule'])) {
        die("Les données du véhicule ne sont pas disponibles.");
    }

    $currentVehicule = $_SESSION['currentVehicule'];
    $alias = $_SESSION['alias'];
    
    // Utiliser les valeurs existantes si le champ est vide
    $plaqueImmatriculation = !empty($_POST['plaqueImmatriculation']) ? $_POST['plaqueImmatriculation'] : $currentVehicule['plaque'];
    $datemisecirculation = !empty($_POST['datemisecirculation']) ? $_POST['datemisecirculation'] : $currentVehicule['date_mise_circulation'];
    $cessionStr = isset($_POST['cession']) ? $_POST['cession'] : ($currentVehicule['cession'] == 0 ? "En activité" : "A céder");
    $cession = ($cessionStr == "En activité") ? 0 : 1;

    // Récupérer la société
    if ($_SESSION['fk_emploi'] == 3) {
        $societe = $_SESSION['fk_societe'];
    } else {
        $societeStr = !empty($_POST['societe']) ? $_POST['societe'] : $currentVehicule['societe_nom'];
        $societe = getSocieteByName($societeStr);
    }

    // Récupérer la marque
    $marqueStr = !empty($_POST['marque']) ? $_POST['marque'] : $currentVehicule['marque_nom'];
    $marque = getMarqueByName($marqueStr);

    // Récupérer le modèle
    $modeleStr = !empty($_POST['modele']) ? $_POST['modele'] : $currentVehicule['modele_nom'];
    $modele = getModeleByName($modeleStr);
    if (!$modele) {
        die("Modèle invalide ou inexistant");
    }

    // Récupérer le type
    $typeStr = !empty($_POST['type']) ? $_POST['type'] : $currentVehicule['type_nom'];
    $type = getTypeByName($typeStr);
    if (!$type) {
        die("Type invalide ou inexistant");
    }

    try {
        updateVehicule(
            $Emploi = $_SESSION['fk_emploi'],
            $alias,
            $_SESSION['fk_emploi'] == 3 ? $societe : $societe['id_societe'],
            $marque,
            $modele,
            $type,
            $plaqueImmatriculation,
            $datemisecirculation,
            $cession
        );
        unset($_SESSION['currentVehicule']); // Supprimer les données du véhicule après la mise à jour
    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour : " . $e->getMessage());
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
