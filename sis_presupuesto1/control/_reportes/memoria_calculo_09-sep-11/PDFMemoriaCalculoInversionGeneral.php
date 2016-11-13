<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../LibModeloPresupuesto.php");

class PDF extends FPDF
{
	//Cargar los datos
	//Cabecera de página

	function Header(){
	global $title;
	$this->SetLeftMargin(15);
	$funciones = new funciones();
	//Logo
	$this->Image('../../../../lib/images/logo_reporte.jpg',165,5,36,12);
	//Arial bold 15
	$this->SetLineWidth(.1);
	$this->SetFont('Arial','B',10);
	//Movernos a la derecha
	$this->Cell(200,10,'DIRECCIÓN GENERAL DE ASUNTOS ADMINISTRATIVOS',0,0,'C');
	$this->Ln(5);
	$this->Cell(200,10,'MEMORIAS DE CÁLCULO',0,0,'C');
	$this->Ln(5);
	$this->Cell(200,10,'ANTEPROYECTO PRESUPUESTO GESTIÓN '.$_SESSION['rep_mem_cal_gestion_pres'],0,0,'C');
	$this->Ln(5);
	$this->Cell(200,10,'COSTOS ESTIMADOS POR PARTIDA DE GASTO',0,0,'C');
	$this->Ln(5);
	$this->Cell(200,10,'PARTIDA '.$_SESSION['rep_mem_cal_codigo_partida'].' "'.$_SESSION['rep_mem_cal_nombre_partida'].'"',0,0,'C');
	$this->Ln(10);
	$this->SetFont('Arial','B',7);
	
	if($_SESSION['filtro'] == 1)
	{
		$this->Cell(22,4,'REGIONAL','LTR',0,'L');
		$this->Cell(78,4,$_SESSION['rep_mem_cal_regional'],'TR',0,'L');
		$this->Cell(25,4,'',0,0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Ln(4);
		$this->Cell(22,4,'ORG. FINANC.','LTR',0,'L');
		$this->Cell(78,4,$_SESSION['rep_mem_cal_financiador'],'TR',0,'L');
		$this->Cell(25,4,'',0,0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Ln(4);
		$this->Cell(22,4,'PROGRAMA','LTR',0,'L');
		$this->Cell(78,4,$_SESSION['rep_mem_cal_programa'],'TR',0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Cell(45,4,$_SESSION['rep_mem_cal_cod_formulario_gasto'],'LTRB',0,'C');
		$this->Ln(4);
		$this->Cell(22,4,'SUBPROGRAMA','LTR',0,'L');
		$this->Cell(78,4,$_SESSION['rep_mem_cal_proyecto'],'TR',0,'L');
		$this->Cell(25,4,'',0,0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Ln(4);
		$this->Cell(22,4,'ACTIVIDAD','LTR',0,'L');
		$this->Cell(78,4,$_SESSION['rep_mem_cal_actividad'],'TR',0,'L');
		$this->Cell(25,4,'',0,0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Ln(4);
		$this->Cell(22,4,'FUENTE','LTR',0,'L');
		$this->Cell(78,4,$_SESSION['rep_mem_serv_fuente_financiamiento'],'TR',0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Cell(45,4,'GESTIÓN:     '.$_SESSION['rep_mem_cal_gestion_pres'],'LTR',0,'L');
		$this->Ln(4);     
		$this->Cell(22,4,'UNIDAD ORG.','LTRB',0,'L');
		$this->Cell(78,4,$_SESSION['rep_mem_cal_unidad_organizacional'],'TRB',0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Cell(45,4,'FECHA ELAB.: '.$_SESSION['rep_mem_cal_fecha_elaboracion'],'LRB',0,'L');
	}
	else
	{			
		$this->Cell(44,4,'COD. PROGRAMA','LTR',0,'L');
		$this->Cell(56,4,$_SESSION['PDF_cod_prog'],'TR',0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Cell(45,4,$_SESSION['rep_mem_serv_cod_formulario_gasto'],'LTRB',0,'C');
		$this->Ln(4);
		$this->Cell(44,4,'COD. PROYECTO','LTR',0,'L');
		$this->Cell(56,4,$_SESSION['PDF_cod_proy'],'TR',0,'L');
		$this->Cell(25,4,'',0,0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Ln(4);
		$this->Cell(44,4,'COD. ACTIVIDAD','LTR',0,'L');
		$this->Cell(56,4,$_SESSION['PDF_cod_act'],'TR',0,'L');
		$this->Cell(25,4,'',0,0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Ln(4);
		$this->Cell(44,4,'COD. ORGANISMO FINANCIADOR','LTR',0,'L'); 
		$this->Cell(56,4,$_SESSION['PDF_cod_organismo'],'TR',0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Cell(45,4,'GESTIÓN:     '.$_SESSION['rep_mem_serv_gestion_pres'],'LTR',0,'L');
		$this->Ln(4);     
		$this->Cell(44,4,'COD. FUENTE DE FINANCIAMIENTO','LTRB',0,'L');
		$this->Cell(56,4,$_SESSION['PDF_cod_fuente_fin'],'TRB',0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Cell(45,4,'FECHA ELAB.: '.$_SESSION['rep_mem_serv_fecha_elaboracion'],'LRB',0,'L');
	}
	
	$this->Ln(8);
	
	$this->SetFont('Arial','B',6);
	$this->Cell(10,4,'','LTR',0,'L');
	$this->Cell(60,4,'','TR',0,'L');
	$this->Cell(20,4,'','TR',0,'L');
	$this->Cell(20,4,'','TR',0,'L');
	$this->Cell(20,4,'','TR',0,'L');
	$this->Cell(60,4,'','TR',0,'L');
	$this->Ln(4);	
	$this->Cell(10,4,'Nro.','LR',0,'C');
	$this->Cell(60,4,'DESCRIPCIÓN','R',0,'C');
	$this->Cell(20,4,'CANTIDAD','R',0,'C');
	$this->Cell(20,4,'COSTO UNITARIO','R',0,'C');
	$this->Cell(20,4,'COSTO TOTAL','R',0,'C');
	$this->Cell(60,4,'JUSTIFICACIÓN','R',0,'C');	
	$this->Ln(4);
	$this->SetFont('Arial','B',4);
	$this->Cell(10,4,'','LR',0,'L');
	$this->Cell(60,4,'','R',0,'L');
	$this->Cell(20,4,'','R',0,'C');
	$this->Cell(20,4,'('.$_SESSION['rep_mem_cal_simbolo'].')','R',0,'C');
	$this->Cell(20,4,'('.$_SESSION['rep_mem_cal_simbolo'].')','R',0,'C');
	$this->Cell(60,4,'','R',0,'L');
	$this->Ln(4);
	$this->Cell(10,4,'','LTR',0,'L');
	$this->Cell(60,4,'','TR',0,'L');
	$this->Cell(20,4,'','TR',0,'L');
	$this->Cell(20,4,'','TR',0,'L');
	$this->Cell(20,4,'','TR',0,'L');
	$this->Cell(60,4,'','TR',0,'L');
	
	$this->Ln(3);
	}
	//Pie de página
	function Footer(){
		
		
		
		
		
		$this->SetY(-35);
		//Arial italic 8
		$this->SetFont('Arial','',7);
		//fecha
		$fecha=date("d-m-Y");
		//hora
		$hora=date("H:i:s");
		$this->ln(0);
		$this->Cell(190,5,'','LRT',0,'C');
		$this->ln(4);
		$this->Cell(133,4,'','L',0,'C');
		$this->Cell(57,4,'FIRMA Y SELLO','R',0,'C');
		$this->ln(4);
		$this->Cell(133,3,'','LTR',0,'L');
		$this->Cell(57,3,'','LTR',0,'C');
		$this->ln(3);
		$this->Cell(20,5,'Elaborado Por: ','L',0,'L');
		$this->Cell(111,5,'','B',0,'L');
		$this->Cell(2,5,'','R',0,'L');
		$this->Cell(2,5,'','L',0,'L');
		$this->Cell(53,5,'','B',0,'L');
		$this->Cell(2,5,'','R',0,'L');
		$this->ln(5);
		$this->Cell(20,5,'Aprobado Por: ','L',0,'L');
		$this->Cell(111,5,'','B',0,'L');
		$this->Cell(2,5,'','R',0,'L');
		$this->Cell(2,5,'','L',0,'L');
		$this->Cell(53,5,'','B',0,'L');
		$this->Cell(2,5,'','R',0,'L');
		$this->ln(5);
		$this->Cell(133,3,'','LBR',0,'L');
		$this->Cell(57,3,'','LBR',0,'C');
		$this->ln(5);
		$this->SetFont('Arial','',6);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - PRESTO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');		
	}
	function LoadData($id_partida_presupuesto,$id_presupuesto,$tipo_memoria,$id_partida,$id_moneda,$tipo_pres,$cod_prog,$cod_proy,$cod_act,$cod_fuente_fin,$cod_organismo){
		$cant=1000;
	    $puntero=0;
	    $sortcol='CINGAS.desc_ingas_item_serv';
	    $sortdir='asc';
	    if($_SESSION['filtro'] == 1)
	    {    
	    	$criterio_filtro="PARPRE.id_partida=$id_partida AND PRESUP.id_presupuesto like ''$id_presupuesto'' AND MEMCAL.tipo_detalle= $tipo_memoria AND MONEDA.id_moneda=$id_moneda AND PRESUP.tipo_pres =$tipo_pres ";
	    }
	    else 
	    {
	    	$criterio_filtro="PARPRE.id_partida=$id_partida AND VPRE.cod_prg = $cod_prog and vpre.cod_proy = $cod_proy and vpre.cod_act = $cod_act and vpre.cod_fin = $cod_organismo and vpre.codigo_fuente = $cod_fuente_fin AND MEMCAL.tipo_detalle= $tipo_memoria AND MONEDA.id_moneda=$id_moneda AND PRESUP.tipo_pres =$tipo_pres ";
	    }
	    //Leer las líneas del fichero
	    $Custom = new cls_CustomDBPresupuesto();	    
	    $Custom->ListarRepGralMemoriaInversion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);		
	    
		//echo var_dump($Custom); exit;
		
		$data=$Custom->salida;
	    return $data;
	}
	//Tabla coloreada
	function FancyTable($data,$id_partida_presupuesto,$id_presupuesto,$tipo_memoria,$id_partida,$id_moneda,$tipo_pres,$cod_prog,$cod_proy,$cod_act,$cod_fuente_fin,$cod_organismo){
		//Colores, ancho de línea y fuente en negrita	
		$this->SetLineWidth(.1);
		//obtener el total de registros
		$criterio_filtro='PARPRE.id_partida='.$id_partida.' AND MEMCAL.tipo_detalle='.$tipo_memoria.' AND MONEDA.id_moneda='.$id_moneda;
		if($_SESSION['filtro'] == 1)
	    {	
			$criterio_suma="PARPRE.id_partida=$id_partida AND PRESUP.id_presupuesto like ''$id_presupuesto'' AND MEMCAL.tipo_detalle=$tipo_memoria AND MONEDA.id_moneda=$id_moneda AND PRESUP.tipo_pres =$tipo_pres";
	    }
	    else 
	    {
	    	$criterio_suma="PARPRE.id_partida=$id_partida AND VPRE.cod_prg = $cod_prog and vpre.cod_proy = $cod_proy and vpre.cod_act = $cod_act and vpre.cod_fin = $cod_organismo and vpre.codigo_fuente = $cod_fuente_fin AND MEMCAL.tipo_detalle= $tipo_memoria AND MONEDA.id_moneda=$id_moneda AND PRESUP.tipo_pres =$tipo_pres ";
	    }
	    //Leer las líneas del fichero
	    $CustomC= new cls_CustomDBPresupuesto();
		$CustomC->ContarRepGralMemoriaInversion(15,0,'','',$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);		
	    $cantidad=sizeof($CustomC->salida);
	    $CustomS= new cls_CustomDBPresupuesto();
		$CustomS->SumaCostoMemoriaInversion(15,0,'','',$criterio_suma,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);		
		$suma_total=$CustomS->salida;
	  	//Cabecera
		$w=array(10,60,20);
			//Restauración de colores y fuentes
			/*$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);*/
			$this->SetFont('Arial','',7);
			$numero_paginas=ceil($cantidad/36);
			if($numero_paginas==0){
				$numero_paginas=1;
			}
			$cantidad_estimada=$numero_paginas*36;
			$restante=($cantidad_estimada-$cantidad)/2;
			//Datos			    
				$numero=1;
				$this->SetWidths(array(10,60,20,20,20,60));
				$this->SetFills(array(0,0,0,0,0,0));
				$this->SetAligns(array('C','L','C','R','R','J'));
			 	$this->SetVisibles(array(1,1,1,1,1,1));
			  	$this->SetFontsSizes(array(7,7,7,7,7,7));
			 	$this->SetFontsStyles(array('','','','','',''));
			 	$this->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5));
			 	$this->setDecimales(array(0,0,0,0,0,0));
			    $this->SetFormatNumber(array(0,0,0,0,0,0));				   	  
			       
				for($j=0;$j<count($data);$j++)
				{					
					$this->Multitabla(array_merge(array($j+1),$data[$j]),1,1,3.5,7,1);				
				}
				
		       /*foreach($data as $row){       
					$this->Cell($w[0],4,$numero.'.-','LR',0,'C');
					$this->Cell($w[1],4,$row[0],'R',0,'L');
					$this->Cell($w[2],4,number_format($row[1],2,'.',','),'R',0,'R');
					$this->Cell($w[2],4,number_format($row[2],2,'.',','),'R',0,'R');
					$this->Cell($w[2],4,number_format($row[3],2,'.',','),'R',0,'R');
					$this->MultiCell($w[1],4,$row[4],'R','L',0);
					//$this->Ln(4);
					$numero=$numero+1;
			    }*/
			   /*for($i=1;$i<=$restante;$i++){
			     	$this->Cell($w[0],4,'','LR',0,'L');
					$this->Cell($w[1],4,'','R',0,'L');
					$this->Cell($w[2],4,'','R',0,'C');
					$this->Cell($w[2],4,'','R',0,'C');
					$this->Cell($w[2],4,'','R',0,'C');
					$this->MultiCell($w[1],4,'','R','C',0);
					//$this->Ln(4);
					$numero=$numero+1;
			   }*/
			   $this->SetFont('Arial','',7);
			   $this->Cell($w[0],4,'',1,0,'L');
			   $this->Cell($w[1],4,'TOTAL PRESUPUESTO ANUAL ',1,0,'L');
			   $this->Cell($w[2],4,'',1,0,'L');
			   $this->Cell($w[2],4,'',1,0,'L');
			   $this->Cell(20,4,number_format($suma_total, 2, '.', ','),'LTRB',0,'R'); 	
			   $this->Cell(60,4,'',1,0,'L');					   
			   $this->Ln(4);
			   //$this->Cell(190,4,'','LR',0,'L');   			
		}
}
$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
//Carga de datos
$data=$pdf->LoadData($id_partida_presupuesto,$id_presupuesto,$tipo_memoria,$id_partida,$id_moneda,$tipo_pres,$cod_prog,$cod_proy,$cod_act,$cod_fuente_fin,$cod_organismo);
$pdf->SetFont('Arial','',14);
$pdf->SetAutoPageBreak(1,35);
$pdf->SetTopMargin(13);
$pdf->SetRightMargin(10);
$pdf->SetLeftMargin(15);
$pdf->AddPage();$pdf->FancyTable($data,$id_partida_presupuesto,$id_presupuesto,$tipo_memoria,$id_partida,$id_moneda,$tipo_pres,$cod_prog,$cod_proy,$cod_act,$cod_fuente_fin,$cod_organismo);
$pdf->Output();
?>