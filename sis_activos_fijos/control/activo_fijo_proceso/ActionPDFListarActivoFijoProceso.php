<?php
/**
**********************************************************
Nombre de archivo:	    ActionPDFDepreciacion.php
Prop�sito:				Permite realizar el reporte de activos fijos proceso
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro
Valores de Retorno:    	
Fecha de Creaci�n:	    17/01/2011
Versi�n:				1.0.0
Autor:					Silvia Ximena Ortiz Fernandez
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$CustomA = new cls_CustomDBActivoFijo();

$nombre_archivo = 'ActionPDFListarActivoFijoProceso.php';
if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
	
	//echo $id_activo_fijo_proceso;
	//exit;
//Par�metros del filtro
	if($limit == '') $cant = 30000;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_activo_fijo_proceso';
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
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	if(ereg('CUST',$txt_desc_proceso) || ereg('DEVCUS',$txt_desc_proceso))
	{
		$criterio_filtro=$criterio_filtro." and afp.asignar = ''si'' and afp.id_grupo_proceso=$m_id_grupo_proceso";
	}
		
	else
	{
		$criterio_filtro=$criterio_filtro." AND DEPTUS.cargo=''Responsable de Activos Fijos'' and DEPTUS.estado=''activo''  and afp.id_grupo_proceso=$m_id_grupo_proceso";
	}
	
	$_SESSION['PDF_desc_activo_fijo']=($txt_desc_activo_fijo);
	$_SESSION['PDF_desc_depto_des']=($txt_desc_depto_des);
	$_SESSION['PDF_desc_proceso']=($txt_desc_proceso);
	$_SESSION['PDF_desc_empleado_ori']=($txt_desc_empleado_ori);
	$_SESSION['PDF_desc_empleado_des']=($txt_desc_empleado_des);
	$_SESSION['PDF_sw_prestamo']=($txt_sw_prestamo);
	$_SESSION['PDF_fecha_devolucion']=($txt_fecha_devolucion);
	$_SESSION['PDF_fecha_contabilizacion']=($txt_fecha_contabilizacion);
	//$_SESSION['id_grupo_proceso']=$m_id_grupo_proceso;
	$_SESSION['PDF_sw_devol_prestamo']=($txt_sw_devol_prestamo);
	$_SESSION['PDF_estado']=($txt_estado);
	$_SESSION['PDF_descripcion']=($txt_descripcion);
	$_SESSION['PDF_custodio']=($custodio);
	
	//criterio_estado 
	$res = $Custom-> ListarPDFActivoFijoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	//var_dump($res); exit;	
	
	$_SESSION["PDF_activo_fijo_proceso"]=$Custom->salida;
	
	if(ereg('DEVCUS',$txt_desc_proceso))
	{	
		$id_activo_fijo = $Custom->salida[0][0];		
		
		$criterio_filtroA = $criterio_filtroA."afe.id_activo_fijo = $id_activo_fijo";
		
		$resA = $CustomA-> ObtieneResponsableAF($cant,$puntero,$sortcol,$sortdir,$criterio_filtroA,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		//echo 'llega'; exit;
		//var_dump($resA); exit;
		
		//$_SESSION['PDF_responsable'] = $CustomA->salida[0][0];
		$_SESSION['PDF_responsable'] = $txt_desc_empleado_ori;
	}
	
	if($res)$total_registros= $Custom->salida;	
		
	if($res)
	{
		
		header("location: ../../vista/activo_fijo_proceso/PDFReporte.php");
		
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