<?php
/*
**********************************************************
Nombre de archivo:	  	ActionListarActivoFijoDistGrupoProceso.php
Propósito:				dado el id del grupo proceso como parametro, permite
						listar los af que tienen programa distribucion
Tabla:					actif.taf_tipo_activo_cuenta
Parámetros:				$id_grupo_proceso_1	--> id del grupoProceso
						$catidad_ids -> # ids
$descripcion			lista los af  con programa distriibucion para que 
						posterior  a esto se  hagan modificaciones en cuanto a las cuentas y
						sus auxiliares

Valores de Retorno:	   Número de registros
Fecha de Creación:	   01/02/2013	  	  	
Versión: 				1.1.1
Autor:					Elmer Velasquez
**********************************************************
*/
session_start();

include_once("../../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionListarActivoFijoDistGrupoProceso.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	//Parámetros del filtro
	if($limit == "") $cant = 30;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

	if($sort == "") $sortcol = 'taf.id_activo_fijo';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'asc';
	else $sortdir = $dir;
	
	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> "si", "no"
	switch ($cod)
	{
		case "si":
			$decodificar = true;
			break;
		case "no":
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}
	
	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=="") $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$cond->add_criterio_extra("afgp.id_grupo_proceso",$id_grupo_proceso);
	$criterio_filtro = $cond->obtener_criterio_filtro();
	
	//Obtiene el total de los registros
	$res = $Custom->CountActivoFijoDistribucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	if($res) $total_registros= $Custom->salida;
	
	//condicion tension
	if($tension=='si')
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		$xml->mostrar_xml();
	}
		
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarActivoFijoDistribucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_activo_fijo', $f["id_activo_fijo"]);
			$xml->add_nodo('descripcion_activo_fijo', $f["descripcion_activo_fijo"]);
			$xml->add_nodo('id_tipo_activo2', $f["id_tipo_activo"]);
			$xml->add_nodo('tipo_activo', $f["tipo_activo"]);		
			$xml->add_nodo('id_sub_tipo_activo', $f["id_sub_tipo_activo"]);
			$xml->add_nodo('subtipo_activo', $f["subtipo_activo"]);
			$xml->add_nodo('programa', $f["programa"]);
			$xml->add_nodo('codigo_programa', $f["codigo_programa"]);
			$xml->add_nodo('tension', $f["tension"]);
			
			$xml->fin_rama();
		}
		$xml->mostrar_xml();
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true, "406");
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

}
?>