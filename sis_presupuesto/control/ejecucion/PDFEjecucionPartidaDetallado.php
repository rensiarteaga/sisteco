<?php

session_start();
require('../../../lib/fpdf/fpdf.php');
require('../../../lib/funciones.inc.php');
include_once("../../../lib/configuracion.log.php");
include_once("../LibModeloPresupuesto.php");

		
class PDF extends FPDF
{
		var  $id_partida=0;
		var  $codigo_partida=0;
		var  $nombre_partida=0;
		var  $desc_partida=0;
		var  $nivel_partida=0;
		var  $sw_transaccional=0;
		var  $tipo_partida=0;
		var  $id_parametro=0;
		var  $id_partida_padre=0;
		var  $tipo_memoria=0;
		var  $sw_movimiento=0;
		var  $id_concepto_colectivo=0;
		var  $mes_01=0;
		var  $mes_02=0;
		var  $mes_03=0;
		var  $mes_04=0;
		var  $mes_05=0;
		var  $mes_06=0;
		var  $mes_07=0;
		var  $mes_08=0;
		var  $mes_09=0;
		var  $mes_10=0;
		var  $mes_11=0;
		var  $mes_12=0;
		var  $total=0;
		var  $relleno=true;	
		
		var  $porcentaje_ejecucion=0;
	 
	//Cabecera de página
	function Header()
	{
		$this->SetLeftMargin(8);//margen izquierdo
		$funciones = new funciones();
	    //Logo
	    	$this->Image('../../../lib/images/logo_reporte.jpg',240,5,36,10);
	    //$this->Image('../../../lib/images/logo_reporte_factur.jpg',210,5);//llama al logo
	    //Arial bold 15
	    $this->SetFont('Arial','B',12);//tifo de fuente
	    //Movernos a la derecha
		$this->Ln(3);//salto de linea 
	    //$this->Cell(100);//celda de dibujo
	    
	    $this->Cell(0,7,'DETALLE DE EJECUCIÓN PRESUPUESTARIA ',0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->SetFont('Arial','I',10);
	    $this->Ln();
	    $this->Cell(0,4,'Presupuesto de '.$_SESSION['PDF_desc_pres']." Gestión ".$_SESSION['PDF_gestion_pres'],0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->SetFont('Arial','I',7);
	    $this->Ln();
	    $this->Cell(0,4,'Del '.$_SESSION['PDF_fecha_desde'].' Al '.$_SESSION['PDF_fecha_hasta']." ",0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->Ln(3);
	    $this->Cell(0,4,'(Expresado en '.$_SESSION['PDF_desc_moneda'].")",0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    
	    
	    $this->Ln(7);//10
	    $this->SetFont('Arial','I',7);
	    	
	    $epe=" ";   
	    $bandera=false;
		    
	    if($_SESSION['PDF_regional']){
	     	$epe=$epe."REGIONAL: ".$_SESSION['PDF_regional'];$bandera=true;
		}
	   	if($_SESSION['PDF_financiador']){
	     	if($bandera){
	     		$epe=$epe." \n "."FINANCIADOR: ".$_SESSION['PDF_financiador'];	
	     	}else{
	     		$epe=$epe."FINANCIADOR: ".$_SESSION['PDF_financiador'];
	     	}
	 	}
	 	if($_SESSION['PDF_programa']){
	 		if($bandera){$epe= $epe." \n "."PROGRAMA: ".$_SESSION['PDF_programa'];	
	 		}else{$epe=$epe."PROGRAMA: ".$_SESSION['PDF_programa'];}
	 	}	 
		if($_SESSION['PDF_proyecto']){
	 		if($bandera){$epe=$epe." \n "."PROYECTO: ".$_SESSION['PDF_proyecto'];	
	 		}else{$epe=$epe."PROYECTO: ".$_SESSION['PDF_proyecto'];}
	 	}	
	 	if($_SESSION['PDF_actividad']){
	 		if($bandera){$epe=$epe." \n "."ACTIVIDAD: ".$_SESSION['PDF_actividad'];	
	 		}else{$epe=$epe."ACTIVIDAD: ".$_SESSION['PDF_actividad'];}
	 		if($bandera){$epe=$epe." \n "."CATEGORIA: ".$_SESSION['PDF_categoria_prog']."  ID: ".$_SESSION['PDF_id_presupuesto'];	
	 		}else{$epe=$epe."CATEGORIA: ".$_SESSION['PDF_categoria_prog']."  ID: ".$_SESSION['PDF_id_presupuesto'];}
	 	}
		   
	 	if($epe==" "){$epe="Todos";};
		
	 	$this->Cell(45,2,'ESTRUCTURA PROGRAMATICA: ',0,0,'L',0);		
		$this->MultiCell(200,2.5,$epe);
		$this->Ln();
	   	$this->Cell(45,2,'UNIDAD ORGANIZACIONAL:',0,0,'L',0);
	    $this->MultiCell(200,2,$_SESSION['PDF_unidad_organizacional'] );
	    $this->Ln();
		$this->Cell(45,2,'FUENTE DE FINANCIAMIENTO:',0,0,'L',0);
	    $this->MultiCell(200,2,$_SESSION['PDF_Fuente_financiamiento']);
		
	    $this->Ln();
	    $this->SetFont('Arial','B',8);	
	    $this->Cell(15,5,'PARTIDA: ',0,0,'L',0);		//CODIGO
	    $this->Cell(120,5,$_SESSION['PDF_desc_partida'],0,1,'L',0);	//PARTIDA	    
	
	   // $this->Ln(0.1);
	    $this->SetFont('Arial','B',6);	
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
   	   // $this->Cell(200,0.2,'',1,1);
		$this->Cell(110,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(82,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(110,3,'Sistema: ENDESIS - PRESTO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(82,3,'',0,0,'L');
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


$comprometidoT=$_SESSION['PDF_comprometidoT'];
$comprometido2T=$_SESSION['PDF_comprometido2T'];
$comprometido3T=$_SESSION['PDF_comprometido3T'];
$comprometido4T=$_SESSION['PDF_comprometido4T'];
$comprometido5T=$_SESSION['PDF_comprometido5T'];
$comprometido6T=$_SESSION['PDF_comprometido6T'];
$comprometido7T=$_SESSION['PDF_comprometido7T'];
$comprometido8T=$_SESSION['PDF_comprometido8T'];

$devengado=$_SESSION['PDF_devengado'];
$devengado2=$_SESSION['PDF_devengado2'];
$devengado3=$_SESSION['PDF_devengado3'];
$devengado4=$_SESSION['PDF_devengado4'];
$devengado5=$_SESSION['PDF_devengado5'];
$devengado6=$_SESSION['PDF_devengado6'];
$devengado7=$_SESSION['PDF_devengado7'];
$devengado8=$_SESSION['PDF_devengado8'];

$pagado=$_SESSION['PDF_pagado'];
$pagado2=$_SESSION['PDF_pagado2'];
$pagado3=$_SESSION['PDF_pagado3'];
$pagado4=$_SESSION['PDF_pagado4'];
$pagado5=$_SESSION['PDF_pagado5'];
$pagado6=$_SESSION['PDF_pagado6'];
$pagado7=$_SESSION['PDF_pagado7'];
$pagado8=$_SESSION['PDF_pagado8'];





//-------------------------TOTAL COMPROMETIDO descontando el REVERTIDO------------------------------------------
$pdf->Ln(3);

		$pdf->SetFillColor(200, 200, 200);	//Plomo oscuro
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(265,5,'DETALLE DE CONCEPTOS COMPROMETIDOS','LTBR',1,'C',true);
				
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(265,3,'','',1);			
		$pdf->SetFillColor(230, 230, 230);	//Plomo claro
		
		//$pdf->Ln(2);
 		//$pdf->SetX(15);
 		$pdf->SetFillColor(230 , 230, 230);	//Plomo claro
 		$pdf->SetFont('Arial','B',7);
 		
 		$pdf->Cell(15,4,'SISTEMA ','LTRB',0,'C',true);  
 		$pdf->Cell(35,4,'NRO DOCUMENTO','LTRB',0,'C',true); 
 		$pdf->Cell(20,4,'FECHA DOC ','LTRB',0,'C',true);  
 		$pdf->Cell(50,4,'SOLICITANTE ','LTRB',0,'C',true);  
		$pdf->Cell(65,4,'MOTIVO ','LTRB',0,'C',true);  
 		$pdf->Cell(40,4,'CONCEPTO ','LTRB',0,'C',true);  
 		$pdf->Cell(20,4,'FECHA EJE ','LTRB',0,'C',true); 
 		$pdf->Cell(20,4,'IMPORTE ','LTRB',1,'C',true); 
 		//$pdf->Cell(10,4,'ID ','LTRB',1,'C',true); 		 
 		
 		
 		$pdf->SetWidths(array(15,35,20,50,65,40,20,20));
		$pdf->SetFills(array(0,0,0,0,0,0,0,0));
 		$pdf->SetAligns(array('C','C','C','L','L','L','C','R'));
 		$pdf->SetVisibles(array(1,1,1,1,1,1,1,1));
 		$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6));
 		$pdf->SetFontsStyles(array('','','','','','','','',''));
 		$pdf->SetDecimales(array(0,0,0,0,0,0,0,2));
 		$pdf->SetSpaces(array(3,3,3,3,3,3,3,3));
 		$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,1));
 		
				
		$total_importe_comprometidoT=0;
		$total_comprometidoT=0;
		$total_comprometido2T=0;
		$total_comprometido3T=0;
		$total_comprometido4T=0;
		$total_comprometido5T=0;
		$total_comprometido6T=0;
		$total_comprometido7T=0;
		$total_comprometido8T=0;
		
   		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(265,3,'Solicitudes de viáticos, fondos en avance y solicitudes de efectivo','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($comprometidoT);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($comprometidoT[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_comprometidoT=$total_importe_comprometidoT+$comprometidoT[$i][7];
	  		$total_comprometidoT=$total_comprometidoT+$comprometidoT[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total comprometido desde solicitudes de tesoreria:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_comprometidoT,2),1,1,'R');
   		
   		
   		/*$pdf->Cell(200,3,'Rendiciones','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($comprometido2T);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($comprometido2T[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_comprometidoT=$total_importe_comprometidoT+$comprometido2T[$i][6];
	  		$total_comprometido2T=$total_comprometido2+$comprometido2T[$i][6];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(180,5,'Sub total comprometido rendiciones:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_comprometido2T,2),1,1,'R');*/   		
   		
   		
   		$pdf->Cell(265,3,'Comprobantes contables manuales','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($comprometido3T);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($comprometido3T[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_comprometidoT=$total_importe_comprometidoT+$comprometido3T[$i][7];
	  		$total_comprometido3T=$total_comprometido3T+$comprometido3T[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total comprometido desde comprobantes:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_comprometido3T,2),1,1,'R');
   		
   		
   		$pdf->Cell(265,3,'Solicitudes de compra de la gestión actual','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($comprometido4T);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($comprometido4T[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_comprometidoT=$total_importe_comprometidoT+$comprometido4T[$i][7];
	  		$total_comprometido4T=$total_comprometido4T+$comprometido4T[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total comprometido desde solicitudes de compra:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_comprometido4T,2),1,1,'R');
   		
   		
   		$pdf->Cell(265,3,'Solicitudes de compra de la gestión anterior','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($comprometido5T);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($comprometido5T[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_comprometidoT=$total_importe_comprometidoT+$comprometido5T[$i][7];
	  		$total_comprometido5T=$total_comprometido5T+$comprometido5T[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total comprometido desde solicitudes de compra de la gestion anterior:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_comprometido5T,2),1,1,'R');
   		
   		
   		$pdf->Cell(265,3,'Pagos Devengados','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($comprometido6T);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($comprometido6T[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_comprometidoT=$total_importe_comprometidoT+$comprometido6T[$i][7];
	  		$total_comprometido6T=$total_comprometido6T+$comprometido6T[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total comprometido desde pagos devengados:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_comprometido6T,2),1,1,'R');
		
		
		$pdf->Cell(265,3,'Planillas de sueldos','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($comprometido7T);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($comprometido7T[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_comprometidoT=$total_importe_comprometidoT+$comprometido7T[$i][7];
	  		$total_comprometido7T=$total_comprometido7T+$comprometido7T[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total comprometido desde planillas de sueldos:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_comprometido7T,2),1,1,'R');
		
		
		$pdf->Cell(265,3,'Otros','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($comprometido8T);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($comprometido8T[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_comprometidoT=$total_importe_comprometidoT+$comprometido8T[$i][7];
	  		$total_comprometido8T=$total_comprometido8T+$comprometido8T[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total comprometido otros:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_comprometido8T,2),1,1,'R');
   		
   		
   		$pdf->Cell(245,5,'TOTAL COMPROMETIDO:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_importe_comprometidoT,2),1,1,'R');
   		
   		
 
//-------------------------DEVENGADO------------------------------------------
$pdf->Ln(5);

		$pdf->SetFillColor(200, 200, 200);	//Plomo oscuro
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(265,5,'DETALLE DE CONCEPTOS DEVENGADOS','LTBR',1,'C',true);
				
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(265,3,'','',1);			
		$pdf->SetFillColor(230, 230, 230);	//Plomo claro 
		
		//$pdf->Ln(2);
 		//$pdf->SetX(15);
 		$pdf->SetFillColor(230 , 230, 230);	//Plomo claro
 		$pdf->SetFont('Arial','B',7);
 		//$pdf->Cell(10,4,' ','',0,'C',false);
 		$pdf->Cell(15,4,'SISTEMA ','LTRB',0,'C',true);  
 		$pdf->Cell(35,4,'NRO DOCUMENTO','LTRB',0,'C',true); 
 		$pdf->Cell(20,4,'FECHA DOC ','LTRB',0,'C',true);  
 		$pdf->Cell(50,4,'SOLICITANTE ','LTRB',0,'C',true);  
		$pdf->Cell(65,4,'MOTIVO ','LTRB',0,'C',true);  
 		$pdf->Cell(40,4,'CONCEPTO ','LTRB',0,'C',true);  
 		$pdf->Cell(20,4,'FECHA EJE ','LTRB',0,'C',true); 
 		$pdf->Cell(20,4,'IMPORTE ','LTRB',1,'C',true); 
 		//$pdf->Cell(10,4,'','',1,'C',false);  
 		
 		
		$pdf->SetWidths(array(15,35,20,50,65,40,20,20));
		$pdf->SetFills(array(0,0,0,0,0,0,0,0));
 		$pdf->SetAligns(array('C','C','C','L','L','L','C','R'));
 		$pdf->SetVisibles(array(1,1,1,1,1,1,1,1));
 		$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6));
 		$pdf->SetFontsStyles(array('','','','','','','','',''));
 		$pdf->SetDecimales(array(0,0,0,0,0,0,0,2));
 		$pdf->SetSpaces(array(3,3,3,3,3,3,3,3));
 		$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,1));
		
		$total_importe_devengado=0;
		$total_devengado=0;
		$total_devengado2=0;
		$total_devengado3=0;
		$total_devengado4=0;
		$total_devengado5=0;
		$total_devengado6=0;
		$total_devengado7=0;
		$total_devengado8=0;
		
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(265,3,'Solicitudes de viáticos, fondos en avance y solicitudes de efectivo','LTBR',1,'L',true);
		for ($i=0;$i<sizeof($devengado);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($devengado[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_devengado=$total_importe_devengado+$devengado[$i][7];
	  		$total_devengado=$total_devengado+$devengado[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total devengado desde solicitudes de tesoreria:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_devengado,2),1,1,'R');
   		
		$pdf->Cell(265,3,'Rendiciones de cuenta','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($devengado2);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($devengado2[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_devengado=$total_importe_devengado+$devengado2[$i][7];
	  		$total_devengado2=$total_devengado2+$devengado2[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total devengado desde rendiciones de cuentas:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_devengado2,2),1,1,'R');
   		
		$pdf->Cell(265,3,'Comprobantes contables manuales','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($devengado3);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($devengado3[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_devengado=$total_importe_devengado+$devengado3[$i][7];
	  		$total_devengado3=$total_devengado3+$devengado3[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total devengado desde comprobantes:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_devengado3,2),1,1,'R');
   		
   		$pdf->Cell(265,3,'Solicitudes de compra de la gestión actual','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($devengado4);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($devengado4[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_devengado=$total_importe_devengado+$devengado4[$i][7];
	  		$total_devengado4=$total_devengado4+$devengado4[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total devengado desde solicitudes de compra:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_devengado4,2),1,1,'R');
   		
   		$pdf->Cell(265,3,'Solicitudes de compra de la gestión anterior','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($devengado5);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($devengado5[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_devengado=$total_importe_devengado+$devengado5[$i][7];
	  		$total_devengado5=$total_devengado5+$devengado5[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total devengado desde solicitudes de compra de la gestion anterior:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_devengado5,2),1,1,'R');
   		
   		
   		$pdf->Cell(265,3,'Pagos devengados desde tesoreria','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($devengado6);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($devengado6[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_devengado=$total_importe_devengado+$devengado6[$i][7];
	  		$total_devengado6=$total_devengado6+$devengado6[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total devengado desde pagos devengados:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_devengado6,2),1,1,'R');
		
		
		$pdf->Cell(265,3,'Planillas de sueldos','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($devengado7);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($devengado7[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_devengado=$total_importe_devengado+$devengado7[$i][7];
	  		$total_devengado7=$total_devengado7+$devengado7[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total devengado desde planillas de sueldos:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_devengado7,2),1,1,'R');
		
		
		$pdf->Cell(265,3,'Otros','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($devengado8);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($devengado8[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_devengado=$total_importe_devengado+$devengado8[$i][7];
	  		$total_devengado8=$total_devengado8+$devengado8[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total devengado otros:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_devengado8,2),1,1,'R');
   		
   		
   		$pdf->Cell(245,5,'TOTAL DEVENGADO:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_importe_devengado,2),1,1,'R');
   		//$pdf->Cell(10,5,'','',1);   

//-------------------------PAGADO------------------------------------------
$pdf->Ln(5);

		$pdf->SetFillColor(200, 200, 200);	//Plomo oscuro
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(265,5,'DETALLE DE CONCEPTOS PAGADOS','LTBR',1,'C',true);
				
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(264,3,'','',1);			
		$pdf->SetFillColor(230, 230, 230);	//Plomo claro
		
		//$pdf->Ln(2);
 		//$pdf->SetX(15);
 		$pdf->SetFillColor(230 , 230, 230);	//Plomo claro
 		$pdf->SetFont('Arial','B',7);
 		//$pdf->Cell(10,4,' ','',0,'C',false);
 		$pdf->Cell(15,4,'SISTEMA ','LTRB',0,'C',true);  
 		$pdf->Cell(35,4,'NRO DOCUMENTO','LTRB',0,'C',true); 
 		$pdf->Cell(20,4,'FECHA DOC ','LTRB',0,'C',true);  
 		$pdf->Cell(50,4,'SOLICITANTE ','LTRB',0,'C',true);  
		$pdf->Cell(65,4,'MOTIVO ','LTRB',0,'C',true);  
 		$pdf->Cell(40,4,'CONCEPTO ','LTRB',0,'C',true);  
 		$pdf->Cell(20,4,'FECHA EJE ','LTRB',0,'C',true); 
 		$pdf->Cell(20,4,'IMPORTE ','LTRB',1,'C',true); 
 		//$pdf->Cell(10,4,'','',1,'C',false);  
 		
 		
		$pdf->SetWidths(array(15,35,20,50,65,40,20,20));
		$pdf->SetFills(array(0,0,0,0,0,0,0,0));
 		$pdf->SetAligns(array('C','C','C','L','L','L','C','R'));
 		$pdf->SetVisibles(array(1,1,1,1,1,1,1,1));
 		$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6));
 		$pdf->SetFontsStyles(array('','','','','','','','',''));
 		$pdf->SetDecimales(array(0,0,0,0,0,0,0,2));
 		$pdf->SetSpaces(array(3,3,3,3,3,3,3,3));
 		$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,1));
		
		$total_importe_pagado=0;
		$total_pagado=0;
		$total_pagado2=0;
		$total_pagado3=0;
		$total_pagado4=0;
		$total_pagado5=0;
		$total_pagado6=0;
		$total_pagado7=0;
		$total_pagado8=0;
		
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(265,3,'Solicitudes de viáticos y fondos en avance','LTBR',1,'L',true);
		for ($i=0;$i<sizeof($pagado);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($pagado[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_pagado=$total_importe_pagado+$pagado[$i][7];
	  		$total_pagado=$total_pagado+$pagado[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total pagado desde solicitudes de tesoreria:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_pagado,2),1,1,'R');
   		
		$pdf->Cell(265,3,'Rendiciones de cuenta','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($pagado2);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($pagado2[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_pagado=$total_importe_pagado+$pagado2[$i][7];
	  		$total_pagado2=$total_pagado2+$pagado2[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total pagado desde rendiciones de cuenta:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_pagado2,2),1,1,'R');
   		
		$pdf->Cell(265,3,'Comprobantes contables manuales','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($pagado3);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($pagado3[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_pagado=$total_importe_pagado+$pagado3[$i][7];
	  		$total_pagado3=$total_pagado3+$pagado3[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total pagado desde comprobantes:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_pagado3,2),1,1,'R');
   		
   		$pdf->Cell(265,3,'Solicitudes de compra de la gestión actual','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($pagado4);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($pagado4[$i],0,3,3,6,1);  
	  		
			if ($_SESSION['ss_id_usuario']==131){
			$pdf->Cell(10,4,'saleee aquiiii :(','',1,'C',false);  
			//echo "llega?";
			//exit;
             }			
	  		$total_importe_pagado=$total_importe_pagado+$pagado4[$i][7];
	  		$total_pagado4=$total_pagado4+$pagado4[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total pagado desde solicitudes de compra:','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_pagado4,2),1,1,'R');
   		
   		$pdf->Cell(265,3,'Solicitudes de compra de la gestión anterior','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($pagado5);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($pagado5[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_pagado=$total_importe_pagado+$pagado5[$i][7];
	  		$total_pagado5=$total_pagado5+$pagado5[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total pagado desde solicitudes de compra de la gestion anterior:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_pagado5,2),1,1,'R');
   		
   		$pdf->Cell(265,3,'Pagos Devengados','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($pagado6);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($pagado6[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_pagado=$total_importe_pagado+$pagado6[$i][7];
	  		$total_pagado6=$total_pagado6+$pagado6[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total pagado desde pagos devengados:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_pagado6,2),1,1,'R');
		
		
		$pdf->Cell(265,3,'Planillas de Sueldos','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($pagado7);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($pagado7[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_pagado=$total_importe_pagado+$pagado7[$i][7];
	  		$total_pagado7=$total_pagado7+$pagado7[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total pagado desde planilla de sueldos:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_pagado7,2),1,1,'R');
		
		
		$pdf->Cell(265,3,'Otros','LTBR',1,'L',true);
   		for ($i=0;$i<sizeof($pagado8);$i++)
		{  	 	
			//$pdf->Cell(10,4,' ','',0,'C',false);	
	  		$pdf->MultiTabla($pagado8[$i],0,3,3,6,1);  
	  		//$pdf->Cell(10,4,'','',1,'C',false);  		
	  		$total_importe_pagado=$total_importe_pagado+$pagado8[$i][7];
	  		$total_pagado8=$total_pagado8+$pagado8[$i][7];
   		}
   		$pdf->SetFont('Arial','B',6);
   		$pdf->Cell(245,5,'Sub total pagado desde planilla de sueldos:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_pagado8,2),1,1,'R');
   		
   		
   		$pdf->Cell(245,5,'TOTAL PAGADO:  ','',0,'R');   		
   		$pdf->Cell(20,5,number_format($total_importe_pagado,2),1,1,'R');
   		//$pdf->Cell(10,5,'','',1);      		  		

//--------------------------------RESUMEN--------------------------------   		
 $pdf->Ln(5);

		$pdf->SetFillColor(200, 200, 200);	//Plomo oscuro
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(265,5,'RESUMEN DE IMPORTES OBTENIDOS','LTBR',1,'C',true);
				
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(265,3,'','',1);			
		$pdf->SetFillColor(230, 230, 230);	//Plomo claro
		
		//$pdf->Ln(2);
 		//$pdf->SetX(15);
 		$pdf->SetFillColor(230 , 230, 230);	//Plomo claro
 		$pdf->SetFont('Arial','B',7);
 		//$pdf->Cell(10,4,' ','',0,'C',false);
 		$pdf->Cell(40,4,'DESCRIPCIÓN ','LTRB',0,'C',true);  
 		$pdf->Cell(25,4,'SOLICITUDES ','LTRB',0,'C',true); 
 		$pdf->Cell(25,4,'RENDICIONES ','LTRB',0,'C',true);  
 		$pdf->Cell(25,4,'COMPROBANTES ','LTRB',0,'C',true);  
 		$pdf->Cell(25,4,'ADQUISICIONES ','LTRB',0,'C',true);  
 		$pdf->Cell(25,4,'ADQUISICIONES 2 ','LTRB',0,'C',true); 
 		$pdf->Cell(25,4,'P. DEVENGADOS ','LTRB',0,'C',true); 
		$pdf->Cell(25,4,'PLANILLA SUELDOS ','LTRB',0,'C',true); 
		$pdf->Cell(25,4,'OTROS ','LTRB',0,'C',true); 
 		$pdf->Cell(25,4,'TOTALES ','LTRB',1,'C',true);  
 		
 		/*$pdf->Cell(45,4,'SOLO COMPROMETIDO (C)','LTRB',0,'L',false);  
 		$pdf->Cell(22,4,number_format($total_comprometido,2),'LTRB',0,'R',false); 
 		$pdf->Cell(22,4,number_format($total_comprometido2,2),'LTRB',0,'R',false);  
 		$pdf->Cell(22,4,number_format($total_comprometido3,2),'LTRB',0,'R',false);  
 		$pdf->Cell(22,4,number_format($total_comprometido4,2),'LTRB',0,'R',false);  
 		$pdf->Cell(22,4,number_format($total_comprometido5,2),'LTRB',0,'R',false);
 		$pdf->Cell(22,4,number_format($total_comprometido6,2),'LTRB',0,'R',false); 
 		$pdf->Cell(23,4,number_format($total_importe_comprometido,2),'LTRB',1,'R',false);	
 		
 		$pdf->Cell(45,4,'SOLO REVERTIDO (R)','LTRB',0,'L',false);  
 		$pdf->Cell(22,4,number_format($total_revertido,2),'LTRB',0,'R',false); 
 		$pdf->Cell(22,4,number_format($total_revertido2,2),'LTRB',0,'R',false);  
 		$pdf->Cell(22,4,number_format($total_revertido3,2),'LTRB',0,'R',false);  
 		$pdf->Cell(22,4,number_format($total_revertido4,2),'LTRB',0,'R',false);  
 		$pdf->Cell(22,4,number_format($total_revertido5,2),'LTRB',0,'R',false); 
 		$pdf->Cell(22,4,number_format($total_revertido6,2),'LTRB',0,'R',false); 
 		$pdf->Cell(23,4,number_format($total_importe_revertido,2),'LTRB',1,'R',false);
 		
 		$pdf->Cell(45,4,'TOTAL COMPROMETIDO (C+R)','LTRB',0,'L',false);  
 		$pdf->Cell(22,4,number_format($total_comprometido+$total_revertido,2),'LTRB',0,'R',false); 
 		$pdf->Cell(22,4,number_format($total_comprometido2+$total_revertido2,2),'LTRB',0,'R',false);  
 		$pdf->Cell(22,4,number_format($total_comprometido3+$total_revertido3,2),'LTRB',0,'R',false);  
 		$pdf->Cell(22,4,number_format($total_comprometido4+$total_revertido4,2),'LTRB',0,'R',false);  
 		$pdf->Cell(22,4,number_format($total_comprometido5+$total_revertido5,2),'LTRB',0,'R',false);
 		$pdf->Cell(22,4,number_format($total_comprometido6+$total_revertido6,2),'LTRB',0,'R',false);  
 		$pdf->Cell(23,4,number_format($total_importe_comprometido+$total_importe_revertido,2),'LTRB',1,'R',false);*/	
 		
 		$pdf->Cell(40,4,'TOTAL COMPROMETIDO ','LTRB',0,'L',false);  
 		$pdf->Cell(25,4,number_format($total_comprometidoT,2),'LTRB',0,'R',false); 
 		$pdf->Cell(25,4,number_format($total_comprometido2T,2),'LTRB',0,'R',false);  
 		$pdf->Cell(25,4,number_format($total_comprometido3T,2),'LTRB',0,'R',false);  
 		$pdf->Cell(25,4,number_format($total_comprometido4T,2),'LTRB',0,'R',false);  
 		$pdf->Cell(25,4,number_format($total_comprometido5T,2),'LTRB',0,'R',false);
 		$pdf->Cell(25,4,number_format($total_comprometido6T,2),'LTRB',0,'R',false); 
		$pdf->Cell(25,4,number_format($total_comprometido7T,2),'LTRB',0,'R',false); 
		$pdf->Cell(25,4,number_format($total_comprometido8T,2),'LTRB',0,'R',false); 
 		$pdf->Cell(25,4,number_format($total_importe_comprometidoT,2),'LTRB',1,'R',false);
 		
 		$pdf->Cell(40,4,'TOTAL DEVENGADO ','LTRB',0,'L',false);  
 		$pdf->Cell(25,4,number_format($total_devengado,2),'LTRB',0,'R',false); 
 		$pdf->Cell(25,4,number_format($total_devengado2,2),'LTRB',0,'R',false);  
 		$pdf->Cell(25,4,number_format($total_devengado3,2),'LTRB',0,'R',false);  
 		$pdf->Cell(25,4,number_format($total_devengado4,2),'LTRB',0,'R',false);  
 		$pdf->Cell(25,4,number_format($total_devengado5,2),'LTRB',0,'R',false); 
 		$pdf->Cell(25,4,number_format($total_devengado6,2),'LTRB',0,'R',false); 
		$pdf->Cell(25,4,number_format($total_devengado7,2),'LTRB',0,'R',false); 
		$pdf->Cell(25,4,number_format($total_devengado8,2),'LTRB',0,'R',false); 
 		$pdf->Cell(25,4,number_format($total_importe_devengado,2),'LTRB',1,'R',false);

 		$pdf->Cell(40,4,'TOTAL PAGADO ','LTRB',0,'L',false);  
 		$pdf->Cell(25,4,number_format($total_pagado,2),'LTRB',0,'R',false); 
 		$pdf->Cell(25,4,number_format($total_pagado2,2),'LTRB',0,'R',false);  
 		$pdf->Cell(25,4,number_format($total_pagado3,2),'LTRB',0,'R',false);  
 		$pdf->Cell(25,4,number_format($total_pagado4,2),'LTRB',0,'R',false);  
 		$pdf->Cell(25,4,number_format($total_pagado5,2),'LTRB',0,'R',false); 
 		$pdf->Cell(25,4,number_format($total_pagado6,2),'LTRB',0,'R',false); 
		$pdf->Cell(25,4,number_format($total_pagado7,2),'LTRB',0,'R',false);
		$pdf->Cell(25,4,number_format($total_pagado8,2),'LTRB',0,'R',false); 		
 		$pdf->Cell(25,4,number_format($total_importe_pagado,2),'LTRB',1,'R',false);	
 			

//$pdf->SetRightMargin(10);
$pdf->Output();//mostrar el reporte
?>