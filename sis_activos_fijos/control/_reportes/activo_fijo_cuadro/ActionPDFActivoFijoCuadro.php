<?php
session_start();
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../../LibModeloActivoFijo.php");
$nombre_archivo = 'ActionPDFActivoFijoCuadro.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{	$id_financiador            =  $hidden_id_financiador;
	$id_regional               =  $hidden_id_regional;
	$id_programa               =  $hidden_id_programa;
	$id_proyecto               =  $hidden_id_proyecto;
    $mes_fin                   =  $txt_mes_fin;
    $gestion_fin               =  $txt_gestion_fin;

    $fecha_inicio=$gestion_fin."/".$mes_fin."/"."01";    
    if($mes_fin==01 || $mes_fin==03 || $mes_fin==05 || $mes_fin==07 || $mes_fin==08 ||$mes_fin==10 ||$mes_fin==12){
    	$fecha_fin=$gestion_fin."/".$mes_fin."/"."31";
    	$dia=31;
   	 }
   	 elseif ($mes_fin==02 ){
   	 	$aux=$gestion_fin%4;
   	 	if($aux==0){
   	 		$fecha_fin=$gestion_fin."/".$mes_fin."/"."29";
   	 		$dia=29;
   	 	}
   	 	else{
   	 		$fecha_fin=$gestion_fin."/".$mes_fin."/"."28";
   	 		$dia=28;
   	 	}
   	 }
   	 else{
   	 	$fecha_fin=$gestion_fin."/".$mes_fin."/"."30";
   	 	$dia=30;
   	 }
   	 if($mes_fin==01){$nombre_mes="ENERO" ;}
   	 if($mes_fin==02){$nombre_mes="FEBRERO" ;}
   	 if($mes_fin==03){$nombre_mes="MARZO" ;}
   	 if($mes_fin==04){$nombre_mes="ABRIL" ;}
   	 if($mes_fin==05){$nombre_mes="MAYO" ;}
   	 if($mes_fin==06){$nombre_mes="JUNIO" ;}
   	 if($mes_fin==07){$nombre_mes="JULIO" ;}
   	 if($mes_fin==08){$nombre_mes="AGOSTO" ;}
   	 if($mes_fin==09){$nombre_mes="SEPTIEMBRE" ;}
   	 if($mes_fin==10){$nombre_mes="OCTUBRE" ;}
   	 if($mes_fin==11){$nombre_mes="NOVIEMBRE" ;}
     if($mes_fin==12){$nombre_mes="DICIEMBRE" ;}
        	 
    $_SESSION['rep_af_incor_fecha_inicio']=$fecha_inicio;
	$_SESSION['rep_af_incor_fecha_fin']=$fecha_fin;
	$_SESSION['rep_af_incor_nombre_mes']=$nombre_mes;
	$_SESSION['rep_af_incor_dia']=$dia;
	$_SESSION['rep_af_incor_gestion_fin']=$gestion_fin;
	//$_SESSION['rep_af_incor_financiador']=$financiador;


	
	
	
  /* 	echo($fecha_inicio);
	exit();*/
 header("location:PDFActivoFijoCuadro.php?id_financiador=$id_financiador&id_regional=$id_regional&id_programa=$id_programa&id_proyecto=$id_proyecto&fecha_inicio=$fecha_inicio&fecha_fin=$fecha_fin");	
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