<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarPeriodo.php
Prop�sito:				Permite realizar el listado en tct_periodo
Tabla:					t_tct_periodo
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		2008-12-01 14:49:33
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarPeriodo .php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Par�metros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'periodo';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'desc';
	else $sortdir = $dir;

	//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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
	
	$cond->add_criterio_extra("GESTIO.id_gestion",$id_gestion);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Periodo');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarPeriodo($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_periodo',$f["id_periodo"]);
			$xml->add_nodo('id_gestion',$f["id_gestion"]);
			$xml->add_nodo('desc_gestion',$f["desc_gestion"]);
			$xml->add_nodo('periodo',$f["periodo"]);
			$xml->add_nodo('fecha_inicio',$f["fecha_inicio"]);
			$xml->add_nodo('fecha_final',$f["fecha_final"]);
			$xml->add_nodo('estado_peri_gral',$f["estado_peri_gral"]);
			$xml->add_nodo('desc_periodo',$f["desc_periodo"]);
			
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