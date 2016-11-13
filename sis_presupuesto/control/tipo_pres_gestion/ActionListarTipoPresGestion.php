<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCategoria.php
Propósito:				Permite realizar el listado en tpr_categoria
Tabla:					tpr_tpr_categoria
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-07-04 08:54:27
Versión:				1.0.0
Autor:					Grover Velasquez Colque
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarTipoPresGestion.php';

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

	if($sort == '') $sortcol = 'TIPREGES.id_tipo_pres_gestion';
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
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'TIPREGES.id_tipo_pres_gestion');
	$sortcol = $crit_sort->get_criterio_sort();
	
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	if($m_incluir_dobles=='no'){		
		//Filtramos solo los registros que no son dobles
		$criterio_filtro=$criterio_filtro." AND TIPREGES.doble=''no'' ";
	}
	
	if($m_incluir_dobles=='in'){
		//Filtramos solo los registros que son dobles
		$criterio_filtro=$criterio_filtro." AND TIPREGES.doble=''si'' ";
	}
	$criterio_filtro=$criterio_filtro." and TIPREGES.id_parametro= ".$m_id_parametro;
	//Filtramos solo los tipos de presupuesto en estado activo	
	$criterio_filtro=$criterio_filtro." AND TIPREGES.estado=''activo'' ";
	
	
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarTipoPresGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarTipoPresGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_tipo_pre_gestion',$f["id_tipo_pres_gestion"]);
			$xml->add_nodo('id_tipo_pres',$f["id_tipo_pres"]);
			$xml->add_nodo('desc_tipo_pres',$f["desc_tipo_pres"]);
			$xml->add_nodo('id_parametro',$f["id_parametro"]);
			$xml->add_nodo('desc_parametro',$f["desc_parametro"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('doble',$f["doble"]);

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