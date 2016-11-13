<?php
/**
**********************************************************
Nombre de archivo:	    ActionPDFDepreciacion.php
Propósito:				Permite realizar el reporte de depreciacion de activos fijos
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro
Valores de Retorno:    	
Fecha de Creación:	    07/01/2011
Versión:				1.0.0
Autor:					Marcos A. Flores Valda
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();

$nombre_archivo = 'ActionPDFDepreciacion.php';
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

	if($sort == '') $sortcol = 'id_depreciacion';
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
	
	$cond->add_criterio_extra("DEPRE.id_grupo_depreciacion",$m_id_grupo_depreciacion);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();	
	
	//criterio_estado 
	$res = $Custom-> ListarDepreciacionRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	//$res = $Custom-> ListarDetalleDepRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	//$_SESSION["PDF_depreciacion"]=$Custom->salida;
	$_SESSION["PDF_depreciacion"]=$Custom->salida;

	$ano_fin = $txt_ano_fin;
	$mes_fin = $txt_mes_fin;
	$depart = $txt_depart;
			
	if($res)$total_registros= $Custom->salida;	
		
	if($res)
	{
		//header("location: ../../vista/depreciacion/PDFDepreciacion.php");
		header("location: ../../vista/depreciacion/PDFDepreciacion.php?ano_fin=$ano_fin&mes_fin=$mes_fin&depart=$depart");
		//header("location: ../../vista/_reportes/detalle_depreciacion/PDFDetalleDepreciacion.php?ano_fin=$ano_fin&mes_fin=$mes_fin&depart=$depart");
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

}?>