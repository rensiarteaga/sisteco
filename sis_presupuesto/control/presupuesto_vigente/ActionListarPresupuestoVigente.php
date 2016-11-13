<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarPartidaModificacion.php
Prop�sito:				Permite realizar el listado en tpr_partida_modificacion
Tabla:					tpr_tpr_partida_modificacion
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		2010-05-10 18:19:16
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarPresupuestoVigente.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
	//Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0)
	{
		$get=true;
		$cont=1;
		
		
		//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
		//valores permitidos de $cod -> "si", "no"
		switch ($cod)
		{
			case "si":
				$decodificar = true;
				break;
			case "no":
				$decodificar = false;
				break;
			default:
				$decodificar = true;
				break;
		}
	}
	elseif(sizeof($_POST) > 0)
	{
		$get = false;
		$cont =  $_POST["cantidad_ids"];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
		$resp->origen = "ORIGEN = ";
		$resp->proc = "PROC = ";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}
	
	//Par�metros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'descripcion';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'desc';
	else $sortdir = $dir;

	//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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
		
	$id_presupuesto = $_POST["id_presupuesto"];
	$id_partida = $_POST["id_partida"];
	$id_moneda = $_POST["id_moneda"]; 
	$id_partida_modificacion = $_POST["id_partida_modificacion"]; 
	$id_partida_presupuesto = $_POST["id_partida_presupuesto"]; 
	$tipo_modificacion = $_POST['tipo_modificacion'];
					
	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
		
	$criterio_filtro = $cond -> obtener_criterio_filtro();
		
	//$criterio_filtro = $criterio_filtro." and parpre.id_presupuesto = $id_presupuesto and parpre.id_partida = $id_partida and pardet.id_moneda = $id_moneda";
		
	//Obtiene el total de los registros
	//if($id_moneda != '' && $id_partida != '' && $id_partida_modificacion != '' && $id_partida_presupuesto != '' && $id_presupuesto)
		$res = $Custom -> PresupuestoVigente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_presupuesto,$id_partida,$id_moneda,$id_partida_modificacion,$id_partida_presupuesto);
		//echo var_dump($Custom); exit;
	
	/*else 
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,'406');
		$resp->mensaje_error = "No se puede editar esta fila";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = 'NIVEL = 3';
		echo $resp->get_mensaje();
		exit;
	}*/
					
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		$sw=0;

		if($id_partida_modificacion == '') //nuevo
		{
			foreach ($Custom->salida as $f)
			{
				$xml->add_rama('ROWS');
				$xml->add_nodo('id_partida_detalle_modificacion',$f["id_partida_detalle_modificacion"]);
				$xml->add_nodo('descripcion',$f["descripcion"]);
				
				if($f["mes_01"] == '')
					$xml->add_nodo('mes_01',0);
				else
					$xml->add_nodo('mes_01',$f["mes_01"]);
					
				if($f["mes_02"] == '')
					$xml->add_nodo('mes_02',0);
				else
					$xml->add_nodo('mes_02',$f["mes_02"]);
				
				if($f["mes_03"] == '')
					$xml->add_nodo('mes_03',0);
				else	
					$xml->add_nodo('mes_03',$f["mes_03"]);
					
				if($f["mes_04"] == '')
					$xml->add_nodo('mes_04',0);
				else
					$xml->add_nodo('mes_04',$f["mes_04"]);
					
				if($f["mes_05"] == '')
					$xml->add_nodo('mes_05',0);
				else
					$xml->add_nodo('mes_05',$f["mes_05"]);
					
				if($f["mes_06"] == '')
					$xml->add_nodo('mes_06',0);
				else
					$xml->add_nodo('mes_06',$f["mes_06"]);
					
				if($f["mes_07"] == '')
					$xml->add_nodo('mes_07',0);
				else
					$xml->add_nodo('mes_07',$f["mes_07"]);
				
				if($f["mes_08"] == '')
					$xml->add_nodo('mes_08',0);
				else	
					$xml->add_nodo('mes_08',$f["mes_08"]);
				
				if($f["mes_09"] == '')
					$xml->add_nodo('mes_09',0);
				else	
					$xml->add_nodo('mes_09',$f["mes_09"]);
				
				if($f["mes_10"] == '')
					$xml->add_nodo('mes_10',0);
				else	
					$xml->add_nodo('mes_10',$f["mes_10"]);
				
				if($f["mes_11"] == '')
					$xml->add_nodo('mes_11',0);
				else	
					$xml->add_nodo('mes_11',$f["mes_11"]);
				
				if($f["mes_12"] == '')
					$xml->add_nodo('mes_12',0);
				else	
					$xml->add_nodo('mes_12',$f["mes_12"]);
				
				if($f["total"] == '')
					$xml->add_nodo('total',0);
				else	
					$xml->add_nodo('total',$f["total"]);
				
				$t_mes_01 = $t_mes_01 + $f["mes_01"];
				$t_mes_02 = $t_mes_02 + $f["mes_02"];
				$t_mes_03 = $t_mes_03 + $f["mes_03"];
				$t_mes_04 = $t_mes_04 + $f["mes_04"];
				$t_mes_05 = $t_mes_05 + $f["mes_05"];
				$t_mes_06 = $t_mes_06 + $f["mes_06"];
				$t_mes_07 = $t_mes_07 + $f["mes_07"];
				$t_mes_08 = $t_mes_08 + $f["mes_08"];
				$t_mes_09 = $t_mes_09 + $f["mes_09"];
				$t_mes_10 = $t_mes_10 + $f["mes_10"];
				$t_mes_11 = $t_mes_11 + $f["mes_11"];
				$t_mes_12 = $t_mes_12 + $f["mes_12"];
				$total = $total + $f["total"];
					
				$xml->add_nodo('fila','vigente');	
				$xml->fin_rama();
				$sw=1;
			}
			//adiciona la fila para editar
			if($sw==1)
			{
				$xml->add_rama('ROWS');
				$xml->add_nodo('id_partida_detalle_modificacion','edit_'.$f["id_partida_detalle_modificacion"]);
				$xml->add_nodo('descripcion','REFORMULACION');
				$xml->add_nodo('mes_01',0);
				$xml->add_nodo('mes_02',0);
				$xml->add_nodo('mes_03',0);
				$xml->add_nodo('mes_04',0);
				$xml->add_nodo('mes_05',0);
				$xml->add_nodo('mes_06',0);
				$xml->add_nodo('mes_07',0);
				$xml->add_nodo('mes_08',0);
				$xml->add_nodo('mes_09',0);
				$xml->add_nodo('mes_10',0);
				$xml->add_nodo('mes_11',0);
				$xml->add_nodo('mes_12',0);
				$xml->add_nodo('total',0);
				$xml->add_nodo('fila','modificacion');
	
				$xml->fin_rama();
			
				//adiciona total
				$xml->add_rama('ROWS');
				$xml->add_nodo('id_partida_detalle_modificacion','total');
				$xml->add_nodo('descripcion','**TOTAL**');
				
				if($f["mes_01"] == '')
					$xml->add_nodo('mes_01',0);
				else 
					$xml->add_nodo('mes_01',$t_mes_01);
									
				if($f["mes_02"] == '')
					$xml->add_nodo('mes_02',0);
				else
					$xml->add_nodo('mes_02',$t_mes_02);
				
				if($f["mes_03"] == '')
					$xml->add_nodo('mes_03',0);
				else	
					$xml->add_nodo('mes_03',$t_mes_03);
					
				if($f["mes_04"] == '')
					$xml->add_nodo('mes_04',0);
				else
					$xml->add_nodo('mes_04',$t_mes_04);
					
				if($f["mes_05"] == '')
					$xml->add_nodo('mes_05',0);
				else
					$xml->add_nodo('mes_05',$t_mes_05);
					
				if($f["mes_06"] == '')
					$xml->add_nodo('mes_06',0);
				else
					$xml->add_nodo('mes_06',$t_mes_06);
					
				if($f["mes_07"] == '')
					$xml->add_nodo('mes_07',0);
				else
					$xml->add_nodo('mes_07',$t_mes_07);
				
				if($f["mes_08"] == '')
					$xml->add_nodo('mes_08',0);
				else	
					$xml->add_nodo('mes_08',$t_mes_08);
				
				if($f["mes_09"] == '')
					$xml->add_nodo('mes_09',0);
				else	
					$xml->add_nodo('mes_09',$t_mes_09);
				
				if($f["mes_10"] == '')
					$xml->add_nodo('mes_10',0);
				else	
					$xml->add_nodo('mes_10',$t_mes_10);
				
				if($f["mes_11"] == '')
					$xml->add_nodo('mes_11',0);
				else	
					$xml->add_nodo('mes_11',$t_mes_11);
				
				if($f["mes_12"] == '')
					$xml->add_nodo('mes_12',0);
				else	
					$xml->add_nodo('mes_12',$t_mes_12);
				
				if($f["total"] == '')
					$xml->add_nodo('total',0);
				else	
					$xml->add_nodo('total',$total);
					
				$xml->add_nodo('fila','total');
	
				$xml->fin_rama();
			}
		}
		else //editar
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_partida_detalle_modificacion',$f["id_partida_detalle_modificacion"]);
			$xml->add_nodo('descripcion',$Custom->salida[0]["descripcion"]);
			
			if($tipo_modificacion == "\'Incremento\'")
			{						
				if($Custom->salida[0]['mes_01'] == null)
					$xml->add_nodo('mes_01',0);
				else 
					$xml->add_nodo('mes_01',$Custom->salida[0]['mes_01']);
					
				if($Custom->salida[0]['mes_02'] == '')
					$xml->add_nodo('mes_02',0);
				else 
					$xml->add_nodo('mes_02',$Custom->salida[0]['mes_02']);
					
				if($Custom->salida[0]['mes_03'] == '')
					$xml->add_nodo('mes_03',0);
				else 
					$xml->add_nodo('mes_03',$Custom->salida[0]['mes_03']);
					
				if($Custom->salida[0]['mes_04'] == '')
					$xml->add_nodo('mes_04',0);
				else 
					$xml->add_nodo('mes_04',$Custom->salida[0]['mes_04']);
					
				if($Custom->salida[0]['mes_05'] == '')
					$xml->add_nodo('mes_05',0);
				else 
					$xml->add_nodo('mes_05',$Custom->salida[0]['mes_05']);
					
				if($Custom->salida[0]['mes_06'] == '')
					$xml->add_nodo('mes_06',0);
				else 
					$xml->add_nodo('mes_06',$Custom->salida[0]['mes_06']);
					
				if($Custom->salida[0]['mes_07'] == '')
					$xml->add_nodo('mes_07',0);
				else 
					$xml->add_nodo('mes_07',$Custom->salida[0]['mes_07']);
					
				if($Custom->salida[0]['mes_08'] == '')
					$xml->add_nodo('mes_08',0);
				else 
					$xml->add_nodo('mes_08',$Custom->salida[0]['mes_08']);
					
				if($Custom->salida[0]['mes_09'] == '')
					$xml->add_nodo('mes_09',0);
				else 
					$xml->add_nodo('mes_09',$Custom->salida[0]['mes_09']);
					
				if($Custom->salida[0]['mes_10'] == '')
					$xml->add_nodo('mes_10',0);
				else 
					$xml->add_nodo('mes_10',$Custom->salida[0]['mes_10']);
					
				if($Custom->salida[0]['mes_11'] == '')
					$xml->add_nodo('mes_11',0);
				else 
					$xml->add_nodo('mes_11',$Custom->salida[0]['mes_11']);
					
				if($Custom->salida[0]['mes_12'] == '')
					$xml->add_nodo('mes_12',0);
				else 
					$xml->add_nodo('mes_12',$Custom->salida[0]['mes_12']);
					
				if($Custom->salida[0]['total'] == '')
					$xml->add_nodo('total',0);
				else 
					$xml->add_nodo('total',$Custom->salida[0]['total']);
			}
			else 
			{
				/*$xml->add_nodo('mes_01',$Custom->salida[0]['mes_01']);
				$xml->add_nodo('mes_02',$Custom->salida[0]['mes_02']);
				$xml->add_nodo('mes_03',$Custom->salida[0]['mes_03']);
				$xml->add_nodo('mes_04',$Custom->salida[0]['mes_04']);
				$xml->add_nodo('mes_05',$Custom->salida[0]['mes_05']);
				$xml->add_nodo('mes_06',$Custom->salida[0]['mes_06']);
				$xml->add_nodo('mes_07',$Custom->salida[0]['mes_07']);
				$xml->add_nodo('mes_08',$Custom->salida[0]['mes_08']);
				$xml->add_nodo('mes_09',$Custom->salida[0]['mes_09']);
				$xml->add_nodo('mes_10',$Custom->salida[0]['mes_10']);
				$xml->add_nodo('mes_11',$Custom->salida[0]['mes_11']);
				$xml->add_nodo('mes_12',$Custom->salida[0]['mes_12']);
				$xml->add_nodo('total',$Custom->salida[0]['total']);*/
				
				if($Custom->salida[0]['mes_01'] == null)
					$xml->add_nodo('mes_01',0);
				else 
					$xml->add_nodo('mes_01',$Custom->salida[0]['mes_01']);
					
				if($Custom->salida[0]['mes_02'] == '')
					$xml->add_nodo('mes_02',0);
				else 
					$xml->add_nodo('mes_02',$Custom->salida[0]['mes_02']);
					
				if($Custom->salida[0]['mes_03'] == '')
					$xml->add_nodo('mes_03',0);
				else 
					$xml->add_nodo('mes_03',$Custom->salida[0]['mes_03']);
					
				if($Custom->salida[0]['mes_04'] == '')
					$xml->add_nodo('mes_04',0);
				else 
					$xml->add_nodo('mes_04',$Custom->salida[0]['mes_04']);
					
				if($Custom->salida[0]['mes_05'] == '')
					$xml->add_nodo('mes_05',0);
				else 
					$xml->add_nodo('mes_05',$Custom->salida[0]['mes_05']);
					
				if($Custom->salida[0]['mes_06'] == '')
					$xml->add_nodo('mes_06',0);
				else 
					$xml->add_nodo('mes_06',$Custom->salida[0]['mes_06']);
					
				if($Custom->salida[0]['mes_07'] == '')
					$xml->add_nodo('mes_07',0);
				else 
					$xml->add_nodo('mes_07',$Custom->salida[0]['mes_07']);
					
				if($Custom->salida[0]['mes_08'] == '')
					$xml->add_nodo('mes_08',0);
				else 
					$xml->add_nodo('mes_08',$Custom->salida[0]['mes_08']);
					
				if($Custom->salida[0]['mes_09'] == '')
					$xml->add_nodo('mes_09',0);
				else 
					$xml->add_nodo('mes_09',$Custom->salida[0]['mes_09']);
					
				if($Custom->salida[0]['mes_10'] == '')
					$xml->add_nodo('mes_10',0);
				else 
					$xml->add_nodo('mes_10',$Custom->salida[0]['mes_10']);
					
				if($Custom->salida[0]['mes_11'] == '')
					$xml->add_nodo('mes_11',0);
				else 
					$xml->add_nodo('mes_11',$Custom->salida[0]['mes_11']);
					
				if($Custom->salida[0]['mes_12'] == '')
					$xml->add_nodo('mes_12',0);
				else 
					$xml->add_nodo('mes_12',$Custom->salida[0]['mes_12']);
					
				if($Custom->salida[0]['total'] == '')
					$xml->add_nodo('total',0);
				else 
					$xml->add_nodo('total',$Custom->salida[0]['total']);
			}
											
			$xml->add_nodo('fila','vigente');	
			$xml->fin_rama();
			$sw=1;
			
			//adiciona la fila para editar
			if($sw==1)
			{
				$xml->add_rama('ROWS');
				$xml->add_nodo('id_partida_detalle_modificacion','edit_'.$f["id_partida_detalle_modificacion"]);
				$xml->add_nodo('descripcion','REFORMULACION');
				
				/*$xml->add_nodo('mes_01',$Custom->salida[1]['mes_01']);
				$xml->add_nodo('mes_02',$Custom->salida[1]['mes_02']);
				$xml->add_nodo('mes_03',$Custom->salida[1]['mes_03']);
				$xml->add_nodo('mes_04',$Custom->salida[1]['mes_04']);
				$xml->add_nodo('mes_05',$Custom->salida[1]['mes_05']);
				$xml->add_nodo('mes_06',$Custom->salida[1]['mes_06']);
				$xml->add_nodo('mes_07',$Custom->salida[1]['mes_07']);
				$xml->add_nodo('mes_08',$Custom->salida[1]['mes_08']);
				$xml->add_nodo('mes_09',$Custom->salida[1]['mes_09']);
				$xml->add_nodo('mes_10',$Custom->salida[1]['mes_10']);
				$xml->add_nodo('mes_11',$Custom->salida[1]['mes_11']);
				$xml->add_nodo('mes_12',$Custom->salida[1]['mes_12']);
				$xml->add_nodo('total',$Custom->salida[1]['total']);*/
				
				if($Custom->salida[1]['mes_01'] == null)
					$xml->add_nodo('mes_01',0);
				else 
					$xml->add_nodo('mes_01',$Custom->salida[1]['mes_01']);
					
				if($Custom->salida[1]['mes_02'] == '')
					$xml->add_nodo('mes_02',0);
				else 
					$xml->add_nodo('mes_02',$Custom->salida[1]['mes_02']);
					
				if($Custom->salida[1]['mes_03'] == '')
					$xml->add_nodo('mes_03',0);
				else 
					$xml->add_nodo('mes_03',$Custom->salida[1]['mes_03']);
					
				if($Custom->salida[1]['mes_04'] == '')
					$xml->add_nodo('mes_04',0);
				else 
					$xml->add_nodo('mes_04',$Custom->salida[1]['mes_04']);
					
				if($Custom->salida[1]['mes_05'] == '')
					$xml->add_nodo('mes_05',0);
				else 
					$xml->add_nodo('mes_05',$Custom->salida[1]['mes_05']);
					
				if($Custom->salida[1]['mes_06'] == '')
					$xml->add_nodo('mes_06',0);
				else 
					$xml->add_nodo('mes_06',$Custom->salida[1]['mes_06']);
					
				if($Custom->salida[1]['mes_07'] == '')
					$xml->add_nodo('mes_07',0);
				else 
					$xml->add_nodo('mes_07',$Custom->salida[1]['mes_07']);
					
				if($Custom->salida[1]['mes_08'] == '')
					$xml->add_nodo('mes_08',0);
				else 
					$xml->add_nodo('mes_08',$Custom->salida[1]['mes_08']);
					
				if($Custom->salida[1]['mes_09'] == '')
					$xml->add_nodo('mes_09',0);
				else 
					$xml->add_nodo('mes_09',$Custom->salida[1]['mes_09']);
					
				if($Custom->salida[1]['mes_10'] == '')
					$xml->add_nodo('mes_10',0);
				else 
					$xml->add_nodo('mes_10',$Custom->salida[1]['mes_10']);
					
				if($Custom->salida[1]['mes_11'] == '')
					$xml->add_nodo('mes_11',0);
				else 
					$xml->add_nodo('mes_11',$Custom->salida[1]['mes_11']);
					
				if($Custom->salida[1]['mes_12'] == '')
					$xml->add_nodo('mes_12',0);
				else 
					$xml->add_nodo('mes_12',$Custom->salida[1]['mes_12']);
					
				if($Custom->salida[1]['total'] == '')
					$xml->add_nodo('total',0);
				else 
					$xml->add_nodo('total',$Custom->salida[1]['total']);
								
				$t_mes_01 = $t_mes_01 + $Custom->salida[0]["mes_01"] + $Custom->salida[1]["mes_01"];
				$t_mes_02 = $t_mes_02 + $Custom->salida[0]["mes_02"] + $Custom->salida[1]["mes_02"];
				$t_mes_03 = $t_mes_03 + $Custom->salida[0]["mes_03"] + $Custom->salida[1]["mes_03"];
				$t_mes_04 = $t_mes_04 + $Custom->salida[0]["mes_04"] + $Custom->salida[1]["mes_04"];
				$t_mes_05 = $t_mes_05 + $Custom->salida[0]["mes_05"] + $Custom->salida[1]["mes_05"];
				$t_mes_06 = $t_mes_06 + $Custom->salida[0]["mes_06"] + $Custom->salida[1]["mes_06"];
				$t_mes_07 = $t_mes_07 + $Custom->salida[0]["mes_07"] + $Custom->salida[1]["mes_07"];
				$t_mes_08 = $t_mes_08 + $Custom->salida[0]["mes_08"] + $Custom->salida[1]["mes_08"];
				$t_mes_09 = $t_mes_09 + $Custom->salida[0]["mes_09"] + $Custom->salida[1]["mes_09"];
				$t_mes_10 = $t_mes_10 + $Custom->salida[0]["mes_10"] + $Custom->salida[1]["mes_10"];
				$t_mes_11 = $t_mes_11 + $Custom->salida[0]["mes_11"] + $Custom->salida[1]["mes_11"];
				$t_mes_12 = $t_mes_12 + $Custom->salida[0]["mes_12"] + $Custom->salida[1]["mes_12"];
				$total = $total + $Custom->salida[0]["total"] + $Custom->salida[1]["total"];
				
	//echo $t_mes_01.'-'.$t_mes_02.'-'.$t_mes_03.'-'.$t_mes_04.'-'.$t_mes_05.'-'.$t_mes_06.'-'.$t_mes_07.'-'.$t_mes_08.'-'.$t_mes_09.'-'.$t_mes_10.'-'.$t_mes_11.'-'.$t_mes_12.'-'.$total; exit;
				
				$xml->add_nodo('fila','modificacion');	
				$xml->fin_rama();
			
				//adiciona total
				$xml->add_rama('ROWS');
				$xml->add_nodo('id_partida_detalle_modificacion','total');
				$xml->add_nodo('descripcion','**TOTAL**');
				
				/*if($tipo_modificacion == "\'Incremento\'")
				{*/	
					if($Custom->salida[0]['mes_01'] == '')
						$xml->add_nodo('mes_01',$Custom->salida[1]['mes_01']);
					else
						$xml->add_nodo('mes_01',$t_mes_01); 
					
					if($Custom->salida[0]['mes_02'] == '')
						$xml->add_nodo('mes_02',$Custom->salida[1]['mes_02']);
					else
						$xml->add_nodo('mes_02',$t_mes_02);
						
					if($Custom->salida[0]['mes_03'] == '')
						$xml->add_nodo('mes_03',$Custom->salida[1]['mes_03']);
					else
						$xml->add_nodo('mes_03',$t_mes_03);
						
					if($Custom->salida[0]['mes_04'] == '')
						$xml->add_nodo('mes_04',$Custom->salida[1]['mes_04']);
					else
						$xml->add_nodo('mes_04',$t_mes_04);
						
					if($Custom->salida[0]['mes_05'] == '')
						$xml->add_nodo('mes_05',$Custom->salida[1]['mes_05']);
					else
						$xml->add_nodo('mes_05',$t_mes_05);
						
					if($Custom->salida[0]['mes_06'] == '')
						$xml->add_nodo('mes_06',$Custom->salida[1]['mes_06']);
					else
						$xml->add_nodo('mes_06',$t_mes_06);
						
					if($Custom->salida[0]['mes_07'] == '')
						$xml->add_nodo('mes_07',$Custom->salida[1]['mes_07']);
					else
						$xml->add_nodo('mes_07',$t_mes_07);
					
					if($Custom->salida[0]['mes_08'] == '')
						$xml->add_nodo('mes_08',$Custom->salida[1]['mes_08']);
					else
						$xml->add_nodo('mes_08',$t_mes_08);
						
					if($Custom->salida[0]['mes_09'] == '')
						$xml->add_nodo('mes_09',$Custom->salida[1]['mes_09']);
					else
						$xml->add_nodo('mes_09',$t_mes_09);
						
					if($Custom->salida[0]['mes_10'] == '')
						$xml->add_nodo('mes_10',$Custom->salida[1]['mes_10']);
					else
						$xml->add_nodo('mes_10',$t_mes_10);
						
					if($Custom->salida[0]['mes_11'] == '')
						$xml->add_nodo('mes_11',$Custom->salida[1]['mes_11']);
					else
						$xml->add_nodo('mes_11',$t_mes_11);
						
					if($Custom->salida[0]['mes_12'] == '')
						$xml->add_nodo('mes_12',$Custom->salida[1]['mes_12']);
					else
						$xml->add_nodo('mes_12',$t_mes_12);
						
					if($Custom->salida[0]['total'] == '')
						$xml->add_nodo('total',$Custom->salida[1]['total']);
					else 
						$xml->add_nodo('total',$total);
				/*}
				else
				{
					//echo 'entra'; exit;
					
					$xml->add_nodo('mes_01',$Custom->salida[0]['mes_01']);						
					$xml->add_nodo('mes_02',$Custom->salida[0]['mes_02']);
					$xml->add_nodo('mes_03',$Custom->salida[0]['mes_03']);
					$xml->add_nodo('mes_04',$Custom->salida[0]['mes_04']);
					$xml->add_nodo('mes_05',$Custom->salida[0]['mes_05']);
					$xml->add_nodo('mes_06',$Custom->salida[0]['mes_06']);
					$xml->add_nodo('mes_07',$Custom->salida[0]['mes_07']);
					$xml->add_nodo('mes_08',$Custom->salida[0]['mes_08']);
					$xml->add_nodo('mes_09',$Custom->salida[0]['mes_09']);
					$xml->add_nodo('mes_10',$Custom->salida[0]['mes_10']);
					$xml->add_nodo('mes_11',$Custom->salida[0]['mes_11']);
					$xml->add_nodo('mes_12',$Custom->salida[0]['mes_12']);
					$xml->add_nodo('total',$Custom->salida[0]['total']);
				}*/
				
				$xml->add_nodo('fila','total');	
				$xml->fin_rama();
			}
		}		
		
		$xml->mostrar_xml();
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,'406');
		$resp->mensaje_error = $Custom->salida[1];
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;
	}
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;
}?>