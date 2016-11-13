<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarUbicacionFisica.php
Prop�sito:			Permite realizar el listado en taf_ubicacion
Tabla:					taf_ubicacion
Par�metros:			$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:	05/08/2013
Version:				1.0.0
Autor:					unknow
**********************************************************
*/
session_start();
include_once('../LibModeloActivoFijo.php');

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionListarUbicacionFisica .php';

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

	if($sort == '') $sortcol = 'UBI.id_ubicacion';
	else $sortcol = $sort;

	if($dir == '') $sortdir = '';
	else $sortdir = $dir;

	//Verifica si se hara o no la decodificacion(solo pregunta en caso del GET)
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
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarListaUbicacionFisica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	if($res) $total_registros= $Custom->salida; 
	
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarUbicacionFisica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_ubicacion',$f["id_ubicacion"]);
			$xml->add_nodo('id_lugar',$f["id_lugar"]);
			$xml->add_nodo('codigo',$f["codigo"]);
			$xml->add_nodo('ubicacion',$f["ubicacion"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('desc_lugar',$f["desc_lugar"]);
					
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