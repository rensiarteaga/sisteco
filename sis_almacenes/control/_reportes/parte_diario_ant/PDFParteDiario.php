<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../LibModeloAlmacenes.php");

class PDF extends FPDF
{
	//Cargar los datos
	//Cabecera de página
	var $saldo_ing;//Para los saldos de los ingresos
	var $saldo_sal;//Para los saldos de las salidas
	var $saldo_inicial;//Saldo inicial físico
	var $saldo_mon_inicial;//Saldo inicial monetario

	function Header()
	{
		global $title;
		$imprimir_footer=1;
		$this->SetLeftMargin(15);
		$funciones = new funciones();
		//Logo
		//$this->Image('../../../../lib/images/logo_reporte.jpg',200,2);
		$this->Image('../../../../lib/images/logo_reporte.jpg',235,8,36,13);
		
		$this->SetFont('Arial','',8);
		$this->SetX(247);
		$this->Cell(60,13,'Página '.$this->PageNo().' de {nb}',0,1,'L');
		//Arial bold 15
		/*$this->SetFont('Arial','B',12);
		//Movernos a la derecha
		$this->Cell(185,13,'PEDIDO DE MATERIALES',0,0,'C');
		$this->Ln(16);*/
	}
	//Pie de página
	function Footer()
	{
		//Posición: a 1,5 cm del final

		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','',8);
		//ip
		$ip = captura_ip();
		//Número de página
		$fecha=date("d-m-Y");
		//hora
		$hora=date("H:i:s");
		$this->Cell(60,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L');
		//$this->Cell(165,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		//$this->Cell(165,10,'Fecha: '.$fecha ,0,0,'L');
		$this->ln(3);
		$this->Cell(60,10,'',0,0,'L');
		$this->Cell(165,10,'',0,0,'C');
		//$this->Cell(165,10,'Hora: '.$hora ,0,0,'L');
		//fecha
	}
	function LoadData()
	{
		$cant=100000;
		$puntero=0;
		$sortcol='INGRES.fecha_finalizado_cancelado';
		$sortdir='asc';
		$criterio_filtro=' INGRES.fecha_finalizado_cancelado BETWEEN '.$_SESSION["part_dia_fecha_ini"].' AND '.$_SESSION["part_dia_fecha_fin"];
		//Leer las líneas del fichero
		$Custom=new cls_CustomDBAlmacenes();
		$Custom->ListarParteDiario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

		$resp=$Custom->salida;

		return $resp;
	}

	function Maestro($data,$titulo_copia,$header,$header_det)
	{
		$this->imprimir_footer=1;
		$this->SetFont('Arial','B',12);
		//Movernos a la derecha
		$this->Cell(185,13,'KARDEX',0,1,'C');
		$this->Cell(185,13,'DEL '.$_SESSION["kard_item_fecha_desde"].'  AL '.$_SESSION["kard_item_fecha_hasta"],0,0,'C');
		$this->Ln(10);

		/*if(sizeof($data>0))
		{
		$this->SetFont('Arial','',10);
		$this->Cell(120,10,'Item: '.$data[0]['nombre_item'],0,0,'L');//,'LR',0,'C');
		$this->Cell(140,10,'Descripción: '.$data[0]['descripcion_item'],0,0,'L');
		$this->Ln(4);
		$this->FancyTable($data,$header,$header_det);
		}*/

	}


	//Tabla coloreada
	function FancyTable($data,$header,$header_det)
	{
		// establecemos el idioma de la página
         setlocale (LC_TIME,"spanish", "es_ES@euro", "es_ES", "es");
        //creamos la cadena con los especificadores necesarios
         $formato = "%d de %B de %Y";
         //$formato = "%A, %d de %B de %Y";
		
		$cant=100000;
		$puntero=0;
		$sortcol='ITEM.nombre';
		$sortdir='asc';
		$criterio_filtro=" INGRES.fecha_finalizado_cancelado BETWEEN ''".$_SESSION["part_dia_fecha_desde"]."'' AND ''".$_SESSION["part_dia_fecha_hasta"]."''";
		//$criterio_filtro=" INGRES.fecha_finalizado_cancelado = ''".$_SESSION["part_dia_fecha_desde"]."''";
		$Custom=new cls_CustomDBAlmacenes();

		//Obtiene los Ingresos por Item
		$Custom->ListarParteDiarioIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$resp_ing=$Custom->salida;
		
		//Obtiene las Salidas por Item
		//$criterio_filtro=" SALIDA.fecha_finalizado_cancelado = ''".$_SESSION["part_dia_fecha_desde"]."''";
		$criterio_filtro=" SALIDA.fecha_finalizado_cancelado BETWEEN ''".$_SESSION["part_dia_fecha_desde"]."'' AND ''".$_SESSION["part_dia_fecha_hasta"]."''";
		$Custom->ListarParteDiarioSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$resp_sal=$Custom->salida;

		//print "<pre>";
		//print_r($resp_sal);
		//print "</pre>";

		//Obtiene los ingresos y salidas en el formato para el reporte
		$par_ing=$this->FormatoIngreso($resp_ing);
		$par_sal=$this->FormatoSalida($resp_sal);

		//print "<pre>";
		//print_r($par_sal);
		//print "</pre>";

		/*print "<pre>";
		print_r($par_ing);
		print "</pre>";
		exit;*/


		/*$par_sal[0]['item']='PACTAPGSA00';
		$par_sal[0]['nombre']='12 mm';
		$par_sal[0]['descripcion_item']='Sin Rosca 12 mm Contra Tuerca a Presión ,Acero Galvanizado, 12 mm';
		$par_sal[0]['cant_sal']='1';
		$par_sal[0]['cant_tran_sal']='2';
		$par_sal[0]['cant_demasia']='3';
		$par_sal[0]['parcial_sal']='4';*/


		//Obtiene el array con ingresos y salidas
		$parte_diario=$par_ing;
		/*echo"<pre>";
		print_r($parte_diario);
		echo"</pre>";
		exit;*/
		$cont=1;
		$sw=0;

		//Recorre todas las salidas ubicadas y busca los items dentro del array parte diario para completar los datos de las salidas
		if(count($par_sal)>0)
		{
			foreach ($par_sal as $row)
			{
				
				if(count($par_ing)>0)
				{
					foreach ($par_ing as $data)
					{
						if($data['id_item']==$row['id_item'])
						{
							$parte_diario[$cont]['cant_sal']=$row['cant_sal'];
							$parte_diario[$cont]['cant_tran_sal']=$row['cant_tran_sal'];
							$parte_diario[$cont]['cant_demasia']=$row['cant_demasia'];
							$parte_diario[$cont]['parcial_sal']=$row['parcial_sal'];
							//$parte_diario[$cont]['saldo']=$data['parcial_ing']-$row['parcial_sal'];
							$sw=1;
							break;
						}
						$cont++;
					}
				}
				else
				{
					$parte_diario[$cont]['item']=$row['codigo'];
					$parte_diario[$cont]['nombre']=$row['nombre'];
					$parte_diario[$cont]['descripcion_item']=$row['descripcion_item'];
					$parte_diario[$cont]['cant_ing']='';
					$parte_diario[$cont]['cant_tran_ing']='';
					$parte_diario[$cont]['cant_dev_ing']='';
					$parte_diario[$cont]['parcial_ing']='';

					$parte_diario[$cont]['cant_sal']=$row['cant_sal'];
					$parte_diario[$cont]['cant_tran_sal']=$row['cant_tran_sal'];
					$parte_diario[$cont]['cant_demasia']=$row['cant_demasia'];
					$parte_diario[$cont]['parcial_sal']=$row['parcial_sal'];
					$parte_diario[$cont]['saldo_actual']=$row['saldo_actual'];
					//$parte_diario[$cont]['saldo']=$data['parcial_ing']-$row['parcial_sal'];
					$cont++;
				}


				//Si hubieron ingresos de ese item ese día, lo carga en el array parte diario
				/*if(!$sw)
				{
					$parte_diario[$cont]['item']=$row['codigo'];
					$parte_diario[$cont]['nombre']=$row['nombre'];
					$parte_diario[$cont]['descripcion_item']=$row['descripcion_item'];

					$parte_diario[$cont]['cant_ing']='';
					$parte_diario[$cont]['cant_tran_ing']='';
					$parte_diario[$cont]['cant_dev_ing']='';
					$parte_diario[$cont]['parcial_ing']='';

					$parte_diario[$cont]['cant_sal']=$row['cant_sal'];
					$parte_diario[$cont]['cant_tran_sal']=$row['cant_tran_sal'];
					$parte_diario[$cont]['cant_demasia']=$row['cant_demasia'];
					$parte_diario[$cont]['parcial_sal']=$row['parcial_sal'];
					$parte_diario[$cont]['saldo']=-$data['parcial_sal'];
				}*/
			}
		}
		//Si no existe ninguna salida, entonces actualiza los saldos al parcial de los ingresos
		else
		{
			$cont=1;
			foreach ($parte_diario as $data)
			{
				$parte_diario[$cont]['cant_sal']='';
				$parte_diario[$cont]['cant_tran_sal']='';
				$parte_diario[$cont]['cant_demasia']='';
				$parte_diario[$cont]['parcial_sal']='';
				$parte_diario[$cont]['saldo']=$data['parcial_ing'];
				$cont++;
			}
		}

		/*print "<pre>";
		print_r($parte_diario);
		print "</pre>";
		exit;*/
		
		//Actualiza el saldo en función de los ingresos y salidas en el Array
		reset($parte_diario);
		$cont=1;
		if(count($parte_diario)>0)
		{
			foreach ($parte_diario as $row)
			{
				$parte_diario[$cont]['saldo_ant']=$row['saldo_actual']-$row['parcial_ing']+$row['parcial_sal'];
				$cont++;
			}
		}
		
		/*print "<pre>";
		print_r($parte_diario);
		print "</pre>";
		exit;*/

		$this->SetFont('Arial','B',12);
		//Movernos a la derecha
		$this->Cell(250,4,'PARTE DIARIO',0,1,'C');
		
		$fechad=$_SESSION["part_dia_fecha_desde"];
			
         $mes = substr($fechad, 0, 2);
         $dia = substr($fechad, 3, 2);
         $anio = substr($fechad, -4); 
         $fechad=$dia.'-'.$mes.'-'.$anio;
         //Mostramos la fecha, ahora sí en el idioma deseado.
         $fechad=strftime($formato, strtotime($fechad));
         
         $fechah=$_SESSION["part_dia_fecha_hasta"];
		
		 $mes = substr($fechah, 0, 2);
		 $dia = substr($fechah, 3, 2);
         $anio = substr($fechah, -4); 
         $fechah=$dia.'-'.$mes.'-'.$anio;
		 
		 //Mostramos la fecha, ahora sí en el idioma deseado.
         $fechah=strftime($formato, strtotime($fechah));
         
		$this->SetFont('Arial','B',8);
		$this->Cell(250,6,'Del '.$fechad.' Al '.$fechah,0,0,'C');
		$this->Ln(10);

		//Contador hoja
		$prim_hoja=1;

		$this->SetFont('Arial','',10);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.1);
		$this->SetFont('','',10);

		//Cabecera
		$w=array(5,20,80,14,14,17,15,14,14,17,14,14,14);
		//('Item','Descripción','Ingresos','Transferencias','Devoluciones','Parcial','Salidas','Transferencias','Demasía','Parcial','Saldo');
		$fecha=date("d-m-Y");

		$this->SetFont('Arial','',7);
		//Imprime los rótulos de las columnas

		$this->Cell(119,3,'',0,0,'C',1);
		$this->Cell(46,3,'INGRESOS','LTR',0,'C',1);
		$this->Cell(14,3,'','L',0,'C',1);
		$this->Cell(45,3,'SALIDAS','LTR',1,'C',1);

		for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],5,$header[$i],1,0,'C',1);
		$this->Ln();

		// Se imprime los datos de ingresos
		$this->SetFont('Arial','',5);
		$cont=1;
		$id_item='';
		$tot_item=0;

		foreach($parte_diario as $row)
		{
			//Coloca el Item y la descripción
			$this->Cell($w[0],4,$cont,'LTRB',0,'C',$fill);
			$this->Cell($w[1],4,$row['nombre'],'LTRB',0,'L',$fill);
			$this->Cell($w[2],4,$row['descripcion_item'],'LTRB',0,'L',$fill);
			$this->Cell($w[3],4,$row['saldo_ant'],'LTRB',0,'R',$fill);
			$this->Cell($w[4],4,$row['cant_ing'],'LTRB',0,'R',$fill);
			$this->Cell($w[5],4,$row['cant_tran_ing'],'LTRB',0,'R',$fill);
			$this->Cell($w[6],4,$row['cant_dev_ing'],'LTRB',0,'R',$fill);
			$this->Cell($w[7],4,$row['parcial_ing'],'LTRB',0,'R',$fill);
			$this->Cell($w[8],4,$row['cant_sal'],'LTRB',0,'R',$fill);
			$this->Cell($w[9],4,$row['cant_tran_sal'],'LTRB',0,'R',$fill);
			$this->Cell($w[10],4,$row['cant_demasia'],'LTRB',0,'R',$fill);
			$this->Cell($w[11],4,$row['parcial_sal'],'LTRB',0,'R',$fill);
			$this->Cell($w[12],4,$row['saldo_actual'],'LTRB',1,'R',$fill);
			$cont++;
		}
	}

	function FormatoIngreso($resp_ing)
	{
		//Une ambos arrays para desplegarlos
		$id_item='';
		$cont=0;
		$tot_item=0;
		foreach($resp_ing as $row)
		{
			if($id_item!=$row['id_item'])
			{
				if($cont>0)
				{
					//Coloca el Parcial del anterior Item
					$par_ing[$cont]['parcial_ing']=$tot_item;
					$par_ing[$cont]['saldo']=$tot_item;
				}

				$tot_item=0;
				$id_item=$row['id_item'];
				$cont++;

				//Coloca el Item y la descripción
				$par_ing[$cont]['item']=$row['codigo'];
				$par_ing[$cont]['nombre']=$row['nombre'];
				$par_ing[$cont]['descripcion_item']=$row['descripcion_item'];

				$par_ing[$cont]['cant_ing']='';
				$par_ing[$cont]['cant_tran_ing']='';
				$par_ing[$cont]['cant_dev_ing']='';
				$par_ing[$cont]['parcial_ing']='';

			}

			//Coloca las cantidades dependiendo del motivo de ingreso
			if($row['mot_ingreso']=='Ingresos')
			{
				$par_ing[$cont]['cant_ing']=$row['cantidad'];
			}
			else if($row['mot_ingreso']=='Transferencia')
			{
				$par_ing[$cont]['cant_tran_ing']=$row['cantidad'];
			}
			else if($row['mot_ingreso']=='Devolucion')
			{
				$par_ing[$cont]['cant_dev_ing']=$row['cantidad'];
			}
			
			//Carga el saldo actual
			$par_ing[$cont]['saldo_actual']=$row['saldo_actual'];

			//Obtiene el Parcial
			$tot_item+=$row['cantidad'];
		}
		
		//Coloca el Parcial del último Item
		if(count($resp_ing)>0)
		{
			$par_ing[$cont]['parcial_ing']=$tot_item;
			$par_ing[$cont]['saldo']=$tot_item;
		}

		return $par_ing;
	}

	function FormatoSalida($resp_sal)
	{
		//Une ambos arrays para desplegarlos
		$id_item='';
		$cont=0;
		$tot_item=0;
		$tot_demasia=0;
		foreach($resp_sal as $row)
		{
			if($id_item!=$row['id_item'])
			{
				if($cont>0)
				{
					//Coloca el Parcial del anterior Item
					$par_sal[$cont]['parcial_sal']=$tot_item;
					$par_sal[$cont]['cant_demasia']=$tot_demasia;
				}

				$tot_item=0;
				$tot_demasia=0;
				$id_item=$row['id_item'];
				$cont++;

				//Coloca el Item y la descripción
				$par_sal[$cont]['item']=$row['codigo'];
				$par_sal[$cont]['nombre']=$row['nombre'];
				$par_sal[$cont]['descripcion_item']=$row['descripcion_item'];

				$par_sal[$cont]['cant_sal']='';
				$par_sal[$cont]['cant_tran_sal']='';
				$par_sal[$cont]['cant_demasia']='';
				$par_sal[$cont]['parcial_sal']='';
			}

			//Coloca las cantidades dependiendo del motivo de ingreso
			if($row['mot_salida']=='Salida')
			{
				$par_sal[$cont]['cant_sal']=$row['cantidad'];
			}
			else if($row['mot_salida']=='Transferencia')
			{
				$par_sal[$cont]['cant_tran_sal']=$row['cantidad'];
			}
			
			//Carga el saldo actual
			$par_sal[$cont]['saldo_actual']=$row['saldo_actual'];

			//Obtiene el Parcial
			$tot_item+=$row['cantidad'];
			$tot_demasia+=$row['demasia'];
		}
		//Coloca el Parcial del último Item
		if(count($resp_sal)>0)
		{
			$par_sal[$cont]['parcial_sal']=$tot_item;
			$par_sal[$cont]['cant_demasia']=$tot_demasia;
		}
		return $par_sal;
	}


}

$pdf=new PDF('L','mm','Letter');
$pdf->AliasNbPages();
//Títulos de las columnas
$header=array('#','Item','Descripción','Saldo Ant.','Ingresos','Transferencias','Devoluciones','Parcial','Salidas','Transferencias','Demasía','Parcial','Saldo');


//Carga de datos
$tipo=$tipo;
//$data=$pdf->LoadData();
//echo json_encode($tipo_torre);
$pdf->SetFont('Arial','',10);
$pdf->SetAutoPageBreak(1,20);
$pdf->SetTopMargin(15);
$pdf->SetRightMargin(15);
$pdf->SetLeftMargin(15);
$pdf->AddPage();
//$pdf->Maestro($data,'Original',$header,$header_det);
$pdf->FancyTable('',$header,'');
$pdf->Output();
?>