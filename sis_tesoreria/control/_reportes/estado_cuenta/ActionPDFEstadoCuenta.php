<?php
session_start();
include_once('../LibModeloTesoreria.php');
include_once('../../../lib/lib_control/GestionarExcel.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionPDFEstadoCuenta.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
/*echo "down down".utf8_decode($_GET['fecha_desde']);
exit; */
if($_SESSION['autentificado']=="SI")
{
	$cant = 100000;
	$puntero = 0;
	$sortcol = 'CUEDOC.fecha_sol, CUEDOC.nro_documento';	
	$sortdir = 'desc';
	
				
		$id_depto=$_SESSION['id_depto']=utf8_decode($_GET['id_depto']);
		$_SESSION['desc_depto']=utf8_decode($_GET['desc_depto']);
		$id_empleado=$_SESSION['id_empleado']=utf8_decode($_GET['id_empleado']);	
		$estado=$_SESSION['estado']=utf8_decode($_GET['estado']);	
		$estado=$_SESSION['estado']=utf8_decode($_GET['estado']);
		$_SESSION['fecha_desde']=utf8_decode($_GET['fecha_desde']);
		$_SESSION['fecha_hasta']=utf8_decode($_GET['fecha_hasta']);
		$tipo_reporte=$_GET['tipo_reporte'];
		$fecha_ini= substr( $_SESSION['fecha_desde'],3,2)."/".substr($_SESSION['fecha_desde'],0,2)."/".substr( $_SESSION['fecha_desde'],6,4);
		$fecha_fin= substr( $_SESSION['fecha_hasta'],3,2)."/".substr($_SESSION['fecha_hasta'],0,2)."/".substr( $_SESSION['fecha_hasta'],6,4);
	echo '.....'.$tipo_reporte; exit;
if ($tipo_reporte=='2')
		{
			if ($id_depto == "undefined" || $id_depto == "" || $id_depto == 'null'){
				$id_depto=4;
			}
		$Excel = new GestionarExcel();
		$Excel->SetNombreReporte('DETALLE DEL ESTADO DE CUENTAS');
		$datos_cuenta = $Custom->ListarReporteEstadoCuentaExcel(1500,$puntero,$sortcol,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_depto,$id_empleado,$fecha_ini,$fecha_fin,$estado);
		$v_datos_cuenta=$Custom->salida;
		$Excel->setDetalle($v_datos_cuenta[$i]);
		
		
		$Excel->setFin();
		}else 
		{
			
		if ($id_depto == "undefined" || $id_depto == "" || $id_depto == 'null')
		{		 
			$id_empleado = $Custom-> ListarReporteEstadoCuenta(1500,$puntero,$sortcol,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_depto,$id_empleado,$fecha_ini,$fecha_fin,$estado);
			                    
			$_SESSION['PDF_estado_cuenta']=$Custom->salida;
				
			//header("location:PDFEstadoCuentaEmpleado.php");	
		}
		else 
		{
			//AQUI ESTARA EL CODIGO PARA EL REPORTE POR DEPARTAMENTO CONTABLE			
			
			
			$_SESSION['fecha_desde']=$fecha_ini;
			$_SESSION['fecha_hasta']=$fecha_fin;
	
		//	header("location: PDFEstadoCuentaDepartamento.php");			
			
			
		}
		
		
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