<?php

session_start();
include_once('../../LibModeloAlmacenes.php');

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = 'ActionListarAlmacen.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	
	$_SESSION['PDF_fecha_desde']=$txt_fecha_desde;
	$_SESSION['PDF_fecha_hasta']=$txt_fecha_hasta;
	$_SESSION['PDF_id_financiador']=$txt_id_financiador;
	$_SESSION['PDF_id_regional']=$txt_id_regional;
	$_SESSION['PDF_id_programa']=$txt_id_programa;
	$_SESSION['PDF_id_proyecto']=$txt_id_proyecto;
	$_SESSION['PDF_id_actividad']=$txt_id_actividad;
	$_SESSION['PDF_id_parametro_almacen']=$txt_id_parametro_almacen;
	$_SESSION['PDF_id_almacen']=$txt_id_almacen;
	$_SESSION['PDF_id_almacen_logico']=$txt_id_almacen_logico;
	$_SESSION['PDF_desc_almacen']=$txt_desc_almacen;
	$_SESSION['PDF_desc_almacen_logico']=$txt_desc_almacen_logico;
	$_SESSION['PDF_institucion']=$txt_institucion;
	$_SESSION['PDF_nombre_institucion']=$nombre_institucion;
	$_SESSION['PDF_nombre_contratista']=$nombre_contratista;
	$_SESSION['PDF_nombre_funcionario']=$nombre_funcionario;
	$_SESSION['PDF_codigo_ep']=$codigo_ep;
	$_SESSION['PDF_gestion']=$gestion;
	
	if( $nombre_institucion!=''){
		$_SESSION['PDF_solicitante']=$nombre_institucion;
	} elseif ($nombre_funcionario!=''){
		$_SESSION['PDF_solicitante']=$nombre_funcionario;
	}elseif ($nombre_contratista!=''){
		$_SESSION['PDF_solicitante']=$nombre_contratista;
	}
	
    if($limit == "") $cant = 2000;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

if($sort == '') $sortcol = 'TIUNCO.codigo';//'TIUNCO.nombre';
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
	
	if( $nombre_institucion!=''){
	
		$criterio_filtro= $criterio_filtro ." AND SALIDA.estado_salida=''Finalizado'' AND PARALM.id_parametro_almacen=$txt_id_parametro_almacen and ALMEP.id_fina_regi_prog_proy_acti = $id_fina_regi_prog_proy_acti AND
ALMLOG.id_almacen_logico=$txt_id_almacen_logico and ALMACE.id_almacen=$txt_id_almacen AND
SALIDA.fecha_finalizado_cancelado >=''$txt_fecha_desde'' and SALIDA.fecha_finalizado_cancelado<=''$txt_fecha_hasta'' and
SALIDA.id_institucion=$txt_id_institucion 
GROUP BY TIUNCO.codigo,
       TIUNCO.nombre,
       TIUNCO.descripcion	";

	} elseif ($nombre_funcionario!=''){
		$criterio_filtro= $criterio_filtro ." AND SALIDA.estado_salida=''Finalizado'' AND PARALM.id_parametro_almacen=$txt_id_parametro_almacen and ALMEP.id_fina_regi_prog_proy_acti = $id_fina_regi_prog_proy_acti AND
ALMLOG.id_almacen_logico=$txt_id_almacen_logico and ALMACE.id_almacen=$txt_id_almacen AND
SALIDA.fecha_finalizado_cancelado >=''$txt_fecha_desde'' and SALIDA.fecha_finalizado_cancelado<=''$txt_fecha_hasta'' and
SALIDA.id_empleado=$txt_id_empleado 
GROUP BY TIUNCO.codigo,
       TIUNCO.nombre,
       TIUNCO.descripcion	";

	}elseif ($nombre_contratista!=''){
		$criterio_filtro= $criterio_filtro ." AND SALIDA.estado_salida=''Finalizado'' AND PARALM.id_parametro_almacen=$txt_id_parametro_almacen and ALMEP.id_fina_regi_prog_proy_acti = $id_fina_regi_prog_proy_acti AND
ALMLOG.id_almacen_logico=$txt_id_almacen_logico and ALMACE.id_almacen=$txt_id_almacen AND
SALIDA.fecha_finalizado_cancelado >=''$txt_fecha_desde'' and SALIDA.fecha_finalizado_cancelado<=''$txt_fecha_hasta'' and
SALIDA.id_contratista=$txt_id_contratista 
GROUP BY TIUNCO.codigo,
       TIUNCO.nombre,
       TIUNCO.descripcion	";

	}
	
	
	
	/*
	$criterio_filtro= $criterio_filtro ." SALIDA.estado_salida=''Finalizado'' AND PARALM.id_parametro_almacen=$txt_id_parametro_almacen and ALMEP.id_fina_regi_prog_proy_acti = $id_fina_regi_prog_proy_acti AND
ALMLOG.id_almacen_logico=$txt_id_almacen_logico and ALMACE.id_almacen=$txt_id_almacen
SALIDA.fecha_finalizado_cancelado Between($txt_fecha_desde and $txt_fecha_hasta) and
(SALIDA.id_empleado=$txt_id_empleado or SALIDA.id_contratista=$txt_id_contratista or SALIDA.id_institucion=$txt_id_institucion)	";

	*/
	    $salida_det = array();
		$salida_det = $Custom-> ReporteEntregadoUnidadConsDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	    $_SESSION['PDF_material_entregado_detalle']=$Custom->salida;
	    //	http://cincel.ende.bo/endesis_desarrollo/sis_almacenes/vista/material_entregado_solicitante/PDFMaterialEntregadoSolicitante.php
	    
		header("location: ../../../vista/_reportes/unidades_constructivas_entregadas/PDFEntregadoUnidadConstructiva.php");

	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>