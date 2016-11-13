<?php
/**
Nombre de archivo:	    ActionListarContraCuenta.php  
Prop�sito:			Permite desplegar el contenido de la tabla actif.taf_contra_cuenta
Tabla:					actif.taf_contra_cuenta
Par�metros:			$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro
						

Valores de Retorno:    	Listado de actif.taf_contra_cuenta y total de registros listados
Fecha de Creacion:		
Version:				1.0.0
Autor:					unknow
**********************************************************
*/
session_start();

include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionListarContraCuenta.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	//Par�metros del filtro
	if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

	if($sort == "") $sortcol = 'concta.id_tipo_proceso';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'DESC';
	else $sortdir = $dir;
	
	//Verifica si se hara o no la decodificacionn(solo pregunta en caso del GET)
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
	//echo $criterio_filtro;exit;
	$res = $Custom->CountContraCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	if($res) $total_registros= $Custom->salida;
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarContraCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_contra_cuenta', $f["id_contra_cuenta"]);
			$xml->add_nodo('id_regional', $f["id_regional"]);
			$xml->add_nodo('desc_regional', $f["desc_regional"]);
			$xml->add_nodo('id_gestion', $f["id_gestion"]);
			$xml->add_nodo('gestion', $f["gestion"]);
			$xml->add_nodo('id_cuenta_titular', $f["id_cuenta_titular"]);
			$xml->add_nodo('desc_cuenta', $f["desc_cuenta"]);
			$xml->add_nodo('id_cuenta_auxiliar', $f["id_cuenta_auxiliar"]);
			$xml->add_nodo('desc_cuenta_aux', $f["desc_cuenta_aux"]);
			$xml->add_nodo('id_tipo_proceso', $f["id_tipo_proceso"]);
			$xml->add_nodo('desc_proceso', $f["desc_proceso"]);
			$xml->add_nodo('tipo_importe', $f["tipo_importe"]);
			$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
			$xml->add_nodo('id_usuario_reg', $f["id_usuario_reg"]);
			
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