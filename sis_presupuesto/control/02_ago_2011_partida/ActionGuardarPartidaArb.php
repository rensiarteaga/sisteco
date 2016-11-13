<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPartidaArb.php
Propósito:				Permite insertar y modificar datos en la tabla tpr_partida
Tabla:					tpr_partida

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-11-07 15:46:18
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarPartidaArb.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{

	$decodificado = stripslashes($_REQUEST['datos']);
	$proceso=stripslashes($_REQUEST['proc']);

	$nodo = json_decode($decodificado,true);

	/*	echo "proc:".$proc;
	echo "tipo:".$nodo['tipo'];
	exit;*/

	//Selección de procedimiento a ejecutar en la BD
	if($proc==='del'){
		if($nodo['id_p']=='' || $nodo['id_p']=='undefined'){
			$res=$Custom->EliminarPartidaRaiz($nodo['id']);
			if(!$res){
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
		else{
			$res = $Custom->EliminarPartidaArb($nodo['id'],$nodo['id_p']);
			if(!$res){
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
      	//Devuelve el mensaje de éxito
		$mensaje_exito = $Custom->salida[1];
		$resp = new cls_manejo_mensajes(false);
		$resp->add_nodo("mensaje",$mensaje_exito);
		$resp->add_nodo("tiempo_resp", "200");
		echo $resp->get_mensaje();
		exit;
	}
	elseif($proc==='add'){
		if($nodo['id_p']=='' || $nodo['id_p']=='undefined' || $nodo['id_p']=='null'){
			$res = $Custom -> InsertarPartidaRaiz($nodo['id'],$nodo['codigo_partida'],$nodo['nombre_partida'],$nodo['nivel_partida'],$nodo['sw_transaccional'],$nodo['tipo_partida'],$nodo['id_parametro'],$nodo['id_p'],$nodo['tipo_memoria'],$nodo['desc_partida']);
			if(!$res){
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;

			}
			$tmp['id'] = $Custom->salida[2];
			echo json_encode($tmp);
			exit;
		}
		else{
			$res = $Custom -> InsertarPartidaArb($nodo['id'],$nodo['codigo_partida'],$nodo['nombre_partida'],$nodo['nivel_partida'],$nodo['sw_transaccional'],$nodo['tipo_partida'],$nodo['id_parametro'],$nodo['id_p'],$nodo['tipo_memoria'],$nodo['desc_partida'],$nodo['sw_movimiento'],$nodo['id_concepto_colectivo'],$nodo['id_oec_sigma'],$nodo['ent_trf']);
			if(!$res){
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;

			}
			$tmp['id'] = $Custom->salida[2];
			echo json_encode($tmp);
			exit;
		}
		//Devuelve el Id del TUC creado
		$tmp['success'] = 'true';
		echo json_encode($tmp);
		exit;

	}
	elseif($proc==='upd'){
			              
		$res=$Custom->ModificarPartidaArb($nodo['id'],$nodo['codigo_partida'],$nodo['nombre_partida'],$nodo['nivel_partida'],$nodo['sw_transaccional'],$nodo['tipo_partida'],$nodo['id_parametro'],$nodo['id_p'],$nodo['tipo_memoria'],$nodo['desc_partida'],$nodo['sw_movimiento'],$nodo['id_concepto_colectivo'],$nodo['id_oec_sigma'],$nodo['ent_trf']);
			if(!$res){
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}

			//Devuelve el Id del TUC creado
			$tmp['id'] = $Custom->salida[2];
			echo json_encode($tmp);
			exit;		
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "401");
		$resp->mensaje_error = "MENSAJE ERROR = Proceso no identificado";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = "NIVEL = 1";
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