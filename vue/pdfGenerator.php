<?php
require('../fpdf184/fpdf.php');


$pathRoulant= $_GET['roulantpath'];
$pathARS = $_GET['arspath'];
$immatriculation = $_GET['id'];


class PDF extends FPDF
{
// En-tête
function Header()
{
    // Police Arial gras 15
    $this->SetFont('Arial','B',15);
    // Décalage à droite
    $this->Cell(70);
    // Titre
    $this->Cell(40,15,'SANIOS',1,0,'C');
    // Saut de ligne
    $this->Ln(20);
}

// Pied de page
function Footer()
{
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    // Police Arial italique 8
    $this->SetFont('Arial','I',8);
    // Numéro de page
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

}

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',14);
$pdf->Image($pathRoulant,40,40);
$pdf->Image($pathARS,130,40);

$pdf->SetMargins(40,0,0); 
$pdf->Ln(0);
$pdf->Cell(100,90,$immatriculation,0);
$pdf->Cell(10,90,$immatriculation,0);
$pdf->Ln(5); // saut de ligne 10mm
$pdf->Cell(100,90,'ROULANT',0);
$pdf->Cell(100,90,'ARS',0);


$pdf->Output();


?>