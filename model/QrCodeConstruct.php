<?php
session_start();
$accueil='QRCODE';
if ($_SESSION['fk_emploi'] == 4){ 
    session_abort();
    require __DIR__."/../vue/gestionnaire.php";
};
if ($_SESSION['fk_emploi'] == 3){ 
    session_abort();
    require __DIR__."/../vue/regule.php"; };

include('../phpqrcode/qrlib.php');



$tempDir = '../vue/media/qrCode/';

if(isset($_POST['vehiculeId'])){
   $immatriculation = $_POST['vehiculeId'];
}else{
    $immatriculation = $_SESSION['newVehiculeImmat'];
}



/*********************************************************************************/
/*********************************************************************************/
/*********************************************************************************/
/********************** GENERATION DU QR CODE ROULANT  ***************************/
/*********************************************************************************/
/*********************************************************************************/
/*********************************************************************************/

$codeContentsRoulant = 'http://ambu17.com/nouveauSanios/index.php?alias='.$immatriculation;
// we need to generate filename somehow, 
// with md5 or with database ID used to obtains $codeContents...
$fileNameRoulant ='QrcodeIdRoulant'.$immatriculation.'.png';
$pngAbsoluteFilePathRoulant = $tempDir.$fileNameRoulant;

// generating
if (!file_exists($pngAbsoluteFilePathRoulant)) {
    QRcode::png($codeContentsRoulant, $pngAbsoluteFilePathRoulant, QR_ECLEVEL_L, 3);
} 



/*********************************************************************************/
/*********************************************************************************/
/*********************************************************************************/
/********************** GENERATION DU QR CODE ARS     ***************************/
/*********************************************************************************/
/*********************************************************************************/
/*********************************************************************************/


$codeContentsArs = 'http://ambu17.com/nouveauSanios/vue/ars.php?alias='.$immatriculation;
// we need to generate filename somehow, 
// with md5 or with database ID used to obtains $codeContents...
$fileNameArs = 'QrcodeIdARS'.$immatriculation.'.png';
$pngAbsoluteFilePathArs = $tempDir.$fileNameArs;

// generating
if (!file_exists($pngAbsoluteFilePathArs)) {
    QRcode::png($codeContentsArs, $pngAbsoluteFilePathArs, QR_ECLEVEL_L, 3);
} 

include('../vue/qrCodeGenerator.php');



?>
