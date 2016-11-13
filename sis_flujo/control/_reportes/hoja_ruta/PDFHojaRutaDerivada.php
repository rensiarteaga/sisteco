<?php

session_start();
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../LibModeloFlujo.php");


class PDF extends FPDF
{	
	//Cabecera de página	
	function Header()
	{
		$this->SetLeftMargin(5);//margen izquierdo	
	    //Logo
	    $this->Image('../../../../lib/images/logo_reporte.jpg',170,5,36,10);
	    $this->SetFont('Arial','B',12);//tifo de fuente
	    //Movernos a la derecha
		$this->Ln(5);//salto de linea 	  
	    $this->Cell(0,5,'REGISTRO DE CORRESPONDENCIA DERIVADA',0,1,'C'); //dibuja una celda con contenido y orientacion  x, y 		
	    
	    
	    if($_SESSION["PDF_desc_uo"] != 'null' && $_SESSION["PDF_desc_uo"] != '')
 		{			    
		    $this->Ln(4);
		    $this->SetFont('Arial','B',8);
		    $this->Cell(0,5,'Unidad: '.$_SESSION["PDF_desc_uo"],0,1,'L');
		    $this->Ln(2); 
		}
	    else
	    {
	    	$this->Ln(6);   
	    }
	}

	//Pie de página
	function Footer()
	{
	    //Posición: a 1,5 cm del final
	    $this->SetY(-12);
	    	    
		//Número de página
	    $fecha=date("d-m-Y");
	    $hora=date("H:i:s");	

	    $this->SetFont('Arial','i',6);
	    if($_SESSION["ss_id_usuario"]==120){
	    	$this->Cell(70,3,'Usuario: ANEYBA IVANOVIC GILKA WARA',0,0,'L');
	    }else{
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
	    }
	    $this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(40,3,'',0,0,'L');
		if($_SESSION["ss_id_usuario"]==120){
			$this->Cell(18,3,'Fecha: 12-07-2016',0,0,'L');
		}else{
		
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		}
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - CORRESPONDENCIA',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(40,3,'',0,0,'L');
		if($_SESSION["ss_id_usuario"]==120){
			$this->Cell(18,3,'Hora: 17:03:47',0,0,'L');
		}ELSE{
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');
		}		   
	}
	
	function maestro()
	{	
	 	$valorY = 20;
	 	$contador = 0;	
	 	
	 	//$arreglo_id_correspondencia= array(658,656,627); 	
	 	$arreglo_id_correspondencia=$_SESSION['PDF_arreglo_id_correspondencia'];

		/*echo $arreglo_id_correspondencia;
		exit();*/
	 	
	 			
		$this->FancyTable($arreglo_id_correspondencia,6,$valorY,200,62,8);
	}	
	
	
	function FancyTable($data,$pos_x,$pos_y,$log_x,$log_y,$letra)
	{		
		$funciones = new funciones();
				
		$this->SetLineWidth(.1);
	    $this->SetFont('Arial','',$letra);
	    
	    //Cabecera
	    $tam_columna=$log_x/7;
	    $tam_fila=$log_y/16;
	   
	    //Restauración de colores y fuentes
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetDrawColor(0,0,0);	
	    
	    $contador=0;
	    $contForeach=0;
	    $Custom = new cls_CustomDBFlujo();//$this->SetY(36);
	    $cant=100;
        $puntero=0;
        $sortcol='corini.fecha_reg';
        $sortdir='asc';

        $id_uo=$_SESSION['PDF_id_uo_rep'];	
        	 	
	 	for($i=0; $i < count($data) ; $i++)
	 	{
	 		//$id_correspondencia= $id_correspondencia-$i;
	 		$id_correspondencia= $data[$i];
	 		$criterio_filtro='corini.id_correspondencia='.$id_correspondencia;	 		 		
	 		
		 	$resRuta=$Custom->ListarReporteHojaRutaDerivada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);	
		 	$dataRuta= $Custom->salida; 
		 	$detalle_show=array();  		 	
		 	
		 	
		 	$criterio_filtro2='corini.id_correspondencia='.$id_correspondencia;
		  	if($id_uo != 'null' && $id_uo != '')
	 		{	 		
	 			$criterio_filtro2=$criterio_filtro2.' and corfin.id_uo='.$id_uo;
	 		}
		   
		    $resRutaFlujo=$Custom->ListarReporteHojaRutaFlujoDerivada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro2);	
		 	$dataRutaFlujo= $Custom->salida;
		 	
		 	
	  
		 	IF(count($dataRutaFlujo)>0)
		 	{		 	
			   foreach($dataRuta as $row)
			   {	
			      $this->SetFont('Arial','B',$letra+1);
			      $this->Cell($tam_columna*1.5,$tam_fila,"Nro: ".$row[1],'TBL',0,'L',0);
			      $this->SetFont('Arial','B',$letra);
			      $this->Cell($tam_columna*2,$tam_fila,"FECHA RECEP: ".$row[2],'TB',0,'L',0);
			      $this->Cell($tam_columna*2,$tam_fila,"FECHA DOC: ".$row[5],'TB',0,'L',0);
			      $this->Cell($tam_columna*1.5,$tam_fila,"TIPO: ".$row[3],'TBR',1,'L',0);
			      	
			      $this->SetFont('Arial','B',$letra);
			      	    
				  $this->Cell($tam_columna*2,$tam_fila,"REMITENTE",'LB',0,'L',0); 
				  $this->Cell($tam_columna*2+$tam_columna/2,$tam_fila,"REFERENCIA",'B',0,'L',0); 
				  $this->Cell($tam_columna,$tam_fila,"ESTADO",'B',0,'L',0); 
				  $this->Cell($tam_columna*1.5,$tam_fila,"OBSERVACIÓN",'RB',1,'L',0);    
				  
				  $this->Ln(1);			  
				  $this->SetFont('Arial','',$letra);			     
			      
			      $this->SetWidths(array($tam_columna*2,$tam_columna*2+$tam_columna/2,$tam_columna,$tam_columna*1.5));
					$this->SetFills(array(0,0,0,0));
				 	$this->SetAligns(array('L','L','L','L'));
				 	$this->SetVisibles(array(1,1,1,1));
				  	$this->SetFontsSizes(array($letra,$letra,$letra,$letra));
				 	$this->SetFontsStyles(array('','','',''));
				 	$this->SetSpaces(array(3,3,3,3));
				 	$this->setDecimales(array(0,0,0,0));
				    $this->SetFormatNumber(array(0,0,0,0));
			      
			      
				  $detalle_show[0][0]=$row[9];	//Remitente
	   		   	  $detalle_show[0][1]=$row[10];	//Referencia
	   		   	  $detalle_show[0][2]=$row[12];	//Estado
	   		   	  $detalle_show[0][3]=$row[13];	//Observación
				  
				  //MultiTabla(Arreglo de datos, No se usa, Bordes 1=horizontales 2=verticales 3=cuadriculado 4=solo marco, spaces, Tamaño letra, Para formatos numericos)
				  $this->MultiTabla($detalle_show[0],0,0,3,$letra,1);				  
				  
			   }//fin del foreach
		 	
		    
		 	
		    	//$pos_y = $pos_y+$tam_fila*6; 
		    	//$this->SetXY($pos_x, $pos_y);	
		    	
		    	$this->Ln(5);  
		  		$this->SetFont('Arial','B',$letra-1);
		        //$this->Cell($tam_columna,$tam_fila,"",'',0,'L',0);
		        $this->Cell($tam_columna/1.5,$tam_fila,"USUARIO",'',0,'L',0);		    
			    $this->Cell($tam_columna,$tam_fila,"FECHA DERIV.",'',0,'L',0); 
			    $this->Cell((($tam_columna+6)*2),$tam_fila,"DERIVADO A",'',0,'L',0); 
			    $this->Cell($tam_columna,$tam_fila,"ACCIÓN",'',0,'L',0);
			    $this->Cell($tam_columna*2+$tam_columna/2,$tam_fila,"MENSAJE",'',1,'L',0); 	
			    $this->SetFont('Arial','',$letra);   
			  
			    $this->SetWidths(array($tam_columna/1.5,$tam_columna,(($tam_columna+6)*2),$tam_columna,$tam_columna*2+$tam_columna/2));
				$this->SetFills(array(0,0,0,0,0));
			 	$this->SetAligns(array('L','L','L','L','L'));
			 	$this->SetVisibles(array(1,1,1,1,1));
			  	$this->SetFontsSizes(array($letra,$letra,$letra,$letra,$letra));
			 	$this->SetFontsStyles(array('','','','',''));
			 	$this->SetSpaces(array(3,3,3,3,3));
			 	$this->setDecimales(array(0,0,0,0,0));
			    $this->SetFormatNumber(array(0,0,0,0,0));
			      
				//$this->SetXY($pos_x, $pos_y+$tam_fila);	
				for ($h=0;$h<count($dataRutaFlujo);$h++)
				{ 
				  	 //MultiTabla(Arreglo de datos, No se usa, Bordes 1=horizontales 2=verticales 3=cuadriculado 4=solo marco, spaces, Tamaño letra, Para formatos numericos)	 			
			 		 $this->MultiTabla($dataRutaFlujo[$h],0,0,5,$letra,1); 	 			 
			 	}
			   
			   $this->Ln(15);	
		   
		 	}//FIN IF	 
			
	 	}//fin del for
	      
	}//fin del funcy table	
	
}

//Creación del objeto de la clase heredada
//$pdf=new PDF('P','mm','Legal'); //Oficio
$pdf=new PDF('P','mm','Letter');  //Carta	

$pdf->AliasNbPages();

$pdf->AddPage('P');
$pdf->SetFont('Times','',12);
$pdf->SetAutoPageBreak(true,20);  //2 milimetros desde el final de la hoja
$pdf->maestro();
//$pdf->FancyTable($header,$data);
$pdf->Output();
?>

?>