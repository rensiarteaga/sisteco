<?php
/**
Nombre de archivo:		ActionListarTipoActivoCuenta.php  
Propósito:				Permite desplegar el contenido de la tabla actif.taf_tipo_activo_cuenta
Tabla:					actif.taf_tipo_activo_cuenta
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro
						

Valores de Retorno:    	Listado de actif.taf_tipo_activo_cuenta y total de registros listados
Fecha de Creación:		
Versión:				1.0.0
Autor:					
**********************************************************
*/
session_start();

include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionListarTipoActivoCuenta.php';

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

	if($sort == "") $sortcol = 'tac.id_tipo_activo_cuenta';
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
	
	$res = $Custom->CountTipoActivoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	if($res) $total_registros= $Custom->salida;
	
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarTipoActivoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_tipo_activo_cuenta', $f["id_tipo_activo_cuenta"]);
			$xml->add_nodo('id_tipo_activo', $f["id_tipo_activo"]);
			$xml->add_nodo('codigo_programa', $f["codigo_programa"]);
			$xml->add_nodo('descripcion_programa', $f["descripcion_programa"]);
			$xml->add_nodo('cuenta_activo', $f["cuenta_activo"]);
			$xml->add_nodo('cuenta_dep_acumulada', $f["cuenta_dep_acumulada"]);
			$xml->add_nodo('cuenta_gasto', $f["cuenta_gasto"]);
			$xml->add_nodo('cuenta_activo_auxiliar', $f["cuenta_activo_auxiliar"]);
			$xml->add_nodo('cuenta_dep_acumulada_auxiliar', $f["cuenta_dep_acumulada_auxiliar"]);
			$xml->add_nodo('cuenta_gasto_auxiliar', $f["cuenta_gasto_auxiliar"]);
			$xml->add_nodo('tension', $f["tension"]);
			$xml->add_nodo('descripcion', $f["descripcion"]);
			$xml->add_nodo('nombre_cuenta_activo', $f["nombre_cuenta_activo"]);
			$xml->add_nodo('nombre_cuenta_activo_auxiliar', $f["nombre_cuenta_activo_auxiliar"]);
			$xml->add_nodo('nombre_cuenta_dep_acumulada', $f["nombre_cuenta_dep_acumulada"]);
			$xml->add_nodo('nombre_cuenta_dep_acumulada_auxiliar', $f["nombre_cuenta_dep_acumulada_auxiliar"]);
			$xml->add_nodo('nombre_cuenta_gasto', $f["nombre_cuenta_gasto"]);
			$xml->add_nodo('nombre_cuenta_gasto_auxiliar', $f["nombre_cuenta_gasto_auxiliar"]);
			
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

}?>