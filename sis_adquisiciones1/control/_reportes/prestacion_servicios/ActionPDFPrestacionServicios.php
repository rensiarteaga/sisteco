<?php
/**
**********************************************************
Nombre de archivo:	    ActionPDFPrestacionServicios.php
Propósito:				Permite realizar el reporte de prestacion de servicios
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro
Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:	    08/03/2010
Versión:				1.0.0
Autor:					Ana Maria villegas
**********************************************************
*/
session_start();
include_once("../../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFPrestacionServicios.php';
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

	if($sort == '') $sortcol = 'id_devengado_detalle';
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
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//criterio_estado
	/**********************para los estados ******************/
	$estado_cons=" ";
	$estado_reporte;
	list($estados[0],
	     $estados[1],
	     $estados[2],
	     $estados[3],
	     $estados[4]
	     ) = explode(",",$estado);
	
$bandera=false;
	for ($i=0;$i<count($estados);$i++){
		
	 if ($estados[$i]=='%'){
	 	    $bandera=true;
	 	    $estado_reporte='TODOS';
	     	break;
	    	
	 }else{
	 
     $bandera=false;
    switch ($estados[$i]) {
    	
    	case 'orden_compra':
    		    
    		    $estado_cons=$estado_cons." ''orden_compra'',";
    		    $estado_reporte=$estado_reporte.'Orden de Compra,';
        break;
        case 'formulacion_pp':
    		    $estado_cons=$estado_cons." ''formulacion_pp'',";
    		    $estado_reporte=$estado_reporte.'Formulacion PP,';
        break;
        case 'en_pago':
    		    $estado_cons=$estado_cons." ''en_pago'',";
    		    $estado_reporte=$estado_reporte.'En Pago,';
        break;
        case 'finalizado':
    		    $estado_cons=$estado_cons." ''finalizado''";
    		    $estado_reporte=$estado_reporte.'Finalizado';
        break;


       }
       
	 }
	}
	
	if ($bandera==true)
	{
		$criterio_filtro=$criterio_filtro." AND c.estado_vigente like ''%'' ";
	}else{
		$criterio_filtro=$criterio_filtro." AND c.estado_vigente in (".rtrim($estado_cons,",").")";
	}
  
	/**************** fin del estado*//////////////
	//criterio departamento
	$criterio_filtro=$criterio_filtro." AND pro.id_depto like ''$departamento''";
	//criterio proveedor
	$criterio_filtro= $criterio_filtro. " AND c.id_proveedor like ''$proveedor''";
	//criterio fecha
	$criterio_filtro = $criterio_filtro. " AND c.fecha_orden_compra>=''$fecha_ini'' AND c.fecha_orden_compra<=''$fecha_fin''";
	//criterio tipo de servicio
	$criterio_filtro= $criterio_filtro. " AND c.id_cotizacion IN (select id_cotizacion
	                                                              from compro.tad_cotizacion_det
	                                                              where id_servicio IN(select id_servicio
	                                                                                   from compro.tad_servicio ser
	                                                                                   inner join compro.tad_tipo_servicio tipser on (tipser.id_tipo_servicio=ser.id_tipo_servicio)
	                                                                                   where tipser.id_tipo_servicio like ''$id_tipo_servicio'' AND tipser.id_tipo_adq = $id_tipo_adq))";
	
	

	
    
	//$res = $Custom->ListarPrestacionServicios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
/*echo $criterio_filtro;
exit;*/
	$res = $Custom->ListarPrestacionServicios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
		
	$_SESSION["PDF_prestacion_servicios"]=$Custom->salida;
	if($res) $total_registros= $Custom->salida;
	$_SESSION['PDF_fecha_inicio']=$fecha_ini;
	$_SESSION['PDF_fecha_fin']=$fecha_fin;
	$_SESSION['PDF_desc_depto']=$desc_depto;
	$_SESSION['PDF_desc_proveedor']=$desc_proveedor;
	$_SESSION['PDF_desc_tipo_servicio']=$desc_tipo_servicio;
	$_SESSION['PDF_desc_tipo_adq']=$desc_tipo_adq;
	$_SESSION['PDF_estado_reporte']=rtrim($estado_reporte,",");
	$_SESSION['PDF_fecha_inicio']=$rep_fecha_ini;
	$_SESSION['PDF_fecha_fin']=$rep_fecha_fin;
	
	if($res)
	{
		header("location: ../../../vista/_reportes/prestacion_servicios/PDFPrestacionServicios.php");
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