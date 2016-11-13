<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarAuxiliar.php
Propósito:				Permite desplegar los auxiliar
Tabla:					tct_auxiliar
Parámetros:				$cant
$puntero
$sortcol
$sortdir
$criterio_filtro
$id_usuario_asignacion

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		13/12/2010
Versión:				1.0.0
Autor:					Ana Maria Villegas Quispe
**********************************************************
*/
session_start();
include_once("../LibModeloCobranza.php");

$Custom = new cls_CustomDBcobranza();
$nombre_archivo = 'ActionListarEstadoProceso.php';

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

	if($sort == '') $sortcol = 'id_estado_proceso';
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

	if($sw_estado=='si'	){
		$criterio_filtro=$criterio_filtro." and estpro.id_estado_proceso in   ( select b.id_estado_proceso
																				from cobra.tcb_proceso_facturacion_cobranza a
																				     inner join cobra.tcb_estado_proceso b on a.id_tipo_facturacion_cobranza =
																				     b.id_tipo_facturacion_cobranza
																				where a.id_proceso_facturacion_cobranza = $m_id_proceso_facturacion_cobranza and
																				      b.prioridad <=
																				      (
																				        select b.prioridad + 1
																				        from cobra.tcb_historico_estado a
																				             inner join cobra.tcb_estado_proceso b on a.id_estado_proceso =
																				             b.id_estado_proceso
																				        where a.id_proceso_facturacion_cobranza = $m_id_proceso_facturacion_cobranza and
																				              sw_estado = ''activo''
																				      )
																				ORDER by b.prioridad desc
																				LIMIT 3 OFFSET 0) ";
		$sortcol="estpro.prioridad";
		$sortdir="asc";
	}
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'EstadoProceso');
	$sortcol = $crit_sort->get_criterio_sort();
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarEstadoProceso($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarEstadoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	//echo $Custom->query;
	//exit;
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_estado_proceso',$f["id_estado_proceso"]);
			$xml->add_nodo('id_tipo_facturacion_cobranza',$f["id_tipo_facturacion_cobranza"]);
			$xml->add_nodo('nombre_proceso',$f["nombre_proceso"]);
			$xml->add_nodo('accion_anterior',$f["accion_anterior"]);
			$xml->add_nodo('accion_siguiente',$f["accion_siguiente"]);
			$xml->add_nodo('prioridad',$f["prioridad"]);
			$xml->add_nodo('sw_dblink_anterior',$f["sw_dblink_anterior"]);
			$xml->add_nodo('sw_dblink_siguiente',$f["sw_dblink_siguiente"]);
			$xml->add_nodo('nombre_estado',$f["nombre_estado"]);

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
