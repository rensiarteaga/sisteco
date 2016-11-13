<?php
/**
 * Nombre:				ActionPDFCodigoBarrasPrueba.php
 * Autor:				Silvia Ximena Ortiz Fernández
 * Fecha creación:		08/02/2011
 */
session_start();
include_once("../../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();

$nombre_archivo = 'ActionPDFCodigoBarrasV2.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 30000;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = '';
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
	
	$_SESSION['PDF_tamano']=$txt_tamano;
	$_SESSION['PDF_id_sub_tipo_activo']=$hidden_id_sub_tipo_activo;
	$_SESSION['PDF_id_activo_fijo']=$hidden_id_activo_fijo;
	$_SESSION['PDF_id_tipo_activo']=$hidden_id_tipo_activo;



	if(!$res)
	{
		header("location:../../../vista/_reportes/codigo_barras_v2/PDFCodigoBarrasV2.php");
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
		    header("HTTP/1.0 401 No autorizado");
			header('Content-Type: text/plain; charset=iso-8859-1');
			echo "No tiene los permisos necesarios ";
	}
?>