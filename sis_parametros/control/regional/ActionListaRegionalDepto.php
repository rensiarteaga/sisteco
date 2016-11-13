<?php
/**
* Nombre de archivo:	    ActionListaFinanciador.php
* Propósito:				Permite desplegar los regitros de los financiadores
* Tabla:					tpm_financiador
* Parámetros:
* Valores de Retorno:   	Listado de los Financiadores, y el total de registros listados
* Autor:					Rodrigo Chumacero Moscoso
* Fecha de Creación:		04-06-2007
*/

session_start();
include_once("../LibModeloParametros.php");
$Custom = new cls_CustomDBParametros();
$nombre_archivo = 'ActionListaRegionalDepto.php';

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

	if($sort == "") $sortcol = 'REGION.nombre_regional';
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
	$res = $Custom->ContarRegionalDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarRegionalDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		if($origen == 'filtro'){
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_regional','%');
			$xml->add_nodo('codigo_regional','Todas las Regionales');
			$xml->add_nodo('nombre_regional', 'Todas las Regionales');
			$xml->add_nodo('descripcion_regional','Todas las Regionales');
			$xml->fin_rama();
		}

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_regional', $f["id_regional"]);
			$xml->add_nodo('codigo_regional', $f["codigo_regional"]);
			$xml->add_nodo('nombre_regional', $f["nombre_regional"]);
			$xml->add_nodo('descripcion_regional', $f["descripcion_regional"]);
			$xml->fin_rama();
		}
		$xml-> mostrar_xml();
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = $Custom->salida[1];
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = '3';
		$resp->get_mensaje();
		exit;
	}
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'Usuario no Autentificado';
	$resp->origen = $nombre_archivo;
	$resp->proc = $nombre_archivo;
	$resp->nivel = '3';
	$resp->get_mensaje();
	exit;

}?>
