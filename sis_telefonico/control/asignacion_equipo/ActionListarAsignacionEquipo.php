<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarAsignacionEquipo.php
Propósito:				Permite realizar el listado en tst_AsignacionEquipo
Tabla:					t_tst_AsignacionEquipo
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-01-18 19:44:11
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloSistemaTelefonico.php');

$Custom = new cls_CustomDBSistemaTelefonico();
$nombre_archivo = 'ActionListarAsignacionEquipo.php';

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

	if($sort == '') $sortcol = 'id_asignacion_equipo';
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
	
	
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'AsignacionEquipo');
	$sortcol = $crit_sort->get_criterio_sort();
	if(isset($_POST["id_empleado"]) && $_POST["id_empleado"]>0){
		$criterio_filtro=$criterio_filtro. " AND ASIGEQ.id_empleado=".$_POST["id_empleado"]; 
	}

	//Obtiene el total de los registros
	$res = $Custom -> ContarAsignacionEquipo($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarAsignacionEquipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{  
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_asignacion_equipo',$f["id_asignacion_equipo"]);
			$xml->add_nodo('id_equipo',$f["id_equipo"]);
			$xml->add_nodo('id_plan_llamada',$f["id_plan_llamada"]);
			$xml->add_nodo('id_empleado',$f["id_empleado"]);
			$xml->add_nodo('id_correspondencia',$f["id_correspondencia"]);
			$xml->add_nodo('estado_reg',$f["estado_reg"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('fecha_ini',$f["fecha_ini"]);
			$xml->add_nodo('fecha_fin',$f["fecha_fin"]);
			$xml->add_nodo('usuario_reg',$f["usuario_reg"]);
			$xml->add_nodo('nro_asignacion',$f["nro_asignacion"]);
			$xml->add_nodo('desc_plan_llamada',$f["desc_plan_llamada"]);
			$xml->add_nodo('nombre_completo',$f["nombre_completo"]);
			$xml->add_nodo('desc_correspondencia',$f["desc_correspondencia"]);
			$xml->add_nodo('desc_equipo',$f["desc_equipo"]);
			
			$xml->add_nodo('id_componente',$f["id_componente"]);
			$xml->add_nodo('desc_componente',$f["desc_componente"]);
			$xml->add_nodo('id_linea',$f["id_linea"]);
			$xml->add_nodo('desc_linea',$f["desc_linea"]);
			$xml->add_nodo('tipo_asignacion',$f["tipo_asignacion"]);
			$xml->add_nodo('id_usuario_resp',$f["id_usuario_resp"]);
			$xml->add_nodo('desc_usuario_resp',$f["desc_usuario_resp"]);
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