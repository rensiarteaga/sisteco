<?php
session_start();
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../../LibModeloActivoFijo.php");
$nombre_archivo = 'ActionPDFActivoFijoTransferencia.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
			/*$id_composicion_tuc=$maestro_id_composicion_tuc;
			$node=$maestro_id_tipo_unidad_constructiva;
			$tipo=$maestro_tipo;
			$nombre=$maestro_nombre;
			$terminado=$maestro_terminado;
			$_SESSION['nombre_pie']=$maestro_nombre;
			$_SESSION['nombre_cabecera']=$maestro_nombre;
			$_SESSION['nombre']=$maestro_nombre;
			$nombre_padre=$maestro_nombre_padre;
			$_SESSION['tipo_maestro']=$maestro_tipo;
			$_SESSION['nombre_padre']=$maestro_nombre_padre; */
			//echo($id_composicion_tuc);
			//exit();
			//header("location:PDFUnidadConstructiva.php?node=$node&terminado=$terminado&tipo=$tipo&nombre=$nombre&nombre_padre=$nombre_padre");
			///////////////////////////////////
	
		
	$_SESSION['rep_af_det_fecha_asig1']=$txt_fecha_asig1;
	$_SESSION['rep_af_det_fecha_asig2']=$txt_fecha_asig2;
	
	/*echo($fecha_asig2);
	exit();*/
	
	header("location:PDFActivoFijoTransferencia.php?id_financiador=$hidden_id_financiador&id_regional=$hidden_id_regional&id_programa=$hidden_id_programa&id_proyecto=$hidden_id_proyecto&id_actividad=$hidden_id_actividad&id_tipo_activo=$hidden_id_tipo_activo&id_sub_tipo_activo=$hidden_id_sub_tipo_activo&id_activo_fijo=$hidden_id_activo_fijo&id_unidad_organizacional=$hidden_id_unidad_organizacional&fecha_asig1=$txt_fecha_asig1&fecha_asig2=$txt_fecha_asig2");		
			
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