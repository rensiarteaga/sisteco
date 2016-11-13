<?php

session_start();
require('../../../lib/fpdf/fpdf.php');
require('../../../lib/funciones.inc.php');
include_once("../../../lib/configuracion.log.php");
include_once("../../control/LibModeloAdquisiciones.php");


class PDF extends FPDF
{
	var $total_año=0;
	var $total_totales=0;
	
	
//Cabecera de página
function Header()
{
	 $this->SetLeftMargin(8);
	$funciones = new funciones();
    //Logo
    $this->Image('../../../lib/images/logo_reporte_factur.jpg',210,2);
    
    //Arial bold 15
    $this->SetFont('Arial','B',12);
    //Movernos a la derecha
    $this->Cell(100);
    
    $this->Cell(80,13,'APERTURA DE OFERTAS',0,0,'C');
    $this->Ln(17);
   
    $this->SetFont('Arial','',7);
    
    
    $this->Cell(80,5,'FECHA:',0,0,'R');
    $this->Cell(5,5,'',0,0,'L');
    $this->Cell(150,5,$_SESSION['PDF_fecha_cotiza'],'B',0,'L');
    $this->Ln(6);
    $this->Cell(80,5,'No CONVOCATORIA:',0,0,'R');
    $this->Cell(5,5,'',0,0,'L');
    $this->Cell(150,5,$_SESSION['PDF_convocatoria'],'B',0,'L');
    $this->Ln(6);
    $this->Cell(80,5,'OBJETO:',0,0,'R');
    $this->Cell(5,5,'',0,0,'L');
    $this->MultiCell(150,5,$_SESSION['PDF_objeto'],'B','L');
    //$this->Ln(6);
    $this->Cell(80,5,'PRECIO REFERENCIAL:',0,0,'R');
    $this->Cell(5,5,'',0,0,'L');
    $this->Cell(150,5,$_SESSION['PDF_precio'],'B',0,'L');
    $this->Ln(10);
   
   
    //$this->Cell(10);
    $this->SetFont('Arial','B',8);
    $this->Cell(80,7,'PROPONENTE','LRT',0,'C',0);
    $this->Cell(25,7,'VALIDEZ DE','LRT',0,'C',0);
    $this->Cell(25,7,'FORMULARIO','LRT',0,'C',0);
    $this->Cell(40,7,'MONTO DE LA OFERTA','LRT',0,'C',0);
    $this->Cell(35,7,'PLAZO ENTREGA','LRT',0,'C',0);
    $this->Cell(50,7,'OBSERVACIONES','LRT',0,'C',0);
    $this->Ln(3);
    $this->Cell(80,7,'','LRB',0,'C',0);
    $this->Cell(25,7,'OFERTA','LRB',0,'C',0);
    $this->Cell(25,7,'No 1','LRB',0,'C',0);
    $this->Cell(40,7,'BS','LRB',0,'C',0);
    $this->Cell(35,7,'','LRB',0,'C',0);
    $this->Cell(50,7,'','LRB',0,'C',0);
   
   
    $this->Ln();
    
    
     
}

//Pie de página
function Footer()
{
      //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //ip
    //$ip = captura_ip();
    
   
	 //Número de página
    $fecha=date("d-m-Y");
	//hora
    $hora=date("H:i:s");
	$this->Cell(130,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L'); 
    $this->Cell(100,10,'Página '.$this->PageNo().' de {nb}',0,0,'L');     
    $this->Cell(100,10,'Fecha: '.$fecha ,0,0,'L');
    $this->ln(3);
    $this->Cell(130,10,'',0,0,'L'); 
    $this->Cell(100,10,'',0,0,'L');
    $this->Cell(100,10,'Hora: '.$hora ,0,0,'L');
    //fecha
   
}

function FancyTable()
{
	
	$funciones = new funciones();
    $Custom = new cls_CustomDBAdquisiciones();
    
    $criterio_filtro="id_proceso_compra=".$_SESSION['adq__id_proceso'];
    $res=$Custom->ListarAperturaOfertas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
    if(!$res){
    	
    	echo $Custom->salida[1];
    	exit();
    }
    else{
    	$arreglo=$Custom->salida;
    	
    }
    $this->SetFont('Arial','',8); 
	$this->SetWidths(array(80,25,25,40,35,50));
	$this->SetAligns(array('L','L','L','R','L','L'));
	$this->SetFontsSizes(array(8,8,8,8,8,8,8));
	$this->SetVisibles(array(1,1,1,1,1,1,1));
	$this->SetDecimales(array(0,0,0,2,0,0));
	
	for($i=0;$i<count($arreglo);$i++){
		
		$this->MultiTabla($arreglo[$i],0,3,5,10);
	}
	
	$this->SetFont('Arial','I',8);
	$this->Cell(130,8,'Por la Comisión:','',0,'L',0);
	$this->Cell(125,8,'Por los Poponentes:','',0,'L',0);
	$this->ln(5);
	
	for($i=0;$i<count($arreglo)*2;$i++){
		$this->Cell(255,6,'','B',1,'C',0);
		
	}
}
   
   
   

}

//Creación del objeto de la clase heredada
$pdf=new PDF('L','mm','Letter');
//$data=$_SESSION['PDF_mora'];
$pdf->AliasNbPages();

$pdf->AddPage('L');
$pdf->SetFont('Times','',12);
$pdf->SetAutoPageBreak(true,15);
$pdf->FancyTable();
//$pdf->FancyTable($header,$data);
$pdf->Output();
?>



?>
