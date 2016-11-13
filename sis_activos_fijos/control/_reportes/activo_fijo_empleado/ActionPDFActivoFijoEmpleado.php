<?php
/**
 * Nombre:				ActionPDFActivoFijoEmpleado
 * Autor:				Silvia Ximena Ortiz Fernandez
 * Fecha creaci�n:		07/01/2011
 *
 */
session_start();
include_once("../../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();

$nombre_archivo = 'ActionPDFActivoFijoEmpleado.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Par�metros del filtro
	if($limit == '') $cant = 30000;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = '';
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
	if($CantFiltros=="") $CantFiltros = 0;
	
	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	//$_SESSION["PDF_titulo"]='ACTIVO';
	if($sw_activo_clasificacion==0||$sw_activo_clasificacion==2 ||$sw_activo_clasificacion==3){
		if ($sw_activo_clasificacion==3){
		/*	echo $id_persona;
			exit;*/
			$criterio_filtro=$criterio_filtro." AND  EMPL.id_persona=$id_persona";
		}else{
			
		    $criterio_filtro=$criterio_filtro." AND  EMPL.id_empleado=$hidden_id_empleado";
		    
		}
		
		
	}
	else {

		$criterio_filtro= $criterio_filtro ." AND EMPL.id_deposito=$hidden_id_deposito";
	}
	//echo $sw_activo_clasificacion; exit;
	
	if($sw_activo_clasificacion==2)
	{
		//echo $criterio_filtro;exit;
		$res_detalle = $Custom->ListarActivoFijoEmpleadoDetalle2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	} else{
		$res_detalle = $Custom->ListarActivoFijoEmpleadoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);		
	}
	

	$_SESSION["PDF_activo_fijo_empleado_detalle"]=$Custom->salida;
	if($res) $total_registros= $Custom->salida;
		$_SESSION['PDF_desc_empleado']=$desc_empleado;
		$_SESSION['PDF_desc_per']=$desc_per;
		$_SESSION['PDF_desc_deposito']=$desc_deposito; 
		$_SESSION['PDF_sw_activo_clasificacion']=$sw_activo_clasificacion; 
		$_SESSION['PDF_id_empleado']=$hidden_id_empleado;
		$_SESSION['PDF_id_deposito']=$hidden_id_deposito;    
	
	if(!$res)
	{
		//echo $sw_activo_clasificacion; exit;
		if($sw_activo_clasificacion==2){ 
			header("location:../../../vista/_reportes/activo_fijo_empleado/PDFFormulAsignacion.php");
			
		} else{
			
			header("location:../../../vista/_reportes/activo_fijo_empleado/PDFActivoFijoEmpleado.php");	
			
		}
		
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