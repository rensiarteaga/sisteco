<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDepreciacion2Det.php
Propósito:				Permite realizar el listado en taf_depreciacion
Tabla:					t_taf_depreciacion
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2010-07-20 14:54:41
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloActivoFijo.php');

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionListarDepreciacion2Det .php';

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

	if($sort == '') $sortcol = 'id_activo_fijo,fecha_desde';
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
	
	$cond->add_criterio_extra("GRUDE.id_grupo_depreciacion",$id_grupo_depreciacion);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Depreciacion');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarDepreciacion2Det($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarDepreciacion2Det($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_depreciacion',$f["id_depreciacion"]);
			$xml->add_nodo('fecha_desde',$f["fecha_desde"]);
			$xml->add_nodo('fecha_hasta',$f["fecha_hasta"]);
			$xml->add_nodo('monto_vigente_ant',$f["monto_vigente_ant"]);
			$xml->add_nodo('monto_vigente',$f["monto_vigente"]);
			$xml->add_nodo('vida_util',$f["vida_util"]);
			$xml->add_nodo('tipo_cambio_ini',$f["tipo_cambio_ini"]);
			$xml->add_nodo('tipo_cambio_fin',$f["tipo_cambio_fin"]);
			$xml->add_nodo('depreciacion_acum_ant',$f["depreciacion_acum_ant"]);
			$xml->add_nodo('depreciacion',$f["depreciacion"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('depreciacion_acum',$f["depreciacion_acum"]);
			$xml->add_nodo('id_activo_fijo',$f["id_activo_fijo"]);
			$xml->add_nodo('desc_activo_fijo',$f["desc_activo_fijo"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			$xml->add_nodo('monto_vigente_ant_2',$f["monto_vigente_ant_2"]);
			$xml->add_nodo('monto_vigente_2',$f["monto_vigente_2"]);
			$xml->add_nodo('vida_util_2',$f["vida_util_2"]);
			$xml->add_nodo('depreciacion_acum_ant_2',$f["depreciacion_acum_ant_2"]);
			$xml->add_nodo('depreciacion_2',$f["depreciacion_2"]);
			$xml->add_nodo('depreciacion_acum_2',$f["depreciacion_acum_2"]);
			$xml->add_nodo('monto_actualiz_ant',$f["monto_actualiz_ant"]);
			$xml->add_nodo('monto_actualiz',$f["monto_actualiz"]);
			$xml->add_nodo('dep_acum_actualiz',$f["dep_acum_actualiz"]);
			$xml->add_nodo('monto_actualiz_2',$f["monto_actualiz_2"]);
			$xml->add_nodo('dep_acum_actualiz_2',$f["dep_acum_actualiz_2"]);
			$xml->add_nodo('id_grupo_depreciacion',$f["id_grupo_depreciacion"]);
			$xml->add_nodo('desc_grupo_depreciacion',$f["desc_grupo_depreciacion"]);

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