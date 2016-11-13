<?php
/*
**********************************************************
Nombre de archivo:	    ActionListaMetodoDepreciacion.php
Propósito:				Permite desplegar los Metodos de Depreciacion registrados
Tabla:					taf_metodo_depreciacion
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro
						$id_usuario_asignacion

Valores de Retorno:    	Listado de Metodos de Depreciacion
Fecha de Creación:		06- 06 - 07
Versión:				1.0.0
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");
$CustomActivos = new cls_CustomDBActivoFijo();
$nombre_archivo='ActionListaMetodoDepreciacion.php';

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

	if($sort == "") $sortcol = 'id_metodo_depreciacion';
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
	
	//Verifica si tiene un id_met por defecto
	if($hidden_id_metodo_depreciacion != '' || $hidden_id_metodo_depreciacion!= 'undefined')
	{
		$cond->add_condicion_filtro('id_metodo_depreciacion', $hidden_id_metodo_depreciacion, 'true');
	}
	//Se aumenta el criterio del id_met para filtrar los datos de un metodo_dep específico
	
	$criterio_filtro = $cond->obtener_criterio_filtro();
	
	$res = $CustomActivos->ContarListaMetodoDepreciacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res)
	{
		$total_registros= $CustomActivos->salida;
	}
	
	//Obtiene el conjunto de datos de la consulta
	$res = $CustomActivos->ListarMetodoDepreciacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

	
	if($res)
	{	// PREPARA EL ARCHIVO XML
		$xml= new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		foreach ($CustomActivos->salida as $f)
		{ 
		    $xml->add_rama('ROWS');
		    $xml->add_nodo('id_metodo_depreciacion',$f["id_metodo_depreciacion"]);
		    $xml->add_nodo('descripcion',$f["descripcion"]);
		    $xml->fin_rama();
		}
		$xml->mostrar_xml();
		/*header('HTTP/1.0 200 OK');
		header('Content-Type:text/xml');
		echo $xml -> cadena_xml();
		exit;*/
		
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = $CustomActivos->salida[1];
		$resp->origen = $CustomActivos->salida[2];
		$resp->proc = $CustomActivos->salida[3];
		$resp->nivel = $CustomActivos->salida[4];
		$resp->query = $CustomActivos->query;
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