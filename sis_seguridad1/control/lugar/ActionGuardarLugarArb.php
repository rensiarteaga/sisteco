<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarLugarArb.php
Propósito:				Permite insertar y modificar datos en la tabla tsg_lugar 
Tabla:					tsg_lugar
Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-25-03 08:36:13
Versión:				1.0.0
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once("../LibModeloSeguridad.php");

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = "ActionGuardarLugarArb.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
	
	$decodificado = stripslashes($_REQUEST['datos']);
	$proceso=stripslashes($_REQUEST['proc']);

	$nodo = json_decode($decodificado,true);

	  if($proc==='dd'){
	  	
	   		if($nodo['tipo']=='hoja'){
	   		
	   		  $res = $Custom -> DropLugarHoja($nodo['id'],$nodo['id_pn'],$nodo['tipo']);
	   		 
			  if(!$res){
				
			  	$tmp['success'] = 'false';
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
		elseif ($proc==='add'){
		  // if($nodo['tipo']=='raiz'){
			$res= $Custom->InsertarLugar($nodo['id'],$nodo['id_p'],0,$nodo['txt_codigo'],$nodo['txt_nombre'],$nodo['txt_ubicacion'],$nodo['txt_telefono1'],$nodo['txt_telefono2'],$nodo['txt_fax'],$nodo['observacion'],$nodo['txt_sw_municipio'],$nodo['txt_sw_impuesto'],$nodo['prioridad_kard'],$nodo['txt_sigla_sigma']);
			  if(!$res){
			  	$tmp['success'] = 'false';
				echo json_encode($tmp);
				exit;
			 	$resp= new cls_manejo_mensajes(true,"406");
			 	$resp->mensaje_error= $Custom->salida[1];
			 	$resp->origen =$Custom->salida[2];
			 	$resp->proc=$Custom->salida[3];
			 	$resp->nivel=$Custom->salida[4];
			 	$resp->query = $Custom->query;
			 	echo $resp->get_mensaje();
			 	exit;
			 }else{
			 	$tmp['success'] = 'true';
				echo json_encode($tmp);
				exit;
			 }
			
			
		}elseif($proc==='del'){
			
				$res= $Custom->EliminarLugar($nodo['id']);
				if(!$res){
					$resp= new cls_manejo_mensajes(true,"406");
					$resp->mensaje_error= $Custom->salida[1];
					$resp->origen=$Custom->salida[2];
					$resp->proc=$Custom->salida[3];
					$resp->nivel=$Custom->salida[4];
					$resp->query=$Custom->query;
					echo $resp->get_mensaje();
					exit;
				}
			
		}
        elseif ($proc==='upd'){
         
		  // if($nodo['tipo']=='raiz'){
			$res= $Custom->ModificarLugar($nodo['id'],$nodo['id_p'],0,$nodo['txt_codigo'],$nodo['txt_nombre'],$nodo['txt_ubicacion'],$nodo['txt_telefono1'],$nodo['txt_telefono2'],$nodo['txt_fax'],$nodo['observacion'],$nodo['txt_sw_municipio'],$nodo['txt_sw_impuesto'],$nodo['prioridad_kard'],$nodo['txt_sigla_sigma']);
			  if(!$res){ 
			  	$tmp['success'] = 'false';
				echo json_encode($tmp);
				exit;
			 	$resp= new cls_manejo_mensajes(true,"406");
			 	$resp->mensaje_error= $Custom->salida[1];
			 	$resp->origen =$Custom->salida[2];
			 	$resp->proc=$Custom->salida[3];
			 	$resp->nivel=$Custom->salida[4];
			 	$resp->query = $Custom->query;
			 	echo $resp->get_mensaje();
			 	exit;
			 	
			 }
else{
			 	$tmp['success'] = 'true';
				echo json_encode($tmp);
				exit;
			 }
			
			
		}

		
		
		
}
?>