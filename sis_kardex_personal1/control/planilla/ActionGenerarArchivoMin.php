<?php 
session_start();
include_once("../LibModeloKardexPersonal.php");

//include_once('../../../lib/lib_control/cls_manejo_reportes.php');

include_once("archivos/ActionGenerarPrincipal.php");

$Custom = new  cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionGuardarRuta.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{

	$nombre_archivo = 'ActionGenerarArchivoMin.php';
		$bandera='no';
		
		
		$res=$Custom -> ListarArchivoMin($_POST["id_planilla"],$_POST["codigo"]);
		
		
		if ($res){
			
				if (file_exists("../../control/planilla/archivos/ministerio/".$_POST["id_planilla"].'_'.$_POST["codigo"].".txt")){ 
			   		unlink("../../control/planilla/archivos/ministerio/".$_POST["id_planilla"].'_'.$_POST["codigo"].".txt");
				
				}
				
				$fp=fopen("../../control/planilla/archivos/ministerio/".$_POST["id_planilla"].'_'.$_POST["codigo"].".txt", "w+");
			
			    foreach ($Custom->salida as $f){
			    	//echo $f["cadena"]; exit;
					fwrite($fp,$f["cadena"]);
					fwrite($fp,"\r\n");
				}
		}
		
		
		fclose($fp);
	//$res1 = new GenerarPrincipal($_GET["id_planilla"],$_GET["id_subsistema"],$_GET["nombre"]);
	return $res;
		
}	

?>