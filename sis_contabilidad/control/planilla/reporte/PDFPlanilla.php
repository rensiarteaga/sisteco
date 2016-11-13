<?php

session_start();
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../LibModeloContabilidad.php");
class PDF extends FPDF
{
var  $posicionDebe=0;
var  $posicionHaber=0;
var $inicioX=10;
var $inicioY=75;
var $inicioY1=75;
var $inicioY2=75;
var $nivel=7;
var $nro_cuenta;
var $nombre_cuenta;
var $importe_cuenta;
var $bandera;
var $cantidad_cuenta;
var $bandera_rubro=0;
var $rubro;
var $nombre_rubro;
var $importe_rubro=0;

	
	 
//Cabecera de página
function Header()
{
	$this->SetLeftMargin(8);//margen izquierdo
	$funciones = new funciones();
   }
 
//Pie de página
function Footer()
{
 	
	//Posición: a 1,5 cm del final
    
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //ip
    $ip = captura_ip();
    
    	//$this->line(8,$this->GetY(),273,$this->GetY()); 
	 //Número de página
    $fecha=date("d/m/Y");
	//hora
    $hora=date("H:i:s");
	$this->SetY(-15);
    $this->Cell(0,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L'); 
    $this->SetY(-15);
    $this->Cell(0,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');     
    $this->SetY(-15);
    $this->Cell(0,10,'Fecha: '.$fecha ,0,0,'R');
    $this->ln(3);
    $this->Cell(0,10,'Hora: '.$hora ,0,0,'R');
    //fecha
   
}
 
 
function maestro()
{
	
 
	
	$Custom = new cls_CustomDBContabilidad();//$this->SetY(36);
	$this->SetLineWidth(.1);//ancho de las lineas 
//	$this->SetFillColor(224,235,255);//color de fondo las celdas 
  //  $this->SetTextColor(0);//color de la letra
    //$this->SetDrawColor(128,0,0);//rgv color de dibujo
	 $this->SetFont('Arial','',6);

	   $cant = 15;
 	   $puntero = 0;
 	   $sortcol = 'id_rubro_cuenta';
 	   $sortdir = 'asc';
	 
	
	 
	$cond = new cls_criterio_filtro($decodificar);

	 $criterio_filtro = $cond -> obtener_criterio_filtro();

	 $criterio_filtro=$criterio_filtro." and pla.id_planilla=19 GROUP BY plan.descripcion ,insti.nombre,ctaBco.nro_cuenta_banco,pla.id_cuenta_bancaria ";
	 $res = $Custom->ListarReporteCabeceraPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,
	 $hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	 //echo  $Custom->query; exit();
	
	 if($res){
	 	$data=$Custom->salida;
		foreach($data as $row)
		{
	$this->AddPage();			
	$this->Image('../../../../lib/images/logo_reporte.jpg',170,5,36,10);	   	  		
    $this->SetFont('Arial','B',16);
    $this->Cell(0,7,"PLANILLA CONSULTORES EXTERNOS",0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
    $this->Ln();
		
		$this->SetX(20);
		$this->SetFont('Arial','B',12);
		$this->Cell(30,5,"INSTITUCION: ",0,0,'LB',0);
		$this->SetFont('Arial','',12);
		$this->Cell(40,5,$row[1]." / ".$row[2],0,0,'L',0);
		$this->Ln();
		$this->SetFont('Arial','B',12);
		$this->SetX(20);
		$this->Cell(30,5,"CONCEPTO: ",0,0,'LB',0);
		$this->SetFont('Arial','',12);
		$this->Cell(40,5,$row[0],0,0,'L',0);
		
		 $this->SetFont('Arial','B',10);
		 $this->SetY(30);
		
		$this->Cell(10,5,'Nº',1,0,'C',0);
		$this->Cell(95,5,'NOMBRE CONSULTOR',1,0,'C',0);
		$this->Cell(40,5,'MONTO',1,0,'C',0);
		$this->Cell(50,5,'CUENTA BANCARIA',1,0,'C',0);	
		$contador=0;
		$this->SetFont('Arial','',10);
		$criterio_filtro_detalle=" pla.id_planilla=19 and  ctaBco.id_cuenta_bancaria=".$row[3];		
		$res = $Custom->ListarReporteDetallePlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro_detalle,$hidden_ep_id_financiador,
				 $hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	  //echo  $Custom->query; exit();
			$data_consultor =$Custom->salida;
			foreach($data_consultor as $row_consultor)
			{
			$this->Ln();
			$contador=$contador+1;
			$this->Cell(10,5,$contador,0,0,'C',$fill);
			$this->Cell(95,5,$row_consultor[0],0,0,'C',$fill);
			$this->Cell(40,5,$row_consultor[1],0,0,'C',$fill);
			$this->Cell(50,5,$row_consultor[3],0,0,'C',$fill);	
			
			//$this->Cell(20,5,$row_cuenta[3],1,0,'C',0);
	   	    //$fill=!$fill;
	   	    }
  		
  
	   	    //$this->CheckPageBreak('L');
	   	    
	   	   // $this->SetPageBreak(true);
	    }
	}
	
	
	
}

    
 
   

}
 
	//Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','Letter');// main (posicion de la pagina,unidad de medida,tamaño)

$pdf->AliasNbPages();//contador de pagina 

//$pdf->AddPage('P');//para modificar la orienacion de la pagina
$pdf->SetMargins(10,10,10,10);
$pdf->SetAutoPageBreak(true,15);
$pdf->SetFont('Times','',12);
$pdf->maestro();//es una funcion en la cual se crea el reporte
//$pdf->FancyTable($header,$data);

//$pdf->SetRightMargin(10);
$pdf->Output();//mostrar el reporte
	

?>



 
