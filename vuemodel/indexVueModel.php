<?php
session_start();
(isset($_SESSION['fk_emploi']) && $_SESSION) ? $profil = $_SESSION['fk_emploi'] : $profil = 0;
$format = ['MAJUSCULE','MINUSCULE'];

/** Récupération de l'alias si existant ( arrivée via QR Code ) */
if (isset($_GET['alias'])) {
    $_SESSION['aliasQr'] = $_GET['alias'];
}


/**
 * Function cleanString
 * @param string $str
 * @param string $format
 * @return string $str
 */
function cleanString($str, $format)
{
    $str = htmlspecialchars($str);
    $str = html_entity_decode(preg_replace('/&([a-zA-Z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);/i', '$1', htmlentities($str, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8');
    $str = trim(preg_replace('/[^A-Za-z]+/i', '-', $str), '-');
    if ($format == "MAJUSCULE") {
        $str =  mb_strtoupper($str);
    } else {
        $str = mb_strtolower($str);
    }
    return $str;
}

/** 
 * Function redirectProfil
 * @param string $pwd
 * @param string $profil
 * @return string 
 * 
**/
function redirectProfil($pwd,$profil){
    if($profil != 'roulant'){
    //hash du password recu : 
    	$pwd = htmlspecialchars($pwd);
    	$pwd = hash('sha256', $pwd);   
	
   		 //comparatif du mdp pour validation et redirection: 
   			 if($pwd == $_SESSION['mdp']){
       			 return header('location:vue/'.$profil.'.php');
   			 } else {
       			 echo "<p>Votre mot de passe est incorrect</p>";
        		return;
  			  }
    }
    else{
    //verification de la date de naissance 
   		 if($pwd == $_SESSION['date_naissance']){	 
     		  return header('location:vue/'.$profil.'.php');
      	 } 
	      
     }
}
	 
	 
	 
		  
		  
		  
		  
		  

/* recuperation des données du formulaire et appel à la fonction cleanString() */
if (isset($_POST["send"])) {
    if (!empty($_POST["nom"]) && !empty($_POST["birthdate"])) {
        require __DIR__.'/../model/indexModel.php';
        $name =  cleanString($_POST['nom'], $format[0]);
        $birthday =  $_POST['birthdate'];
        //Appel de BDD 
        $userData = IndexFetch($name,$birthday);

     		 if($userData) { 
       		 //Lancement de la session
     		 $_SESSION['logged'] = true;
     		 //Données de Session
     		 $_SESSION['id_user'] = $userData['id_user'];
     		 $_SESSION['nom'] = $userData['nom'];
     		 $_SESSION['prenom'] = $userData['prenom'];
     		 $_SESSION['mdp'] = $userData['mdp'];
     		 $_SESSION['date_naissance'] = $userData['date_naissance'];
     		 $_SESSION['fk_societe'] = $userData['fk_societe'];
    		 $_SESSION['fk_emploi'] = $userData['fk_emploi'];
    		 $_SESSION['statut'] = $userData['statut'];
    		 $profil =  $_SESSION['fk_emploi'];
     		}
  
   	        else {
             // $_SESSION = array();
              //session_destroy();
			   		if (!empty($_SESSION['aliasQr'])){
			 				 return header('location:index.php?erreur=login&alias='.$_SESSION['aliasQr']);
					}
					else {
							return header('location:index.php?erreur=login');
					}
        
             }
}

}
?>