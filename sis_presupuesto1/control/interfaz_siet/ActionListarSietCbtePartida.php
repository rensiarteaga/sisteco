<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarSietCbtePartida.php
Propósito:				Permite realizar el listado en tsi_siet_cbte
Tabla:					tsi_siet_cbte_partida
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		01/11/2015
Versión:				1.0.0
Autor:					A.V.Q
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarSietCbtePartida.php';

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

	if($sort == '') $sortcol = 'id_siet_cbte_partida';
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
	
	if ($get)
	{
		$id_siet_cbte= $_GET["m_id_siet_cbte"];
		$id_siet_declara= $_GET["m_id_siet_declara"];
	}
	else
	{   $id_siet_cbte= $_POST["m_id_siet_cbte"];
		$id_siet_declara= $_POST["m_id_siet_declara"];
			
	}
	/*echo $id_siet_declara;
	exit;*/
	$criterio_filtro=$criterio_filtro." AND SIEPAR.id_siet_cbte =$id_siet_cbte ";
	
	
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'SietCbtePartida');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarSietCbtePartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarSietCbtePartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			
			
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_siet_cbte_partida',$f["id_siet_cbte_partida"]);
			$xml->add_nodo('id_siet_cbte',$f["id_siet_cbte"]);
			$xml->add_nodo('id_partida',$f["id_partida"]);
			$xml->add_nodo('codigo_partida',$f["codigo_partida"]);
			$xml->add_nodo('desc_partida',$f["codigo_partida"].'-'.$f["nombre_partida"]);
			$xml->add_nodo('importe',$f["importe"]);
			$xml->add_nodo('id_oec',$f["id_oec"]);
			$xml->add_nodo('codigo_oec',$f["codigo_oec"]);
			$xml->add_nodo('desc_oec',$f["codigo_oec"].'-'.$f["nombre_oec"]);
			$xml->add_nodo('id_siet_ent_ua_transf',$f["id_siet_ent_ua_transf"]);
			$xml->add_nodo('codigo',$f["desc_entidad"].'-'.$f["desc_ua"]);
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