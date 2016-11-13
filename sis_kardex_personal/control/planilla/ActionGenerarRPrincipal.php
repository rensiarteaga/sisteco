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

	$nombre_archivo = 'ActionGenerarRPrincipal.php';
		$bandera='no';
		
		$res=$Custom -> ListarArchivoPago($_GET["id_planilla"],$_GET["id_subsistema"],$_GET["id_cuenta_bancaria"],$_GET["codigo"]);
		
		
		if ($res){
			
			if($id_subsistema==4){
				$fp=fopen("../../control/planilla/archivos/consultores/".$_GET["nombre"], "w+");
			    
			}else{
				if (file_exists("../../control/planilla/archivos/planta/".$_GET["nombre"])){ 
			   		unlink("../../control/planilla/archivos/planta/".$_GET["nombre"]);
				
				}
				
				
				$fp=fopen("../../control/planilla/archivos/planta/".$_GET["nombre"], "w+");
			}
			
				$fecha=$Custom->salida[0]["fecha_pago"];
				$num_empleados=count($Custom->salida);
				//$num_empleados->$Custom->salida[0]["nro_emp"];
				$num_empleados=$num_empleados-1;
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
				
				$fecha=substr($fecha,8,2).''.substr($fecha,5,2).''.substr($fecha,0,4); 
				
				if($_GET["codigo"]=='AGUIN'){
					fwrite($fp,"AGUINALDOS ".$gestion."    ".$relleno.''.$num_empleados.''.$fecha);
				}else{
					
					if($_GET["codigo"]=='BONMES'||$_GET["codigo"]=='REFRIGERIO'){
						fwrite($fp,"BONOS ".$periodo."/".$gestion."    ".$relleno.''.$num_empleados.''.$fecha);
					}else{
						if($_GET["codigo"]=='PRIMA'){
							fwrite($fp,"PRIMA ".$periodo."/".$gestion."    ".$relleno.''.$num_empleados.''.$fecha);
						}else{
						
						    fwrite($fp,"REMUNERACIONES ".$periodo."/".$gestion."    ".$relleno.''.$num_empleados.''.$fecha);
						}
					}
				}
			    
			    fwrite($fp,"\r\n");
			
			    foreach ($Custom->salida as $f){
			
				
				fwrite($fp,$f["nro_cuenta"]);
				fwrite($fp,"\r\n");
			}
			
			
		}
		
		
		fclose($fp);
	//$res1 = new GenerarPrincipal($_GET["id_planilla"],$_GET["id_subsistema"],$_GET["nombre"]);
	return $res;
}	

?>