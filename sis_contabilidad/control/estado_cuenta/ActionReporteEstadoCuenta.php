<?php

session_start();


include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarReporteEstadoCuenta.php';


if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
			$_SESSION['rep_id_cuenta']=$id_cuenta;
			$_SESSION['rep_id_moneda']=$id_moneda;
			$_SESSION['rep_id_ep']=$id_ep;
			$_SESSION['rep_id_uo']=$id_uo;
			$_SESSION['rep_id_auxiliar']=$id_auxiliar;
			$_SESSION['rep_al_fecha']=$txt_fecha;
			$fecha=date("Y");
			$_SESSION['rep_del_fecha']=$fecha;
			//echo $fecha.'aux'.$id_auxiliar.'fe'.$txt_fecha;exit;
//echo 'cate'.$id_cuenta .'--ruta'.$id_moneda.'--uo'.$id_uo.'--ep'.$id_ep;exit();
	
	$cant = 100000;
	$puntero = 0;
	$sortcol = 'cli.nro_cuenta';
	//$sortdir = 'asc';
    /* echo "muestraaaaaaaa".$id_fina_regi_prog_proy_acti;
     exit;		*/	
	if($id_fina_regi_prog_proy_acti=='' && $id_cuenta=='' && $id_uo!=''){
			header("location: ../../../sis_contabilidad/vista/estado_cuenta/PDFEstadoCuentaUnidad.php");
	}elseif ($id_fina_regi_prog_proy_acti!='' && $id_cuenta==''){
		header("location: ../../../sis_contabilidad/vista/estado_cuenta/PDFEstadoCuentaCentros.php");
	}else {
		if($id_cuenta!=''){
		header("location: ../../../sis_contabilidad/vista/estado_cuenta/PDFEstadoCuenta.php");}
		else {header("location: ../../../sis_contabilidad/vista/estado_cuenta/PDFEstadoAuxiliar.php");}
		//echo 'no hay esa ep';
	}
	
	
	
	
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