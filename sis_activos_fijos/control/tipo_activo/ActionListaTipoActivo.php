<?php
/**
* Nombre de archivo:	    ActionListaTipoActivo.php
* Propósito:				Permite desplegar los regitros de los Tipos de Activos
* Tabla:					taf_tipo_activo
* Parámetros:
* Valores de Retorno:   	Listado de los Tipos de Activos, y el total de registros listados
* Autor:					Rodrigo Chumacero Moscoso
* Fecha de Creación:		08-06-2007
*/

session_start();

include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionListaTipoActivo.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	//Parámetros del filtro
	if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

	if($sort == "") $sortcol = 'tip.descripcion';
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
	$criterio_filtro = $cond->obtener_criterio_filtro();
	
	//Obtiene el total de los registros
	$res = $Custom->ContarListaTipoActivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros= $Custom->salida;
		
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarTipoActivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		//Verifica si el xml será para llenar un combo o no
		if($origen == 'filtro'){
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_tipo_activo', '%');
			$xml->add_nodo('codigo', 'Todos los Tipos de Activos');
			$xml->add_nodo('descripcion', 'Todos los Tipos de Activos');
			$xml->add_nodo('flag_depreciacion', '');
			$xml->add_nodo('fecha_reg', '');
			$xml->add_nodo('estado', '');
			$xml->add_nodo('id_metodo_depreciacion', '');
			$xml->add_nodo('desc_metodo_depreciacion', '');
			$xml->fin_rama();
		}

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_tipo_activo', $f["id_tipo_activo"]);
			$xml->add_nodo('codigo', $f["codigo"]);
			$xml->add_nodo('descripcion', $f["descripcion"]);
			$xml->add_nodo('flag_depreciacion', $f["flag_depreciacion"]);
			$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
			$xml->add_nodo('estado', $f["estado"]);
			$xml->add_nodo('id_metodo_depreciacion', $f["id_metodo_depreciacion"]);
			$xml->add_nodo('desc_metodo_depreciacion', $f["desc_metodo_depreciacion"]);
			$xml->fin_rama();
		}
		/*header('HTTP/1.0 200 OK');
		header('Content-Type:text/xml');
		echo $xml -> cadena_xml();
		exit;*/
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

}?>
