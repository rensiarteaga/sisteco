<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDescargoDetalle.php
Propósito:				Permite realizar el listado en tts_avance
Tabla:					tts_tts_avance
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-10-17 10:39:24
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloTesoreria.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionListarDescargoDetalle.php';

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

	if($sort == '') $sortcol = 'id_avance';
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
	$cond->add_criterio_extra("AVANPA.id_avance",$m_id_avance);
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'DescargoDetalle');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarDescargoDetalle($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarDescargoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_avance',$f["id_avance"]);
			$xml->add_nodo('tipo_avance',$f["tipo_avance"]);
			$xml->add_nodo('fecha_avance',$f["fecha_avance"]);
			$xml->add_nodo('importe_avance',$f["importe_avance"]);
			$xml->add_nodo('estado_avance',$f["estado_avance"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('nombre_moneda',$f["nombre_moneda"]);
			$xml->add_nodo('id_documento',$f["id_documento"]);
			$xml->add_nodo('tipo_documento',$f["tipo_documento"]);
			$xml->add_nodo('nro_documento',$f["nro_documento"]);
			$xml->add_nodo('fecha_documento',$f["fecha_documento"]);
			$xml->add_nodo('razon_social',$f["razon_social"]);
			$xml->add_nodo('nro_nit',$f["nro_nit"]);
			$xml->add_nodo('nro_autorizacion',$f["nro_autorizacion"]);
			$xml->add_nodo('codigo_control',$f["codigo_control"]);
			$xml->add_nodo('fk_avance',$f["fk_avance"]);
			$xml->add_nodo('importe_detalle',$f["importe_detalle"]);
			$xml->add_nodo('sw_valida',$f["sw_valida"]);
			$xml->add_nodo('id_usuario_aprueba',$f["id_usuario_aprueba"]);
			$xml->add_nodo('aprobador',$f["aprobador"]);
			$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
			$xml->add_nodo('id_unidad_organizacional',$f["id_unidad_organizacional"]);
			$xml->add_nodo('id_usr_reg',$f["id_usr_reg"]);
			$xml->add_nodo('id_empleado_reg',$f["id_empleado_reg"]);
			$xml->add_nodo('id_depto',$f["id_depto"]);
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