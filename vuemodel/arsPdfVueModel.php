<?php
require __DIR__.'/../model/arsModel.php';


$vehicule = getDataVehicule($immatriculation);
$currentDate = date('d-m-Y');
$currentDateMinus5 = date('d-m-Y', strtotime($currentDate. ' - 5 week'));



/**
 * Function cleanString
 * @param string $str
 * @return string $str
 */
function cleanString($str)
{
    if(preg_match('/\d{4}-\d{2}-\d{2}/',$str)) {
        return $str;
    }else{
    $str = htmlspecialchars($str);
    $str = html_entity_decode(preg_replace('/&([a-zA-Z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);/i', '$1', htmlentities($str, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8');
    $str = trim(preg_replace('/[^A-Za-z]+/i', ' ', $str), '-');
    return $str;
    
}

}


$hygienesDatas = fetchLastHygiene($vehicule['id_vehicule'], $currentDate, $currentDateMinus5);





?>