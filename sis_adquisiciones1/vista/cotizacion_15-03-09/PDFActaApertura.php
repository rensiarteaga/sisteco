<?php

session_start();

require('../../../lib/fpdf/fpdf.php');
//require('../../../lib/fpdf/mc_table.php');
define('FPDF_FONTPATH','font/');
class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
  //   $this->SetAutoPageBreak(25);
    //Iniciación de variables
    }
 var $widths;
 var $aligns;

function Header()
{
    //Logo
  
    $this->Image('../../../lib/images/adquisiciones/acta1.jpg',20,2,35,25);
    $this->Image('../../../lib/images/adquisiciones/acta2.jpg',80,2,35,25);
    $this->Image('../../../lib/images/adquisiciones/acta3.jpg',150,2,35,25);
    $this->Ln(30);
}
//Pie de página
function Footer()
   {
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    $this->SetFont('Arial','',8);
    $this->Cell(0,5,'Pagina '.$this->PageNo().' de  {nb}',0,0,'C');
   }


}

$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial');
$pdf->SetLeftMargin(20);
$pdf->SetAutoPageBreak(true,25);
//-----------------------Acta de Apertura
$pdf->SetFont('Arial','B',14);
$pdf->Cell(185,5,'EMPRESA NACIONAL DE ELECTRICIDAD S.A.',0,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(185,5,'MODALIDAD DE APOYO NACIONAL A LA PRODUCCIÓN Y EMPLEO',0,1,'C');
$pdf->SetFont('Arial','B',14);
$pdf->Ln(2);
$pdf->Cell(185,5,'REQUERIMIENTO DE PROPUESTAS TECNICAS',0,1,'C');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(185,5,'Convocatoria Nº'.$_SESSION['PDF_num_convocatoria'],0,1,'C');
$pdf->SetFont('Arial','B',12);
$pdf->Ln(3);
$pdf->MultiCell(185,5,''.$_SESSION['PDF_observaciones'].'',0,'C');
$pdf->Cell(185,5,''.$_SESSION['PDF_nombre_unidad'].'',0,1,'C');
$pdf->SetFont('Arial','B',12);
$pdf->Ln(3);
$pdf->Cell(185,5,'ACTA DE APERTURA DE PROPUESTAS ',0,1,'C');
$pdf->SetFont('Arial','',10);
$pdf->Ln(3);

$pdf->MultiCell(185,5,'De acuerdo a lo previsto en la convocatoria y cronograma de la Convocatoria Nº '.$_SESSION['PDF_num_convocatoria'].', destinada a la '.$_SESSION['PDF_tipo_adq'].',  '.$_SESSION['PDF_observaciones'].', en fecha:         , se llevó a cabo el Acto de Apertura de Propuestas con la asistencia de la comisión de Calificación de ENDE y de los siguientes proponentes:');
$pdf->Ln(3);
$pdf->SetX(60);
$data=$_SESSION['PDF_proveedores_acta'];
$pdf->SetWidths(array(60,60,60));
$cdata=count($data);


 for($i=0;$i<$cdata;$i++)
 {
     if($data[$i][2]!=''){
        $pdf->Row2($data[$i],2,'L',60);
     }else{
        $pdf->Row2($data[$i],1,'L',60);
     }
 }
$pdf->MultiCell(185,5,'Al cierre del plazo de presentación de propuestas, se contó con la participación de las firmas de los proponentes ',0,'J');
$pdf->Ln(3);
$pdf->SetX(60);
$pdf->SetWidths(array(60,60,60));

 for($i=0;$i<$cdata;$i++)
 {
   $pdf->Row2($data[$i],1,'L',60,0);
   
 }


$pdf->Ln(3);

$pdf->MultiCell(185,5,'Luego de la presentación de los servidores publicos que conforman la Comisión de Calificación, asi como de los representantes de las firmas interesadas, se hizo una breve reseña de los actos administrativos previos al Acto de  Apertura, y se dio lectura del Acta de Presentación de Propuestas. ',0,'J');
$pdf->Ln(3);
$pdf->MultiCell(185,5,'Seguidamente se dió lectura del precio presupuestado para el presente proceso cuyo importe alcanza a Bs '.$_SESSION['PDF_precio_total'].' ('.$_SESSION['PDF_literal_precio_total'].')Luego de la presentación de los servidores publicos que conforman la Comisión de Calificación, asi como de los representantes de las firmas interesadas, se hizo una breve reseña de los actos administrativos previos al Acto de  Apertura, y se dio lectura del Acta de Presentación de Propuestas. ',0,'J');

$pdf->MultiCell(185,5,$_SESSION['PDF_observaciones_acta'],0,'J');

$pdf->Ln(3);
$pdf->MultiCell(185,5,'Posteriormente, se realizó la verificación de la documentación presentada, de acuerdo con lo estipulado en el Documento Base de Contratación del proceso de referencia, cuyo detalle se anexa al presente documento',0,'J');
$pdf->Ln(3);
$pdf->MultiCell(185,5,''.$_SESSION['descripcion'].'',0,'J');
$pdf->Ln(3);
$fecha=time();

$pdf->MultiCell(185,5,'No existiendo ninguna consulta de parte de los proponentes, el acto concluyó a Hrs.      ');
$pdf->Ln(3);
$pdf->MultiCell(185,5,'Firman al pie:');
$pdf->Ln(5);
$pdf->MultiCell(185,5,'Por los proponentes:');
$pdf->Ln(15);

$size_firmas=count($data);
for($u=1;$u<=ceil($size_firmas/3);$u++){
	$x=$pdf->GetX();
    $y=$pdf->GetY();
    //echo $y;
  if((ceil($size_firmas/3))==$u){
  	for($a=((3*$u)-3);$a<$size_firmas;$a++){
  		    $x=$pdf->GetX();
  		    if(($data[$a][2])==($data[$a][1])){
  		    $pdf->MultiCell(60,5,'________________________'."\n".$data[$a][2],0,'C');	
  		    }else{
  		    $pdf->MultiCell(60,5,'________________________'."\n".$data[$a][2]." \n ".$data[$a][1],0,'C');	
  		    }
  		     $y=$pdf->GetY();
          $pdf->SetXY($x+60,$y-15); 
          //echo $y;
 
	}
	 $pdf->SetY($y +30);
  }
   else{
    	
   	for($a1=(3*$u)-3;$a1<(3*$u);$a1++){
   		$x=$pdf->GetX();
   		$pdf->MultiCell(60,5,'_________________________'."\n".$data[$a1][2]." \n ".$data[$a1][1],0,'C');
   		$pdf->SetXY($x+60,$y);
   		
   		
   	}
           $pdf->SetY($y+30);
   }
  }


$pdf->Cell(90,5,'Por la comisión de Calificación',0,1);
/*$pdf->Ln(10);
$pdf->Cell(60,5,'Ing. Edgar Yrady',0,0,'C');
$pdf->Cell(60,5,'Lic. Vivian Badani M.',0,0,'C');
$pdf->Cell(60,5,'Ing. Percy Ramirez',0,1,'C');
$pdf->Cell(60,5,'VOCAL TECNICO',0,0,'C');
$pdf->Cell(60,5,'SECRETARIA',0,0,'C');
$pdf->Cell(60,5,'PRESIDENTE',0,1,'C');
*/$pdf->SetLeftMargin(15);

$pdf->Output();
?>