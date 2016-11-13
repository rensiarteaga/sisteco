<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../../LibModeloActivoFijo.php");
define('FPDF_FONTPATH','font/');

class PDF extends FPDF{
	//Cargar los datos
	//Cabecera de página
	var $sep_decim=',';
	var $sep_miles='.';

	function Header()
	{	global $title;
	$this->SetLeftMargin(15);
	$funciones = new funciones();
	//Logo
	$this->Image('../../../../lib/images/logo_reporte.jpg',210,2);
	$this->SetFont('Arial','B',14);
	$this->Cell(255,10,'CUADRO DE ACTIVOS FIJOS',0,0,'C');
	$this->Ln(7);
	$this->SetFont('Arial','B',12);
	//$this->Cell(255,8,'AL  '.$_SESSION['rep_af_incor_dia'].' DE  '.$_SESSION['rep_af_incor_nombre_mes'].'  DE  '.$_SESSION['rep_af_incor_gestion_fin'],0,0,'C');
	$this->Cell(255,8,'AL  '.$_SESSION['rep_af_cuad_conta_fecha'],0,0,'C');
	$this->Ln(6);
	$this->SetFont('Arial','B',10);
	//$this->Cell(255,8,'(EXPRESADO EN UFV)',0,0,'C');
	$this->Ln(4);
	}

	function Footer()
	{	//Posición: a 1,5 cm del final
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','',6);

		//Número de página
		$fecha=date("d-m-Y");
		//hora
		$hora=date("H:i:s");
		$this->Cell(120,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L');
		$this->Cell(110,10,'Página '.$this->PageNo().' de {nb}',0,0,'L');
		$this->Cell(200,10,'Fecha: '.$fecha ,0,0,'L');
		$this->ln(3);
		//$this->Cell(100,10,'Sistema: ENDESIS - ACTIF',0,0,'L');
		$this->Cell(230,10,'',0,0,'L');
		$this->Cell(200,10,'Hora: '.$hora ,0,0,'L');
		//fecha
	}
	/////////////////////////////////////////////////////////////////////////////
	function LoadData($id_financiador,$id_regional,$id_programa,$id_proyecto,$fecha,$id_auxiliar)
	{
		$cant=20;
		$puntero=0;
		$sortcol='actif.codigo';
		$sortdir='asc';
		$criterio_filtro=" FINANC.id_financiador LIKE ''$id_financiador'' ";
		$criterio_filtro.=" AND REGION.id_regional LIKE ''$id_regional'' ";
		$criterio_filtro.=" AND PROGRA.id_programa LIKE ''$id_programa'' ";
		$criterio_filtro.=" AND PROYEC.id_proyecto LIKE ''$id_proyecto'' ";
		//$criterio_filtro.=" AND DEPREC.fecha_desde = ''04/01/2008'' ";
		//$criterio_filtro.=" AND to_char(DEPREC.fecha_desde,''mm/yyyy'') = to_char(''$fecha''::date,''mm/yyyy''::varchar)";
		$criterio_filtro.=" AND AUXILI.id LIKE ''$id_auxiliar'' ";

		//Leer las líneas del fichero

		$Custom=new cls_CustomDBActivoFijo();
		$Custom->ListarCuadroActivoFijoConta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha,$fecha);
		$var1=$Custom->salida;
		/*echo"<pre>";
		print_r($Custom->salida);
		echo"</pre>";
		exit;*/

		return $var1;
	}

	//Tabla coloreada
	function FancyTable($header,$data)
	{
		//Variables auxiliares para los totales
		$tot_sub;//array con los totales por subprograma
		$cont_sub=0;
		$cont_aux=0;
		$financiador='';
		$regional='';
		$programa='';
		$subprograma='';
		$auxiliar='';
		$prim_auxiliar=1;
		$prim_subp=1;
		$sw_aux=0;

		$this->SetFont('Arial','',6);
		foreach($data as $row){
			//Verifica si cambia de Auxiliar
			if($auxiliar!=$row['auxiliar']){
				if($prim_auxiliar==0){
					//Despliega los totales por Auxiliar
					$sw_aux=1;

					$this->SetFont('Arial','',6);
					//$this->Cell($w[0],4,$row['auxiliar'],'',0,'L');//desc_detalle
					$this->Cell($w[0],4,$auxiliar,'',0,'L');//desc_detalle
					//$this->Cell($w[1],4,'','',0,'L');//desc_valor_activo
					$linea='';

					$this->Cell($w[2],4,number_format($tot_sub[$cont_sub][$cont_aux]['val_act'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//desc_ret_incor
					$this->Cell($w[3],4,number_format($tot_sub[$cont_sub][$cont_aux]['inc_act'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//actualiz
					$this->Cell($w[4],4,number_format($tot_sub[$cont_sub][$cont_aux]['val_actualiz'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//valor_actualiz
					$this->Cell($w[5],4,number_format($tot_sub[$cont_sub][$cont_aux]['deprec_acum_ini'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//depreciacion_acum_ant
					$this->Cell($w[6],4,number_format($tot_sub[$cont_sub][$cont_aux]['inc_dep_act'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//dep_actualiz
					$this->Cell($w[7],4,number_format($tot_sub[$cont_sub][$cont_aux]['dep_actualiz'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//dep_valor_actuliz
					$this->Cell($w[8],4,number_format($tot_sub[$cont_sub][$cont_aux]['dep_men'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//depreciacion
					$this->Cell($w[9],4,number_format($tot_sub[$cont_sub][$cont_aux]['dep_acum'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//depreciacion_acum
					$this->Cell($w[10],4,number_format($tot_sub[$cont_sub][$cont_aux]['val_neto'],2,$this->sep_decim,$this->sep_miles),$linea,1,'R');//monto_vigente
				}
				//Despliega las columnas del Grupo Auxiliar
				/*$this->SetX(15);
				$this->Cell(10,4,'Auxiliar:',0,0,'L');
				$this->Cell(30,4,$row['auxiliar'],'',1,0,'L',0);//
				$auxiliar=$row['auxiliar'];
				$cont_aux++;*/
			}

			//Verificamos si es una nueva EP
			if($financiador!=$row['financiador']||$regional!=$row['regional']||$programa!=$row['programa']||$subprograma!=$row['subprograma']){
				//Si cambia la EP, hace como si el auxiliar igual hubiera cambiado aunque no lo haya hecho
				if($sw_aux==0){
					if($prim_auxiliar==0){
						//Despliega los totales por Auxiliar
						$this->SetFont('Arial','',6);
						//$this->Cell($w[0],4,$row['auxiliar'],'',0,'L');//desc_detalle
						$this->Cell($w[0],4,$auxiliar,'',0,'L');//desc_detalle
						//$this->Cell($w[1],4,'','',0,'L');//desc_valor_activo
						$linea='';
						$this->Cell($w[2],4,number_format($tot_sub[$cont_sub][$cont_aux]['val_act'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//desc_ret_incor
						$this->Cell($w[3],4,number_format($tot_sub[$cont_sub][$cont_aux]['inc_act'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//actualiz
						$this->Cell($w[4],4,number_format($tot_sub[$cont_sub][$cont_aux]['val_actualiz'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//valor_actualiz
						$this->Cell($w[5],4,number_format($tot_sub[$cont_sub][$cont_aux]['deprec_acum_ini'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//depreciacion_acum_ant
						$this->Cell($w[6],4,number_format($tot_sub[$cont_sub][$cont_aux]['inc_dep_act'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//dep_actualiz
						$this->Cell($w[7],4,number_format($tot_sub[$cont_sub][$cont_aux]['dep_actualiz'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//dep_valor_actuliz
						$this->Cell($w[8],4,number_format($tot_sub[$cont_sub][$cont_aux]['dep_men'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//depreciacion
						$this->Cell($w[9],4,number_format($tot_sub[$cont_sub][$cont_aux]['dep_acum'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//depreciacion_acum
						$this->Cell($w[10],4,number_format($tot_sub[$cont_sub][$cont_aux]['val_neto'],2,$this->sep_decim,$this->sep_miles),$linea,1,'R');//monto_vigente
					}
					//Aumnenta caracteres para forzar a que el auxiliar sea considerado como otro distinto al anterior e imprimir el auxiliar como nuevo
					$auxiliar.='xxx';
				}

				//Verifica de la EP
				if($prim_subp==0){
					//Despliega los totales por Subprograma
					$this->SetFont('Arial','B',6);
					$aux=$this->obtener_totales_subp($tot_sub[$cont_sub]);
					$this->Cell($w[0],4,'Total Subprograma:','T',0,'L');//desc_detalle
					//$this->Cell($w[1],4,'','T',0,'L');//desc_valor_activo
					$this->Cell($w[2],4,number_format($aux['val_act'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//desc_ret_incor
					$this->Cell($w[3],4,number_format($aux['inc_act'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//actualiz
					$this->Cell($w[4],4,number_format($aux['val_actualiz'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//valor_actualiz
					$this->Cell($w[5],4,number_format($aux['deprec_acum_ini'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//depreciacion_acum_ant
					$this->Cell($w[6],4,number_format($aux['inc_dep_act'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//dep_actualiz
					$this->Cell($w[7],4,number_format($aux['dep_actualiz'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//dep_valor_actuliz
					$this->Cell($w[8],4,number_format($aux['dep_men'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//depreciacion
					$this->Cell($w[9],4,number_format($aux['dep_acum'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//depreciacion_acum
					$this->Cell($w[10],4,number_format($aux['val_neto'],2,$this->sep_decim,$this->sep_miles),'T',1,'R');//monto_vigente
					$this->AddPage();
				}

				//Despliega los títulos de la EP
				$this->SetFont('Arial','',8);
				$this->Cell(20,5,'Financiador:',0,0,'L');
				$this->Cell(55,5,$row['financiador'],0,0,'L');
				$this->Ln(4);
				$this->Cell(20,5,'Regional:',0,0,'L');
				$this->Cell(55,5,$row['regional'],0,0,'L');
				$this->Ln(4);
				$this->Cell(20,5,'Programa:',0,0,'L');
				$this->Cell(55,5,$row['programa'],0,0,'L');
				$this->Ln(4);
				$this->Cell(20,5,'Subprograma:',0,0,'L');
				$this->Cell(55,5,$row['subprograma'],0,1,'L');
				$this->Ln(4);

				//Se despliegan los títulos de columnas
				$this->SetFont('Arial','',6);
				$w=array(67,20,20,20,21,20,25,20,20,20);

				for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],5,$header[$i],1,0,'C',0);
				$this->Ln();

				//Se iguala las variables internas de la EP
				$financiador=$row['financiador'];
				$regional=$row['regional'];
				$programa=$row['programa'];
				$subprograma=$row['subprograma'];
				$cont_sub++;
			}

			//Verifica si se debe colocar los títulos de las columnas por el Auxiliar
			if($auxiliar!=$row['auxiliar']){
				//Despliega las columnas del Grupo Auxiliar
				$this->SetFont('Arial','B',6);
				//$this->SetX(15);
				//$this->Ln(2);
				//$this->SetFillColor(193,205,205);

				$this->Cell(12,4,'',0,0,'L',0);
				$this->Cell(80,4,'',0,0,'L',0);//
				$this->Ln(1);

				$auxiliar=$row['auxiliar'];
				$cont_aux++;
			}

			//Se modifica la bandera que indica que no es la primera vez que entra
			$prim_subp=0;
			$prim_auxiliar=0;
			$sw_aux=0;

			$this->SetFont('Arial','',6);
			//Dibuja los datos de la grilla

			//Acumula los totales por auxiliar
			$tot_sub[$cont_sub][$cont_aux]['val_act']+=$row['valor_activo'];
			$tot_sub[$cont_sub][$cont_aux]['inc_act']+=$row['incremento_actualiz'];
			$tot_sub[$cont_sub][$cont_aux]['val_actualiz']+=$row['valor_actualiz'];
			$tot_sub[$cont_sub][$cont_aux]['deprec_acum_ini']+=$row['deprec_acum_ini'];
			$tot_sub[$cont_sub][$cont_aux]['inc_dep_act']+=$row['incremento_dep_actualiz'];
			$tot_sub[$cont_sub][$cont_aux]['dep_actualiz']+=$row['dep_actualiz'];
			$tot_sub[$cont_sub][$cont_aux]['dep_men']+=$row['deprec_mensual'];
			$tot_sub[$cont_sub][$cont_aux]['dep_acum']+=$row['depreciacion_acum'];
			$tot_sub[$cont_sub][$cont_aux]['val_neto']+=$row['valor_neto'];
		}

		if(count($data)>0){
			//Despliega los totales del último auxiliar

			$this->SetFont('Arial','',6);
			
			$this->Cell($w[0],4,$row['auxiliar'],'',0,'L');//desc_detalle
			//$this->Cell($w[1],4,'','',0,'L');//desc_valor_activo
			$linea='';
			$this->Cell($w[2],4,number_format($tot_sub[$cont_sub][$cont_aux]['val_act'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//desc_ret_incor
			$this->Cell($w[3],4,number_format($tot_sub[$cont_sub][$cont_aux]['inc_act'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//actualiz
			$this->Cell($w[4],4,number_format($tot_sub[$cont_sub][$cont_aux]['val_actualiz'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//valor_actualiz
			$this->Cell($w[5],4,number_format($tot_sub[$cont_sub][$cont_aux]['deprec_acum_ini'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//depreciacion_acum_ant
			$this->Cell($w[6],4,number_format($tot_sub[$cont_sub][$cont_aux]['inc_dep_act'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//dep_actualiz
			$this->Cell($w[7],4,number_format($tot_sub[$cont_sub][$cont_aux]['dep_actualiz'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//dep_valor_actuliz
			$this->Cell($w[8],4,number_format($tot_sub[$cont_sub][$cont_aux]['dep_men'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//depreciacion
			$this->Cell($w[9],4,number_format($tot_sub[$cont_sub][$cont_aux]['dep_acum'],2,$this->sep_decim,$this->sep_miles),$linea,0,'R');//depreciacion_acum
			$this->Cell($w[10],4,number_format($tot_sub[$cont_sub][$cont_aux]['val_neto'],2,$this->sep_decim,$this->sep_miles),$linea,1,'R');//monto_vigente

			//Despliega los totales del último Subprograma
			$this->SetFont('Arial','B',6);
			$aux=$this->obtener_totales_subp($tot_sub[$cont_sub]);
			$this->Cell($w[0],4,'Total Subprograma:','T',0,'L');//desc_detalle
			//$this->Cell($w[1],4,'','T',0,'L');//desc_valor_activo
			$this->Cell($w[2],4,number_format($aux['val_act'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//desc_ret_incor
			$this->Cell($w[3],4,number_format($aux['inc_act'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//actualiz
			$this->Cell($w[4],4,number_format($aux['val_actualiz'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//valor_actualiz
			$this->Cell($w[5],4,number_format($aux['deprec_acum_ini'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//depreciacion_acum_ant
			$this->Cell($w[6],4,number_format($aux['inc_dep_act'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//dep_actualiz
			$this->Cell($w[7],4,number_format($aux['dep_actualiz'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//dep_valor_actuliz
			$this->Cell($w[8],4,number_format($aux['dep_men'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//depreciacion
			$this->Cell($w[9],4,number_format($aux['dep_acum'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//depreciacion_acum
			$this->Cell($w[10],4,number_format($aux['val_neto'],2,$this->sep_decim,$this->sep_miles),'T',1,'R');//monto_vigente

			//Despliega el Total General
			$this->Ln(5);
			$aux=$this->obtener_total_ep($tot_sub);
			//Despliega los totales por Auxiliar
			$this->SetFont('Arial','B',6);
			$this->Cell($w[0],4,'TOTAL GENERAL:','T',0,'L');//desc_detalle
			//$this->Cell($w[1],4,'','T',0,'L');//desc_valor_activo
			$this->Cell($w[2],4,number_format($aux['val_act'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//desc_ret_incor
			$this->Cell($w[3],4,number_format($aux['inc_act'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//actualiz
			$this->Cell($w[4],4,number_format($aux['val_actualiz'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//valor_actualiz
			$this->Cell($w[5],4,number_format($aux['deprec_acum_ini'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//depreciacion_acum_ant
			$this->Cell($w[6],4,number_format($aux['inc_dep_act'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//dep_actualiz
			$this->Cell($w[7],4,number_format($aux['dep_actualiz'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//dep_valor_actuliz
			$this->Cell($w[8],4,number_format($aux['dep_men'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//depreciacion
			$this->Cell($w[9],4,number_format($aux['dep_acum'],2,$this->sep_decim,$this->sep_miles),'T',0,'R');//depreciacion_acum
			$this->Cell($w[10],4,number_format($aux['val_neto'],2,$this->sep_decim,$this->sep_miles),'T',1,'R');//monto_vigente
		}


		/*echo"<pre>";
		print_r($tot_sub);
		echo"<pre>";*/
	}

	function obtener_totales_subp($array){
		$result;
		/*echo 'sadasdasd';
		echo"<pre>";
		print_r($array);
		echo"<pre>";
		exit;*/
		foreach ($array as $det){
			$result['val_act']+=$det['val_act'];
			$result['inc_act']+=$det['inc_act'];
			$result['val_actualiz']+=$det['val_actualiz'];
			$result['deprec_acum_ini']+=$det['deprec_acum_ini'];
			$result['inc_dep_act']+=$det['inc_dep_act'];
			$result['dep_actualiz']+=$det['dep_actualiz'];
			$result['dep_men']+=$det['dep_men'];
			$result['dep_acum']+=$det['dep_acum'];
			$result['val_neto']+=$det['val_neto'];
		}
		return $result;
	}

	function obtener_total_ep($array){
		$result;
		foreach ($array as $val){
			foreach ($val as $det){
				$result['val_act']+=$det['val_act'];
				$result['inc_act']+=$det['inc_act'];
				$result['val_actualiz']+=$det['val_actualiz'];
				$result['deprec_acum_ini']+=$det['deprec_acum_ini'];
				$result['inc_dep_act']+=$det['inc_dep_act'];
				$result['dep_actualiz']+=$det['dep_actualiz'];
				$result['dep_men']+=$det['dep_men'];
				$result['dep_acum']+=$det['dep_acum'];
				$result['val_neto']+=$det['val_neto'];
			}
		}
		return $result;
	}

}

$pdf=new PDF('L','mm','Letter');
$pdf->AliasNbPages();
//Títulos de las columnas


//Verifica si el tipo de reporte es Detalle o Totales

$header=array('AUXILIAR','VALOR ACTIVO','ACTUALIZ UFV','VALOR ACTUALIZ','DEPRE.ACU. INICIAL','ACTUALIZ UFV','DEPRE.ACU.ACTUALIZ','DEP MENSUAL','DEP. ACUM','VALOR NETO');//toodo lo que quiero mostrar en mis columnas

/*echo $fecha_inicio;
exit;*/
$data=$pdf->LoadData($id_financiador,$id_regional,$id_programa,$id_proyecto,$fecha,$id_auxiliar);
/*echo($fecha_inicio);
exit();*/
$pdf->SetFont('Arial','',12);
$pdf->SetAutoPageBreak(1,35);
$pdf->SetTopMargin(15);
$pdf->SetRightMargin(10);
$pdf->SetLeftMargin(10);
$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();
?>