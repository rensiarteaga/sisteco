<?php

session_start();
//require('../../../lib/fpdf/fpdf.php');

require('../../../lib/fpdf/fpdf.php');
require('../../../lib/funciones.inc.php');
/*include_once("../../../lib/configuracion.log.php");
include_once("../LibModeloTesoreria.php");*/

		
class PDF extends FPDF
{
		 
	//Cabecera de página
	function Header()
	{
		$this->SetLeftMargin(8);//margen izquierdo
		$funciones = new funciones();
		
		//Logo
	    $this->Image('../../../lib/images/logo_reporte.jpg',170,5,36,10);
	    
	    	//$this->Image('../../../lib/images/logo_reporte_factur.jpg',210,5);//llama al logo
	    //Arial bold 15
	    $this->SetFont('Arial','B',12);//tipo de fuente
	    //Movernos a la derecha
		//$this->Ln(4);//salto de linea 
	    //$this->Cell(100);//celda de dibujo
	    
	    $this->Cell(0,7,'VERIFICACIÓN PRESUPUESTARIA DE LA RENDICIÓN',0,1,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    
	    $this->Ln(1);
	    
	    $this->SetFont('Arial','I',7);
	
	    $cab_rendicion_verificacion=$_SESSION['PDF_cab_rendicion_verificacion'];
	    //$this->Cell(0,4,'Presupuesto de '.$_SESSION['desc_pres']." Gestión ".$_SESSION['gestion_pres'],0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->Cell(120,3,'Nombre y Apellido: 		'.$cab_rendicion_verificacion[0][0],0,0,'L'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->Cell(0,3,'Fecha de Rendición: 		'.$cab_rendicion_verificacion[0][1],0,1,'L'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->Cell(120,3,'Centro de Responsabilidad: '.$cab_rendicion_verificacion[0][2],0,0,'L'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->Cell(0,3,'Periodo: 					'.$cab_rendicion_verificacion[0][3],0,1,'L'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->MultiCell(200,3,'Concepto: 				'.$cab_rendicion_verificacion[0][4],0,'L',false); //dibuja una celad con contenido y orientacion  x, y 
	    	   
	    //$this->Ln(1);
	    $this->SetFont('Arial','B',6);	    	
	}	
		 
  
	//Pie de página
	function Footer()
	{	 	
	    $this->SetY(-15);	   
	    $this->SetFont('Arial','I',8);	  
	    //$ip = captura_ip();	    
	 
	    $fecha=date("d-m-Y");
		$hora=date("H:i:s");	    
	     
   	    $this->SetFont('Arial','',6);   	   
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - TESORO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');		
	}   
}

//Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','Letter');// main (posicion de la pagina,unidad de medida,tamaño)
$pdf->AliasNbPages();//contador de pagina 

$pdf->AddPage();//para modificar la orienacion de la pagina
/* echo "down down".utf8_decode($_SESSION['tipo_pres']);
exit;*/ 
$pdf->SetAutoPageBreak(true,15);
$pdf->SetFont('Times','',12);

//$cab_rendicion_verificacion=$_SESSION['PDF_cab_rendicion_verificacion'];
$det_solicitudes_ampliaciones=$_SESSION['PDF_det_solicitudes_ampliaciones'];	//
$det_rendiciones_anteriores=$_SESSION['PDF_det_rendiciones_anteriores'];	//
$det_rendicion_verificacion=$_SESSION['PDF_det_rendicion_verificacion'];	//

//-------------------------LISTADO DE LOS IMPORTES DE LA SOLICITUD Y AMPLIACIONES------------------------------------------
		$pdf->SetFillColor(200, 200, 200);	//Plomo oscuro
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(200,6,'','',1);	
		$pdf->Cell(200,6,'','',1);
		$pdf->Cell(200,5,'DETALLE DE IMPORTES COMPROMETIDOS DESDE SOLICITUDES Y AMPLIACIONES','LTBR',1,'C',true);
	
		$pdf->SetFont('Arial','',6);
		//$pdf->Cell(200,3,'','',1);			
		$pdf->SetFillColor(230, 230, 230);	//Plomo claro		
	
		//$pdf->Ln(1);
 		//$pdf->SetX(15);
 		$pdf->SetFillColor(230 , 230, 230);	//Plomo claro
 		$pdf->SetFont('Arial','B',7);
 		//$pdf->Cell(10,4,'ID','',0,'C',false);
 		$pdf->Cell(60,4,'PARTIDA','LBTR',0,'C',true); 
 		$pdf->Cell(80,4,'PRESUPUESTO','LBTR',0,'C',true); 
 		$pdf->Cell(60,4,'IMPORTE TOTAL SOLICITADO','LBTR',1,'C',true);  
 		
 		
 		$pdf->SetWidths(array(60,80,60));
		$pdf->SetFills(array(0,0,0));
 		$pdf->SetAligns(array('L','L','R'));
 		$pdf->SetVisibles(array(1,1,1));
 		$pdf->SetFontsSizes(array(6,6,6));
 		$pdf->SetFontsStyles(array('','',''));
 		$pdf->SetDecimales(array(0,0,0));
 		$pdf->SetSpaces(array(3,3,3));
 		$pdf->SetFormatNumber(array(0,0,0)); 	
		
   		$pdf->SetFont('Arial','B',6);
   		$total_importe_det_solicitudes_ampliaciones=0;
   		
		//$pdf->Cell(200,3,'Solicitudes (Antiguo)','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($det_solicitudes_ampliaciones);$i++)
		{  	 								
	  		$pdf->MultiTabla($det_solicitudes_ampliaciones[$i],0,3,3,6,1); 
	  		//$pdf->SetFontsColors(array(array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0)));	  			  		
	  		$total_importe_det_solicitudes_ampliaciones=$total_importe_det_solicitudes_ampliaciones+$det_solicitudes_ampliaciones[$i][2];	  			  		  		
   		}
   		
   		$pdf->SetFont('Arial','B',7);
   		$pdf->Cell(140,5,'TOTAL SOLICITUDES:  ','',0,'R');   		
   		$pdf->Cell(60,5,number_format($total_importe_det_solicitudes_ampliaciones,2),1,1,'R');
   		//$pdf->Cell(10,5,'','',1);
   		
//-------------------------LISTADO DE RENDICIONES REGISTRADAS ANTERIORMENTE ------------------------------------------

		$pdf->SetFillColor(200, 200, 200);	//Plomo oscuro
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(200,6,'','',1);	
		$pdf->Cell(200,6,'','',1);
		$pdf->Cell(200,5,'DETALLE DE IMPORTES PAGADOS POR RENDICIONES ANTERIORES','LTBR',1,'C',true);

		$pdf->SetFont('Arial','',6);
		//$pdf->Cell(200,3,'','',1);			
		$pdf->SetFillColor(230, 230, 230);	//Plomo claro
		
		/*$pdf->Cell(30,3,'F : Fondo Rotatorio','',1,'L',false); 
 		$pdf->Cell(30,3,'C: Cuenta Documentada','',1,'L',false); */ 
		
		//$pdf->Ln(1);
 		//$pdf->SetX(15);
 		$pdf->SetFillColor(230 , 230, 230);	//Plomo claro
 		$pdf->SetFont('Arial','B',7);
 		//$pdf->Cell(10,4,'ID','',0,'C',false);
 		$pdf->Cell(60,4,'PARTIDA','LBTR',0,'C',true); 
 		$pdf->Cell(80,4,'PRESUPUESTO','LBTR',0,'C',true);
 		$pdf->Cell(60,4,'IMPORTE TOTAL RENDIDO','LBTR',1,'C',true);  
 		 
 		
 		$pdf->SetWidths(array(60,80,60));
		$pdf->SetFills(array(0,0,0));
 		$pdf->SetAligns(array('L','L','R'));
 		$pdf->SetVisibles(array(1,1,1));
 		$pdf->SetFontsSizes(array(6,6,6));
 		$pdf->SetFontsStyles(array('','',''));
 		$pdf->SetDecimales(array(0,0,0));
 		$pdf->SetSpaces(array(3,3,3));
 		$pdf->SetFormatNumber(array(0,0,0)); 	
		
   		$pdf->SetFont('Arial','B',6);
   		$total_importe_det_rendiciones_anteriores=0;
   		
		//$pdf->Cell(200,3,'Solicitudes (Antiguo)','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($det_rendiciones_anteriores);$i++)
		{  	 		
	  		$pdf->MultiTabla($det_rendiciones_anteriores[$i],0,3,3,6,1); 
	  		//$pdf->SetFontsColors(array(array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0)));	  			  		
	  		$total_importe_det_rendiciones_anteriores=$total_importe_det_rendiciones_anteriores+$det_rendiciones_anteriores[$i][2];	  			  		  		
   		}
   		
   		$pdf->SetFont('Arial','B',7);
   		$pdf->Cell(140,5,'TOTAL RENDICIONES ANTERIORES:  ','',0,'R');   		
   		$pdf->Cell(60,5,number_format($total_importe_det_rendiciones_anteriores,2),1,1,'R');
   		//$pdf->Cell(10,5,'','',1);
   		

//-------------------------LISTADO DE PARTIDAS Y LA DISPONIBILIDAD PRESUPUESTARIA DE LOS IMPORTES------------------------------------------
		$pdf->SetFillColor(200, 200, 200);	//Plomo oscuro
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(200,6,'','',1);
		$pdf->Cell(200,6,'','',1);	
		$pdf->Cell(200,5,'DISPONIBILIDAD PRESUPUESTARIA PARA LA RENDICIÓN ACTUAL','LTBR',1,'C',true);
	
		$pdf->SetFont('Arial','',6);		
		$pdf->SetFillColor(230, 230, 230);	//Plomo claro
				
 		$pdf->SetFillColor(230 , 230, 230);	//Plomo claro
 		$pdf->SetFont('Arial','B',7);
 		//$pdf->Cell(10,4,'ID','',0,'C',false);
 		$pdf->Cell(50,4,'PARTIDA','LBTR',0,'C',true); 
 		$pdf->Cell(70,4,'PRESUPUESTO','LBTR',0,'C',true);
 		$pdf->Cell(40,4,'IMPORTE TOTAL RENDIDO','LBTR',0,'C',true);  		 		 
 		$pdf->Cell(40,4,'DISPONIBILIDAD','LBTR',1,'C',true);  
 		
 		$pdf->SetWidths(array(10,50,70,40,40));
		$pdf->SetFills(array(0,0,0,0,0));
 		$pdf->SetAligns(array('L','L','L','R','C'));
 		$pdf->SetVisibles(array(0,1,1,1,1));
 		$pdf->SetFontsSizes(array(6,6,6,6,6));
 		$pdf->SetFontsStyles(array('','','','',''));
 		$pdf->SetDecimales(array(0,0,0,0,0));
 		$pdf->SetSpaces(array(3,3,3,3,3));
 		$pdf->SetFormatNumber(array(0,0,0,0,0)); 	
		
   		$pdf->SetFont('Arial','B',6);
   		$total_importe_det_rendicion_verificacion=0;
   		
		//$pdf->Cell(200,3,'Solicitudes (Antiguo)','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($det_rendicion_verificacion);$i++)
		{  	 
			if($det_rendicion_verificacion[$i][4]=='NO DISPONIBLE')
 	 		{
 	 			$pdf->SetFontsColors(array(array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(237,10,3))); //
 	 		}
					
	  		$pdf->MultiTabla($det_rendicion_verificacion[$i],0,3,3,6,1); 
	  		$pdf->SetFontsColors(array(array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0)));
	  			  		
	  		$total_importe_det_rendicion_verificacion=$total_importe_det_rendicion_verificacion+$det_rendicion_verificacion[$i][3];	  			  		  		
   		}
   		
   		$pdf->SetFont('Arial','B',7);
   		$pdf->Cell(120,5,'TOTAL RENDICIÓN ACTUAL:  ','',0,'R');   		
   		$pdf->Cell(40,5,number_format($total_importe_det_rendicion_verificacion,2),1,1,'R');
   		//$pdf->Cell(10,5,'','',1);

//$pdf->SetRightMargin(10);
$pdf->Output();//mostrar el reporte

?>
