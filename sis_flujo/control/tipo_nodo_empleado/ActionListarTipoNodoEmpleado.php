<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarTipoNodoEmpleado.php
Propósito:				Permite realizar el listado en tfl_tipo_nodo_empleado
Tabla:					tfl_tipo_nodo_empleado
Parámetros:				$id_tipo_nodo_empleado
						$id_tipo_nodo
						$id_empleado
					    $criterio_condicion
						$prioridad
						$seguimiento

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2011-01-05 10:38:40
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloFlujo.php');

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = 'ActionListarTipoNodoEmpleado.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_tipo_nodo_empleado';
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

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}	
	$cond->add_criterio_extra("TINOEM.id_tipo_nodo_empleado",$id_tipo_nodo_empleado);	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	////////verificar por si acaso
	if(isset($m_id_tipo_nodo)) //Criterio de filtro que viene desde la vista maestro en la variable $_m_id_tipo_nodo
		{  $criterio_filtro.=" and TINOEM.id_tipo_nodo = $m_id_tipo_nodo";
		  
		}
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'id_tipo_nodo_empleado');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom ->ContarTipoNodoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarTipoNodoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_tipo_nodo_empleado',$f["id_tipo_nodo_empleado"]);
			$xml->add_nodo('id_tipo_nodo',$f["id_tipo_nodo"]);
			$xml->add_nodo('id_empleado',$f["id_empleado"]);
			$xml->add_nodo('criterio_condicion',$f["criterio_condicion"]);
			$xml->add_nodo('prioridad',$f["prioridad"]);						
			$xml->add_nodo('seguimiento',$f["seguimiento"]);
			
			$xml->add_nodo('id_usuario_reg',$f["id_usuario_reg"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('estado_reg',$f["estado_reg"]);				
			$xml->add_nodo('desc_persona',$f["desc_persona"]);		
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