<?php
session_start();
/**
 * Autor: Boris Claros Olivera
 * Fecha de creacion: 28/03/2011
 * Descripción: Reporte de Depreciaciones
 * **/

require('../../../lib/fpdf/fpdf.php');

include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
define('FPDF_FONTPATH','font/');

$_SESSION['PDF_descripcion_larga']=utf8_decode($_SESSION['PDF_descripcion_larga']);

class PDF extends FPDF
{   
	var $cuenta_anterior='';
	var $primera_vez=0;
	//var $cont=0;
	var $contador=0;
	var $total_count=0;	
					
	function PDF($orientation='L',$unit='mm',$format='Letter')
    {
	    //Llama al constructor de la clase padre
	    $this->FPDF($orientation,$unit,$format);
	    $this-> AddFont('Arial','','arial.php');
	     
	    //Iniciación de variables    
    }
    
	function Header()
	{       
   		$this->Image('../../../lib/images/logo_reporte.jpg',230,2,45,20);//ENDE-0001:04/09/2012: ubicacion de logo corporacion
  		$this->Ln(7); 		 		  
	}
	
	//Pie de página
	function Footer()
	{
	   	$this->SetY(-7);
		$this->pieHash('PRESTO','','H');	
				
		/*//Posición: a 1,5 cm del final
	    $fecha=date("d-m-Y");
		$hora=date("H:i:s");
		$this->SetY(-7);
	    $this->SetFont('Arial','',6);
	    $this->Cell(90,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(30,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(40,3,'',0,0,'L');
		$this->Cell(20,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(90,3,'Sistema: ENDESIS - PRESTO',0,0,'L');
		$this->Cell(30,3,'',0,0,'C');
		$this->Cell(40,3,'',0,0,'L');
		$this->Cell(20,3,'Hora: '.$hora,0,0,'L');	 */       
	}
	
	function maestro($id_modificacion,$m_id_gestion,$tipo)
	{					
		$incremento='Incremento';	
		$Custom = new cls_CustomDBPresupuesto();
		
		//Parámetros del filtro
		if($limit == '') $cant2 = 100;
		else $cant2 = $limit;
	
		if($start == '') $puntero2 = 0;
		else $puntero2 = $start;
	
		if($sort == '') $sortcol2 = 'id_partida_modificacion';
		else $sortcol2 = $sort;
	
		if($dir == '') $sortdir2 = 'asc';
		else $sortdir2 = $dir;
	
		//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
		//valores permitidos de $cod -> 'si', 'no'
		
		switch ($cod)
		{
			case 'si':
				$decodificar = true;
				break;
			case 'no':
				$decodificar = false;
				break;
			default:
				$decodificar = true;
				break;
		}
	
		//Verifica si se manda la cantidad de filtros
		if($CantFiltros=='') $CantFiltros = 0;
	
		//Se obtiene el criterio del filtro con formato sql para mandar a la BD
		$cond = new cls_criterio_filtro($decodificar);
		for($i=0;$i<$CantFiltros;$i++)
		{
			$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
		}
		$cond->add_criterio_extra(" PARMOD.id_modificacion",$id_modificacion);
		$criterio_filtro2 = $cond -> obtener_criterio_filtro();		
	
		//echo $criterio_filtro;exit;
		$res=$Custom->ContarPartidaModificacion($cant2 ,$puntero2,$sortcol2,$sortdir2,"PARMOD.id_modificacion=".$id_modificacion,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		
		//echo var_dump($Custom); exit;
		
    	if($res) $total_count= $Custom->salida;
		$this->SetFont('Arial','',12);
		
    	if($tipo=='Disminucion')
    	{
    		if($_SESSION['tipo_modificacion'] != 3)
	    	{
    			$this->Cell(0,5,'Partidas Presupuestarias a ser Disminuidas ',0,1,'C');	
				$this->Ln(4);
				
				$this->SetFont('Arial','B',7);
				$this->Cell(5,3,'Nro','TRL',0,'C');  
				 $this->Cell(70,3,'ESTRUCTURA PROGRAMATICA','TRL',0,'C');  
				 $this->Cell(40,3,'PARTIDA - DESCRIPCIÓN','TRL',0,'C');  
				 $this->Cell(13,3,'IMPORTE','TRL',0,'C'); 
				 $this->Cell(12,3,'ENE','TRL',0,'C');  
				 $this->Cell(12,3,'FEB','TRL',0,'C'); 
				 $this->Cell(12,3,'MAR','TRL',0,'C'); 
				 $this->Cell(12,3,'ABR','TRL',0,'C'); 
				 $this->Cell(12,3,'MAY','TRL',0,'C'); 
				 $this->Cell(12,3,'JUN','TRL',0,'C'); 
				 $this->Cell(12,3,'JUL','TRL',0,'C'); 
				 $this->Cell(12,3,'AGO','TRL',0,'C'); 
				 $this->Cell(12,3,'SEP','TRL',0,'C'); 
				 $this->Cell(12,3,'OCT','TRL',0,'C'); 
				 $this->Cell(12,3,'NOV','TRL',0,'C'); 
				 $this->Cell(12,3,'DIC','TRL',1,'C'); 
				
			     
				 $this->Cell(5,3,'','BRL',0,'C');  		
				 $this->Cell(70,3,'','BRL',0,'C');  		
				 $this->Cell(40,3,'','BRL',0,'C');  		
				 $this->Cell(13,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',1,'C'); 
	    	}
    	}
    	else 
    	{
			if($_SESSION['tipo_modificacion'] != 4)
	    	{
				$this->Cell(0,5,'Partidas Presupuestarias a ser Incrementadas ',0,1,'C');	
				$this->Ln(4);
				
				$this->SetFont('Arial','B',7);
				$this->Cell(5,3,'Nro','TRL',0,'C');  
				 $this->Cell(70,3,'ESTRUCTURA PROGRAMATICA','TRL',0,'C');  
				 $this->Cell(40,3,'PARTIDA - DESCRIPCIÓN','TRL',0,'C');  
				 $this->Cell(13,3,'IMPORTE','TRL',0,'C'); 
				 $this->Cell(12,3,'ENE','TRL',0,'C');  
				 $this->Cell(12,3,'FEB','TRL',0,'C'); 
				 $this->Cell(12,3,'MAR','TRL',0,'C'); 
				 $this->Cell(12,3,'ABR','TRL',0,'C'); 
				 $this->Cell(12,3,'MAY','TRL',0,'C'); 
				 $this->Cell(12,3,'JUN','TRL',0,'C'); 
				 $this->Cell(12,3,'JUL','TRL',0,'C'); 
				 $this->Cell(12,3,'AGO','TRL',0,'C'); 
				 $this->Cell(12,3,'SEP','TRL',0,'C'); 
				 $this->Cell(12,3,'OCT','TRL',0,'C'); 
				 $this->Cell(12,3,'NOV','TRL',0,'C'); 
				 $this->Cell(12,3,'DIC','TRL',1,'C'); 
				
				 
				 $this->Cell(5,3,'','BRL',0,'C');  		
				 $this->Cell(70,3,'','BRL',0,'C');  		
				 $this->Cell(40,3,'','BRL',0,'C');  		
				 $this->Cell(13,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',0,'C');  
				 $this->Cell(12,3,'','BRL',1,'C'); 
			 }
    	}
		
		
							    		
    		$id_modificacion = $_SESSION['id_modificacion'];
    		
    		$res = $Custom->ListarPartidaModificacion($cant2 ,$puntero2,$sortcol2,$sortdir2,"PARMOD.id_modificacion=".$id_modificacion,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);    		    		  
			    		    		
    		if($res)
    		{
					
    				$data=	$Custom->salida;
					
					$this->FancyTable($data,$ban,$total_count,$puntero,$tipo);
		    			
					$ban++;
					
					if($puntero==0)
					{
						$this->cuenta_anterior=$data[0][0];
						$this->primera_vez=1;
					}
			}
			$puntero=$puntero+10000;			
	}
	
	function FancyTable($data,$van,$total_count,$puntero,$tipo)	
	{		 
		
		     $suma_mes_01 = 0;	    		
			 $suma_mes_02 = 0;
			 $suma_mes_03 = 0;
			 $suma_mes_04 = 0;
			 $suma_mes_05 = 0;
			 $suma_mes_06 = 0;
			 $suma_mes_07 = 0;
			 $suma_mes_08 = 0;
			 $suma_mes_09 = 0;
			 $suma_mes_10 = 0;
			 $suma_mes_11 = 0;
			 $suma_mes_12 = 0;
			 $s_total = 0;
			
			//$Custom = new cls_CustomDBPresupuesto();
			$contador = $puntero;			
		    $cont=0;
			
		    $this->SetLineWidth(.1);
		    $this->SetFont('Arial','B',7);
		    //Restauración de colores y fuentes
		    $this->SetFillColor(224,235,255);
		    $this->SetTextColor(0);
		    $this->SetDrawColor(0,0,0);	    
		    $fill=0;	    	
		     	    	
			 		 
		    foreach($data as $row)
		    {		    	
		    	$this->SetFont('Arial','',6);
		    	
		    	if($tipo=='Disminucion')
		    	{
		    		if($_SESSION['tipo_modificacion'] != 3)  //Diferente de incremento
		    		{
			    		if ($row[6]=='Disminucion')
			    		{
			    			$this->cont=$this->cont+1; 
			    			
			    			$this->Cell(5,5,$this->cont,'BRL',0,'L',$fill);
			        		//$this->Cell(70,5,$row[18],'BR',0,'L',$fill);
			        		//$this->Cell(40,5,$row[16],'BR',0,'L',$fill);
							$this->Cell(70,5, substr ($row[18] ,0,70) ,'BR',0,'L',$fill);
							$this->Cell(40,5,substr($row[16],0,40),'BR',0,'L',$fill);
			        		$this->Cell(13,5,$row[9],'BR',0,'R',$fill);
			        			        		
			        		//$this->Cell(12,5,$row[20],'BR',0,'R',$fill);
			        		$this->Cell(12,5,$row[21],'BR',0,'R',$fill);
			        		$this->Cell(12,5,$row[22],'BR',0,'R',$fill);
			        		$this->Cell(12,5,$row[23],'BR',0,'R',$fill);
			        		$this->Cell(12,5,$row[24],'BR',0,'R',$fill);
			        		$this->Cell(12,5,$row[25],'BR',0,'R',$fill);
			        		$this->Cell(12,5,$row[26],'BR',0,'R',$fill);
			        		$this->Cell(12,5,$row[27],'BR',0,'R',$fill);
			        		$this->Cell(12,5,$row[28],'BR',0,'R',$fill);
			        		$this->Cell(12,5,$row[29],'BR',0,'R',$fill);
			        		$this->Cell(12,5,$row[30],'BR',0,'R',$fill);
			        		$this->Cell(12,5,$row[31],'BR',0,'R',$fill);
							$this->Cell(12,5,$row[31],'BR',1,'R',$fill);
			        		
			        		$suma_mes_01=$suma_mes_01+$row[21];
			        		$suma_mes_02=$suma_mes_02+$row[22];
			        		$suma_mes_03=$suma_mes_03+$row[23];
			        		$suma_mes_04=$suma_mes_04+$row[24];
			        		$suma_mes_05=$suma_mes_05+$row[25];
			        		$suma_mes_06=$suma_mes_06+$row[26];
			        		$suma_mes_07=$suma_mes_07+$row[27];
			        		$suma_mes_08=$suma_mes_08+$row[28];
			        		$suma_mes_09=$suma_mes_09+$row[29];
			        		$suma_mes_10=$suma_mes_10+$row[30];
			        		$suma_mes_11=$suma_mes_11+$row[31];
			        		$suma_mes_12=$suma_mes_12+$row[32];
			        		$s_total = $s_total + $row[9];
			    		}
		    		}	   			
		    	}		    	
		    	else
		    	{		    		
		    		if ($row[6]=='Incremento')
		    		{
						if($_SESSION['tipo_modificacion'] != 4)  //Diferente de disminucion
						{						
							$this->cont=$this->cont+1;	 
							
							$this->Cell(5,5,$this->cont,'BRL',0,'L',$fill);
							$this->Cell(70,5, substr ($row[18] ,0,70) ,'BR',0,'L',$fill);
							$this->Cell(40,5,substr($row[16],0,40),'BR',0,'L',$fill);
							$this->Cell(13,5,$row[9],'BR',0,'R',$fill);
												
							//$this->Cell(12,5,$row[20],'BR',0,'R',$fill);
							$this->Cell(12,5,$row[21],'BR',0,'R',$fill);
							$this->Cell(12,5,$row[22],'BR',0,'R',$fill);
							$this->Cell(12,5,$row[23],'BR',0,'R',$fill);
							$this->Cell(12,5,$row[24],'BR',0,'R',$fill);
							$this->Cell(12,5,$row[25],'BR',0,'R',$fill);
							$this->Cell(12,5,$row[26],'BR',0,'R',$fill);
							$this->Cell(12,5,$row[27],'BR',0,'R',$fill);
							$this->Cell(12,5,$row[28],'BR',0,'R',$fill);
							$this->Cell(12,5,$row[29],'BR',0,'R',$fill);
							$this->Cell(12,5,$row[30],'BR',0,'R',$fill);
							$this->Cell(12,5,$row[31],'BR',0,'R',$fill);
							$this->Cell(12,5,$row[32],'BR',1,'R',$fill);
							
							$suma_mes_01=$suma_mes_01+$row[21];
							$suma_mes_02=$suma_mes_02+$row[22];
							$suma_mes_03=$suma_mes_03+$row[23];
							$suma_mes_04=$suma_mes_04+$row[24];
							$suma_mes_05=$suma_mes_05+$row[25];
							$suma_mes_06=$suma_mes_06+$row[26];
							$suma_mes_07=$suma_mes_07+$row[27];
							$suma_mes_08=$suma_mes_08+$row[28];
							$suma_mes_09=$suma_mes_09+$row[29];
							$suma_mes_10=$suma_mes_10+$row[30];
							$suma_mes_11=$suma_mes_11+$row[31];
							$suma_mes_12=$suma_mes_12+$row[32];
							$s_total = $s_total + $row[9];
						}
		    		}	    			
		    	} 
		    	   		
				if($contador==$total_count-1)
				{
					$this->Cell(5,1,'','B',0,'R',$fill);
	        		$this->Cell(70,1,'','B',0,'R',$fill);
	        		$this->Cell(40,1,'','B',0,'C',$fill);
	        		$this->Cell(15,1,'','B',0,'L',$fill);
	        
	         		$this->Ln();
				}
				$contador++;	       
	    	}
	    	
	    	if($tipo=='Disminucion')
	    	{	
			    if($_SESSION['tipo_modificacion'] != 3)
		    	{	
	    			//$this->maestro($v_cabecera[0][0],$v_cabecera[0][13],'Disminucion'); 
		    		//////////////////// DATOS PARA ARRIBA
					$this->Cell(75,5,'',0,0,'L');
					$this->SetFont('Arial','B',7);
				 	$this->Cell(40,5,'TOTAL DISMINUCIÓN',1,0,'C');
				 	$this->SetFont('Arial','',6);
				 	$this->Cell(13,5,number_format($s_total,2),1,0,'R');	
				 	
				 	$this->Cell(12,5,number_format($suma_mes_01,2),1,0,'R');
				 	$this->Cell(12,5,number_format($suma_mes_02,2),1,0,'R');
				 	$this->Cell(12,5,number_format($suma_mes_03,2),1,0,'R');
				 	$this->Cell(12,5,number_format($suma_mes_04,2),1,0,'R');
				 	$this->Cell(12,5,number_format($suma_mes_05,2),1,0,'R');
				 	$this->Cell(12,5,number_format($suma_mes_06,2),1,0,'R');
				 	$this->Cell(12,5,number_format($suma_mes_07,2),1,0,'R');
				 	$this->Cell(12,5,number_format($suma_mes_08,2),1,0,'R');
				 	$this->Cell(12,5,number_format($suma_mes_09,2),1,0,'R');
				 	$this->Cell(12,5,number_format($suma_mes_10,2),1,0,'R');
				 	$this->Cell(12,5,number_format($suma_mes_11,2),1,0,'R');
				 	$this->Cell(12,5,number_format($suma_mes_12,2),1,1,'R');
	    		}
	    	}
	    	else 
	    	{
				 if($_SESSION['tipo_modificacion'] != 4)
		    	{	
					//$this->maestro($v_cabecera[0][0],$v_cabecera[0][14],'Disminucion'); 
					////////////////////DATOS PARA ABAJO
					$this->Cell(75,5,'',0,0,'L');
					$this->SetFont('Arial','B',7);
					$this->Cell(40,5,'TOTAL INCREMENTO',1,0,'C');
					$this->SetFont('Arial','',6);
					$this->Cell(13,5,number_format($s_total,2),1,0,'R');	
					
					$this->Cell(12,5,number_format($suma_mes_01,2),1,0,'R');
					$this->Cell(12,5,number_format($suma_mes_02,2),1,0,'R');
					$this->Cell(12,5,number_format($suma_mes_03,2),1,0,'R');
					$this->Cell(12,5,number_format($suma_mes_04,2),1,0,'R');
					$this->Cell(12,5,number_format($suma_mes_05,2),1,0,'R');
					$this->Cell(12,5,number_format($suma_mes_06,2),1,0,'R');
					$this->Cell(12,5,number_format($suma_mes_07,2),1,0,'R');
					$this->Cell(12,5,number_format($suma_mes_08,2),1,0,'R');
					$this->Cell(12,5,number_format($suma_mes_09,2),1,0,'R');
					$this->Cell(12,5,number_format($suma_mes_10,2),1,0,'R');
					$this->Cell(12,5,number_format($suma_mes_11,2),1,0,'R');
					$this->Cell(12,5,number_format($suma_mes_12,2),1,1,'R');
				}
	    	}	    	
    }
}


	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(5,5,5);
    
    //  TITULO
	$v_cabecera = $_SESSION['PDF_cabecera'];
	
	function TipoPresupuesto($value)
	{
		if($value == 1)
		{return "Recurso";}
		if($value == 2)
		{return "Gasto";}
		if($value == 3)
		{return "Inversión";}
		if($value == 4)
		{return "PNO - Recurso";}
		if($value == 5)
		{return "PNO - Gasto";}
		if($value == 6)
		{return "PNO - Inversión";}
		
		return '';
	}
	    

	function TipoModificacion($value)
	{
		if($value == 1)
		{return "Traspaso";}
		if($value == 2)
		{return "Reformulación";}
		if($value == 3)
		{return "Incremento";}
		if($value == 4)
		{return "Disminución";}
		return '';
	}
	
    $pdf->SetFont('Arial','B',16);
    if(TipoModificacion($v_cabecera[0][3]) == 'Traspaso')
    {
    	$pdf->Cell(0,6,"REPORTE DE TRASPASOS PRESUPUESTARIOS",0,1,'C');
    }
    elseif (TipoModificacion($v_cabecera[0][3]) == 'Reformulación')
    {
    	$pdf->Cell(0,6,"REPORTE DE MODIFICACIÓNES PRESUPUESTARIAS",0,1,'C');
    }
	elseif (TipoModificacion($v_cabecera[0][3]) == 'Incremento')
    {
    	$pdf->Cell(0,6,"REPORTE DE INCREMENTOS PRESUPUESTARIOS",0,1,'C');
    }
    else 
    {
    	$pdf->Cell(0,6,"REPORTE DE DISMINUCIONES PRESUPUESTARIAS",0,1,'C');
    }
 	
 	$pdf->SetFont('Arial','B',8);
 	$pdf->Cell(0,5,'Gestión: '.$v_cabecera[0][2],0,1,'C');
 	$pdf->Ln(6);
 	$pdf->Cell(200,3,'','B',1,'C');  //primera linea
 	// FIN TITULO 	
 		 	
 	$pdf->SetFont('Arial','B',8);
 	$pdf->Cell(35,5,'TIPO MODIFICACIÓN:',0,0,'L');
 	$pdf->SetFont('Arial','',8);
 	$pdf->Cell(55,5,trim(TipoModificacion($v_cabecera[0][3])),0,0,'L');
 	
 	//ESPACIO EN BLANCO
 	$pdf->Cell(35,5,'',0,0,'L');
 	
 	$pdf->SetFont('Arial','B',8);
 	$pdf->Cell(35,5,'TIPO PRESUPUESTO:',0,0,'L');
 	$pdf->SetFont('Arial','',8);
 	$pdf->Cell(50,5,trim(TipoPresupuesto($v_cabecera[0][5])),0,1,'L');
 	
 	$pdf->SetFont('Arial','B',8);
 	$pdf->Cell(35,5,'ESTADO:',0,0,'L');
 	$pdf->SetFont('Arial','',8);
 	$pdf->Cell(55,5,trim($v_cabecera[0][8]),0,0,'L');
 	
 	//ESPACIO EN BLANCO
 	$pdf->Cell(35,5,'',0,0,'L');
 	
 	$pdf->SetFont('Arial','B',8);
 	$pdf->Cell(35,5,'FECHA REGISTRO:',0,0,'L');
 	$pdf->SetFont('Arial','',8);
 	$pdf->Cell(145,5,trim($v_cabecera[0][9]),0,1,'L');
 	
 	$pdf->SetFont('Arial','B',8);
 	$pdf->Cell(35,5,'RESPONSABLE REG.:',0,0,'L');
 	$pdf->SetFont('Arial','',8);
 	$pdf->Cell(55,5,trim($v_cabecera[0][12]),0,0,'L');
 	
 	//ESPACIO EN BLANCO
 	$pdf->Cell(35,5,'',0,0,'L');
 	
 	$pdf->SetFont('Arial','B',8);
 	$pdf->Cell(35,5,'FECHA CONCLUSIÓN:',0,0,'L');
 	$pdf->SetFont('Arial','',8);
 	$pdf->Cell(55,5,trim($v_cabecera[0][10]),0,1,'L');
	 	
	 
 	$pdf->Cell(200,3,'','B',1,'C');  //segunda linea
 	$pdf->Ln(5);
	$pdf->maestro($v_cabecera[0][0],$v_cabecera[0][14],'Disminucion');  	
 	$pdf->Ln(5);
 	
 	$pdf->maestro($v_cabecera[0][0],$v_cabecera[0][14],'Incremento');  	 	 	 	
 	$pdf->Ln(5);
 	
 	
 	$pdf->SetFont('Arial','B',9);
 	$pdf->Cell(40,10,'OBSERVACIONES: ','LTB',0,'L');
 	$pdf->SetFont('Arial','',8);
 	$pdf->Cell(160,10,trim($v_cabecera[0][4]),'RTB',1,'L');
	 	
	$pdf->Output();		
?>

