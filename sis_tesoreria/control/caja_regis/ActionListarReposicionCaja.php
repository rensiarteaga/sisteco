<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarReposicionCaja.php
Propósito:				Permite realizar el listado en tts_caja_regis
Tabla:					tts_tts_caja_regis
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-10-21 15:53:15
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloTesoreria.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionListarReposicionCaja .php';

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

	if($sort == '') $sortcol = 'id_caja_regis';
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
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'CajaRegis');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarReposicionCaja($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarReposicionCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_caja_regis',$f["id_caja_regis"]);
			$xml->add_nodo('id_caja',$f["id_caja"]);
			$xml->add_nodo('desc_caja',$f["desc_caja"]);
			$xml->add_nodo('moneda',$f["moneda"]);
			$xml->add_nodo('tipo_caja',$f["tipo_caja"]);
			$xml->add_nodo('id_cajero',$f["id_cajero"]);
			$xml->add_nodo('desc_cajero',$f["desc_cajero"]);
			$xml->add_nodo('nombre_moneda',$f["nombre_moneda"]);
			$xml->add_nodo('tipo_caja_caja',$f["tipo_caja_caja"]);
			$xml->add_nodo('apellido_paterno_persona',$f["apellido_paterno_persona"]);
			$xml->add_nodo('apellido_materno_persona',$f["apellido_materno_persona"]);
			$xml->add_nodo('nombre_persona',$f["nombre_persona"]);
			$xml->add_nodo('codigo_empleado_empleado',$f["codigo_empleado_empleado"]);
			$xml->add_nodo('estado_cajero_cajero',$f["estado_cajero_cajero"]);
			$xml->add_nodo('fecha_regis',$f["fecha_regis"]);
			$xml->add_nodo('importe_regis',$f["importe_regis"]);
			$xml->add_nodo('nombre_unidad',$f["nombre_unidad"]);
			$xml->add_nodo('nombre_depto',$f["nombre_depto"]);
			$xml->add_nodo('tipo_regis',$f["tipo_regis"]);
			$xml->add_nodo('estado_regis',$f["estado_regis"]);
			$xml->add_nodo('id_depto',$f["id_depto"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('id_cheque',$f["id_cheque"]);
			$xml->add_nodo('nro_documento',$f["nro_documento"]);
			$xml->add_nodo('fecha_ini',$f["fecha_ini"]);
			$xml->add_nodo('fecha_fin',$f["fecha_fin"]);
			$xml->add_nodo('codigo_repo',$f["codigo_repo"]);
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