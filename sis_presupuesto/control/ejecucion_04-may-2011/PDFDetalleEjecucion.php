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
	    
	    $this->Cell(0,7,'EJECUCIÓN PRESUPUESTARIA',0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->SetFont('Arial','I',10);
	    $this->Ln();
	    $this->Cell(0,4,'Presupuesto de '.$_SESSION['PDF_desc_pres']." Gestión ".$_SESSION['PDF_gestion_pres'],0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->SetFont('Arial','I',7);
	    $this->Ln();
	    $this->Cell(0,4,'Del '.$_SESSION['PDF_fecha_ini'].' Al '.$_SESSION['PDF_fecha_fin']." ",0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
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
	    $this->Ln();
		$this->Cell(45,2,'FUENTE DE FINANCIAMIENTO:',0,0,'L',0);
	    $this->MultiCell(200,2,$_SESSION['PDF_Fuente_financiamiento']);
		/*$this->Ln();
	    $this->Cell(45,3,'CONCEPTO COLECTIVO:',0,0,'L',0);
	    $this->MultiCell(200,3,$_SESSION['colectivo'] );
		$this->Ln();*/
		$this->SetFont('Arial','B',8);
		  
		//$this->Cell(0,5,$_SESSION['desc_estado_gral'],0,0,'R'); 
		//$this->Cell(0,3,'',0,0,'R');   
	 
	    //$this->Ln(7);
	    //$this->Cell(100);    
	 
	    $this->Ln(3);
	    //$this->line(7,$this->GetY()+3,273,$this->GetY()+3);//recupera las oordenadas de x y y
	   
	    //$this->Cell(10);
	    $this->SetFont('Arial','B',6);
	
	    $this->Cell(7,4,'CÓDIGO','T',0,'C',0);		//CODIGO
	    $this->Cell(47,4,'PARTIDA','T',0,'C',0);	//PARTIDA
	    
	    
	    IF($_SESSION['PDF_tipo_pres']>1)//PRESUPUESTOS DE GASTO E INVERSION
	    {
	    	$this->Cell(20,4,'PRESUPUESTADO','T',0,'C',0);	//PRESUPUESTADO
		    $this->Cell(20,4,'TRASPASO','T',0,'C',0);		//TRASPASO
		    $this->Cell(20,4,'REFORMULACIÓN','T',0,'C',0);	//REFORMULACION
		    $this->Cell(20,4,'PRESUPUESTO','T',0,'C',0);	//PRESUPUESTO VIGENTE
		    $this->Cell(20,4,'COMPROMETIDO','T',0,'C',0);	//COMPROMETIDO
		    $this->Cell(20,4,'DEVENGADO','T',0,'C',0);		//DEVENGADO
		    $this->Cell(20,4,'PAGADO','T',0,'C',0);			//PAGADO
		    $this->Cell(20,4,'SALDO POR','T',0,'C',0);		//SALDO POR COMPROMETER
		    $this->Cell(20,4,'SALDO POR','T',0,'C',0);		//SALDO POR DEVENGAR
		    $this->Cell(20,4,'SALDO POR','T',0,'C',0);		//SALDO POR PAGAR
		    $this->Cell(10,4,'EJECUCIÓN','T',0,'C',0);		//PORCENTAJE DE EJECUCION 
		}
		else //PRESUPUESTOS DE RECURSOS
	    {
	    	$this->Cell(25,4,'PRESUPUESTADO','T',0,'C',0);	//PRESUPUESTADO
			$this->Cell(25,4,'TRASPASO','T',0,'C',0);		//TRASPASO
			$this->Cell(25,4,'REFORMULACIÓN','T',0,'C',0);	//REFORMULACION
			$this->Cell(25,4,'PRESUPUESTO','T',0,'C',0);	//PRESUPUESTO VIGENTE
			$this->Cell(25,4,'DEVENGADO','T',0,'C',0);		//DEVENGADO
		    $this->Cell(25,4,'INGRESADO','T',0,'C',0);		//INGRESADO
		    $this->Cell(25,4,'SALDO POR','T',0,'C',0);		//SALDO POR DEVENGAR
		    $this->Cell(25,4,'SALDO POR','T',0,'C',0);  	//SALDO POR INGRESAR
		    $this->Cell(10,4,'EJECUCIÓN','T',0,'C',0);  	//PORCENTAJE DE EJECUCIÓN
	    }
	    $this->Ln(5);
	    $this->SetFont('Arial','B',6);
	
	    $this->Cell(7,4,'','B',0,'C',0);	//CODIGO
	    $this->Cell(47,4,'','B',0,'C',0);   //PARTIDA 
	    
	    
	    IF($_SESSION['PDF_tipo_pres']>1)	//PRESUPUESTOS DE GASTO E INVERSION
	    {
	    	$this->Cell(20,4,'','B',0,'C',0);				//PRESUPUESTADO
		    $this->Cell(20,4,'','B',0,'C',0);				//TRASPASO
		    $this->Cell(20,4,'','B',0,'C',0);				//REFORMULACION
		    $this->Cell(20,4,'VIGENTE','B',0,'C',0);		//PRESUPUESTO VIGENTE
		    $this->Cell(20,4,'','B',0,'C',0);				//COMPROMETIDO
		    $this->Cell(20,4,'','B',0,'C',0);				//DEVENGADO
		    $this->Cell(20,4,'','B',0,'C',0);				//PAGADO
		    $this->Cell(20,4,'COMPROMETER','B',0,'C',0);	//SALDO POR COMPROMETER
		    $this->Cell(20,4,'DEVENGAR','B',0,'C',0);		//SALDO POR DEVENGAR
		    $this->Cell(20,4,'PAGAR','B',0,'C',0);			//SALDO POR PAGAR
		    $this->Cell(10,4,'(%)','B',0,'C',0);			//PORCENTAJE DE EJECUCIÓN
		    
		}
		else 	//PRESUPUESTOS DE RECURSOS
	    {
	    	$this->Cell(25,4,'','B',0,'C',0);				//PRESUPUESTADO
			$this->Cell(25,4,'','B',0,'C',0);				//TRASPASO
			$this->Cell(25,4,'','B',0,'C',0);				//REFORMULACION
			$this->Cell(25,4,'VIGENTE','B',0,'C',0);		//PRESUPUESTO VIGENTE
			$this->Cell(25,4,'','B',0,'C',0);				//DEVENGADO
		    $this->Cell(25,4,'','B',0,'C',0);				//INGRESADO
		    $this->Cell(25,4,'DEVENGAR','B',0,'C',0);		//SALDO POR DEVENGAR 
		    $this->Cell(25,4,'INGREZAR','B',0,'C',0);		//SALDO POR INGREZAR
		    $this->Cell(10,4,'(%)','B',0,'C',0);		    //PORCENTAJE EJECUCION   	
	    }
	    $this->Ln(6);	    
	}
 

  
	function maestro()
	{
		IF($_SESSION['PDF_tipo_pres']>1)
		{
			$w=array(7,47,20,20,20,20,35,35);
		}
	    else 
	    {
	    	$w=array(7,47,25,25,25,25,40,43);
	    }
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
		 $fecha= substr( $_SESSION['PDF_fecha_fin'],3,2)."/".substr($_SESSION['PDF_fecha_fin'],0,2)."/".substr( $_SESSION['PDF_fecha_fin'],6,4);
		 $fecha_ini= substr( $_SESSION['PDF_fecha_ini'],3,2)."/".substr($_SESSION['PDF_fecha_ini'],0,2)."/".substr( $_SESSION['PDF_fecha_ini'],6,4);
		 
		 $res = $Custom->ListarEjecucionPartida($_SESSION['PDF_limit'],$_SESSION['PDF_start'],'codigo_partida','asc',$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$_SESSION['PDF_tipo_pres'],$_SESSION['PDF_id_parametro'],$_SESSION['PDF_id_moneda'],$_SESSION['PDF_ids_fuente_financiamiento'],$_SESSION['PDF_ids_u_o'],$_SESSION['PDF_ids_financiador'],$_SESSION['PDF_ids_regional'],$_SESSION['PDF_ids_programa'],$_SESSION['PDF_ids_proyecto'],$_SESSION['PDF_ids_actividad'],$_SESSION['PDF_sw_vista'],$_SESSION['PDF_ids_concepto_colectivo'],$fecha,$fecha_ini);
		 
		 // echo $Custom->query;exit;
		 
		 if($res)
		 {
		 	$fill=!$fill;
			$data=$Custom->salida;
			foreach($data as $row)
			{	 
				 IF($_SESSION['PDF_tipo_pres']>1)	//Presupuestos de gasto o inversion
				 {
					if($row[5]!=1)	//PARA LAS PARTIDAS TOTALITARIAS
					{
						$this->SetFont('Arial','BU',6);
						$this->Cell($w[0],5,$row[1],'LR',0,'C',$fill);
						$this->SetFont('Arial','B',6);
						$this->Cell($w[1],5,$row[2],'LR',0,'L',$fill);
						$this->SetFont('Arial','BU',6);
						$this->Cell($w[2],5,$this->imprimirLinea($row[24],$w[2]),'LR',0,'R',$fill);//PRESUPUESTADO
						$this->Cell($w[2],5,$this->imprimirLinea($row[32],$w[2]),'LR',0,'R',$fill);//TRASPASO
						$this->Cell($w[2],5,$this->imprimirLinea($row[33],$w[2]),'LR',0,'R',$fill);//REFORMULACION
						$this->Cell($w[2],5,$this->imprimirLinea($row[34],$w[2]),'LR',0,'R',$fill);//PRESUPUESTO VIGENTE
						$this->Cell($w[2],5,$this->imprimirLinea($row[25],$w[2]),'LR',0,'R',$fill);//COMPROMETIDO
						$this->Cell($w[2],5,$this->imprimirLinea($row[28],$w[2]),'LR',0,'R',$fill);//DEVENGADO
						$this->Cell($w[2],5,$this->imprimirLinea($row[29],$w[2]),'LR',0,'R',$fill);//PAGADO
						$this->Cell($w[2],5,$this->imprimirLinea($row[27],$w[2]),'LR',0,'R',$fill);//SALDO POR COMPROMETER
						$this->Cell($w[2],5,$this->imprimirLinea($row[30],$w[2]),'LR',0,'R',$fill);//SALDO POR DEVENGAR
						$this->Cell($w[2],5,$this->imprimirLinea($row[31],$w[2]),'LR',0,'R',$fill);//SALDO POR PAGAR
						$this->Cell(10,5,$this->imprimirLinea( ( 100-( ($row[27]*100) / ($row[34] + 0.01) ) ), 10),'LR',0,'R',$fill);//PORCENTAJE DE EJECUCION
						$this->SetFont('Arial','I',6);
					}
					else		//PARA LAS PARTIDAS DE MOVIMIENTO
					{
						$this->Cell($w[0],5,$row[1],'LR',0,'C',$fill);
				        $this->Cell($w[1],5,$row[2],'LR',0,'L',$fill);
				        $this->Cell($w[2],5,$this->imprimirLinea($row[24],$w[2]),'LR',0,'R',$fill);//PRESUPUESTADO
				        $this->Cell($w[2],5,$this->imprimirLinea($row[32],$w[2]),'LR',0,'R',$fill);//TRASPASO
				        $this->Cell($w[2],5,$this->imprimirLinea($row[33],$w[2]),'LR',0,'R',$fill);//REFORMULACION
				        $this->Cell($w[2],5,$this->imprimirLinea($row[34],$w[2]),'LR',0,'R',$fill);//PRESUPUESTO VIGENTE
				        $this->Cell($w[2],5,$this->imprimirLinea($row[25],$w[2]),'LR',0,'R',$fill);//COMPROMETIDO
				        $this->Cell($w[2],5,$this->imprimirLinea($row[28],$w[2]),'LR',0,'R',$fill);//DEVENGADO
				        $this->Cell($w[2],5,$this->imprimirLinea($row[29],$w[2]),'LR',0,'R',$fill);//PAGADO
				        $this->Cell($w[2],5,$this->imprimirLinea($row[27],$w[2]),'LR',0,'R',$fill);//SALDO POR COMPROMETER
				        $this->Cell($w[2],5,$this->imprimirLinea($row[30],$w[2]),'LR',0,'R',$fill);//SALDO POR DEVENGAR
				        $this->Cell($w[2],5,$this->imprimirLinea($row[31],$w[2]),'LR',0,'R',$fill);//SALDO POR PAGAR
				        $this->Cell(10,5,$this->imprimirLinea( ( 100-( ($row[27]*100) / ($row[34] + 0.01) ) ), 10),'LR',0,'R',$fill);//PORCENTAJE DE EJECUCION
					}
				 }
				// Presupuestos de recursos 
				else if($row[5]==1)
				{
					$this->SetFont('Arial','BU',6);
					$this->Cell($w[0],5,$row[1],'LR',0,'C',$fill);
			        $this->SetFont('Arial','B',6);
					$this->Cell($w[1],5,$row[2],'LR',0,'L',$fill);
					$this->SetFont('Arial','BU',6);
			        $this->Cell($w[3],5,$this->imprimirLinea($row[24],$w[3]),'LR',0,'R',$fill);//PRESUPUESTADO
			        $this->Cell($w[3],5,$this->imprimirLinea($row[32],$w[3]),'LR',0,'R',$fill);//TRASPASO
					$this->Cell($w[3],5,$this->imprimirLinea($row[33],$w[3]),'LR',0,'R',$fill);//REFORMULACION
					$this->Cell($w[3],5,$this->imprimirLinea($row[34],$w[3]),'LR',0,'R',$fill);//PRESUPUESTO VIGENTE
			        $this->Cell($w[3],5,$this->imprimirLinea($row[28],$w[3]),'LR',0,'R',$fill);//DEVENGADO
					$this->Cell($w[3],5,$this->imprimirLinea($row[29],$w[3]),'LR',0,'R',$fill);//INGRESADO
					$this->Cell($w[3],5,$this->imprimirLinea($row[35],$w[3]),'LR',0,'R',$fill);//SALDO POR DEVENGAR
					$this->Cell($w[3],5,$this->imprimirLinea($row[31],$w[3]),'LR',0,'R',$fill);//SALDO POR INGRESAR
					$this->Cell(10,5,$this->imprimirLinea( ( 100-( ($row[35]*100) / ($row[34] + 0.01) ) ), 10),'LR',0,'R',$fill);//PORCENTAJE DE EJECUCION
					$this->SetFont('Arial','I',6);					
				}
				else
				{
					$this->Cell($w[0],5,$row[1],'LR',0,'C',$fill);
			        $this->Cell($w[1],5,$row[2],'LR',0,'L',$fill);
			        $this->Cell($w[3],5,$this->imprimirLinea($row[24],$w[3]),'LR',0,'R',$fill);//PRESUPUESTADO
			        $this->Cell($w[3],5,$this->imprimirLinea($row[32],$w[3]),'LR',0,'R',$fill);//TRASPASO
			        $this->Cell($w[3],5,$this->imprimirLinea($row[33],$w[3]),'LR',0,'R',$fill);//REFORMULACION
			        $this->Cell($w[3],5,$this->imprimirLinea($row[34],$w[3]),'LR',0,'R',$fill);//PRESUPUESTO VIGENTE
			     	$this->Cell($w[3],5,$this->imprimirLinea($row[28],$w[3]),'LR',0,'R',$fill);//DEVENGADO
					$this->Cell($w[3],5,$this->imprimirLinea($row[29],$w[3]),'LR',0,'R',$fill);//INGRESADO
					$this->Cell($w[3],5,$this->imprimirLinea($row[35],$w[3]),'LR',0,'R',$fill);//SALDO POR DEVENGAR
					$this->Cell($w[3],5,$this->imprimirLinea($row[31],$w[3]),'LR',0,'R',$fill);//SALDO POR INGRESAR
					$this->Cell(10,5,$this->imprimirLinea( ( 100-( ($row[35]*100) / ($row[34] + 0.01) ) ), 10),'LR',0,'R',$fill);//PORCENTAJE DE EJECUCION
				}
				
		    	//echo ($w[14]);	    
	        	$this->Ln();
	        	
	        	if($relleno)
	        	{
	        		$this->SetFillColor(224,235,255);//color de fondo las celdas 
	        	}
	        	else 
	        	{        		
	        		$this->SetFillColor(255,255,255);//color de fondo las celdas 
	        	}
	    	    //$fill=!$fill;
	    	    $relleno=!$relleno;
		    }//fin foreach
		}//fin if
	   	$this->line(8,$this->GetY(),272,$this->GetY()); 	
	}

	//Pie de página
	function Footer()
	{
	 	$this->line(8,$this->GetY(),272,$this->GetY()); 
		//Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    //Arial italic 8
	    $this->SetFont('Arial','I',8);
	    //ip
	    $ip = captura_ip();
	    
	    $this->line(8,$this->GetY(),272,$this->GetY()); 
		//Número de página
	    $fecha=date("d-m-Y");	
	    $hora=date("H:i:s");
		$this->Cell(130,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L'); 
	    $this->Cell(100,10,'Página '.$this->PageNo().' de {nb}',0,0,'L');     
	    $this->Cell(100,10,'Fecha: '.$fecha ,0,0,'L');
	    $this->ln(3);
	    $this->Cell(130,10,'Sistema: ENDESIS - PRESTO',0,0,'L'); 
	    $this->Cell(100,10,'',0,0,'L');
	    $this->Cell(100,10,'Hora: '.$hora ,0,0,'L');   
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
