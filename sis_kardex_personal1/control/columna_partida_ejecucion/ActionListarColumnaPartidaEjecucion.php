<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarColumnaPartidaEjecucion.php
Propósito:				Permite realizar el listado en tkp_columna_partida_ejecucion
Tabla:					t_tkp_columna
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		21-10-2010
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloKardexPersonal.php');

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionListarColumnaPartidaEjecucionObli.php';

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

	if($sort == '') $sortcol = 'id_columna_partida_ejecucion';
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
	
    $cond->add_criterio_extra("cpe.id_obligacion",$id_obligacion);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'id_columna_partida_ejecucion');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarColumnaPartidaEjecucionObli($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarColumnaPartidaEjecucionObli($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			
		      $xml->add_nodo('id_columna_partida_ejecucion',$f["id_columna_partida_ejecucion"]);
		      $xml->add_nodo('id_planilla_presupuesto',$f["id_planilla_presupuesto"]);
		      $xml->add_nodo('id_columna',$f["id_columna"]);
		      $xml->add_nodo('id_partida_ejecucion',$f["id_partida_ejecucion"]);
		      $xml->add_nodo('id_columna_partida_ejecucion_padre',$f["id_columna_partida_ejecucion_padre"]);
		      $xml->add_nodo('id_usuario_reg',$f["id_usuario_reg"]);
		      $xml->add_nodo('id_obligacion',$f["id_obligacion"]);
		      $xml->add_nodo('monto',$f["monto"]);
		      $xml->add_nodo('momento',$f["momento"]);
		      $xml->add_nodo('fecha_reg',$f["fecha_reg"]);
		      $xml->add_nodo('estado_reg',$f["estado_reg"]);
		      $xml->add_nodo('desc_columna',$f["desc_columna"]);
		      $xml->add_nodo('desc_tcolumna',$f["desc_tcolumna"]);
		      $xml->add_nodo('id_partida',$f["id_partida"]);
		      $xml->add_nodo('codigo_partida',$f["codigo_partida"]);
		      $xml->add_nodo('desc_partida',$f["desc_partida"]);
			
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