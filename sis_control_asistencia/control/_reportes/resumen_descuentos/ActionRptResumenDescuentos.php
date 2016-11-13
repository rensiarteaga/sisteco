<?php
/**
 * Nombre:	        ActionRptResponsableActivoFijo.php
 * Propósito:		recoge parametrsos de la vista y los pasa al api de agata pera la generacion de un reporte
 * Autor:			Veimar Soliz Poveda
 * Fecha creación:	12-07-2007
 *
 */
session_start();
include_once(dirname(__FILE__)."/../../LibModeloControlAsistencia.php");
include_once(dirname(__FILE__).'/../../../../lib/lib_control/cls_manejo_reportes.php');

$CustomAsistencia = new cls_CustomDBControlAsistencia();
$CustomAsisMax = new cls_CustomDBControlAsistencia();
$CustomAsist = new cls_CustomDBControlAsistencia();
$nombre_archivo = 'ActionRptResumenDescuentos.php';
if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	
	//Parámetros del filtro
	if($start == "") $puntero = 0;
	else $puntero = $start;

	if($sort == "") $sortcol = 'id_empleado';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'asc';
	else $sortdir = $dir;

	$reporte = new cls_manejo_reportes();
	//$parametros = null;
	$txt_fecha_fin=substr($txt_fecha_fin,3,2)."-".substr($txt_fecha_fin,0,2)."-".substr($txt_fecha_fin,6,4);
	$parametros = array ('$fecha_inicio'=>$txt_fecha_ini,
	'$fecha_fin'=>$txt_fecha_fin
	);
	
	$CustomAsisMax->ContarListaSueldo(0,$puntero,$sortcol,$sortdir,'0=0',$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);   
   $contar_sueldo=$CustomAsisMax->salida;
   $res_max=$CustomAsisMax->ListarSueldo($contar_sueldo,$puntero,$sortcol,$sortdir,'0=0',$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
   foreach ($CustomAsisMax->salida as $row){
   	$id_empleado=$row["id_empleado"];
   	$sueldo=$row["sueldo"];
   	$CustomAsist->ExisteDescuento(15,$puntero,$sortcol,$sortdir,'0=0',$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$txt_fecha_ini,$txt_fecha_fin);
   	$existe=$CustomAsist->salida;
     if($existe){
      	$obs='';
      }
      else{
    	$res=$CustomAsist->Descuento(15,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$txt_fecha_ini,$txt_fecha_fin);
	    $atraso=$CustomAsist->salida;
	
	    if($atraso <='00:30:59')
	     {
	       $desc=0;
	       $obs='Sin Descuento';
	     }
	    elseif($atraso >= '00:31:00' AND $atraso <='00:45:59')
	     {
	       $desc=($sueldo*1)/240;
	       $desc=number_format($desc,2,'.',',');
	       $obs='Descuento de 1 hora Laboral';
	     }
	    elseif ($atraso >= '00:46:00' AND $atraso <= '01:00:59')
	     {
	       $desc=($sueldo*2)/240;
	       $desc=number_format($desc,2,'.',',');
	       $obs='Descuento de 2 horas Laborales';
	     }
	    elseif ($atraso >= '01:01:00' AND $atraso <= '01:30:00')
	     {
	       $desc=($sueldo*4)/240;
	        $desc=number_format($desc,2,'.',',');
	       $obs='Descuento de Media Jornada Laboral';
	     }
	    else 
	     {
	        $desc=0;
	     	$obs='Memorandum de Llamada de Atencion';
	     }
	     $descuento=$CustomAsistencia->CrearDescuento("NULL",$id_empleado,$sueldo,$txt_fecha_ini,$txt_fecha_fin,$atraso,$desc,$obs);   
      }
    }
    $repetidos=$CustomAsistencia->EliminarRepetidos();
	$reporte -> CreateReport('Pdf','../../../modelo/_reportes/rca_resumen_descuento.agt',$parametros);
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit;
}
?>