<?php
/**
**********************************************************
Nombre de archivo:	    ActionModificarCorrespondenciaENDE.php
Propï¿½sito:			Permite modificar el estado del campo archivo_externo=si cuando CADEB envíe el id_correspondencia que ya capturaron y guardaron en su sistema
Tabla:					tfl_tfl_correspondencia
Parï¿½metros:			$id_correspondencia
						
Valores de Retorno:    	Nï¿½mero de registros guardados
Fecha de Creaciï¿½n:	2015-01-12 10:52:59
Versiï¿½n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();

include_once(dirname(__FILE__).'../../../modelo/cls_DBCorrespondencia.php');

include_once("../../lib/lib_general/cls_funciones.php");
include_once("../../lib/lib_modelo/cls_middle.php");
include_once("../../lib/lib_modelo/cls_conexion.php");
include_once("../../lib/lib_control/cls_manejo_xml.php");
include_once("../../lib/lib_control/cls_manejo_mensajes.php");

$Custom = new cls_DBCorrespondencia();
$nombre_archivo = "ActionModificarCorrespondenciaENDE.php";



if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
	//Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0)
	{
		$get=true;
		$cont=1;
		
	}
	elseif(sizeof($_POST) > 0)
	{
		$get = false;
		$cont =  1;
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
		$resp->origen = "ORIGEN = ";
		$resp->proc = "PROC = ";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}
	
	
	//header("Content-Type:text/json; charset=".$_SESSION["CODIFICACION_HEADER"]);
	//Envia al Custom la bandera que indica si se decodificarï¿½ o no
	$Custom->decodificar = $decodificar;
	
	
	
	if ($get)
	{
		$id_correspondencia= $_GET["id_correspondencia"];
	
	}
	else
	{
		$id_correspondencia=($_POST["id_correspondencia"]);
	
	}
	
	

	
	
	$datos = stripslashes($_GET['id_correspondencia']);
	
	$json=json_decode($datos,true);
	
	$para_enviar=array();
	foreach($json as $val=>$value){  //echo $val.'--'.$value; exit;
			$para_enviar[$val]=$value;
				
	} 
			
	
			$res = $Custom->ModificarCorrespondenciaENDE($_SESSION["ss_id_usuario"],$_SESSION["ss_ip_origen"], $para_enviar);
				
			if(!$res){
									
				$xml = new cls_manejo_xml('ERROR');
				$xml->add_rama('CorrespondenciaEnde');
				$xml->add_nodo('RespuestaActualizacion',$Custom->salida[0]);
				$xml->add_nodo('DetalleActualizacion',$Custom->salida[1]);
				
				$xml->fin_rama();
				$xml->mostrar_xml();
			}else{
				$xml = new cls_manejo_xml('ROOT');
				$xml->add_rama('CorrespondenciaEnde');
				$xml->add_nodo('RespuestaActualizacion',$Custom->salida[0]);
				$xml->add_nodo('DetalleActualizacion',$Custom->salida[1]);
				
				$xml->fin_rama();
				$xml->mostrar_xml();
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