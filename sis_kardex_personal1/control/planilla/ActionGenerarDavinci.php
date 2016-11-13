<?php 
session_start();
include_once("../LibModeloKardexPersonal.php");

//include_once('../../../lib/lib_control/cls_manejo_reportes.php');

//include_once("archivos/ActionGenerarPrincipal.php");

$Custom = new  cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionGuardarRuta.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{

	$nombre_archivo = 'ActionGenerarDavinci.php';
		$bandera='no';
		
		$res=$Custom -> ListarArchivoDavinci($_GET["id_planilla"],$_GET["codigo"],$_GET["monto"]);
		
		//print_r($Custom->salida[0][0]); exit;
		if ($res){
			if (file_exists("../../control/planilla/archivos/davinci/".$_GET["nombre"])){ 
			   unlink("../../control/planilla/archivos/davinci/".$_GET["nombre"]);
				
			}
			
			$fp=fopen("../../control/planilla/archivos/davinci/".$_GET["nombre"], "w+");
			
			
				/*$fecha=$Custom->salida[0]["fecha_pago"];
				$num_empleados=count($Custom->salida);
				$periodo=$Custom->salida[0]["periodo"];
				$gestion=$Custom->salida[0]["gestion"];
				$contador=0;
				$relleno='';
				
				if(strlen($num_empleados)==4){
					$relleno='0';
				}elseif (strlen($num_empleados)==3){
					$relleno='00';
				}elseif (strlen($num_empleados)==2){
					$relleno='000';
				}else{
				  $relleno='0000';
				}
				//echo $fecha; exit;
				$fecha=substr($fecha,8,2).''.substr($fecha,5,2).''.substr($fecha,0,4); 
				
				*/
			  //  fwrite($fp,"REMUNERACIONES ".$periodo."/".$gestion."    ".$relleno.''.$num_empleados.''.$fecha);
			   // fwrite($fp,"\r\n");
			
			    foreach ($Custom->salida as $f){
				
				fwrite($fp,$f["cadena"]);
				fwrite($fp,"\r\n");
			}
			
			
		}
		
		
		fclose($fp);
	//$res1 = new GenerarPrincipal($_GET["id_planilla"],$_GET["id_subsistema"],$_GET["nombre"]);
	return $res;
}	

?>