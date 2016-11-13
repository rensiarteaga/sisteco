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
	    $this->Cell(0,5,'REGISTRO DE CORRESPONDENCIA RECIBIDA',0,1,'C'); //dibuja una celda con contenido y orientacion  x, y 		
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
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(40,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - CORRESPONDENCIA',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(40,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');		   
	}
	
	function maestro()
	{	
		//$periodo=4;
		//$ruta=$_SESSION['ruta'];			
			
		//$Custom = new cls_CustomDBFlujo();//$this->SetY(36);	
		//$id_correspondencia=$_SESSION['id_correspondencia'];
		
		/*$cant = 1000;
		$puntero = 0;
		$valorY = 10;
		$contador = 0;				 	
	 	$resRuta=$Custom->ListarReporteHojaRuta($id_parametro,$ruta,$gestion,$periodo);	*/
	 	
	 	//$resRuta=$Custom->ListarClientesRuta($id_parametro,$ruta,$gestion,4);
	 	
	 	/*$cant=1;
        $puntero=0;
        $sortcol='corini.fecha_reg';
        $sortdir='asc';
        $criterio_filtro='corini.id_correspondencia='.$id_correspondencia; */
	 	
	 	$valorY = 20;
	 	$contador = 0;	
	 	
	 	//$arreglo_id_correspondencia= array(658,656,627); 	
	 	$arreglo_id_correspondencia=$_SESSION['arreglo_id_correspondencia'];

		/*echo $arreglo_id_correspondencia;
		exit();*/
	 	
	 			
		$this->FancyTable($arreglo_id_correspondencia,6,$valorY,200,62,7);					
		 	
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
	    
	    $Custom = new cls_CustomDBFlujo();//$this->SetY(36);
	    $cant=1;
        $puntero=0;
        $sortcol='corini.fecha_reg';
        $sortdir='asc';
        //$criterio_filtro='corini.id_correspondencia='.$id_correspondencia; 
	 	
	 	for($i=0; $i < count($data) ; $i++)
	 	{
	 		//$id_correspondencia= $id_correspondencia-$i;
	 		$id_correspondencia= $data[$i];
	 		$criterio_filtro='corini.id_correspondencia='.$id_correspondencia;
	 		
		 	$resRuta=$Custom->ListarReporteHojaRuta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);	
		 	$dataRuta= $Custom->salida;
		 	
		 	//$this->Cell($tam_columna/5,$tam_fila,"Númerito: ".$i,1,1,'L',1); 
	    	//$this->Cell($tam_columna/5,$tam_fila,"Númerito: ".$id_correspondencia,1,1,'L',1); 
	    	  
	  
		   foreach($dataRuta as $row)
		   {		   		 	   
		   	  //$this->SetXY($pos_x, $pos_y-6);	
		   	  $this->SetFont('Arial','B',$letra+3);		  
		      //$this->Cell($tam_columna*7,$tam_fila,"AVISO DE COBRANZA",'',0,'C',0);	
		        
		      
		      $this->SetXY($pos_x,$pos_y);	
		      $this->SetFont('Arial','B',$letra);
		      $this->Cell($tam_columna*2,$tam_fila,"Número: ".$row[1],'TBL',0,'L',0);
		      $this->Cell($tam_columna*2,$tam_fila,"Fecha de Recepción: ".$row[2],'TB',0,'L',0);
		      $this->Cell($tam_columna*1.5,$tam_fila,"Fecha de Documento: ".$row[5],'TB',0,'L',0);
		      $this->Cell($tam_columna*1,$tam_fila,"Tipo: ".$row[3],'TB',0,'L',0);
		      $this->Cell($tam_columna/2,$tam_fila,"Aréa: ".$row[4],'TBR',0,'L',0);	
		      
		      $this->Ln(); $this->SetX($pos_x);	
		      $this->SetFont('Arial','B',$letra);
		      //$this->Cell($tam_columna/2,$tam_fila,"Tipo",'',0,'L',0);
		      //$this->Cell($tam_columna/2,$tam_fila,"Aréa",'',0,'L',0);		    
			  $this->Cell($tam_columna*2,$tam_fila,"Remitente",'',0,'L',0); 
			  $this->Cell($tam_columna*2,$tam_fila,"Referencia",'',0,'L',0);   
			  $this->Cell($tam_columna,$tam_fila,"Acción",'',0,'L',0);
			  $this->Cell($tam_columna/2,$tam_fila,"Estado",'',0,'L',0); 
			  $this->Cell($tam_columna*1.5,$tam_fila,"Observación",'',0,'L',0);    
			  
			  $this->Ln(); $this->SetX($pos_x);
			  $this->SetFont('Arial','',$letra);
		      $this->MultiCell($tam_columna*2,$tam_fila,$row[9],'T','L',1); 
			  $this->SetXY($pos_x+$tam_columna*2,$pos_y+$tam_fila*2);		  
			  $this->MultiCell($tam_columna*2,$tam_fila,$row[10],'T','L',1);			  
			  $this->SetXY($pos_x+$tam_columna*4,$pos_y+$tam_fila*2); 
			  
			  $this->MultiCell($tam_columna,$tam_fila,$row[12],'T','L',1); 
			  $this->SetXY($pos_x+$tam_columna*4+$tam_columna,$pos_y+$tam_fila*2);
			  //$this->Cell($tam_columna,$tam_fila,$row[12],'LTRB',0,'L',0); 
			  $this->Cell($tam_columna/2,$tam_fila,$row[13],'T',0,'L',1); 
			  $this->MultiCell($tam_columna*1.5,$tam_fila,$row[14],'T','L',1); 
			  //$this->SetXY($pos_x,$pos_y+$tam_fila*5);	
		        
			    
		   }//fin del foreach
	   	   
		  
		    $resRutaFlujo=$Custom->ListarReporteHojaRutaFlujo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);	
		 	$dataRutaFlujo= $Custom->salida;
		 	
		 	//$this->Cell($tam_columna/5,$tam_fila,"Númerito: ".$i,1,1,'L',1); 
	    	//$this->Cell($tam_columna/5,$tam_fila,"Númerito: ".$id_correspondencia,1,1,'L',1);
	    	
	    	$pos_y = $pos_y+$tam_fila*6; 
	    	$this->SetXY($pos_x, $pos_y);	
	    	  
	  
		   foreach($dataRutaFlujo as $rowF)
		   {  	
		   	  $this->SetX($pos_x);		   	  
		      $this->SetFont('Arial','B',$letra);
		      $this->Cell($tam_columna,$tam_fila,"",'',0,'L',0);
		      $this->Cell($tam_columna,$tam_fila,"Usuario",'',0,'L',0);		    
			  $this->Cell($tam_columna,$tam_fila,"Fecha Recepción",'',0,'L',0); 
			  $this->Cell($tam_columna*2,$tam_fila,"Dirigido a",'',0,'L',0); 
			  $this->Cell($tam_columna*2,$tam_fila,"Mensaje",'',1,'L',0);    
			  
			  $this->SetX($pos_x); 			 
			  $this->SetFont('Arial','',$letra);	 
			  $this->Cell($tam_columna,$tam_fila,'','',0,'L',0);	

			  $this->Cell($tam_columna,$tam_fila,$rowF[0],'T',0,'L',0);  
		      			  
			  $this->MultiCell($tam_columna,$tam_fila,$rowF[1],'T','L',0);
			  $this->SetXY($pos_x+$tam_columna*3,$pos_y+$tam_fila);			 
			  		  
			  $this->MultiCell($tam_columna*2,$tam_fila,$rowF[2],'T','L',0); 
			  $this->SetXY($pos_x+$tam_columna*5,$pos_y+$tam_fila); 	
			  		  
			  $this->MultiCell($tam_columna*2,$tam_fila,$rowF[3],'T','L',0);			   
			  //$this->SetXY($pos_x,$pos_y+$tam_fila*5);
			  
			  $pos_y = $pos_y+$tam_fila*2;
			    
		   }//fin del foreach
		   
		    
		   
		   
		   
		   $contador = $contador+1;				 	 
			if($contador<5)
			{
				//$pos_y = $pos_y+40;				
			}	
			else 
			{
				$this->addPage();
				$pos_y = 10;
				$contador = 0;
			}
			
			$pos_y = $pos_y+$tam_fila*5;
			
	 	}//fin del for
	      
	}//fin del funcy table
	
	
	
   /* function imprimirImportes($row,$pos_x,$pos_y,$log_x,$log_y,$letra)
    {   
		$this->SetXY($pos_x,$pos_y);
		$this->SetLineWidth(.1);
	    $this->SetFont('Arial','',$letra);
	    
	    //Cabecera
	    $sub_tam_columna=$log_x/2;
	    $sub_tam_fila=$log_y/11;
	   
	    //Restauración de colores y fuentes
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetDrawColor(0,0,0);	      
	    	
	      $this->Cell($sub_tam_columna,$sub_tam_fila,"Importe por Energía:",'R',0,'L',0);   
	      $this->Cell($sub_tam_columna,$sub_tam_fila,$row[28],'L',0,'R',0);  	
	      $this->Ln(); $this->SetX($pos_x);	 
	      
	      $this->Cell($sub_tam_columna,$sub_tam_fila,"Importe por Potencia:",'R',0,'L',0);   
	      $this->Cell($sub_tam_columna,$sub_tam_fila,$row[29],'L',0,'R',0);   
	      $this->Ln(); $this->SetX($pos_x);	 
	      
	      $this->Cell($sub_tam_columna,$sub_tam_fila,"Importe por Corte/Reconexión:",'R',0,'L',0);   
	      $this->Cell($sub_tam_columna,$sub_tam_fila,$row[30],'L',0,'R',0);  
	      $this->Ln(); $this->SetX($pos_x);	 
	      
	      $this->Cell($sub_tam_columna,$sub_tam_fila,"Créditos/Débitos/Devolución:",'R',0,'L',0);   
	      $this->Cell($sub_tam_columna,$sub_tam_fila,$row[31],'L',0,'R',0);   
	      
	      $this->Ln(); $this->SetX($pos_x);	 $this->SetFont('Arial','BU',$letra);
	      $this->Cell($sub_tam_columna,$sub_tam_fila,"Importe Total por el Suministro:",'R',0,'L',0);   
	      $this->Cell($sub_tam_columna,$sub_tam_fila,$row[32],'L',0,'R',0);   $this->SetFont('Arial','',$letra);
	      
	      $this->Ln(); $this->SetX($pos_x);	 
	      $this->Cell($sub_tam_columna,$sub_tam_fila,"Descuento por Vejes (Ley 1886):",'R',0,'L',0);   
	      $this->Cell($sub_tam_columna,$sub_tam_fila,$row[33],'L',0,'R',0);  
	      
	      $this->Ln(); $this->SetX($pos_x);	 
	      $this->Cell($sub_tam_columna,$sub_tam_fila,"Descuento por Tarifa Dignidad:",'R',0,'L',0);   
	      $this->Cell($sub_tam_columna,$sub_tam_fila,$row[34],'L',0,'R',0);  
	      
	      $this->Ln(); $this->SetX($pos_x);	 $this->SetFont('Arial','BU',$letra);
	      $this->Cell($sub_tam_columna,$sub_tam_fila,"Importe Total :",'R',0,'L',0);   
	      $this->Cell($sub_tam_columna,$sub_tam_fila,$row[35],'L',0,'R',0);   $this->SetFont('Arial','',$letra);
	      
	      $this->Ln(); $this->SetX($pos_x);	 
	      $this->Cell($sub_tam_columna,$sub_tam_fila,"Tasa de Alumbrado Público:",'R',0,'L',0);   
	      $this->Cell($sub_tam_columna,$sub_tam_fila,$row[36],'L',0,'R',0);  
	      
	      $this->Ln(); $this->SetX($pos_x);	 
	      $this->Cell($sub_tam_columna,$sub_tam_fila,"Tasa de Aseo y Recojo de Basura:",'R',0,'L',0);   
	      $this->Cell($sub_tam_columna,$sub_tam_fila,$row[37],'L',0,'R',0);  
	      
	      $this->Ln(); $this->SetX($pos_x);	 $this->SetFont('Arial','BU',$letra);
	      $this->Cell($sub_tam_columna,$sub_tam_fila,"Importe Total a Pagar ".$row[6],'R',0,'L',0);   
	      $this->Cell($sub_tam_columna,$sub_tam_fila,$row[38],'L',0,'R',0);   $this->SetFont('Arial','',$letra);
    }*/
   
    
}

//Creación del objeto de la clase heredada
//$pdf=new PDF('P','mm','Legal'); //Oficio
$pdf=new PDF('P','mm','Letter');  //Carta	

$pdf->AliasNbPages();

$pdf->AddPage('P');
$pdf->SetFont('Times','',12);
$pdf->SetAutoPageBreak(true,2);  //2 milimetros desde el final de la hoja
$pdf->maestro();
//$pdf->FancyTable($header,$data);
$pdf->Output();
?>

?>