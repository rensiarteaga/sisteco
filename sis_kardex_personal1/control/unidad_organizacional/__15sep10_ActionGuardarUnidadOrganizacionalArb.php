<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarUnidadOrganizacionalArb.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_unidad_organizacional
Tabla:					tkp_unidad_organizacional
Parámetros:				$hidden_id_tipo_unidad_constructiva
						$txt_codigo
						$txt_nombre
						$txt_tipo
						$txt_descripcion
						$txt_observaciones
						$txt_fecha_reg

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-11-07 15:46:18
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarUnidadOrganizacionalArb.php";

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
			$res=$Custom->EliminarUnidadOrganizacionalRaiz($nodo['id']);
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
			$res = $Custom->EliminarUnidadOrganizacionalArb($nodo['id'],$nodo['id_p']);
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
			$res = $Custom -> InsertarUnidadOrganizacionalRaiz($nodo['id'],$nodo['id_p'],$nodo['relacion'],$nodo['observaciones'],$nodo['nombre_unidad'],$nodo['nombre_cargo'],$nodo['centro'],$nodo['cargo_individual'],$nodo['descripcion'],$nodo['id_nivel_organizacional'],$nodo['id_pn'],$nodo['estado_reg'],$nodo['importe_max_apro'],$nodo['importe_max_pre']);
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
			
			$res = $Custom -> InsertarUnidadOrganizacionalArb($nodo['id'],$nodo['id_p'],$nodo['relacion'],$nodo['observaciones'],$nodo['nombre_unidad'],$nodo['nombre_cargo'],$nodo['centro'],$nodo['cargo_individual'],$nodo['descripcion'],$nodo['id_nivel_organizacional'],$nodo['id_pn'],$nodo['estado_reg'],$nodo['importe_max_apro'],$nodo['importe_max_pre'],$nodo['sw_presto']);
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
		//Verifica si es una inserción de TUC y modificación de Composición simultaneo
		              
		$res=$Custom->ModificarUnidadOrganizacionalArb($nodo['id'],$nodo['id_p'],$nodo['relacion'],$nodo['observaciones'],$nodo['nombre_unidad'],$nodo['nombre_cargo'],$nodo['centro'],$nodo['cargo_individual'],$nodo['descripcion'],$nodo['id_nivel_organizacional'],$nodo['id_pn'],$nodo['estado_reg'],$nodo['importe_max_apro'],$nodo['importe_max_pre'],$nodo['sw_presto']);
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
	elseif($proc==='copy')  //para desbloque un TUC (estado = borrador)
	{
		$res = $Custom ->CopiarUnidadOrganizacional($nodo['id'],$nodo['id_p'],$nodo['id_pn'],$nodo['cantidad'],$nodo['opcional']);
		if(!$res)
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1] ;
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit;
			$tmp['success'] = $Custom->salida[0]=='f' ? 'false':'true';
			echo json_encode($tmp);
			exit;
		}
		$tmp['success'] ='true';
		echo json_encode($tmp);
		exit;

	}
	elseif($proc==='dd'){
	     $res = $Custom ->DragAndDrop($nodo['id'],$nodo['id_p'],$nodo['id_pn']);
		if(!$res)
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1] ;
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit;
			$tmp['success'] = $Custom->salida[0]=='f' ? 'false':'true';
			echo json_encode($tmp);
			exit;
		}
		$tmp['success'] ='true';
		$tmp['id_padre'] =$nodo['id'];
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