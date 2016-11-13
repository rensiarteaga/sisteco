<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarModificacion.php
Propósito:				Permite realizar el listado en tpr_modificacion
Tabla:					tpr_tpr_modificacion
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2010-05-10 18:01:22
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarModificacion .php';

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

	if($sort == '') $sortcol = 'id_modificacion';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'desc';
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
	
	if($m_id_gestion)
	{
	    $criterio_filtro=$criterio_filtro." AND PARAMP.id_gestion=".$m_id_gestion;	
	}
	else 
	{
	    $criterio_filtro=$criterio_filtro." AND PARAMP.gestion_pres=(select max(PARAMP.gestion_pres) from presto.tpr_parametro PARAMP) ";	
	}
	
	if($_GET['reformulacion'] == 'si')
	{	
		$criterio_filtro=$criterio_filtro." and MODIFI.estado_modificacion IN (''Borrador'', ''Autorizacion'', ''Rechazado'', ''Aprobado'', 
																			   ''Borrador_origen'', ''Autorizacion_origen'', ''Rechazado_origen'', ''Aprobado_origen'',
																			   ''Borrador_destino'', ''Autorizacion_destino'', ''Rechazado_destino'', ''Aprobado_destino'') ";
	}
	
	if($_GET['aprobacion'] == 'si')
	{	
		$criterio_filtro=$criterio_filtro." and MODIFI.estado_modificacion IN (''Autorizacion'',''Autorizacion_origen'',''Autorizacion_destino'') ";
	}
	
	if($_GET['conclusion'] == 'si')
	{	
		$criterio_filtro=$criterio_filtro." and MODIFI.estado_modificacion = ''Concluido''";
	}
	
	$tipo_modificacion = $_GET['tipo_modificacion'];
	
	$criterio_filtro=$criterio_filtro." and modifi.tipo_modificacion = ''$tipo_modificacion''";
	
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Modificacion');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarModificacion($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarModificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_modificacion',$f["id_modificacion"]);
			$xml->add_nodo('id_parametro',$f["id_parametro"]);
			$xml->add_nodo('desc_parametro',$f["desc_parametro"]);
			$xml->add_nodo('tipo_modificacion',$f["tipo_modificacion"]);
			$xml->add_nodo('justificacion',$f["justificacion"]);
			$xml->add_nodo('tipo_presupuesto',$f["tipo_presupuesto"]);
			$xml->add_nodo('desc_tipo_pres',$f["desc_tipo_pres"]);
			$xml->add_nodo('nro_modificacion',$f["nro_modificacion"]);
			$xml->add_nodo('estado_modificacion',$f["estado_modificacion"]);
			$xml->add_nodo('fecha_regis',$f["fecha_regis"]);
			$xml->add_nodo('fecha_conclusion',$f["fecha_conclusion"]);
			$xml->add_nodo('id_usuario_reg',$f["id_usuario_reg"]);
			$xml->add_nodo('desc_usuario_reg',$f["desc_usuario_reg"]);
			$xml->add_nodo('total_disminucion',$f["total_disminucion"]);
			$xml->add_nodo('total_incremento',$f["total_incremento"]);
			$xml->add_nodo('id_gestion',$f["id_gestion"]);
			$xml->add_nodo('id_periodo',$f["id_periodo"]);
			$xml->add_nodo('periodo',$f["periodo"]);
            $xml->add_nodo('docmod_tipo',$f["docmod_tipo"]);
            $xml->add_nodo('docmod_nro',$f["docmod_nro"]);
            $xml->add_nodo('docmod_fecha',$f["docmod_fecha"]);
            $xml->add_nodo('docdis_tipo',$f["docdis_tipo"]);
            $xml->add_nodo('docdis_nro',$f["docdis_nro"]);
            $xml->add_nodo('docdis_fecha',$f["docdis_fecha"]);
            
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