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
	var $inicioX=1;
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
	var $ancho_columna_mes=13.5;
	var $data_detalle;
	var $colunas_imprimir= array();	
	var $colunas_cabecera= array();	
		 
	//Cabecera de página
	function Header()
	{
		$this->SetLeftMargin(3);//margen izquierdo
		$funciones = new funciones();
	    //Logo
	    $this->Image('../../../lib/images/logo_reporte.jpg',285,5,36,10);
	    $this->SetFont('Arial','B',12);//tifo de fuente
		$this->Ln(3);//salto de linea 
    
	    $this->Ln();
	    $this->SetFont('Arial','I',7);
	    
	    if (strpos($_SESSION['departamento'],',')!=''){
	    	$this->SetXY(5,5);
	    	$this->MultiCell(180,4,'CONSOLIDADO: '.$_SESSION['departamento'],0,'J');	
	    }else{
	    	$this->SetXY(5,5);
	    	$this->MultiCell(180,4,''.$_SESSION['departamento'],0,'J');	
	    }
	    $this->SetFont('Arial','B',12);//tifo de fuente
	    $this->Cell(0,7,$_SESSION['EEFF'],0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->SetFont('Arial','I',7);
	    $this->Ln(5);
	    $this->Cell(0,5,'Del '.$_SESSION['fecha_reporte_ini']." Al ".$_SESSION['fecha_reporte'],0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->SetFont('Arial','I',7);
	    $this->Ln(3);
	    $this->Cell(0,5,'(Expresado en '.$_SESSION['desc_moneda'].")",0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->SetY(37);
  }
 
	//Pie de página
	function Footer()
	{
 	
	//Posición: a 1,5 cm del final
    
    //Arial italic 8
    $this->SetFont('Arial','I',7);
    //ip
    $ip = captura_ip();
    
    	//$this->line(8,$this->GetY(),273,$this->GetY()); 
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
	 
	 	$this->res = $Custom->listarEEFFConsolidado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,
				 									$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad, 
				 									$_SESSION['ids_depto'],$_SESSION['id_moneda'],$_SESSION['fecha_trans'],
				 									$_SESSION['id_reporte_eeff'], $_SESSION['id_parametro'],$_SESSION['nivel'],
				 									$_SESSION['fecha_trans_ini'],$_SESSION['sw_actualizacion']);
		$this->data_detalle=$Custom->salida;
		$cabecera=array_unique(array_shift($this->data_detalle));	 
   		$this->SetFillColor(224,235,255);//color de fondo las celdas 
 
		foreach( $cabecera as $key=>$valor){
			if($valor!='no_definido'&&$valor!='0.nro_cuenta'&&$valor!='nombre_cuenta'&&$valor!='nro_cuenta_sigma'&&$valor!='nombre_cuenta_sigma')
			{
				array_push($this->colunas_cabecera,$valor);
				array_push($this->colunas_imprimir,$key); 
			}
		}
	
		if($this->data_detalle){
		 	foreach($this->data_detalle as $row)
			{      
				if ($this->imprimir_cabecera%52==0){
	 				if ($this->imprimir_cabecera!=0) {
	 					$this->AddPage();
	 				}
					
	 				$this->SetX($this->inicioX);
					$this->SetFont('Arial','B',6);
					$this->Cell(23,5,'CUENTA',1,0,'C',0);
					$this->Cell(50,5,'DETALLE',1,0,'C',0);
					foreach($this->colunas_cabecera as $valor)
					{
						$this->Cell($this->ancho_columna_mes,5,str_replace("DC-","",$valor),1,0,'C',0);
					}
					$this->Ln(5);
 				}
	 		   	$this->SetFont('Arial','',5);
			   	$this->SetX($this->inicioX);
			   	$this->Cell(23,3,$row[0],0,0,'L',$fill);
			   	$this->Cell(50,3,$row[1],0,0,'L',$fill);
			   	
			   	foreach($this->colunas_imprimir as $i)
	 			{
	 			 	$this->Cell($this->ancho_columna_mes,3,number_format($row[$i],2),0,0,'R',$fill);	
	 			}
	 			$this->Ln();//salto de linea  
		 	    $fill=!$fill;
	   			$this->imprimir_cabecera++;
			}
		}
 	} 
}
 
//Creación del objeto de la clase heredada
$pdf=new PDF('L','mm','Legal');// main (posicion de la pagina,unidad de medida,tamaño)

$pdf->AliasNbPages();//contador de pagina 
$pdf->AddPage('L');//para modificar la orienacion de la pagina
$pdf->SetMargins(1,1,1,1);
$pdf->SetAutoPageBreak(true,15);
$pdf->SetFont('Times','',12);
$pdf->maestro();//es una funcion en la cual se crea el reporte
$pdf->Output();//mostrar el reporte

?>



 
