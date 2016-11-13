<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCircuito.php
Propósito:				Permite realizar el listado en tfl_circuito
Tabla:					tfl_circuito
Parámetros:				$id_circuito
						$id_nodo_origen
						$id_nodo_destino
						$id_accion

Valores de Retorno:    	Listado de tipos de circuitos y total de registros listados
Fecha de Creación:		2011-02-28 09:34:47
Versión:				1.0.0
Autor:					Ariel Ayaviri Omonte
**********************************************************
*/
session_start();
include_once('../LibModeloFlujo.php');

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = 'ActionListarTipoCircuito.php';

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

	if($sort == '') $sortcol = 'id_circuito';
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
	
	//aumenta un criterio de busqueda de acuerdo al id del maestro.
	if(isset($m_id_nodo_origen)){
		$criterio_filtro.="and CIRCUIT.id_nodo_origen = $m_id_nodo_origen";}
	if(isset($m_id_nodo_destino)){
		$criterio_filtro.="and CIRCUIT.id_nodo_destino = $m_id_nodo_destino";}
		
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Circuito');
	$sortcol = $crit_sort->get_criterio_sort();
	
	//Obtiene el total de los registros
	$res = $Custom -> ContaCircuito($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	/*
	 * 17-02-2011 (aayaviri) Se adicionó 2 atrib: nombre_inicio y nombre_fin para reconocer los nombre del nodo_inicio y nodo_fin
	 */
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_circuito',$f["id_circuito"]);
			$xml->add_nodo('id_nodo_origen',$f["id_nodo_origen"]);
			$xml->add_nodo('id_nodo_destino',$f["id_nodo_destino"]);
			$xml->add_nodo('id_accion',$f["id_accion"]);
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