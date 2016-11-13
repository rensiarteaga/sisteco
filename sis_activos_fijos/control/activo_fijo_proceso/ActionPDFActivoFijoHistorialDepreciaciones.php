<?php
session_start();
/**
 * Autor: Elmer Velasquez
 * Fecha de creacion: 15/04/2014
 * Descripción: Historial depreciaciones dado un id_activo_fijo
 * **/

include_once('../LibModeloActivoFijo.php');
$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = "ActionPDFActivoFijoHistorialDepreciaciones.php";


if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

if($sort == '') $sortcol = 'depre.fecha_desde';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'ASC';
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

	$cond->add_criterio_extra("af.id_activo_fijo",$txt_id_activo_fijo);
	$criterio_filtro = $cond->obtener_criterio_filtro();
	
		$res = $Custom-> ActionPDFActivoFijoHistorialDepreciaciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		
		
		if($res)
		{		
			$_SESSION['PDF_detalle_depreciacion_activo'] = $Custom->salida;
			header("location:../../vista/_reportes/activo_fijo_depreciacion/PDF_ActivoFijoHistorialDepreciaciones.php");  
		
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