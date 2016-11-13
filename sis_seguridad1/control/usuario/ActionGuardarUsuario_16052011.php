<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarUsuario.php
Propósito:				Permite insertar y modificar datos en la tabla tsg_usuario
Tabla:					tsg_tsg_usuario
Parámetros:				$hidden_id_usuario
						$txt_id_persona
						$txt_login
						$txt_contrasenia
						$txt_fecha_registro
						$txt_hora_registro
						$txt_fecha_ultima_modificacion
						$txt_hora_ultima_modificacion
						$txt_estado_usuario
						$txt_estilo_usuario
						$txt_filtro_avanzado

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-26 17:44:04
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloSeguridad.php");

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = "ActionGuardarUsuario.php";

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
	
	//Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;

	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$hidden_id_usuario= $_GET["hidden_id_usuario_$j"];
			$txt_id_persona= $_GET["txt_id_persona_$j"];
			$txt_login= $_GET["txt_login_$j"];
			$txt_contrasenia= $_GET["txt_contrasenia_$j"];
			$txt_fecha_registro= $_GET["txt_fecha_registro_$j"];
			$txt_hora_registro= $_GET["txt_hora_registro_$j"];
			$txt_fecha_ultima_modificacion= $_GET["txt_fecha_ultima_modificacion_$j"];
			$txt_hora_ultima_modificacion= $_GET["txt_hora_ultima_modificacion_$j"];
			$txt_estado_usuario= $_GET["txt_estado_usuario_$j"];
			$txt_estilo_usuario= $_GET["txt_estilo_usuario_$j"];
			$txt_filtro_avanzado= $_GET["txt_filtro_avanzado_$j"];
			$txt_fecha_expiracion= $_GET["txt_fecha_expiracion_$j"];
			$txt_autentificacion= $_GET["txt_autentificacion_$j"];
		}
		else
		{
			$hidden_id_usuario=$_POST["hidden_id_usuario_$j"];
			$txt_id_persona=$_POST["txt_id_persona_$j"];
			$txt_login=$_POST["txt_login_$j"];
			$txt_contrasenia=$_POST["txt_contrasenia_$j"];
			$txt_fecha_registro=$_POST["txt_fecha_registro_$j"];
			$txt_hora_registro=$_POST["txt_hora_registro_$j"];
			$txt_fecha_ultima_modificacion=$_POST["txt_fecha_ultima_modificacion_$j"];
			$txt_hora_ultima_modificacion=$_POST["txt_hora_ultima_modificacion_$j"];
			$txt_estado_usuario=$_POST["txt_estado_usuario_$j"];
			$txt_estilo_usuario=$_POST["txt_estilo_usuario_$j"];
			$txt_filtro_avanzado=$_POST["txt_filtro_avanzado_$j"];
			$txt_fecha_expiracion= $_POST["txt_fecha_expiracion_$j"];
			$txt_autentificacion= $_POST["txt_autentificacion_$j"];
		}


		if ($hidden_id_usuario == "undefined" || $hidden_id_usuario == "")
		{//echo $j;
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarUsuario("insert",$hidden_id_usuario, $txt_id_persona,$txt_login,$txt_contrasenia,$txt_fecha_registro,$txt_hora_registro,$txt_fecha_ultima_modificacion,$txt_hora_ultima_modificacion,$txt_estado_usuario,$txt_estilo_usuario,$txt_filtro_avanzado,$txt_autentificacion);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tsg_usuario
			$res = $Custom -> InsertarUsuario($hidden_id_usuario, $txt_id_persona, $txt_login, $txt_contrasenia, $txt_fecha_registro, $txt_hora_registro, $txt_fecha_ultima_modificacion, $txt_hora_ultima_modificacion, $txt_estado_usuario, $txt_estilo_usuario, $txt_filtro_avanzado,$txt_fecha_expiracion,$txt_autentificacion);

			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1]." (iteración $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
		else
		{
			if($_POST["txt_contrasenia_nueva_$j"]=='' and $_POST["txt_estilo_usuario_$j"]!=''){
			///////////////////////Modificación////////////////////
			  //Validación de datos (del lado del servidor)
					$res = $Custom->ValidarUsuario("update",$hidden_id_usuario, $txt_id_persona, $txt_login, $txt_contrasenia, $txt_fecha_registro, $txt_hora_registro, $txt_fecha_ultima_modificacion, $txt_hora_ultima_modificacion, $txt_estado_usuario, $txt_estilo_usuario, $txt_filtro_avanzado, $txt_autentificacion);
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
			
					$res = $Custom->ModificarUsuario($hidden_id_usuario, $txt_id_persona, $txt_login, $txt_contrasenia, $txt_fecha_registro, $txt_hora_registro, $txt_fecha_ultima_modificacion, $txt_hora_ultima_modificacion, $txt_estado_usuario, $txt_estilo_usuario, $txt_filtro_avanzado,$txt_fecha_expiracion, $txt_autentificacion);
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
			else{
				$txt_contrasenia_nueva= $_POST["txt_contrasenia_nueva_0"];
				$txt_contrasenia_nueva_rep= $_POST["txt_contrasenia_nueva_rep_0"];
				$txt_estilo_usuario=$_POST["txt_estilo_usuarios_0"];
				$res=$Custom->ModificarUsuarioPref($hidden_id_usuario,$txt_contrasenia,$txt_contrasenia_nueva,$txt_contrasenia_nueva_rep,$txt_estilo_usuario);
				if(!$res){
					$resp= new cls_manejo_mensajes(true,"406");
					$resp->mensaje_error= $Custom->salida[1];
					$resp->origen=$Custom->salida[2];
					$resp->proc= $Custom->salida[3];
					$resp->nivel=$Custom->salida[4];
					$resp->query=$Custom->query;
					echo $resp->get_mensaje();
					exit;
				}
				
			}
			
			
		}
		
	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_usuario";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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
	exit;
}
?>