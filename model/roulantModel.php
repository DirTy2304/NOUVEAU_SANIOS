<?php
require 'connexion.php';

function dataVehiculeFetch($alias)
{
    $bd = connectBd();
    $sql = $bd->prepare("SELECT * FROM sanios_vehicule
     INNER JOIN sanios_modele ON sanios_vehicule.fk_modele = sanios_modele.id_modele INNER JOIN sanios_marque ON sanios_vehicule.fk_marque = sanios_marque.id_marque
     WHERE plaque = :alias
     ");
    $sql->bindParam('alias', $alias, PDO::PARAM_STR);
    $sql->execute();
    $retourSql = $sql->fetch(PDO::FETCH_ASSOC);
    return $retourSql;
}

function typeHygieneFetch($hygiene)
{
    $bd = connectBd();
    $sql = $bd->prepare("SELECT id_hygiene_type FROM sanios_hygiene_type WHERE nom = :hygiene ");
    $sql->bindParam('hygiene', $hygiene);
    $sql->execute();
    $retournSql = $sql->fetch(PDO::FETCH_ASSOC);
    return $retournSql;
}

/** FUNCTION HYGIENES */

/**
 * createHygiene function
 *
 * @param [int] $fkVehicule
 * @param [int] $fkUser
 * @param [date] $dateDuJour
 * @param [int] $fkUserSociete
 * @param [int] $fkVehiculeSociete
 * @param [int] $type
 */
function createHygiene($fkVehicule, $fkUser, $dateDuJour, $fkUserSociete, $fkVehiculeSociete, $type)
{
    $bd = connectBd();
    $sql = $bd->prepare("INSERT INTO sanios_hygiene 
    (id_entretien, fk_vehicule, fk_user, date, fk_user_societe, fk_vehicule_societe, fk_type) 
    VALUES (NULL, :fkVehicule, :fkUser, :dateDuJour , :fkUserSociete , :fkVehiculeSociete, :fkType ) ");
    $sql->bindParam('fkVehicule', $fkVehicule);
    $sql->bindParam('fkUser', $fkUser);
    $sql->bindParam('dateDuJour', $dateDuJour);
    $sql->bindParam('fkUserSociete', $fkUserSociete);
    $sql->bindParam('fkVehiculeSociete', $fkVehiculeSociete);
    $sql->bindParam('fkType', $type);

    $sql->execute();


?>
    <div id="ModalValidate" class="modal_Box">
        <!-- Modal content -->
        <div class="modalInside display-5">
            <p>Merci d'avoir validé votre hygiène</p>
            <div class="iconSucess"> <i class="fa-solid fa-circle-check"></i> </div>
        </div>
        </br>
        <button class="btn btn-primary w-100 btn-lg btn-block" id="bouton_fermer">Fermer</button>
    </div>

<?php
}
/** FUNCTION INVENTAIRE */

function getIdUser($user)
{
    $bd = connectBd();
    $sql = $bd->prepare("SELECT id_user from sanios_utilisateur where nom = :user ");
    $sql->bindParam('user', $user);
    $sql->execute();
    $retourSql = $sql->fetch(PDO::FETCH_ASSOC);
    return $retourSql;
}

// Fonction véhicule type AMBULANCE
function dataNameAmbuInventaire()
{
    $bd = connectBd();
    $sql = $bd->prepare("SELECT distinct ambuList.nom, ambuList.quantite, ambuList.id_produit, ambuList.peremption FROM `sanios_liste_inventaire_ambu` as ambuList ");
    $sql->execute();
    $retourSql = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $retourSql;
}

function dataInventaireAmbuVehicule($idVehicule)
{
    $bd = connectBd();
    $sql = $bd->prepare("SELECT * FROM `sanios_inventaire_ambu` WHERE `fk_id_vehicule` = :idVehicule ORDER BY  id_inventaire DESC");
    $sql->bindParam('idVehicule', $idVehicule);
    $sql->execute();
    $retourSql = $sql->fetch(PDO::FETCH_ASSOC);
    return $retourSql;
}

function getInventaireAmbu($idProduit, $idVehicule)
{
    $produit = $idProduit . 'P';
    $datePeremption = $idProduit . 'D';
    $vehiculeInventaire = dataInventaireambuVehicule($idVehicule);
    $tab = [];
    if ($vehiculeInventaire == false) {
        $tab[0] = null;
        $tab[1] = null;
    } else {
        $tab[0] = $vehiculeInventaire[$produit];
        if (isset($vehiculeInventaire[$datePeremption])) {
            $tab[1] = $vehiculeInventaire[$datePeremption];
        } else {
            $tab[1] = null;
        }
    }
    return $tab;
}

// Fonctions véhicule type ASSU
function dataNameAssuInventaire()
{
    $bd = connectBd();
    $sql = $bd->prepare("SELECT distinct assuList.nom, assuList.quantite, assuList.id_produit, assuList.peremption FROM `sanios_liste_inventaire_assu` as assuList");
    $sql->execute();
    $retourSql = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $retourSql;
}

function dataInventaireAssuVehicule($idVehicule)
{
    $bd = connectBd();
    $sql = $bd->prepare("SELECT * FROM `sanios_inventaire_assu` WHERE `fk_id_vehicule` = :idVehicule ORDER BY  id_inventaire DESC");
    $sql->bindParam('idVehicule', $idVehicule);
    $sql->execute();
    $retourSql = $sql->fetch(PDO::FETCH_ASSOC);
    return $retourSql;
}







function getInventaireAssu($idProduit, $idVehicule)
{
    $produit = $idProduit . 'P';
    $datePeremption = $idProduit . 'D';
    $vehiculeInventaire = dataInventaireAssuVehicule($idVehicule);
    $tab = [];
    if ($vehiculeInventaire == false) {
        $tab[0] = null;
        $tab[1] = null;
    } else {
     // Vérifier si les clés existent avant de les utiliser
     if (isset($vehiculeInventaire[$produit])) {
        $tab[0] = $vehiculeInventaire[$produit];
    } else {
        // Traitez le cas où la clé du produit est absente
        $tab[0] = null;
    }

    if (isset($vehiculeInventaire[$datePeremption])) {
        $tab[1] = $vehiculeInventaire[$datePeremption];
    } else {
        // Traitez le cas où la clé de la date de péremption est absente
        $tab[1] = null;
    }
    }
    return $tab;
}

//Fonctions véhicule type VSL

function dataNameVslInventaire()
{
    $bd = connectBd();
    $sql = $bd->prepare("SELECT distinct vslList.nom, vslList.quantite, vslList.id_produit, vslList.peremption FROM `sanios_liste_inventaire_vsl` as vslList ");
    $sql->execute();
    $retourSql = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $retourSql;
}

function dataInventaireVslVehicule($idVehicule)
{
    $bd = connectBd();
    $sql = $bd->prepare("SELECT * FROM `sanios_inventaire_vsl` WHERE `fk_id_vehicule` = :idVehicule ORDER BY  id_inventaire DESC");
    $sql->bindParam('idVehicule', $idVehicule);
    $sql->execute();
    $retourSql = $sql->fetch(PDO::FETCH_ASSOC);
    return $retourSql;
}

function getInventaireVsl($idProduit, $idVehicule)
{
    $produit = $idProduit . 'P';
    $datePeremption = $idProduit . 'D';
    $vehiculeInventaire = dataInventaireVslVehicule($idVehicule);

    $tab = [];
    if ($vehiculeInventaire == false) {
        $tab[0] = null;
        $tab[1] = null;
    } else {
        // Vérifier si les clés existent avant de les utiliser
        if (isset($vehiculeInventaire[$produit])) {
            $tab[0] = $vehiculeInventaire[$produit];
        } else {
            // Traitez le cas où la clé du produit est absente
            $tab[0] = null;
        }

        if (isset($vehiculeInventaire[$datePeremption])) {
            $tab[1] = $vehiculeInventaire[$datePeremption];
        } else {
            // Traitez le cas où la clé de la date de péremption est absente
            $tab[1] = null;
        }
    }
    return $tab;
}


function  roulantNameFetch($SocieteCurrentUser)
{
    $bd = connectBd();
    $sql = $bd->prepare("SELECT nom from sanios_utilisateur where fk_societe = :idsociete AND fk_emploi = 1");
    $sql->bindParam('idsociete', $SocieteCurrentUser);
    $sql->execute();
    $retourSql = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $retourSql;
}

function updateEntretien($data, $idVehicule, $dateActuelle, $fkUser, $collaborateur, $typeVehicule)
{

    try {
        $bd = connectBd();
        $dataString = '';
        foreach ($data as $inner) {
            foreach ($inner as $key => $value) {
                if (substr($key, -1) == 'D') {
                    $tempD = '`' . $key . '`' . "=" . "'" . $value . "'";
                } else {
                    $tempP = '`' . $key . '`' . "=" . $value;
                }
            }

            $dataString = $dataString . ',' . $tempD . ',' . $tempP;
        }

        $tableName = 'sanios_inventaire_' . $typeVehicule;
        $debutString = "date_inventaire = " . "'" . $dateActuelle . "'" . ', fk_id_user = ' . $fkUser . ", fk_id_user2 = " . $collaborateur . $dataString;
        $sql = $bd->prepare("UPDATE `$tableName` SET $debutString  WHERE `fk_id_vehicule` = :idVehicule");
        $sql->BindParam('idVehicule', $idVehicule);
        $sql->execute();
    } catch (PDOException $e) {
        return "some fail-messages";
    }
}


/** CONDUITE (0 -> debut et 1->fin ) */

function createConduite($user, $vehicule, $conduite, $latitude, $longitude)
{

    $bd = connectBd();
    $sql = $bd->prepare("INSERT INTO sanios_conduite (`id`, `fk_user`, `fk_vehicule`, `date`, `conduite` , 'latitude' , 'longitude' ) VALUES (NULL, :user , :vehicule ,CURRENT_TIMESTAMP, :conduite , :latitude, :longitude ) ");
    $sql->bindParam('user', $user, PDO::PARAM_INT);
    $sql->bindParam('vehicule', $vehicule, PDO::PARAM_INT);
    $sql->bindParam('conduite', $conduite, PDO::PARAM_BOOL);
    $sql->execute();
}

?>