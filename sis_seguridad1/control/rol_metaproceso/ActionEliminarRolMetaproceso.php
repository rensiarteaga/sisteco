<?php
/**
**********************************************************
Nombre de archivo:	    ActionEliminarRolMetaproceso.php
Propósito:				Permite eliminar registros de la tabla tsg_rol_metaproceso
Tabla:					tsg_tsg_rol_metaproceso
Parámetros:				$hidden_id_rol_metaproceso


Valores de Retorno:    	Número de registros
Fecha de Creación:		2007-11-01 08:36:13
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();

include_once("../LibModeloSeguridad.php");

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = "ActionEliminarRolMetaproceso.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}

if($_SESSION["autentificado"]=="SI")
{
	$decodificado = stripslashes($_REQUEST['datos']);
	$proceso=stripslashes($_REQUEST['proc']);

	$nodo = json_decode($decodificado,true);
	
	
	if($proc==='del'){
			$res = $Custom -> EliminarRolMetaproceso($nodo['id_metaproceso_db'],$nodo['id_rol'],$nodo['id_metaproceso']);
			if(!$res)
			{
				$tmp['success']='false';
				echo json_encode($tmp);
				exit;
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;

			}else{
				$tmp['success'] = 'true';
				echo json_encode($tmp);
				exit;
			}
		}
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