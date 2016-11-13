<?php

session_start();
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../LibModeloTesoreria.php");

		
class PDF extends FPDF
{		 
	//Cabecera de página
	function Header()
	{
		$this->SetLeftMargin(8);//margen izquierdo
		$funciones = new funciones();
		
		//Logo
	    //$this->Image('../../../../lib/images/logo_reporte.jpg',170,5,36,10);  //veritical
	    $this->Image('../../../../lib/images/logo_reporte.jpg',230,5,36,10);  //horizontal
	    
	    	//$this->Image('../../../lib/images/logo_reporte_factur.jpg',210,5);//llama al logo
	    //Arial bold 15
	    $this->SetFont('Arial','B',12);//tifo de fuente
	    //Movernos a la derecha
		$this->Ln(3);//salto de linea 
	    //$this->Cell(100);//celda de dibujo
	    
	    $this->Cell(0,7,'DETALLE DE SOLICITUDES Y SUS ESTADOS',0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->SetFont('Arial','I',10);
	    $this->Ln();
	    //$this->Cell(0,4,'Presupuesto de '.$_SESSION['desc_pres']." Gestión ".$_SESSION['gestion_pres'],0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    
	    $this->Cell(0,4,'Filtrado '.$_SESSION['PDF_tipo_reporte'],0,0,'C');
	    	 
	    
	    $this->SetFont('Arial','I',7);
	    $this->Ln();
	    $this->Cell(0,4,'Del: '.$_SESSION['PDF_fecha_desde'].'  Al: '.$_SESSION['PDF_fecha_hasta']." ",0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->Ln(3);
	    $this->Cell(0,4,'Tipo de Solicitud: '.$_SESSION['PDF_tipo_solicitud'],0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	  	
	    $this->Ln(3);
	    $this->Cell(0,4,'Estado Solicitud: '.$_SESSION['PDF_estado_solicitud'],0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	  	    
	    $this->Ln(1);
	    $this->SetFont('Arial','B',6);	

	    
	    //----------------para que la cabecera del listado aparesca en todas las hojas---------
	    //$this->Ln(1);
				
		$this->SetFont('Arial','',6);
		$this->Cell(200,3,'','',1);			
		$this->SetFillColor(230, 230, 230);	//Plomo claro
		
		$this->Cell(30,3,'FR : Fondo Rotatorio','',1,'L',false); 
 		$this->Cell(30,3,'CD : Cuenta Documentada','',0,'L',false);
 		
 		$this->SetFont('Arial','B',7);  
 		
 		if($_SESSION['PDF_desc_usuario'] == "undefined" || $_SESSION['PDF_desc_usuario'] == "" || $_SESSION['PDF_desc_usuario'] == 'null')
		{
			if($_SESSION['PDF_desc_unidad_organizacional'] == "undefined" || $_SESSION['PDF_desc_unidad_organizacional'] == "" || $_SESSION['PDF_desc_unidad_organizacional'] == 'null')
			{		
				if($_SESSION['PDF_desc_depto'] == "undefined" || $_SESSION['PDF_desc_depto'] == "" || $_SESSION['PDF_desc_depto'] == 'null') 
				{						
					$this->Cell(230,4,'Funcionario Solicitante: '.$_SESSION['PDF_desc_empleado'],0,1,'R');
				}
				else 
				{
					$this->Cell(230,4,'Departamento Contable: '.$_SESSION['PDF_desc_depto'],0,1,'R');					
				}				
			}
			else 
			{
				$this->Cell(230,4,'Unidad Organizacional: '.$_SESSION['PDF_desc_unidad_organizacional'],0,1,'R');
			}
		}
		else 
		{		
			$this->Cell(230,4,'Responsable de Registro: '.$_SESSION['PDF_desc_usuario'],0,1,'R');	
		}
 		
		
		$this->Ln(2);
 		//$pdf->SetX(15);
 		$this->SetFillColor(230 , 230, 230);	//Plomo claro
 		$this->SetFont('Arial','B',7);
 		//$pdf->Cell(10,4,' ','',0,'C',false);
 		$this->Cell(6,3,'Tipo','LTR',0,'C',true); 
 		$this->Cell(15,3,'FECHA','LTR',0,'C',true);  
 		$this->Cell(22,3,'NRO','LTR',0,'C',true); 		 
 		$this->Cell(30,3,'FUNCIONARIO','LTR',0,'C',true);  		  
 		$this->Cell(50,3,'CONCEPTO','LTR',0,'C',true);
 		$this->Cell(18,3,'IMPORTE','LTR',0,'C',true);
 		$this->Cell(18,3,'ESTADO','LTR',0,'C',true);  
 		$this->Cell(28,3,'PERIODO','LTR',0,'C',true); 
 		$this->Cell(30,3,'REGISTRADO','LTR',0,'C',true); 
 		$this->Cell(10,3,'TIEMPO','LT',0,'C',true);  		
 		$this->Cell(36,3,'OBSERVACIONES','LTR',1,'C',true);   
 		
 		//$pdf->SetWidths(array(6,15,22,30,18,50,28,30,8,8,16,8,8,16));
 		
 		$this->Cell(6,3,'','LRB',0,'C',true); 
 		$this->Cell(15,3,'SOLICITUD','LRB',0,'C',true);  
 		$this->Cell(22,3,'SOLICITUD','LRB',0,'C',true); 		 
 		$this->Cell(30,3,'SOLITANTE','LRB',0,'C',true); 		 
 		$this->Cell(50,3,'','LRB',0,'C',true); 
 		$this->Cell(18,3,'SOLICITADO','LRB',0,'C',true); 
 		$this->Cell(18,3,'SOLICITUD','LRB',0,'C',true);  
 		$this->Cell(28,3,'','LRB',0,'C',true); 
 		$this->Cell(30,3,'POR','LRB',0,'C',true); 
 		$this->Cell(10,3,'DIAS','LRB',0,'C',true);  		
 		$this->Cell(36,3,'','LRB',1,'C',true); 		       	
	}	
		 
  
	//Pie de página
	function Footer()
	{
	 	//$this->line(8,$this->GetY(),203,$this->GetY()); 
		//Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    //Arial italic 8
	    $this->SetFont('Arial','I',8);
	    //ip
	    //$ip = captura_ip();
	    
	    //$this->line(8,$this->GetY(),203,$this->GetY()); 
		//Número de página
	    $fecha=date("d-m-Y");
		$hora=date("H:i:s");
	    //$this->SetY(-7);
	     
   	    $this->SetFont('Arial','',6);  	    
		
		$this->Cell(110,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(60,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(72,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(110,3,'Sistema: ENDESIS - TESORO',0,0,'L');	//horizontal
		$this->Cell(60,3,'',0,0,'C');
		$this->Cell(72,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');
	}   
}

$pdf=new PDF('L','mm','Letter');// main (posicion de la pagina,unidad de medida,tamaño)
$pdf->AliasNbPages();//contador de pagina 

$pdf->AddPage();//para modificar la orienacion de la pagina
/* echo "down down".utf8_decode($_SESSION['tipo_pres']);
exit;*/ 
$pdf->SetAutoPageBreak(true,15);
$pdf->SetFont('Times','',12); 

$estado_solicitudes=$_SESSION['PDF_estado_solicitudes'];

//-------------------------LISTADO DE SOLICITUDES------------------------------------------

 		$pdf->SetWidths(array(6,15,22,30,50,18,18,28,30,10,36));
		$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
 		$pdf->SetAligns(array('C','C','C','L','L','C','C','C','L','C','C','C','C','C','C','C'));
 		$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1));
 		$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6));
 		$pdf->SetFontsStyles(array('','','','','','','','','','','','','','','',''));
 		$pdf->SetDecimales(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
 		$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
 		$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)); 					
		
   		$pdf->SetFont('Arial','B',6);
		//$pdf->Cell(200,3,'Solicitudes (Antiguo)','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($estado_solicitudes);$i++)
		{  	 				
	  		$pdf->MultiTabla($estado_solicitudes[$i],0,3,3,6,1); 	  		  		
   		}   				 

//$pdf->SetRightMargin(10);
$pdf->Output();//mostrar el reporte

?>
