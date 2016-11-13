<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarSolicitudLicenciaDet.php
Prop�sito:				Permite realizar el listado en tkp_vacacion
Tabla:					tkp_tkp_vacacion
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		2010-08-17 09:25:59
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloKardexPersonal.php');

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionListarSolicitudLicenciaDet.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Par�metros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'HORARI.fecha_inicio';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
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

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"],$_POST["filterValue_$i"],$_POST["filterAvanzado_$i"]);
	}
	$cond->add_criterio_extra("HORARI.id_vacacion",$m_id_vacacion);
	$cond->add_criterio_extra("HORARI.id_tipo_horario",$m_id_tipo_horario);
	$cond->add_criterio_extra("HORARI.id_empleado_aprobacion",$m_id_empleado_aprobacion);
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	if($tipo=='preaprobar'){
		
		$criterio_filtro=$criterio_filtro." AND HORARI.estado_reg=''pendiente_preaprobacion''";
	}
	if($tipo=='aprobar'){
		
		$criterio_filtro=$criterio_filtro." AND HORARI.estado_reg=''pendiente_aprobacion''";
	}
	if($tipo=='procesar'){
		$criterio_filtro=$criterio_filtro." AND HORARI.num_solicitud=''$m_num_solicitud'' AND (HORARI.estado_reg=''aprobado'' OR HORARI.estado_reg=''reformulado'' OR HORARI.estado_reg=''en_proceso'')";
	}
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'AprobarSolicitudLicenciaDet');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarAprobarSolicitudLicenciaDet($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) 
	{
		$total_registros= $Custom->salida;				
	}
	$_SESSION['PDF_total_reg'] = $total_registros;
		
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarAprobarSolicitudLicenciaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_horario',$f["id_horario"]);
			$xml->add_nodo('id_empleado',$f["id_empleado"]);
			$xml->add_nodo('id_tipo_horario',$f["id_tipo_horario"]);
			$xml->add_nodo('id_vacacion',$f["id_vacacion"]);
			$xml->add_nodo('id_empleado_aprobacion',$f["id_empleado_aprobacion"]);
			$xml->add_nodo('fecha_inicio',$f["fecha_inicio"]);
			$xml->add_nodo('fecha_fin',$f["fecha_fin"]);
			$xml->add_nodo('tipo_periodo',$f["tipo_periodo"]);
			$xml->add_nodo('horas_por_dia',$f["horas_por_dia"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('estado_reg',$f["estado_reg"]);
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