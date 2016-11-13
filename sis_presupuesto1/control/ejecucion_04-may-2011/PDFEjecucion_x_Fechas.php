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
	var  $sw_transaccional=0;
	var  $id_concepto_colectivo=0;
	var  $total=0;
	var  $relleno=true;	
	var  $porcentaje_ejecucion=0;
	 
	//Cabecera de página
	function Header()
	{
		$this->SetLeftMargin(12);//margen izquierdo
		$funciones = new funciones();
	    //Logo
	    $this->Image('../../../lib/images/logo_reporte.jpg',240,5,36,10);
	    $this->SetFont('Arial','B',12);//tifo de fuente
		$this->Ln(3);//salto de linea 
	    
	    $this->Cell(0,7,'EJECUCIÓN PRESUPUESTARIA',0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->SetFont('Arial','I',10);
	    $this->Ln();
	    $this->Cell(0,4,'Presupuesto de '.$_SESSION['PDF_desc_pres']." Gestión ".$_SESSION['PDF_gestion_pres'],0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->SetFont('Arial','I',7);
	    $this->Ln();
	    $this->Cell(0,4,'Del '.$_SESSION['PDF_fecha_desde'].' Al '.$_SESSION['PDF_fecha_hasta']." ",0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->Ln(3);
	    $this->Cell(0,4,'(Expresado en '.$_SESSION['PDF_desc_moneda'].")",0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    
	    
	    $this->Ln(8);//10
	    $this->SetFont('Arial','I',7);
	    	
	    $epe=" ";   
	    $bandera=false;
		    
	    if($_SESSION['PDF_regional'])
	    {
	     	$epe=$epe."REGIONAL: ".$_SESSION['PDF_regional'];$bandera=true;
		}
	   	if($_SESSION['PDF_financiador'])
	   	{
	     	if($bandera)
	     	{
	     		$epe=$epe." \n "."FINANCIADOR: ".$_SESSION['PDF_financiador'];	
	     	}
	     	else
	     	{
	     		$epe=$epe."FINANCIADOR: ".$_SESSION['PDF_financiador'];
	     	}
	 	}
	 	if($_SESSION['PDF_programa']){
	 	if($bandera){$epe= $epe." \n "."PROGRAMA: ".$_SESSION['PDF_programa'];	
	 	}else{$epe=$epe."PROGRAMA: ".$_SESSION['PDF_programa'];}
	 	}	 
		if($_SESSION['PDF_proyecto']){
	 	if($bandera){$epe=$epe." \n "."SUBPROGRAMA: ".$_SESSION['PDF_proyecto'];	
	 	}else{$epe=$epe."SUBPROGRAMA: ".$_SESSION['PDF_proyecto'];}
	 	}	
	 	if($_SESSION['PDF_actividad']){
	 	if($bandera){$epe=$epe." \n "."ACTIVIDAD: ".$_SESSION['PDF_actividad'];	
	 	}else{$epe=$epe."ACTIVIDAD: ".$_SESSION['PDF_actividad'];}
	 	}
		   
	 	if($epe==" "){$epe="Todos";};
		$this->Cell(45,2,'ESTRUCTURA PROGRAMATICA: ',0,0,'L',0);		
		$this->MultiCell(200,3,$epe);
		$this->Ln();
	   	$this->Cell(45,2,'UNIDAD ORGANIZACIONAL:',0,0,'L',0);
	    $this->MultiCell(200,2,$_SESSION['PDF_unidad_organizacional'] );

	    $this->SetFont('Arial','B',8);
		  
	    $this->Ln(3);
	    $this->SetFont('Arial','B',6);
	
	    $this->Cell(15,5,'CÓDIGO',1,0,'C',0);		//CODIGO
	    $this->Cell(100,5,'PARTIDA',1,0,'C',0);	//PARTIDA
	    
	    IF($_SESSION['PDF_tipo_pres']>1)//PRESUPUESTOS DE GASTO E INVERSION
	    {
	    	$this->Cell(25,5,'COMPROMETIDO',1,0,'C',0);	//COMPROMETIDO
		    $this->Cell(25,5,'DEVENGADO',1,0,'C',0);		//DEVENGADO
		    $this->Cell(25,5,'PAGADO',1,1,'C',0);			//PAGADO
		 		}
		else //PRESUPUESTOS DE RECURSOS
	    {
	    	$this->Cell(30,5,'DEVENGADO',1,0,'C',0);		//DEVENGADO
		    $this->Cell(30,5,'INGRESADO',1,1,'C',0);		//INGRESADO
	    }
	    
	    $this->Ln(0.1);
	    $this->SetFont('Arial','B',6);   
	}
 
	function maestro()
	{   
		IF($_SESSION['PDF_tipo_pres']>1)
		{
			$w=array(15,100,25,25,25);
		}
	    else 
	    {
	    	$w=array(15,100,35,35);
	    }
		$Custom = new cls_CustomDBPresupuesto();//$this->SetY(36);
		$this->SetLineWidth(.1);//ancho de las lineas 
		$this->SetFillColor(224,235,255);//color de fondo las celdas 
	    $this->SetTextColor(0);//color de la letra
		$this->SetFont('Arial','',6);
		 
		$cond = new cls_criterio_filtro($decodificar);
		for($i=0;$i<$_SESSION['PDF_CantFiltros'];$i++)
		{
			$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
		}
		 $criterio_filtro = $cond -> obtener_criterio_filtro();
		 $fecha_fin= substr( $_SESSION['PDF_fecha_hasta'],3,2)."/".substr($_SESSION['PDF_fecha_hasta'],0,2)."/".substr( $_SESSION['PDF_fecha_hasta'],6,4);
		 $fecha_ini= substr( $_SESSION['PDF_fecha_desde'],3,2)."/".substr($_SESSION['PDF_fecha_desde'],0,2)."/".substr( $_SESSION['PDF_fecha_desde'],6,4);
		 
		 $res = $Custom->ListarEjecucionPartida_x_fechas($_SESSION['PDF_limit'],$_SESSION['PDF_start'],'codigo_partida','asc',$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$_SESSION['PDF_tipo_pres'],$_SESSION['PDF_id_parametro'],$_SESSION['PDF_id_moneda'],$_SESSION['PDF_ids_fuente_financiamiento'],$_SESSION['PDF_ids_u_o'],$_SESSION['PDF_ids_financiador'],$_SESSION['PDF_ids_regional'],$_SESSION['PDF_ids_programa'],$_SESSION['PDF_ids_proyecto'],$_SESSION['PDF_ids_actividad'],$_SESSION['PDF_sw_vista'],$_SESSION['PDF_ids_concepto_colectivo'],$fecha_ini,$fecha_fin);
		
		 if($res)
		 {
		 	$fill=!$fill;
			$data=$Custom->salida;
			foreach($data as $row)
			{	 
				 IF($_SESSION['PDF_tipo_pres']>1)	//Presupuestos de gasto o inversion
				 {
					if($row[3]!=1)	//PARA LAS PARTIDAS TOTALITARIAS
					{
						$this->SetFont('Arial','BU',6);
						$this->Cell($w[0],4,$row[1],'LR',0,'C',$fill);
						$this->SetFont('Arial','B',6);
						$this->Cell($w[1],4,$row[2],'LR',0,'L',$fill);
						$this->SetFont('Arial','BU',6);
						$this->Cell($w[2],4,$this->imprimirLinea($row[4],$w[2]),'LR',0,'R',$fill);//COMPROMETIDO
						$this->Cell($w[2],4,$this->imprimirLinea($row[5],$w[2]),'LR',0,'R',$fill);//DEVENGADO
						$this->Cell($w[2],4,$this->imprimirLinea($row[6],$w[2]),'LR',0,'R',$fill);//PAGADO
						$this->SetFont('Arial','I',6);
					}
					else		//PARA LAS PARTIDAS DE MOVIMIENTO
					{
						$this->Cell($w[0],4,$row[1],'LR',0,'C',$fill);
				        $this->Cell($w[1],4,$row[2],'LR',0,'L',$fill);
				        $this->Cell($w[2],4,$this->imprimirLinea($row[4],$w[2]),'LR',0,'R',$fill);//COMPROMETIDO
				        $this->Cell($w[2],4,$this->imprimirLinea($row[5],$w[2]),'LR',0,'R',$fill);//DEVENGADO
				        $this->Cell($w[2],4,$this->imprimirLinea($row[6],$w[2]),'LR',0,'R',$fill);//PAGADO
				     }
				 }
				// Presupuestos de recursos 
				else if($row[3]==1)
				{
					$this->SetFont('Arial','BU',6);
					$this->Cell($w[0],4,$row[1],'LR',0,'C',$fill);
			        $this->SetFont('Arial','B',6);
					$this->Cell($w[1],4,$row[2],'LR',0,'L',$fill);
					$this->SetFont('Arial','BU',6);
			        $this->Cell($w[3],4,$this->imprimirLinea($row[5],$w[3]),'LR',0,'R',$fill);//DEVENGADO
					$this->Cell($w[3],4,$this->imprimirLinea($row[6],$w[3]),'LR',0,'R',$fill);//INGRESADO
					$this->SetFont('Arial','I',6);					
				}
				else
				{
					$this->Cell($w[0],4,$row[1],'LR',0,'C',$fill);
			        $this->Cell($w[1],4,$row[2],'LR',0,'L',$fill);
			      	$this->Cell($w[3],4,$this->imprimirLinea($row[5],$w[3]),'LR',0,'R',$fill);//DEVENGADO
					$this->Cell($w[3],4,$this->imprimirLinea($row[6],$w[3]),'LR',0,'R',$fill);//INGRESADO
				}
				
	        	$this->Ln();
	        	
	        	if($relleno)
	        	{
	        		$this->SetFillColor(224,235,255);//color de fondo las celdas 
	        	}
	        	else 
	        	{        		
	        		$this->SetFillColor(255,255,255);//color de fondo las celdas 
	        	}
	    	    $relleno=!$relleno;
		    }//fin foreach
		}//fin if
	   	$this->line(12,$this->GetY(),200,$this->GetY()); 	
	}

	//Pie de página
	function Footer()
	{
	 	$this->line(12,$this->GetY(),202,$this->GetY()); 
	    $this->SetY(-15);
	    $this->SetFont('Arial','I',8);
	    $ip = captura_ip();
	    
	    $this->line(12,$this->GetY(),202,$this->GetY()); 
	    $fecha=date("d-m-Y");
		$hora=date("H:i:s");
	     
   	    $this->SetFont('Arial','',6);
		$this->Cell(70,10,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,10,'',0,0,'L');
		$this->Cell(18,10,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,10,'Sistema: ENDESIS - PRESTO',0,0,'L');
		$this->Cell(50,10,'',0,0,'C');
		$this->Cell(52,10,'',0,0,'L');
		$this->Cell(18,10,'Hora: '.$hora,0,0,'L');	
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
$pdf=new PDF('P','mm','Letter');// main (posicion de la pagina,unidad de medida,tamaño)

$pdf->AliasNbPages();//contador de pagina 

$pdf->AddPage();//para modificar la orienacion de la pagina
/* echo "down down".utf8_decode($_SESSION['tipo_pres']);
exit;*/ 
$pdf->SetAutoPageBreak(true,15);
$pdf->SetFont('Times','',12);
$pdf->maestro();//es una funcion en la cual se crea el reporte
//$pdf->FancyTable($header,$data);

//$pdf->SetRightMargin(10);
$pdf->Output();//mostrar el reporte
?>



?>
