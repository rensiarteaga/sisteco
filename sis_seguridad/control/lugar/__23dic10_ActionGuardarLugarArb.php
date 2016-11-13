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
			$res= $Custom->InsertarLugar($nodo['id'],$nodo['id_p'],0,$nodo['txt_codigo'],$nodo['txt_nombre'],$nodo['txt_ubicacion'],$nodo['txt_telefono1'],$nodo['txt_telefono2'],$nodo['txt_fax'],$nodo['observacion'],$nodo['txt_sw_municipio']);
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
			$res= $Custom->ModificarLugar($nodo['id'],$nodo['id_p'],0,$nodo['txt_codigo'],$nodo['txt_nombre'],$nodo['txt_ubicacion'],$nodo['txt_telefono1'],$nodo['txt_telefono2'],$nodo['txt_fax'],$nodo['observacion'],$nodo['txt_sw_municipio']);
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

		
		
		/*if ($hidden_id_rol_metaproceso == "undefined" || $hidden_id_rol_metaproceso == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarRolMetaproceso("insert",$hidden_id_rol_metaproceso, $txt_id_rol,$txt_id_metaproceso);

			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			//Validación satisfactoria, se ejecuta la inserción en la tabla tsg_rol_metaproceso
			$res = $Custom -> InsertarRolMetaproceso($hidden_id_rol_metaproceso, $txt_id_rol, $txt_id_metaproceso);

			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
		else
		{	///////////////////////Modificación////////////////////
			
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarRolMetaproceso("update",$hidden_id_rol_metaproceso, $txt_id_rol, $txt_id_metaproceso);

			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			$res = $Custom->ModificarRolMetaproceso($hidden_id_rol_metaproceso, $txt_id_rol, $txt_id_metaproceso);

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

	}//END FOR*/

	//Guarda el mensaje de éxito de la operación realizada
	/*if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_rol_metaproceso";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "RROOLL.id_rol=''$m_id_rol''";

	$res = $Custom->ContarRolMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", $total_registros);
	$resp->add_nodo("mensaje", $mensaje_exito);
	$resp->add_nodo("tiempo_resp", "200");
	echo $resp->get_mensaje();
	exit;
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit;*/
}
?>