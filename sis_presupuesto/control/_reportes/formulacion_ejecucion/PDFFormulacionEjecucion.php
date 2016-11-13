<?php

session_start();
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../LibModeloPresupuesto.php");
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
	 
//Cabecera de página
function Header()
{
	$this->SetLeftMargin(8);//margen izquierdo
	$funciones = new funciones();
    //Logo
    	$this->Image('../../../../lib/images/logo_reporte.jpg',240,5,36,10);
    //$this->Image('../../../lib/images/logo_reporte_factur.jpg',210,5);//llama al logo
    //Arial bold 15
    $this->SetFont('Arial','B',12);//tifo de fuente
    //Movernos a la derecha
	$this->Ln(3);//salto de linea 
    //$this->Cell(100);//celda de dibujo
    
    $this->Cell(0,7,'FORMULACIÓN VERSUS EJECUCIÓN',0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
    $this->SetFont('Arial','I',10);
    $this->Ln();
    $this->Cell(0,4,'Presupuesto de '.$_SESSION['PDF_desc_pres']." Gestión ".$_SESSION['PDF_gestion_pres'],0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
    $this->SetFont('Arial','I',7);
    $this->Ln();
    $this->Cell(0,4,'(Expresado en '.$_SESSION['PDF_desc_moneda'].")",0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
   	
			 	
    $this->Ln(8);
      $this->SetFont('Arial','I',7);
    	
     $epe=" ";   
      $bandera=false;
     if($_SESSION['PDF_regional']){$epe=$epe."REGIONAL: ".$_SESSION['PDF_regional'];$bandera=true;}
       	if($_SESSION['PDF_financiador']){
     	if($bandera){$epe=$epe." \n "."FINANCIADOR: ".$_SESSION['PDF_financiador'];	
     	}else{$epe=$epe."FINANCIADOR: ".$_SESSION['PDF_financiador'];}
     	}
     			
		if($_SESSION['PDF_programa']){
     	if($bandera){$epe= $epe." \n "."PROGRAMA: ".$_SESSION['PDF_programa'];	
     	}else{$epe=$epe."PROGRAMA: ".$_SESSION['PDF_programa'];}
     	}	 
		if($_SESSION['PDF_proyecto']){
     	if($bandera){$epe=$epe." \n "."SUBPROGRAMA: ".$_SESSION['PDF_proyecto'];	
     	}else{$epe=$epe." SUBPROGRAMA: ".$_SESSION['PDF_proyecto'];}
     	}	
     	if($_SESSION['PDF_actividad']){
     	if($bandera){$epe=$epe." \n "."ACTIVIDAD: ".$_SESSION['PDF_actividad'];	
     	}else{$epe=$epe."ACTIVIDAD: ".$_SESSION['PDF_actividad'];}
     	}
     	if($epe==" "){$epe="Todos";};
     	$this->Cell(45,2,'ESTRUCTURA PROGRAMATICA: ',0,0,'L',0);
     	$this->MultiCell(200,3,$epe);
     	$this->Ln();
       	$this->Cell(45,2,'UNIDAD ORGANIZACIONAL: ',0,0,'L',0);
        $this->MultiCell(200,2,$_SESSION['PDF_unidad_organizacional'] );
        $this->Ln();
		$this->Cell(45,2,'FUENTE DE FINANCIAMIENTO: ',0,0,'L',0);
        $this->MultiCell(200,2,$_SESSION['PDF_Fuente_financiamiento']);
		$this->Ln();
        /*$this->Cell(45,3,'CONCEPTO COLECTIVO:',0,0,'L',0);
        $this->MultiCell(200,3,$_SESSION['PDF_colectivo'] );
    	$this->Ln();*/
    	$this->SetFont('Arial','B',8);
   		//$this->Cell(0,2,$_SESSION['PDF_desc_estado_gral'],0,0,'R');
    	 
    
    //$this->Cell(100);
    
 
    $this->Ln(3);
    //$this->line(7,$this->GetY()+3,273,$this->GetY()+3);//recupera las oordenadas de x y y
   
    //$this->Cell(10);
    $this->SetFont('Arial','B',6);

    //$this->Cell(7,5,'','TB',0,'C',0);
    $this->Cell(24,5,'','TB',0,'C',0);
    $this->Cell(18,5,'ENERO','TB',0,'C',0);
    $this->Cell(18,5,'FEBRERO','TB',0,'C',0);
    $this->Cell(18,5,'MARZO','TB',0,'C',0);
    $this->Cell(18,5,'ABRIL','TB',0,'C',0);
    $this->Cell(18,5,'MAYO','TB',0,'C',0);
    $this->Cell(18,5,'JUNIO','TB',0,'C',0);
    $this->Cell(18,5,'JULIO','TB',0,'C',0);
    $this->Cell(18,5,'AGOSTO','TB',0,'C',0);
    $this->Cell(18,5,'SEPTIEMBRE','TB',0,'C',0);
    $this->Cell(18,5,'OCTUBRE','TB',0,'C',0);
    $this->Cell(18,5,'NOVIEMBRE','TB',0,'C',0);
    $this->Cell(18,5,'DICIEMBRE','TB',0,'C',0);
    $this->Cell(25,5,'TOTAL','TB',0,'C',0);
    $this->Ln(6);
    //$this->line(6,$this->GetY(),273,$this->GetY());
   
}
 
	//Pie de página
	function Footer()
	{
	 	$this->line(8,$this->GetY(),273,$this->GetY()); 
		//Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    //Arial italic 8
	    $this->SetFont('Arial','I',8);
	    //ip
	    $ip = captura_ip();
	    
	    	$this->line(8,$this->GetY(),273,$this->GetY()); 
		 //Número de página
	    $fecha=date("d-m-Y");
		//hora
	    $hora=date("H:i:s");
		$this->Cell(130,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L'); 
	    $this->Cell(100,10,'Página '.$this->PageNo().' de {nb}',0,0,'L');     
	    $this->Cell(100,10,'Fecha: '.$fecha ,0,0,'L');
	    $this->ln(3);
	    $this->Cell(130,10,'Sistema: ENDESIS - PRESTO',0,0,'L'); 
	    $this->Cell(100,10,'',0,0,'L');
	    $this->Cell(100,10,'Hora: '.$hora ,0,0,'L');
	    //fecha
	   
	}
 
 
	function maestro()
	{
		$w=array(24,18,18,18,18,18,18,18,18,18,18,18,18,25);
		$Custom = new cls_CustomDBPresupuesto();//$this->SetY(36);
		$this->SetLineWidth(.1);//ancho de las lineas 
		$this->SetFillColor(224,235,255);//color de fondo las celdas 
		//$this->SetFillColor(255,255,255);//color de fondo las celdas 
	    $this->SetTextColor(0);//color de la letra
	    //$this->SetDrawColor(128,0,0);//rgv color de dibujo
		 $this->SetFont('Arial','',6);
		 
		$cond = new cls_criterio_filtro($decodificar);
		for($i=0;$i<$_SESSION['PDF_CantFiltros'];$i++)
		{
			$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
		}
		
		 $criterio_filtro = $cond -> obtener_criterio_filtro();
		 $criterio_filtro = $criterio_filtro.' and id_partida_padre is null '; 		 
		 
		 //Lsitamos el total de la formulacion presupuestaria
		 $res = $Custom->ListarConsiliacionPartida($_SESSION['PDF_limit'],$_SESSION['PDF_start'],'codigo_partida','asc',$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$_SESSION['PDF_tipo_pres'],$_SESSION['PDF_id_parametro'],$_SESSION['PDF_id_moneda'],$_SESSION['PDF_ids_fuente_financiamiento'],$_SESSION['PDF_ids_u_o'],$_SESSION['PDF_ids_financiador'],$_SESSION['PDF_ids_regional'],$_SESSION['PDF_ids_programa'],$_SESSION['PDF_ids_proyecto'],$_SESSION['PDF_ids_actividad'],'formulacion',$_SESSION['PDF_ids_concepto_colectivo']);
				 
		
		 if($res)
		 {
		 	$fill=!$fill;
			$data=$Custom->salida;
			
			foreach($data as $row)
			{		
		        $this->SetFont('Arial','B',6);
				$this->Cell($w[0],5,'PROGRAMADO','LR',0,'L',$fill);
				//$this->SetFont('Arial','BU',6);
		        $this->Cell($w[1],5,$this->imprimirLinea($row[12],$w[2]),'LR',0,'R',$fill);
		        $this->Cell($w[2],5,$this->imprimirLinea($row[13],$w[3]),'LR',0,'R',$fill);
		        $this->Cell($w[3],5,$this->imprimirLinea($row[14],$w[4]),'LR',0,'R',$fill);
		        $this->Cell($w[4],5,$this->imprimirLinea($row[15],$w[5]),'LR',0,'R',$fill);
		        $this->Cell($w[5],5,$this->imprimirLinea($row[16],$w[6]),'LR',0,'R',$fill);
		        $this->Cell($w[6],5,$this->imprimirLinea($row[17],$w[7]),'LR',0,'R',$fill);
		        $this->Cell($w[7],5,$this->imprimirLinea($row[18],$w[8]),'LR',0,'R',$fill);
		        $this->Cell($w[8],5,$this->imprimirLinea($row[19],$w[9]),'LR',0,'R',$fill);
		        $this->Cell($w[9],5,$this->imprimirLinea($row[20],$w[10]),'LR',0,'R',$fill);
		        $this->Cell($w[10],5,$this->imprimirLinea($row[21],$w[11]),'LR',0,'R',$fill);
		        $this->Cell($w[11],5,$this->imprimirLinea($row[22],$w[12]),'LR',0,'R',$fill);
		        $this->Cell($w[12],5,$this->imprimirLinea($row[23],$w[13]),'LR',0,'R',$fill);
		        $this->Cell($w[13],5,$this->imprimirLinea($row[24],$w[14]),'LR',1,'R',$fill);   
				
	        	//$this->Ln();
		    }
		}
		
		
		//Listamos la ejecucion presupuestaria
		$res = $Custom->ListarTotalEjecucion($_SESSION['PDF_limit'],$_SESSION['PDF_start'],'codigo_partida','asc',$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$_SESSION['PDF_tipo_pres'],$_SESSION['PDF_id_parametro'],$_SESSION['PDF_id_moneda'],$_SESSION['PDF_ids_fuente_financiamiento'],$_SESSION['PDF_ids_u_o'],$_SESSION['PDF_ids_financiador'],$_SESSION['PDF_ids_regional'],$_SESSION['PDF_ids_programa'],$_SESSION['PDF_ids_proyecto'],$_SESSION['PDF_ids_actividad'],'formulacion',$_SESSION['PDF_ids_concepto_colectivo'],$fecha_fin,$fecha_ini);
		//$res = $Custom->ListarTotalEjecucion($_SESSION['PDF_limit'],$_SESSION['PDF_start'],'codigo_partida','asc',$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$_SESSION['PDF_tipo_pres'],$_SESSION['PDF_id_parametro'],$_SESSION['PDF_id_moneda'],$_SESSION['PDF_ids_fuente_financiamiento'],$_SESSION['PDF_ids_u_o'],$_SESSION['PDF_ids_financiador'],$_SESSION['PDF_ids_regional'],$_SESSION['PDF_ids_programa'],$_SESSION['PDF_ids_proyecto'],$_SESSION['PDF_ids_actividad'],$_SESSION['PDF_sw_vista'],$_SESSION['PDF_ids_concepto_colectivo'],$fecha_fin,$fecha_ini);
		 		
		//$res2 = $Custom->ListarConsiliacionPartida($_SESSION['PDF_limit'],$_SESSION['PDF_start'],'codigo_partida','asc',$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$_SESSION['PDF_tipo_pres'],$_SESSION['PDF_id_parametro'],$_SESSION['PDF_id_moneda'],$_SESSION['PDF_ids_fuente_financiamiento'],$_SESSION['PDF_ids_u_o'],$_SESSION['PDF_ids_financiador'],$_SESSION['PDF_ids_regional'],$_SESSION['PDF_ids_programa'],$_SESSION['PDF_ids_proyecto'],$_SESSION['PDF_ids_actividad'],'formulacion',$_SESSION['PDF_ids_concepto_colectivo']);
		 //ListarTotalEjecucion
		 //echo $Custom->query;
		 //exit;
		 
		 if($res)
		 {
		 	$fill=!$fill;
			$data=$Custom->salida;
			
			$ejecutado=array();
			$Contador=0;
			
			
			foreach($data as $row2)
			{	
		        $ejecutado[$Contador]=$row2[1];
		        $Contador=$Contador+1;
		    }
		    
		    $this->SetFont('Arial','B',6);
			$this->Cell($w[0],5,'EJECUTADO','LR',0,'L',$fill);
			//$this->SetFont('Arial','BU',6);
	        $this->Cell($w[1],5,$this->imprimirLinea($ejecutado[0],$w[2]),'LR',0,'R',$fill);
	        $this->Cell($w[2],5,$this->imprimirLinea($ejecutado[1],$w[3]),'LR',0,'R',$fill);
	        $this->Cell($w[3],5,$this->imprimirLinea($ejecutado[2],$w[4]),'LR',0,'R',$fill);
	        $this->Cell($w[4],5,$this->imprimirLinea($ejecutado[3],$w[5]),'LR',0,'R',$fill);
	        $this->Cell($w[5],5,$this->imprimirLinea($ejecutado[4],$w[6]),'LR',0,'R',$fill);
	        $this->Cell($w[6],5,$this->imprimirLinea($ejecutado[5],$w[7]),'LR',0,'R',$fill);
	        $this->Cell($w[7],5,$this->imprimirLinea($ejecutado[6],$w[8]),'LR',0,'R',$fill);
	        $this->Cell($w[8],5,$this->imprimirLinea($ejecutado[7],$w[9]),'LR',0,'R',$fill);
	        $this->Cell($w[9],5,$this->imprimirLinea($ejecutado[8],$w[10]),'LR',0,'R',$fill);
	        $this->Cell($w[10],5,$this->imprimirLinea($ejecutado[9],$w[11]),'LR',0,'R',$fill);
	        $this->Cell($w[11],5,$this->imprimirLinea($ejecutado[10],$w[12]),'LR',0,'R',$fill);
	        $this->Cell($w[12],5,$this->imprimirLinea($ejecutado[11],$w[13]),'LR',0,'R',$fill);
	        $this->Cell($w[13],5,$this->imprimirLinea($ejecutado[12],$w[14]),'LR',1,'R',$fill);
		}
		
		//Imprimimos los porcentajes de ejecucion
		
		$fill=!$fill;
	   	$this->Cell($w[0],5,'EJECUCIÓN (%)',1,0,1,$fill);
		//$this->SetFont('Arial','BU',6);
        $this->Cell($w[1],5,number_format(($ejecutado[0]*100)/($row[12]+ 0.01),1).' %',1,0,'R',$fill);
        $this->Cell($w[2],5,number_format(($ejecutado[1]*100)/($row[13]+ 0.01),1).' %',1,0,'R',$fill);
        $this->Cell($w[3],5,number_format(($ejecutado[2]*100)/($row[14]+ 0.01),1).' %',1,0,'R',$fill);
        $this->Cell($w[4],5,number_format(($ejecutado[3]*100)/($row[15]+ 0.01),1).' %',1,0,'R',$fill);
        $this->Cell($w[5],5,number_format(($ejecutado[4]*100)/($row[16]+ 0.01),1).' %',1,0,'R',$fill);
        $this->Cell($w[6],5,number_format(($ejecutado[5]*100)/($row[17]+ 0.01),1).' %',1,0,'R',$fill);
        $this->Cell($w[7],5,number_format(($ejecutado[6]*100)/($row[18]+ 0.01),1).' %',1,0,'R',$fill);
        $this->Cell($w[8],5,number_format(($ejecutado[7]*100)/($row[19]+ 0.01),1).' %',1,0,'R',$fill);
        $this->Cell($w[9],5,number_format(($ejecutado[8]*100)/($row[20]+ 0.01),1).' %',1,0,'R',$fill);
        $this->Cell($w[10],5,number_format(($ejecutado[9]*100)/($row[21]+ 0.01),1).' %',1,0,'R',$fill);
        $this->Cell($w[11],5,number_format(($ejecutado[10]*100)/($row[22]+ 0.01),1).' %',1,0,'R',$fill);
        $this->Cell($w[12],5,number_format(($ejecutado[11]*100)/($row[23]+ 0.01),1).' %',1,0,'R',$fill);
        $this->Cell($w[13],5,number_format(($ejecutado[12]*100)/($row[24]+ 0.01),1).' %',1,1,'R',$fill);
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
    
    function imprimirLinea($cadena,$w)
    {
    	$res=0;
    	$res=number_format($cadena,2);
    	return $res; 
    }
}

//Creación del objeto de la clase heredada
$pdf=new PDF('L','mm','Letter');// main (posicion de la pagina,unidad de medida,tamaño)

$pdf->AliasNbPages();//contador de pagina 

$pdf->AddPage('L');//para modificar la orienacion de la pagina
$pdf->SetAutoPageBreak(true,15);
$pdf->SetFont('Times','',12);
$pdf->maestro();//es una funcion en la cual se crea el reporte
//$pdf->FancyTable($header,$data);

//$pdf->SetRightMargin(10);
$pdf->Output();//mostrar el reporte
?>



?>
