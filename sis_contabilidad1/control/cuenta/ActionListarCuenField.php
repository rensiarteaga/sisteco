<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCuenta.php
Prop�sito:				Permite desplegar las cuentas
Tabla:					tct_cuenta
Par�metros:				$cant
$puntero
$sortcol
$sortdir
$criterio_filtro
$id_usuario_asignacion

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		02-10-2007
Versi�n:				1.0.0
Autor:					Jos� A. Mita Huanza
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarCuenField.php';

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

	if($sort == '') $sortcol = 'CUENTA.nro_cuenta';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
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
		if($_POST["filterCol_$i"]!=='rango'){
			$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
		}
	}
	$criterio_filtro = $cond -> obtener_criterio_filtro();

	//RCM: Verifica si es por rango o no. Recorre todos los filtros
	$sw='no_rango'; 
	for($i=0;$i<$CantFiltros;$i++){
		if($_POST["filterCol_$i"]=='rango'){
			$sw='rango';
			$valor_rango=$_POST["filterValue_$i"];
		}
	}
	
	/*echo "rango:".$sw;
	exit;*/
	
	if ($_POST["filterCol_0"]!='id_cuenta'){
		$criterio_filtro=$criterio_filtro." AND CUENTA.sw_transaccional=1";
	}

	if($sw=='rango'){
		if($valor_rango!=='si'){
			$criterio_filtro=$criterio_filtro." AND CUENTA.nro_cuenta >= ''$valor_rango''";
		}
	}
	
	if($m_id_gestion){
	  	$criterio_filtro=$criterio_filtro." AND GESTION.id_gestion=".$m_id_gestion;
		$sortcol = 'CUENTA.nro_cuenta';	
	}
	if($m_id_partida){
	  	$criterio_filtro=$criterio_filtro." AND PARCUE.id_partida=".$m_id_partida;	
	}
	
//echo "no muestra nada?".$m_id_gestion;
//exit;

/*echo 'sw_transaccional: '.$sw_transaccional;
exit;*/

/*if ($m_sw_cuenta_ejercicio=='si'&& $m_id_gestion){
	$criterio_filtro=$criterio_filtro." AND CUENTA.id_parametro in (select id_parametro from sci.tct_parametro where id_gestion=".$m_id_gestion.")";

}
if ($m_sw_rubro_cuenta=='si'&& $m_id_gestion){
	$criterio_filtro=$criterio_filtro." AND CUENTA.id_parametro in (select id_parametro from sci.tct_parametro where id_gestion=".$m_id_gestion.")";

}
 
 

if ($m_sw_partida_cuenta=='si'&& $m_id_gestion){
	$criterio_filtro=$criterio_filtro." AND CUENTA.id_parametro in 
	(select id_parametro from sci.tct_parametro where id_gestion=".$m_id_gestion.")";
}*/
/*echo "Gestion ".$m_id_gestion;
 exit;*/


//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'CuenField');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarCuenField($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCuenField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	/*echo $Custom->query;
	exit;*/
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_cuenta',$f["id_cuenta"]);
			$xml->add_nodo('desc_cuenta',$f["desc_cuenta"]);
			$xml->add_nodo('nro_cuenta',$f["nro_cuenta"]);
			$xml->add_nodo('nombre_cuenta',$f["nombre_cuenta"]);
			$xml->add_nodo('sw_transaccional',$f["sw_transaccional"]);
			$xml->add_nodo('sw_oec',$f["sw_oec"]);
			$xml->add_nodo('sw_aux',$f["sw_aux"]);
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
