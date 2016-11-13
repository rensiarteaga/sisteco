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
	var $ancho_columna_mes=14;
	
	//Cabecera de página
	function Header()
	{
	
		$funciones = new funciones();
	    //Logo
	    $this->Image('../../../lib/images/logo_reporte.jpg',235,5,36,10);

	    $this->SetFont('Arial','I',7);

	    if (strpos($_SESSION['departamento'],',')!=''){
	    	//$this->MultiCell(100,4,'CONSOLIDADO  '.$_SESSION['departamento'],0);	
	    	$this->SetY(5);
	    	$this->MultiCell(100,4,'CONSOLIDADO  '.$_SESSION['departamento'],0,'J');	
	    }else{
	    	$this->SetY(5);
	    	$this->MultiCell(150,4,''.$_SESSION['departamento'],0,'J');	
	    }
	     $this->SetFont('Arial','B',12);//tifo de fuente
	    $this->Cell(0,7,$_SESSION['EEFF'],0,1,'C'); //dibuja una celad con contenido y orientacion  x, y 
	
	    $this->SetFont('Arial','I',7);
	    //$this->Ln();
	    $this->Cell(0,5,'(Expresado en '.$_SESSION['desc_moneda'].")",0,1,'C'); //dibuja una celad con contenido y orientacion  x, y 
    	
	    $epe=" ";   
	    $bandera=false;
	 	
		$this->SetFont('Arial','B',7);
		$this->SetX(10);
		$this->Cell(25,5,'CUENTA',1,0,'C',0);
		$this->Cell(50,5,'DETALLE',1,0,'C',0);
		$this->Cell($this->ancho_columna_mes,5,'ENE',1,0,'C',0);
		$this->Cell($this->ancho_columna_mes,5,'FEB',1,0,'C',0);
		$this->Cell($this->ancho_columna_mes,5,'MAR',1,0,'C',0);
		$this->Cell($this->ancho_columna_mes,5,'ABR',1,0,'C',0);
		$this->Cell($this->ancho_columna_mes,5,'MAY',1,0,'C',0);
		$this->Cell($this->ancho_columna_mes,5,'JUN',1,0,'C',0);
		$this->Cell($this->ancho_columna_mes,5,'JUL',1,0,'C',0);
		$this->Cell($this->ancho_columna_mes,5,'AGO',1,0,'C',0);
		$this->Cell($this->ancho_columna_mes,5,'SEP',1,0,'C',0);
		$this->Cell($this->ancho_columna_mes,5,'OCT',1,0,'C',0);
		$this->Cell($this->ancho_columna_mes,5,'NOV',1,0,'C',0);
		$this->Cell($this->ancho_columna_mes,5,'DIC',1,0,'C',0);
		$this->Cell($this->ancho_columna_mes+5,5,'TOTAL',1,1,'C',0);
		
		$this->SetFont('Arial','',5);
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
		$Custom = new cls_CustomDBContabilidad();//$this->SetY(36);

	   	$cant = 1000000;
 	   	$puntero = 0;
 	   	$sortcol = 'nro_cuenta';
 	   	$sortdir = 'asc';
		$cond = new cls_criterio_filtro($decodificar);
		$criterio_filtro = $cond -> obtener_criterio_filtro();
		$criterio_filtro=$criterio_filtro." ";
	 
	 	$res = $Custom->ListarEEFFPeriodo(	$cant,$puntero,$sortcol,$sortdir,$criterio_filtro,
	 									$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad, 
	 									$_SESSION['ids_depto'],$_SESSION['id_moneda'],$_SESSION['fecha_trans'],
	 									$_SESSION['id_reporte_eeff'], $_SESSION['id_parametro'],$_SESSION['nivel'],
	 									$_SESSION['ids_periodo'],$_SESSION['sw_actualizacion']);
	   if($res)
	   {
			$this->SetFillColor(224,235,255);//color de fondo las celdas  
		 	$data=$Custom->salida;
			$indice_data=1;
			$this->SetX(10);
			$this->SetFont('Arial','B',5);
			$this->SetWidths(array(25,50,14,14,14,14,14,14,14,14,14,14,14,14,19));
			$this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
			$this->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
			$this->SetFontsStyles(array('','','','','','','','','','','','','',''));
			$this->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5));
			$this->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
			$this->SetDecimales(array(0,0,2,2,2,2,2,2,2,2,2,2,2,2,2,2));
			$this->SetFormatNumber(array(0,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
			$this->SetAligns(array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R'));
			$this->SetFills(array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
		 	for($i=0;$i<=count($data);$i++)
		 	{
	 			if(($i % 2)==0)
	            {
	                $this->SetFillColor(224,235,255);//color de fondo las celdas 
	             }else{
	                $this->SetFillColor(255,255,255);//color de fondo las celdas 
				}
	 			$this->Multitabla($data[$i],0,5,3,5,1);
			}					
		}
	}

    function VerificarLinea($row)
    {
    	$band=false;
    	for($i=0;$i<13;$i++)
    	{
    		if($row[$i]!="")
    		{
    			$band=true;
    		}	
    	}
    	return $band;
    }
}

 //Creación del objeto de la clase heredada
$pdf=new PDF('L','mm','Letter');// main (posicion de la pagina,unidad de medida,tamaño)

$pdf->AliasNbPages();//contador de pagina 

$pdf->AddPage('L');//para modificar la orienacion de la pagina
$pdf->SetMargins(10,10,10,10);
$pdf->SetAutoPageBreak(true,15);
$pdf->SetFont('Times','',12);
$pdf->maestro();//es una funcion en la cual se crea el reporte

$pdf->Output();//mostrar el reporte
	
 
?>



 
