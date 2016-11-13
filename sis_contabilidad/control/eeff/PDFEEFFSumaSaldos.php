<?php

session_start();
require('../../../lib/fpdf/fpdf.php');
require('../../../lib/funciones.inc.php');
include_once("../../../lib/configuracion.log.php");
include_once("../LibModeloContabilidad.php");
class PDF extends FPDF
{
	var  $posicionDebe=0;
	var  $posicionHaber=0;
	var $imprimir_cabecera=0;		
	var $inicioX=10;
	var $inicioY=75;
	var $inicioY1=75;
	var $inicioY2=75;
	var $nivel=7;
	var $nro_cuenta;
	var $nombre_cuenta;
	var $importe_cuenta;
	
	var $cantidad_filas_por_hoja=44;
	
	var $bandera;
	var $cantidad_cuenta;
	var $bandera_rubro=0;
	var $rubro;
	var $nombre_rubro;
	var $importe_rubro=0;
	var $ancho_columna_mes=25;
	var $data_detalle;
	var $colunas_imprimir= array();	
	var $colunas_cabecera= array();	
		 
	//Cabecera de página
	function Header()
	{
		$this->SetLeftMargin(8);//margen izquierdo
		$funciones = new funciones();
	    //Logo
	    $this->Image('../../../lib/images/logo_reporte.jpg',180,4,36,10);
	    $this->SetFont('Arial','B',12);
		$this->Ln(3);//salto de linea 
		
	    $this->Ln();
	    $this->SetFont('Arial','I',7);
	
	   	if ($_SESSION['sw_actualizacion']=='no'){$actualizacion_desc='S/A';}
	    if ($_SESSION['sw_actualizacion']=='si'){$actualizacion_desc='C/A';}
	    
	    if (strpos($_SESSION['departamento'],',')!=''){
	    	$this->SetXY(5,5);
	    	$this->MultiCell(160,4,'CONSOLIDADO: - '.$actualizacion_desc.' - '.$_SESSION['departamento'],0,'J');	
	    }else{
	    	$this->SetXY(5,5);
	    	$this->MultiCell(160,4,'- '.$actualizacion_desc.' - '.$_SESSION['departamento'],0,'J');	
	    }
	    
	    $this->SetFont('Arial','B',12);//tifo de fuente
	    $this->Cell(0,7,$_SESSION['EEFF'],0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	
	    $this->SetFont('Arial','I',7);
	    $this->Ln(5);
	    $this->Cell(0,5,'Del '.$_SESSION['fecha_reporte_ini']." Al ".$_SESSION['fecha_reporte'],0,0,'C');
	    $this->SetFont('Arial','I',7);
	    $this->Ln(4);
	    $this->Cell(0,5,'(Expresado en '.$_SESSION['desc_moneda'].")",0,0,'C');	
		
	    $this->SetXY(8,35);
		$this->SetFont('Arial','B',8);
		$this->Cell(30,5,'CUENTA',1,0,'C',0);
		$this->Cell(75,5,'DETALLE',1,0,'C',0);
		$this->Cell($this->ancho_columna_mes,5,'IMPORTE DEBE',1,0,'C',0);
		$this->Cell($this->ancho_columna_mes,5,'IMPORTE HABER',1,0,'C',0);
		$this->Cell($this->ancho_columna_mes,5,'SALDO DEBE',1,0,'C',0);
		$this->Cell($this->ancho_columna_mes,5,'SALDO HABER',1,0,'C',0);
		$this->SetY(40);
	  }
	 
	//Pie de página
	function Footer()
	{
	    $this->SetFont('Arial','I',8);
	    $ip = captura_ip();

		//Número de página
	    $fecha=date("d-m-Y");
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
	}
	
	function maestro()
	{	
		$Custom = new cls_CustomDBContabilidad();
		$cant = 1000000;
	 	$puntero = 0;
	 	$sortcol = 'nro_cuenta';
	 	$sortdir = 'asc';

		$cond = new cls_criterio_filtro($decodificar);
		$criterio_filtro = $cond -> obtener_criterio_filtro();
		$criterio_filtro=$criterio_filtro." ";
		 
		$this->res = $Custom->ListarEstadoSumasySaldos( $cant,$puntero,$sortcol,$sortdir,$criterio_filtro,
					 									$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad, 
					 									$_SESSION['ids_depto'],$_SESSION['id_moneda'],$_SESSION['fecha_trans'],
					 									$_SESSION['id_parametro'],$_SESSION['nivel'],
					 									$_SESSION['fecha_trans_ini'],$_SESSION['sw_actualizacion']);
		$this->data_detalle=$Custom->salida;
		//print_r($_SESSION['ids_depto']) ; exit();
		
		$this->SetFillColor(224,235,255);//color de fondo las celdas 
		$importe_debe=0;
		$importe_haber=0;
		$saldo_debe=0;
		$saldo_haber=0;
					
		if($this->data_detalle){
		 	foreach($this->data_detalle as $row)
		 	{       $this->SetFont('Arial','',7);
					$this->SetX(8);
					$this->Cell(30,5,$row['nro_cuenta'],1,0,'L',$fill);
					$this->Cell(75,5,$row['nombre_cuenta'],1,0,'L',$fill);
					$this->Cell($this->ancho_columna_mes,5,number_format($row['importe_debe'],2),1,0,'R',$fill);
					$this->Cell($this->ancho_columna_mes,5,number_format($row['importe_haber'],2),1,0,'R',$fill);
					$this->Cell($this->ancho_columna_mes,5,number_format($row['saldo_debe'],2),1,0,'R',$fill);
					$this->Cell($this->ancho_columna_mes,5,number_format($row['saldo_haber'],2),1,0,'R',$fill);
					$importe_debe=$importe_debe+$row['importe_debe'];
					$importe_haber=$importe_haber+$row['importe_haber'];
					$saldo_debe=$saldo_debe+$row['saldo_debe'];
					$saldo_haber=$saldo_haber+$row['saldo_haber'];
			 	    $fill=!$fill;
					$this->Ln();
			}
		}
		$this->SetFont('Arial','B',7);
		$this->SetX(8);
		$this->Cell(105,5,'TOTAL',1,0,'L',$fill);
		
		$this->Cell($this->ancho_columna_mes,5,number_format($importe_debe,2),1,0,'R',$fill);
		$this->Cell($this->ancho_columna_mes,5,number_format($importe_haber,2),1,0,'R',$fill);
		$this->Cell($this->ancho_columna_mes,5,number_format($saldo_debe,2),1,0,'R',$fill);
		$this->Cell($this->ancho_columna_mes,5,number_format($saldo_haber,2),1,0,'R',$fill);
	 }
}
 //Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','Letter');// main (posicion de la pagina,unidad de medida,tamaño)

$pdf->AliasNbPages();//contador de pagina 

$pdf->AddPage('P');//para modificar la orienacion de la pagina
$pdf->SetMargins(10,10,10,10);
$pdf->SetAutoPageBreak(true,15);
$pdf->SetFont('Times','',12);
$pdf->maestro();//es una funcion en la cual se crea el reporte
//$pdf->FancyTable($header,$data);
//$pdf->SetRightMargin(10);
$pdf->Output();//mostrar el reporte
?>



 
