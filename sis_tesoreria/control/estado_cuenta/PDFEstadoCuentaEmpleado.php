<?php

session_start();
require('../../../lib/fpdf/fpdf.php');
require('../../../lib/funciones.inc.php');
include_once("../../../lib/configuracion.log.php");
include_once("../LibModeloTesoreria.php");

		
class PDF extends FPDF
{
		 
	//Cabecera de página
	function Header()
	{
		$this->SetLeftMargin(8);//margen izquierdo
		$funciones = new funciones();
		
		//Logo
	    $this->Image('../../../lib/images/logo_reporte.jpg',240,5,36,10);  //veritical
	    //$this->Image('../../../../lib/images/logo_reporte.jpg',230,5,36,10);  //horizontal
	    
	    
	    	//$this->Image('../../../lib/images/logo_reporte_factur.jpg',210,5);//llama al logo
	    //Arial bold 15
	    $this->SetFont('Arial','B',12);//tifo de fuente
	    //Movernos a la derecha
		$this->Ln(3);//salto de linea 
	    //$this->Cell(100);//celda de dibujo	    
	    $this->Cell(0,7,'DETALLE DEL ESTADO DE CUENTAS',0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    
	    
	    if ($_SESSION['desc_depto']>0)
	    {	    
		    $this->SetFont('Arial','I',10);
		    $this->Ln();	    
		    //$this->Cell(0,4,'Presupuesto de '.$_SESSION['desc_pres']." Gestión ".$_SESSION['gestion_pres'],0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
		    $this->Cell(0,4,'Departamento Contable: '.$_SESSION['desc_depto'],0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    }
	    
	    $this->SetFont('Arial','I',7);
	    $this->Ln();
	    $this->Cell(0,4,'Del: '.$_SESSION['fecha_desde'].'   Al: '.$_SESSION['fecha_hasta']." ",0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->Ln(3);
	   // $this->Cell(0,4,'Empleado: '.$_SESSION['id_empleado'],0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
  
	    
	    $this->SetFont('Arial','',6);
		$this->Cell(200,3,'','',1);			
		$this->SetFillColor(230, 230, 230);	//Plomo claro
		
		//$pdf->Cell(30,3,'F : Fondo Rotatorio','',1,'L',false); 
 		//$pdf->Cell(30,3,'C: Cuenta Documentada','',1,'L',false);  
 		$estado_cuenta=$_SESSION['PDF_estado_cuenta'];
 		$this->Cell(30,3,'Empleado: '.$estado_cuenta[0][3],'',1,'L',false);  
		
		$this->Ln(2);
 		//$pdf->SetX(15);
 		$this->SetFillColor(230 , 230, 230);	//Plomo claro
 		$this->SetFont('Arial','B',7);
 		//$pdf->Cell(10,4,' ','',0,'C',false);
 		//$pdf->Cell(10,3,'TIPO','LTR',0,'C',true); 
 		$this->Cell(17,3,'FECHA','LTR',0,'C',true); 	
 		$this->Cell(20,3,'NÚMERO','LTR',0,'C',true);
 		//$pdf->Cell(35,3,'SOLICITANTE','LTR',0,'C',true);	  
 		$this->Cell(50,3,'CONCEPTO','LTR',0,'C',true);
 		$this->Cell(20,3,'ESTADO','LTR',0,'C',true);   
 		$this->Cell(20,3,'IMPORTE','LTR',0,'C',true);  		
 		$this->Cell(23,3,'NUMERO','LTR',0,'C',true); 
 		$this->Cell(20,3,'ESTADO','LTR',0,'C',true); 
 		$this->Cell(20,3,'IMPORTE','LTR',0,'C',true);  
 		$this->Cell(10,3,'ID','LTR',0,'C',true);  		 
 		$this->Cell(25,3,'SALDO A FAVOR','LTR',0,'C',true); 
 		$this->Cell(25,3,'SALDO A FAVOR','LTR',0,'C',true); 
 		$this->Cell(15,3,'VIATICO','LTR',1,'C',true);
 		
 		
 		$this->Cell(17,3,'SOLICITUD','LRB',0,'C',true);  		
 		$this->Cell(20,3,'SOLICITUD','LRB',0,'C',true);  
 		//$pdf->Cell(35,3,'','LRB',0,'C',true); 
 		$this->Cell(50,3,'','LRB',0,'C',true); 
 		$this->Cell(20,3,'SOLICITUD','LRB',0,'C',true); 
 		$this->Cell(20,3,'ENTREGADO','LRB',0,'C',true); 
 		$this->Cell(23,3,'RENDICIÓN','LRB',0,'C',true); 
 		$this->Cell(20,3,'RENDICIÓN','LRB',0,'C',true); 
 		$this->Cell(20,3,'RENDIDO','LRB',0,'C',true); 
 		$this->Cell(10,3,'CBTE','LRB',0,'C',true); 
 		$this->Cell(25,3,'DEL EMPLEADO','LRB',0,'C',true); 
 		$this->Cell(25,3,'DE ENDE','LRB',0,'C',true);  
 		$this->Cell(15,3,'','LRB',1,'C',true);
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
	    $ip = captura_ip();
	    
	    //$this->line(8,$this->GetY(),203,$this->GetY()); 
		//Número de página
	    $fecha=date("d-m-Y");
		$hora=date("H:i:s");
	    //$this->SetY(-7);
	     
   	    $this->SetFont('Arial','',6);
   	    
   	    //vertical   	    
		/*$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - TESORO',0,0,'L');  //vertical
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	*/
		
		//horizontal
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

//Creación del objeto de la clase heredada
$pdf=new PDF('L','mm','Letter');// main (posicion de la pagina,unidad de medida,tamaño)
$pdf->AliasNbPages();//contador de pagina 

$pdf->AddPage();//para modificar la orienacion de la pagina
/* echo "down down".utf8_decode($_SESSION['tipo_pres']);
exit;*/ 
$pdf->SetAutoPageBreak(true,15);
$pdf->SetFont('Times','',12);

$estado_cuenta=$_SESSION['PDF_estado_cuenta'];

//-------------------------LISTADO DE RENDICIONES------------------------------------------
//$pdf->Ln(3);
				
		/*$pdf->SetFont('Arial','',6);
		$pdf->Cell(200,3,'','',1);			
		$pdf->SetFillColor(230, 230, 230);	//Plomo claro
		
		//$pdf->Cell(30,3,'F : Fondo Rotatorio','',1,'L',false); 
 		//$pdf->Cell(30,3,'C: Cuenta Documentada','',1,'L',false);  
 		$pdf->Cell(30,3,'Empleado: '.$estado_cuenta[0][3],'',1,'L',false);  
		
		$pdf->Ln(2);
 		//$pdf->SetX(15);
 		$pdf->SetFillColor(230 , 230, 230);	//Plomo claro
 		$pdf->SetFont('Arial','B',7);
 		//$pdf->Cell(10,4,' ','',0,'C',false);
 		//$pdf->Cell(10,3,'TIPO','LTR',0,'C',true); 
 		$pdf->Cell(20,3,'FECHA','LTR',0,'C',true); 	
 		$pdf->Cell(20,3,'NÚMERO','LTR',0,'C',true);
 		//$pdf->Cell(35,3,'SOLICITANTE','LTR',0,'C',true);	  
 		$pdf->Cell(65,3,'CONCEPTO','LTR',0,'C',true);
 		$pdf->Cell(20,3,'ESTADO','LTR',0,'C',true);   
 		$pdf->Cell(20,3,'IMPORTE','LTR',0,'C',true);  		
 		$pdf->Cell(20,3,'NUMERO','LTR',0,'C',true); 
 		$pdf->Cell(20,3,'ESTADO','LTR',0,'C',true); 
 		$pdf->Cell(20,3,'IMPORTE','LTR',0,'C',true);  
 		$pdf->Cell(20,3,'ID','LTR',0,'C',true);  		 
 		$pdf->Cell(20,3,'SALDO A FAVOR','LTR',0,'C',true); 
 		$pdf->Cell(20,3,'SALDO A FAVOR','LTR',1,'C',true);
 		
 		
 		
 		
 		$pdf->Cell(20,3,'SOLICITUD','LRB',0,'C',true);  		
 		$pdf->Cell(20,3,'SOLICITUD','LRB',0,'C',true);  
 		//$pdf->Cell(35,3,'','LRB',0,'C',true); 
 		$pdf->Cell(65,3,'','LRB',0,'C',true); 
 		$pdf->Cell(20,3,'SOLICITUD','LRB',0,'C',true); 
 		$pdf->Cell(20,3,'ENTREGADO','LRB',0,'C',true); 
 		$pdf->Cell(20,3,'RENDICIÓN','LRB',0,'C',true); 
 		$pdf->Cell(20,3,'RENDICIÓN','LRB',0,'C',true); 
 		$pdf->Cell(20,3,'RENDIDO','LRB',0,'C',true); 
 		$pdf->Cell(20,3,'COMPROBANTE','LRB',0,'C',true); 
 		$pdf->Cell(20,3,'DEL EMPLEADO','LRB',0,'C',true); 
 		$pdf->Cell(20,3,'DE ENDE','LRB',1,'C',true);  	 			*/	 
 		
 		//Para que muestre la columna estado_rendicion al final
 		/*$pdf->SetWidths(array(5,15,22,34,40,28,34,10,10,11));
		$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0));
 		$pdf->SetAligns(array('C','C','C','L','L','C','L','C','C','C'));
 		$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1));
 		$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6));
 		$pdf->SetFontsStyles(array('','','','','','','','','','',''));
 		$pdf->SetDecimales(array(0,0,0,0,0,0,0,0,0,0));
 		$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3));
 		$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0)); */

 		$pdf->SetWidths(array(10,17,20,35,50,20,20,23,20,20,10,25,25,15));
		$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
 		$pdf->SetAligns(array('C','C','C','L','L','C','R','L','C','R','C','R','R','R'));
 		$pdf->SetVisibles(array(0,1,1,0,1,1,1,1,1,1,1,1,1,1,1));
 		$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6,6));
 		$pdf->SetFontsStyles(array('','','','','','','','','','','','','','','',''));
 		$pdf->SetDecimales(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
 		$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
 		$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)); 					
		
   		$pdf->SetFont('Arial','B',6);
		//$pdf->Cell(200,3,'Solicitudes (Antiguo)','LTBR',1,'L',true);
		
		$total_importe_entregado=0;
		$total_importe_rendido=0;
		$total_saldo_empleado=0;
		$total_saldo_entidad=0;
		$neto_saldo_empleado=0;
		$neto_saldo_entidad=0;
		$total_viatico=0;
		
   		for ($i=0;$i<sizeof($estado_cuenta);$i++)
		{  	 				
	  		$pdf->MultiTabla($estado_cuenta[$i],0,3,3,6,1); 

	  		//$total_importe_entregado=$total_importe_entregado+$estado_cuenta[$i][6]; 
	  		//$total_importe_rendido=$total_importe_rendido+$estado_cuenta[$i][9];
	  		
	  		$total_saldo_empleado=$total_saldo_empleado+$estado_cuenta[$i][11]; 
	  		$total_saldo_entidad=$total_saldo_entidad+$estado_cuenta[$i][12];  	
	  		$total_viatico=$total_viatico+$estado_cuenta[$i][13];
   		}
   		
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(200,5,'Totales:  ','',0,'R');   
   		//$pdf->Cell(20,5,number_format($total_importe_entregado,2),1,0,'R');	
   		//$pdf->Cell(20,5,number_format($total_importe_rendido,2),1,0,'R');	
   		$pdf->Cell(25,5,number_format($total_saldo_empleado,2),1,0,'R');	
   		$pdf->Cell(25,5,number_format($total_saldo_entidad,2),1,0,'R');
   		$pdf->Cell(15,5,number_format($total_viatico,2),1,1,'R');
   		
   		if(($total_saldo_empleado-$total_saldo_entidad)>=0)
   		{
   			//saldo a favor del empleado
   			$neto_saldo_empleado=$total_saldo_empleado-$total_saldo_entidad;
			$neto_saldo_entidad=0;   		
   		}
   		else 
   		{
   			//saldo a favor de la empresa
   			$neto_saldo_empleado=0;
			$neto_saldo_entidad=$total_saldo_entidad-$total_saldo_empleado;
   		}	
   		$pdf->Cell(200,5,'Neto:  ','',0,'R'); 
   		$pdf->Cell(25,5,number_format($neto_saldo_empleado,2),1,0,'R');	
   		$pdf->Cell(25,5,number_format($neto_saldo_entidad,2),1,1,'R');		 

//$pdf->SetRightMargin(10);
$pdf->Output();//mostrar el reporte

?>
