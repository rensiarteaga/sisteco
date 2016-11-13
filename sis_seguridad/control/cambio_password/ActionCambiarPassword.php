<?php

/*
 * Nombre:	        ActionPDFDetalleDepreciacion.php
 * Propósito:		Genera un listado para el reporte a detalle de depreciaciones
 * Autor:			Marcos A. Flores Valda 
 * Fecha:			24 - 01 - 11
 */
session_start();
include_once("../LibModeloSeguridad.php");

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = "ActionGuardarPassword.php";

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{	
	$id_usuario = $_SESSION["ss_id_usuario"];
	$contrasenia_ant = $txt_contrasenia_ant;
	$contrasenia_nueva = $txt_contrasenia_nueva;
	$confirmacion = $txt_confirmacion;
	$estilo = $txt_estilo;
	$filtro_avanzado = $txt_filtro_avanzado;
	$mod_contrasenia = $txt_mod_contrasenia;
	$autentificacion = $txt_autentificacion;
	$clave_ldap = base64_decode($txt_contrasenia_win);
	
	//Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0)
	{
		$get=true;
		$cont=1;
		
		//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
		//valores permitidos de $cod -> "si", "no"
		switch ($cod)
		{
			case "si":
				$decodificar = true;
				break;
			case "no":
				$decodificar = false;
				break;
			default:
				$decodificar = true;
				break;
		}
	}
	elseif(sizeof($_POST) > 0)
	{
		$get = false;
		$cont =  $_POST["cantidad_ids"];
		
		//Por Post siempre se decodifica
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
	
	
	$Custom->decodificar = $decodificar;	
	
	
	
	if($autentificacion=='ldap')
		{
			ini_set('display_errors',0);
			$conex = ldap_connect("ende.bo",389) or die ("No ha sido posible conectarse al servidor"); 
			
			ldap_set_option($conex, LDAP_OPT_PROTOCOL_VERSION, 3);
			
			if ($conex) 
			{ 
				// bind with appropriate dn to give update access 
				$r = ldap_bind($conex,trim($_SESSION["ss_usuario"])."@ende.bo",addslashes(htmlentities(trim($clave_ldap),ENT_QUOTES)));
								
				if ($r) 
				{
					$SW_LDAP=TRUE;
				}
				else 
				{
		//			$SW_LDAP=FALSE; 
					//Se produjo un error
					$resp = new cls_manejo_mensajes(true, "406");
					$resp->mensaje_error = 'SU CONTRASEÑA ES INCORRECTA O NO ESTA REGISTRADO EN EL DOMINIO';
					$resp->origen ="";
					$resp->proc = "";
					$resp->nivel = "";
					$resp->query = "";
					echo $resp->get_mensaje();
					exit;
				}
				
				ldap_close($conex); 
		}
	}

	$res = $Custom -> ValidarClave($id_usuario,$contrasenia_ant,$contrasenia_nueva,$confirmacion,$estilo,$filtro_avanzado,$mod_contrasenia,$autentificacion);	
	
	if($Custom->salida[1] = 'Modificación exitosa en sss.tsg_usuario' && $Custom->salida[2] == 1)
	{
		if($contrasenia_nueva == $confirmacion)
		{
			$_SESSION["ss_contrasenia"] = md5('!"·$%&/()=1234567890'.$contrasenia_nueva);	
			$_SESSION["CONTRASENA"] = md5('!"·$%&/()=1234567890'.$contrasenia_nueva);	 
			$_SESSION["ss_autentificacion"] = $autentificacion;
		}
		
		else 
		{
			//Se produjo un error
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = 'LOS DATOS NUEVOS NO COINCIDEN';
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit;
		}
	}
	

	if(!$res)
	{				
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true, "406");
		//$resp->mensaje_error = $Custom->salida[1];
		$resp->mensaje_error = 'ERROR EN LA INFORMACIÓN';
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;
	}
								
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
	exit;
}
?>
