<?php

/*
 * Nombre:	        
 * Propósito:		
 * Autor:			Marcos A. Flores Valda 
 *
 */

session_start();

include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionPDFResumenSolicitud.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}

if($_SESSION['autentificado']=="SI")
{	
	//variables que se reciben de la vista
	
	//Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0)
	{
		$get=true;
		$cont=1;
		
		
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
	}
	elseif(sizeof($_POST) > 0)
	{
		$get = false;
		$cont =  $_POST["cantidad_ids"];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
		$resp->origen = "ORIGEN = ";
		$resp->proc = "PROC = ";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}
	
	//Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;
	
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$tipo_licencia = $_GET["txt_tipo_licencia_$j"];
			$id_vacacion = $_GET["txt_id_vacacion_$j"];			
		}		
	}
			
	if($limit == '') $cant = 30000;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'horari.fecha_inicio';
	
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}	
			
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	$criterio_filtro = $criterio_filtro." and horari.id_vacacion = $id_vacacion  and horari.id_tipo_horario = $tipo_licencia";
						
	$res = $Custom -> RepResSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		
	$_SESSION['PDF_reporte'] =  $Custom->salida;

	$_SESSION['PDF_nombre'] = $Custom->salida[0]['nombre'];
	$_SESSION['PDF_categoria'] = $Custom->salida[0]['categoria'];
	$_SESSION['PDF_gestion'] = $Custom->salida[0]['gestion'];
	$_SESSION['PDF_tipo_licencia'] = $Custom->salida[0]['tipo_licencia'];

}
else
{
	header("HTTP/1.0 401 No autorizado");
	header('Content-Type: text/plain; charset=iso-8859-1');
	echo "No tiene los permisos necesarios";
}
?>