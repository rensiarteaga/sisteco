<?php 
session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionGuardarDepreciacionDepto.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}

if($_SESSION['autentificado']=="SI")
{
	$cant = 0;
	$puntero = 0;
	$sortdir = '';
	$sortcol = ''; 
	$criterio_filtro = '';
	$id_grupo_dep = $grupo_depreciacion;
	$id_deprec_depto = $h_id_depreciacion_depto_0;
	
	if($id_deprec_depto > 0 && $id_grupo_dep > 0)
	{
		$res = $Custom->RegistrarDepreciacionDepto($id_grupo_dep,$id_deprec_depto); 
		
		if($res){
			
			$resp = new cls_manejo_mensajes(false);
			$resp->add_nodo("TotalCount", "Generacion correcta de los departamentos contables.");
			$resp->add_nodo("mensaje", "Se generaron correctamente los departamentos contables.");
			$resp->add_nodo("tiempo_resp", "200");
			echo $resp->get_mensaje();
			exit;
			
		}else{
			
			//Se produjo un error
			$resp = new cls_manejo_mensajes(true);
			$resp->mensaje_error = $Custom->salida[1];
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			echo $resp->get_mensaje();
			exit;
		}
	}
	else {
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true);
		$resp->mensaje_error = $Custom->salida[1];
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		echo $resp->get_mensaje();
		exit;
	}
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 1';
	echo $resp->get_mensaje();
	exit;
}
?>
