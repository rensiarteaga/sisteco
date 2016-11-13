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
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = "ActionGuardarCuentaArb.php";

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
			$res=$Custom->EliminarCuentaRaiz($nodo['id']);
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
			$res = $Custom->EliminarCuentaArb($nodo['id'],$nodo['id_p']);
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
			$res = $Custom -> InsertarCuentaRaiz($nodo['id'],$nodo['nro_cuenta'],$nodo['nombre_raiz'],$nodo['desc_cuenta'],$nodo['nivel_cuenta'],$nodo['tipo_cuenta'],
					$nodo['sw_transaccional'],$nodo['id_p'],$nodo['id_parametro'],$nodo['id_moneda'],$nodo['sw_oec'],$nodo['sw_aux'],$nodo['cuenta_sigma'],$nodo['sw_sigma'],
					$nodo['id_cuenta_actualizacion'],$nodo['id_auxiliar_actualizacion'],$nodo['sw_sistema_actualizacion'],$nodo['id_cuenta_dif'],$nodo['id_auxiliar_dif'],
					$nodo['cuenta_flujo_sigma'],$nodo['nota_eeff'],$nodo['id_cuenta_sigma']);
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
			$res = $Custom -> InsertarCuentaArb($nodo['id'],$nodo['nro_cuenta'],$nodo['nombre_cuenta'],$nodo['desc_cuenta'],$nodo['nivel_cuenta'],$nodo['tipo_cuenta'],
					$nodo['sw_transaccional'],$nodo['id_p'],$nodo['id_parametro'],$nodo['id_moneda'],$nodo['sw_oec'],$nodo['sw_aux'],$nodo['cuenta_sigma'],$nodo['sw_sigma'],
					$nodo['id_cuenta_actualizacion'],$nodo['id_auxiliar_actualizacion'],$nodo['sw_sistema_actualizacion'],$nodo['id_cuenta_dif'],$nodo['id_auxiliar_dif'],
					$nodo['cuenta_flujo_sigma'],$nodo['nota_eeff'],$nodo['id_cuenta_sigma']);
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
		$res=$Custom->ModificarCuentaArb($nodo['id'],$nodo['nro_cuenta'],$nodo['nombre_cuenta'],$nodo['desc_cuenta'],$nodo['nivel_cuenta'],$nodo['tipo_cuenta'],
				$nodo['sw_transaccional'],$nodo['id_p'],$nodo['id_parametro'],$nodo['id_moneda'],$nodo['sw_oec'],$nodo['sw_aux'],$nodo['cuenta_sigma'],$nodo['sw_sigma'],
				$nodo['id_cuenta_actualizacion'],$nodo['id_auxiliar_actualizacion'],$nodo['sw_sistema_actualizacion'],$nodo['id_cuenta_dif'],$nodo['id_auxiliar_dif'],
				$nodo['cuenta_flujo_sigma'],$nodo['nota_eeff'],$nodo['id_cuenta_sigma']);
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