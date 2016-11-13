<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarTipoProceso.php
Propósito:				Permite insertar y modificar datos en la tabla tfl_tipo_proceso
Tabla:					tfl_tipo_proceso
Parámetros:				$id_tipo_proceso
						$codigo
					    $nombre_proceso
						$estado_reg
						$id_usuario_reg

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2010-08-19 10:28:40
Versión:				1.0.0
Autor:					Williams Escobar
**********************************************************
*/
session_start();
include_once("../LibModeloFlujo.php");

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = "ActionEditarTipoProceso.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
	if(isset($m_id_tipo_proceso)){
		
		// PRIMERO SE OBTIENEN LOS CAMPOS NECESARIOS PARA UN UPDATE DE ESE PROCESO
		$res = $Custom->ListarTipoProceso(1,0,'id_tipo_proceso asc','asc'," TIPPRO.id_tipo_proceso = $m_id_tipo_proceso",$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		if($res){
			foreach($Custom->salida as $f){
				$codigo	= $f['codigo'];
				$nombre_proceso=$f['nombre_proceso'];
				$estado = $f['estado'];
				$id_nodo_inicio = $f['id_nodo_inicio'];
				$id_formulario_inicio = $f['id_formulario_inicio'];
			}
			
			$res = $Custom->ModificarTipoProceso($m_id_tipo_proceso,$codigo,$nombre_proceso,'pendiente',$id_nodo_inicio,$id_formulario_inicio);
			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
	}
	else{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = El id_tipo_proceso es nulo.";
		$resp->origen = "ORIGEN = ";
		$resp->proc = "PROC = ";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
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