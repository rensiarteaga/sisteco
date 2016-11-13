<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarPartidaModificacion.php
Propósito:				Permite realizar el listado en tpr_partida_modificacion
Tabla:					tpr_tpr_partida_modificacion
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2010-05-10 18:19:16
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarDetallePresupuestoVigente.php';

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
		
		//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
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
	
	//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'partid.nombre_partida';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

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
		
	$id_presupuesto = $_POST["id_presupuesto"];
	$id_partida = $_POST["id_partida"];
	$id_moneda = $_POST["id_moneda"]; 
	$id_partida_modificacion = $_POST["id_partida_modificacion"]; 
	$id_partida_presupuesto = $_POST["id_partida_presupuesto"]; 
	$tipo_modificacion = $_POST['tipo_modificacion'];

	//echo $id_moneda; exit;
	
	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
		
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	/*$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'PartidaPresupuesto');
	$sortcol = $crit_sort->get_criterio_sort();*/
	

	//Obtiene el total de los registros
	$res = $Custom-> ContarDetallePresupuestoVigente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_presupuesto,$id_partida,$id_moneda,$id_partida_modificacion,$id_partida_presupuesto);

	if($res) $total_registros= $Custom->salida;
		
	//Obtiene el total de los registros
	$res = $Custom -> DetallePresupuestoVigente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_presupuesto,$id_partida,$id_moneda,$id_partida_modificacion,$id_partida_presupuesto);
	//echo var_dump($Custom); exit;
							
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');				
			$xml->add_nodo('id_partida_detalle_modificacion',$f["id_partida_detalle_modificacion"]);
			$xml->add_nodo('codigo_partida',$f["codigo_partida"]);
			$xml->add_nodo('nombre_partida',$f["nombre_partida"]);
			$xml->add_nodo('mes_01',$f["mes_01"]);
			$xml->add_nodo('mes_02',$f["mes_02"]);
			$xml->add_nodo('mes_03',$f["mes_03"]);
			$xml->add_nodo('mes_04',$f["mes_04"]);
			$xml->add_nodo('mes_05',$f["mes_05"]);
			$xml->add_nodo('mes_06',$f["mes_06"]);
			$xml->add_nodo('mes_07',$f["mes_07"]);
			$xml->add_nodo('mes_08',$f["mes_08"]);
			$xml->add_nodo('mes_09',$f["mes_09"]);
			$xml->add_nodo('mes_10',$f["mes_10"]);
			$xml->add_nodo('mes_11',$f["mes_11"]);
			$xml->add_nodo('mes_12',$f["mes_12"]);
			$xml->add_nodo('total',$f["total"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('id_partida_presupuesto',$f["id_partida_presupuesto"]);
			$xml->add_nodo('id_partida_modificacion',$f["id_partida_modificacion"]);
			$xml->add_nodo('id_partida',$f["id_partida"]);
			$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
			$xml->add_nodo('estado',$f["estado"]);
			
			$xml->fin_rama();
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