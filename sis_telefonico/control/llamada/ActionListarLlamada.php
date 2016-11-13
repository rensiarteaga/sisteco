<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarGerencia.php
Propósito:				Permite realizar el listado en tst_gerencia
Tabla:					t_tst_gerencia
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-01-17 15:14:26
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloSistemaTelefonico.php');

$Custom = new cls_CustomDBSistemaTelefonico();
$nombre_archivo = 'ActionListarLlamada.php';

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

	if($sort == '') $sortcol = 'id_llamada';
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
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Llamada');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarLlamada($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_llamada',$f["id_llamada"]);
			$xml->add_nodo('fecha_llamada',$f["fecha_llamada"]);
			$xml->add_nodo('hora_llamada',$f["hora_llamada"]);
			$xml->add_nodo('numero_interno',$f["numero_interno"]);
			$xml->add_nodo('numero_marcado',$f["numero_marcado"]);
			$xml->add_nodo('duracion_llamada',$f["duracion_llamada"]);
			$xml->add_nodo('saliente',$f["saliente"]);
            $xml->add_nodo('transferido',$f["transferido"]);
			$xml->add_nodo('origen_transferencia',$f["origen_transferencia"]); 		
            $xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('fk_id_llamada',$f["fk_id_llamada"]);
			$xml->add_nodo('desc_origen',$f["desc_origen"]);
			$xml->add_nodo('id_linea',$f["id_linea"]);
			$xml->add_nodo('puerto_linea',$f["puerto_linea"]);
			$xml->add_nodo('id_tipo_llamada',$f["id_tipo_llamada"]);
			$xml->add_nodo('desc_tipo_llamada',$f["desc_tipo_llamada"]);
			$xml->add_nodo('id_empleado',$f["id_empleado"]);
			$xml->add_nodo('id_persona',$f["id_persona"]);
			$xml->add_nodo('desc_empleado',$f["desc_empleado"]);
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