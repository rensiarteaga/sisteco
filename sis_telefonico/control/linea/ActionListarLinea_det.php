<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarLinea.php
Propósito:				Permite realizar el listado en tst_linea
Tabla:					t_tst_linea
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
$nombre_archivo = 'ActionListarLinea .php';

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

	if($sort == '') $sortcol = 'id_linea';
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
	
	if(isset($m_id_tipo_llamada) && $m_id_tipo_llamada>0){
	
	$cond->add_criterio_extra("TIPLLA.id_tipo_llamada",$m_id_tipo_llamada);
	}
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Linea');
	$sortcol = $crit_sort->get_criterio_sort();
	if((isset($_POST["sin_asignar"])||isset($_GET["sin_asignar"])) && ($_POST["sin_asignar"]=='si' || $_GET["sin_asignar"]=='si')){
		$criterio_filtro=$criterio_filtro. " and LINEA.id_linea not in (select id_linea from gestel.tst_asignacion_equipo where estado_reg=''activo'') and LINEA.estado_reg=''activo'' ";
	}

	//Obtiene el total de los registros
	$res = $Custom -> ContarLinea($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarLinea($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_linea',$f["id_linea"]);
			$xml->add_nodo('empresa',$f["empresa"]);
			$xml->add_nodo('puerto_linea',$f["puerto_linea"]);
			$xml->add_nodo('numero_telefono',$f["numero_telefono"]);
			$xml->add_nodo('costo_segundo',$f["costo_segundo"]);
			$xml->add_nodo('tiempo_espera',$f["tiempo_espera"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('id_tipo_llamada',$f["id_tipo_llamada"]);
			$xml->add_nodo('desc_tipo_llamada',$f["desc_tipo_llamada"]);
			//mayo2016
			$xml->add_nodo('estado_reg',$f["estado_reg"]);
			$xml->add_nodo('fecha_ini',$f["fecha_ini"]);
			$xml->add_nodo('fecha_fin',$f["fecha_fin"]);
			
			$xml->add_nodo('sim_card',$f["sim_card"]);
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