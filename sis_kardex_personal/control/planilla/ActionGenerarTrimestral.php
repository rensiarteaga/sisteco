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

	$nombre_archivo = 'ActionGenerarTrimestral.php';
		$bandera='no';
		
		$res=$Custom -> ListarArchivoTrimestral($_GET["id_planilla"]);
		
		//print_r($Custom->salida[0][0]); exit;
		if ($res){
			
			if (file_exists("../../control/planilla/archivos/trimestral/".$_GET["nombre"])){ 
			   unlink("../../control/planilla/archivos/trimestral/".$_GET["nombre"]);
				
			}
			$fp=fopen("../../control/planilla/archivos/trimestral/".$_GET["nombre"], "w+");
			
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