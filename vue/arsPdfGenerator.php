<?php
ob_start(); 
require('../fpdf184/fpdf.php');


 $immatriculation = $_GET['immatriculation'];
 require __DIR__.'/../vuemodel/arsPdfVueModel.php';
// faire tourner une requette pour récup tout 


class PDF extends FPDF
{
// En-tête
function Header()
{


    $currentDate = date('Y-m-d');
    $actualYear = date('Y');
    $date_test = $currentDate;
    $good_format=strtotime ($date_test);
    $semaineNum = date('W',$good_format);
    // Logo
    $this->Image('../vue/media/images/SaniosLogo.png',10,6,50);
    // Police Arial gras 15
    $this->Ln(20);
    $this->SetFont('Arial','B',14, true);
    // Décalage à droite
    $this->Cell(80);
    // Titre
    $this->Cell(30,10,'Desinfection des vehicules',0,0,'C');
    // Saut de ligne
    $this->Ln(5);
    $this->SetFont('Arial','B',12, true);
    $this->Cell(80);
    $this->Cell(30,10,'Semaine : ' .$semaineNum . ' - Annee : ' . $actualYear ,0,0,'C');
    // Saut de ligne
    $this->Ln(20);
}

// Pied de page
function Footer()
{
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    // Police Arial italique 8
    $this->SetFont('Arial','I',8, true);
    // Numéro de page
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

function BasicTable($header, $data)
{
    // En-tête
    foreach($header as $col)
        $this->Cell(63,10,$col,1);
        $this->SetFillColor(204,255,255);
    $this->Ln();
    // Données
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(63,8,cleanString($col),1);
        $this->Ln();
    }
}


}

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','',14, true);
$pdf->Cell(0,10,$vehicule['societe_nom']. ' - vehicule : '.$vehicule['plaque'],1,1,'C');
$pdf->ln(5);

$pdf->SetFont('Times','',12, true);

$header=['DATE ','TYPE DE DESINFECTION ','NOM'];

foreach ($hygienesDatas as $hygieneName) {
    cleanString($hygieneName['hygieneNom']);
    cleanString($hygieneName['date']);
    cleanString($hygieneName['userName']);
 }

 $pdf->BasicTable($header,$hygienesDatas);



$pdf->Output();
ob_end_flush(); 
?>