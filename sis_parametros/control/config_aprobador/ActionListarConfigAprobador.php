<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarConfigAprobador.php
Propósito:				Permite realizar el listado en tpm_config_aprobador
Tabla:					t_tpm_config_aprobador
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2007-11-06 21:05:11
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloParametros.php');

$Custom = new cls_CustomDBParametros();
$nombre_archivo = 'ActionListarConfigAprobador.php';

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

	if($sort == '') $sortcol =  'UNIORG.nombre_unidad,PRESU.desc_presupuesto'; //'id_config_aprobador';
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
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'ConfigAprobador');
	$sortcol = $crit_sort->get_criterio_sort();
	
	//filtramos por gestion
	if($m_id_gestion)
	{
	    $criterio_filtro=$criterio_filtro." AND GESTI.id_gestion=".$m_id_gestion;	
	}
	else 
	{
	    $criterio_filtro=$criterio_filtro." AND GESTI.gestion=(select max(GESTI.gestion) from param.tpm_gestion GESTI) ";	
	}
	
	//filtro aprobador solicitud
	if(isset($filtro_solic) && $filtro_solic == 'si')
	{
		if(isset($id_empleado) && isset($id_uo) && isset($id_gestion) && isset($concepto))
		{
			$criterio_filtro = $cond -> obtener_criterio_filtro();
			$criterio_filtro = $criterio_filtro." AND CONF.estado = ''activo'' AND CONF.concepto = ''compro'' AND GESTI.id_gestion = $id_gestion AND UNIORG.id_unidad_organizacional = $id_uo AND EMPLEA.id_empleado <> $id_empleado";
		}
	}
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarConfigAprobador($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarConfigAprobador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_config_aprobador',$f["id_config_aprobador"]);
			$xml->add_nodo('id_gestion',$f["id_gestion"]);
			$xml->add_nodo('gestion',$f["gestion"]);
			$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
			$xml->add_nodo('desc_presupuesto',$f["desc_presupuesto"]);
			$xml->add_nodo('id_uo',$f["id_uo"]);
			$xml->add_nodo('nombre_unidad',$f["nombre_unidad"]);
			$xml->add_nodo('concepto',$f["concepto"]);
			$xml->add_nodo('min_monto',$f["min_monto"]);
			$xml->add_nodo('max_monto',$f["max_monto"]);
			$xml->add_nodo('id_empleado',$f["id_empleado"]);
			$xml->add_nodo('nombre_completo',$f["nombre_completo"]);			
			$xml->add_nodo('prioridad',$f["prioridad"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('fecha_expiracion',$f["fecha_expiracion"]);
			$xml->add_nodo('usuario_reg',$f["usuario_reg"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('usuario_mod',$f["usuario_mod"]);
			$xml->add_nodo('fecha_mod',$f["fecha_mod"]);

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