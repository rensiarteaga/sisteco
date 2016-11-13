<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPersona.php
Propósito:				Permite insertar y modificar datos en la tabla tsg_persona
Tabla:					tsg_tsg_persona
Parámetros:				$hidden_id_persona
						$txt_apellido_paterno
						$txt_apellido_materno
						$txt_nombre
						$txt_fecha_nacimiento
						$txt_foto_persona
						$txt_doc_id
						$txt_genero
						$txt_casilla
						$txt_telefono1
						$txt_telefono2
						$txt_celular1
						$txt_celular2
						$txt_pag_web
						$txt_email1
						$txt_email2
						$txt_email3
						$txt_fecha_registro
						$txt_hora_registro
						$txt_fecha_ultima_modificacion
						$txt_hora_ultima_modificacion
						$txt_observaciones
						$txt_id_tipo_doc_identificacion

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-25 17:19:23
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloSeguridad.php");

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = "ActionGuardarPersona.php";

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
			$hidden_id_persona= $_GET["hidden_id_persona_$j"];
			$txt_apellido_paterno= $_GET["txt_apellido_paterno_$j"];
			$txt_apellido_materno= $_GET["txt_apellido_materno_$j"];
			$txt_nombre= $_GET["txt_nombre_$j"];
			$txt_fecha_nacimiento= $_GET["txt_fecha_nacimiento_$j"];
			//$txt_foto_persona= $_GET["txt_foto_persona_$j"];		
			$txt_doc_id= $_GET["txt_doc_id_$j"];
			$txt_genero= $_GET["txt_genero_$j"];
			$txt_casilla= $_GET["txt_casilla_$j"];
			$txt_telefono1= $_GET["txt_telefono1_$j"];
			$txt_telefono2= $_GET["txt_telefono2_$j"];
			$txt_celular1= $_GET["txt_celular1_$j"];
			$txt_celular2= $_GET["txt_celular2_$j"];
			$txt_pag_web= $_GET["txt_pag_web_$j"];
			$txt_email1= $_GET["txt_email1_$j"];
			$txt_email2= $_GET["txt_email2_$j"];
			$txt_email3= $_GET["txt_email3_$j"];
			$txt_fecha_registro= $_GET["txt_fecha_registro_$j"];
			$txt_hora_registro= $_GET["txt_hora_registro_$j"];
			$txt_fecha_ultima_modificacion= $_GET["txt_fecha_ultima_modificacion_$j"];
			$txt_hora_ultima_modificacion= $_GET["txt_hora_ultima_modificacion_$j"];
			$txt_observaciones= $_GET["txt_observaciones_$j"];
			$txt_id_tipo_doc_identificacion= $_GET["txt_id_tipo_doc_identificacion_$j"];
			$txt_direccion= $_GET["txt_direccion_$j"];
			$txt_nro_registro= $_GET["txt_nro_registro_$j"];
			$tipo= $_GET["tipo_$j"];
			$tipo_emp= $_GET["tipo_emp_$j"];
			$expedicion= $_GET["expedicion_$j"];
			//24.04.2014: adicion de 2 campos pro req de rrhh
			
			$apellido_casada= $_GET["apellido_casada_$j"];  
			$libreta_militar= $_GET["libreta_militar_$j"];
			$num_complementario_doc_identif= $_GET["num_complementario_doc_identif_$j"];
		}
		else
		{
			$hidden_id_persona=$_POST["hidden_id_persona_$j"];
			$txt_apellido_paterno=$_POST["txt_apellido_paterno_$j"];
			$txt_apellido_materno=$_POST["txt_apellido_materno_$j"];
			$txt_nombre=$_POST["txt_nombre_$j"];
			$txt_fecha_nacimiento=$_POST["txt_fecha_nacimiento_$j"];
			//$txt_foto_persona=$_POST["txt_foto_persona_$j"];
			$txt_doc_id=$_POST["txt_doc_id_$j"];
			$txt_genero=$_POST["txt_genero_$j"];
			$txt_casilla=$_POST["txt_casilla_$j"];
			$txt_telefono1=$_POST["txt_telefono1_$j"];
			$txt_telefono2=$_POST["txt_telefono2_$j"];
			$txt_celular1=$_POST["txt_celular1_$j"];
			$txt_celular2=$_POST["txt_celular2_$j"];
			$txt_pag_web=$_POST["txt_pag_web_$j"];
			$txt_email1=$_POST["txt_email1_$j"];
			$txt_email2=$_POST["txt_email2_$j"];
			$txt_email3=$_POST["txt_email3_$j"];
			$txt_fecha_registro=$_POST["txt_fecha_registro_$j"];
			$txt_hora_registro=$_POST["txt_hora_registro_$j"];
			$txt_fecha_ultima_modificacion=$_POST["txt_fecha_ultima_modificacion_$j"];
			$txt_hora_ultima_modificacion=$_POST["txt_hora_ultima_modificacion_$j"];
			$txt_observaciones=$_POST["txt_observaciones_$j"];
			$txt_id_tipo_doc_identificacion=$_POST["txt_id_tipo_doc_identificacion_$j"];
			$txt_direccion= $_POST["txt_direccion_$j"];
			$txt_nro_registro= $_POST["txt_nro_registro_$j"];
			$tipo= $_POST["tipo_$j"];
			$tipo_emp= $_POST["tipo_emp_$j"];
			$expedicion= $_POST["expedicion_$j"];
			//24.04.2014: adicion de 2 campos pro req de rrhh
			
			 $txt_apellido_casada= $_POST["txt_apellido_casada_$j"];
		 	 $txt_libreta_militar=$_POST["txt_libreta_militar_$j"];
		 	 $txt_num_complementario_doc_identif= $_POST["txt_num_complementario_doc_identif_$j"];
		}
		
		/*$txt_foto_persona = $_FILES['foto']['tmp_name'];
		$nombre_foto = $_FILES['foto']['name'];
		$extension = explode("/",$_FILES['foto']['type']);*/
		
		$txt_foto_persona = '';
		$nombre_foto = '';
		$extension = '';
		
		//$f = new funciones();
     /*   $type     =$HTTP_POST_FILES["txt_foto_persona_0"]["type"];
        $tmp_name = $_FILES["txt_foto_persona_0"]["tmp_name"];
        $size     = $_FILES["txt_foto_persona_0"]["size"];
        echo "nombre de la foto espero que salga bien :(".$type;
        $nombre   = basename($_FILES["txt_foto_persona_0"]["name"]);
        echo "nombre de la foto-".$nombre;
        $fp       = fopen($tmp_name, "rb");
        $txt_foto_persona   = fread($fp, filesize($tmp_name));
        fclose($fp);
*/       //13Abr11: para generar mail1 en funcionarios de acuerdo a estandar de creacion de correos
               if(substr($tipo,0,8)=='empleado'){
              	   $txt_nro_registro='empleado';
         
              }
         
		if ($hidden_id_persona == "undefined" || $hidden_id_persona == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarPersona("insert",$hidden_id_persona, $txt_apellido_paterno,$txt_apellido_materno,$txt_nombre,$txt_fecha_nacimiento,$txt_foto_persona,$txt_doc_id,$txt_genero,$txt_casilla,$txt_telefono1,$txt_telefono2,$txt_celular1,$txt_celular2,$txt_pag_web,$txt_email1,$txt_email2,$txt_email3,$txt_fecha_registro,$txt_hora_registro,$txt_fecha_ultima_modificacion,$txt_hora_ultima_modificacion,$txt_observaciones,$txt_id_tipo_doc_identificacion);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tsg_persona
			$res = $Custom -> InsertarPersona($hidden_id_persona, $txt_apellido_paterno, $txt_apellido_materno, $txt_nombre, $txt_fecha_nacimiento, $txt_foto_persona, $txt_doc_id, $txt_genero, $txt_casilla, $txt_telefono1, $txt_telefono2, $txt_celular1, $txt_celular2, $txt_pag_web, $txt_email1, $txt_email2, $txt_email3, $txt_fecha_registro, $txt_hora_registro, $txt_fecha_ultima_modificacion, $txt_hora_ultima_modificacion, $txt_observaciones, $txt_id_tipo_doc_identificacion,$txt_direccion,$txt_nro_registro,$nombre_foto,$numero,$extension[1],$expedicion
					//24.04.2014
					,$txt_apellido_casada, $txt_libreta_militar , $txt_num_complementario_doc_identif
					);

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
			$res = $Custom->ValidarPersona("update",$hidden_id_persona, $txt_apellido_paterno, $txt_apellido_materno, $txt_nombre, $txt_fecha_nacimiento, $txt_foto_persona, $txt_doc_id, $txt_genero, $txt_casilla, $txt_telefono1, $txt_telefono2, $txt_celular1, $txt_celular2, $txt_pag_web, $txt_email1, $txt_email2, $txt_email3, $txt_fecha_registro, $txt_hora_registro, $txt_fecha_ultima_modificacion, $txt_hora_ultima_modificacion, $txt_observaciones, $txt_id_tipo_doc_identificacion);

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
			
	if($tipo_emp=='sel_per'){ 
		$res = $Custom->ModificarPersonaEmpleado($hidden_id_persona, $txt_apellido_paterno, $txt_apellido_materno, $txt_nombre, $txt_fecha_nacimiento, $txt_foto_persona, $txt_doc_id, $txt_genero, $txt_casilla, $txt_telefono1, $txt_telefono2, $txt_celular1, $txt_celular2, $txt_pag_web, $txt_email1, $txt_email2, $txt_email3, $txt_fecha_registro, $txt_hora_registro, $txt_fecha_ultima_modificacion, $txt_hora_ultima_modificacion, $txt_observaciones, $txt_id_tipo_doc_identificacion,$txt_direccion,$txt_nro_registro,$nombre_foto,$numero,$extension[1],$expedicion
				
				);
	
	}else{ 
			$res = $Custom->ModificarPersona($hidden_id_persona, $txt_apellido_paterno, $txt_apellido_materno, $txt_nombre, $txt_fecha_nacimiento, $txt_foto_persona, $txt_doc_id, $txt_genero, $txt_casilla, $txt_telefono1, $txt_telefono2, $txt_celular1, $txt_celular2, $txt_pag_web, $txt_email1, $txt_email2, $txt_email3, $txt_fecha_registro, $txt_hora_registro, $txt_fecha_ultima_modificacion, $txt_hora_ultima_modificacion, $txt_observaciones, $txt_id_tipo_doc_identificacion,$txt_direccion,$txt_nro_registro,$nombre_foto,$numero,$extension[1],$expedicion
				//24.04.2014
				,$txt_apellido_casada, $txt_libreta_militar, $txt_num_complementario_doc_identif
					);
	}		
			if($res)
				//unlink('../../control/persona/archivo/'.$Custom->salida[2].'.'.$Custom->salida[3]);

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

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_persona";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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