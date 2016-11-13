<?php
session_start();
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../../LibModeloActivoFijo.php");
$nombre_archivo = 'ActionPDFActivoFijoTransferenciaVista.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{	$codigo                        =$codigo;
    $descripcion_larga             =$descripcion_larga;
    $desc_empleado_anterior        =$id_empleado_anterior;
    $id_empleado                   =$id_empleado;
    $fecha_asig                    =$fecha_asig;
    $estado                        =$estado;
    
    //$descripcion_larga=substr($descripcion_larga,0,135);
    $_SESSION['rep_af_trans_codigo']=$codigo;
    $_SESSION['rep_af_trans_descripcion_larga']=$descripcion_larga;
    $_SESSION['rep_af_trans_empleado_anterior']=$id_empleado_anterior;
    $_SESSION['rep_af_trans_empleado']=$id_empleado;
    $_SESSION['rep_af_trans_fecha_asig']=$fecha_asig;
   
   	
 /* echo($fecha_asig);
	exit();*/
	header("location:PDFActivoFijoTransferenciaVista.php?codigo=$codigo&descripcion_larga=$descripcion_larga&desc_empleado_anterior= $desc_empleado_anterior&id_empleado= $id_empleado&fecha_asig=$fecha_asig&estado=$estado");		
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