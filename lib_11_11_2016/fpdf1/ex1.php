<?php
//require('morepagestable.php');
require('fpdf.php');
class PDF extends FPDF {

var $tablewidths;
var $footerset;


function Footer() {
    // Check if Footer for this page already exists (do the same for Header())
    if(!$this->footerset[$this->page]) {
        $this->SetY(-15);
        //Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        // set footerset
        $this->footerset[$this->page] = 1;
    }
}

}
function GenerateWord()
{
    //Get a random word
    $nb=rand(3,10);
    $w='';
    for($i=1;$i<=$nb;$i++)
        $w.=chr(rand(ord('a'),ord('z')));
    return $w;
}

function GenerateSentence($words=1000)
{
    //Get a random sentence
    $nb=rand(20,$words);
    $s='';
    for($i=1;$i<=$nb;$i++)
        $s.=GenerateWord().' ';
    return substr($s,0,-1);
}

$pdf = new PDF('P','pt');
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(0,20,'Example to build Tables over more than one Page.');
// set the tablewidths like this or write an extra function
$pdf->tablewidths = array(90,90,90);

srand(microtime()*1000000);
for($i=0; $i < 2; $i++) {
    $datas[] = array('a',GenerateSentence(),'v');
}

$pdf->SetFont('Arial','',12);
$pdf->morepagestable($datas,10);
$pdf->Output();
?>