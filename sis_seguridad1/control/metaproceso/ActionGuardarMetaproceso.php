<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarMetaproceso.php
Propósito:				Permite insertar y modificar datos en la tabla tsg_metaproceso
Tabla:					tsg_tsg_metaproceso
Parámetros:				$hidden_id_metaproceso
						$txt_id_subsistema
						$txt_fk_id_metaproceso
						$txt_nivel
						$txt_nombre
						$txt_codigo_procedimiento
						$txt_nombre_achivo
						$txt_ruta_archivo
						$txt_fecha_registro
						$txt_hora_registro
						$txt_fecha_ultima_modificacion
						$txt_hora_ultima_modificacion
						$txt_descripcion
						$txt_visible
						$txt_habilitar_log
						$txt_orden_logico
						$txt_icono
						$txt_nombre_tabla
						$txt_prefijo
						$txt_codigo_base
						$txt_tipo_vista
						$txt_con_ep
						$txt_con_interfaz
						$txt_num_datos_hijo

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-26 16:42:30
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloSeguridad.php");

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = "ActionGuardarMetaproceso.php";

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
			$hidden_id_metaproceso= $_GET["hidden_id_metaproceso_$j"];
			$txt_id_subsistema= $_GET["txt_id_subsistema_$j"];
			$txt_fk_id_metaproceso= $_GET["txt_fk_id_metaproceso_$j"];
			$txt_nivel= $_GET["txt_nivel_$j"];
			$txt_nombre= $_GET["txt_nombre_$j"];
			$txt_codigo_procedimiento= $_GET["txt_codigo_procedimiento_$j"];
			$txt_nombre_achivo= $_GET["txt_nombre_achivo_$j"];
			$txt_ruta_archivo= $_GET["txt_ruta_archivo_$j"];
			$txt_fecha_registro= $_GET["txt_fecha_registro_$j"];
			$txt_hora_registro= $_GET["txt_hora_registro_$j"];
			$txt_fecha_ultima_modificacion= $_GET["txt_fecha_ultima_modificacion_$j"];
			$txt_hora_ultima_modificacion= $_GET["txt_hora_ultima_modificacion_$j"];
			$txt_descripcion= $_GET["txt_descripcion_$j"];
			$txt_visible= $_GET["txt_visible_$j"];
			$txt_habilitar_log= $_GET["txt_habilitar_log_$j"];
			$txt_orden_logico= $_GET["txt_orden_logico_$j"];
			$txt_icono= $_GET["txt_icono_$j"];
			$txt_nombre_tabla= $_GET["txt_nombre_tabla_$j"];
			$txt_prefijo= $_GET["txt_prefijo_$j"];
			$txt_codigo_base= $_GET["txt_codigo_base_$j"];
			$txt_tipo_vista= $_GET["txt_tipo_vista_$j"];
			$txt_con_ep= $_GET["txt_con_ep_$j"];
			$txt_con_interfaz= $_GET["txt_con_interfaz_$j"];
			$txt_num_datos_hijo= $_GET["txt_num_datos_hijo_$j"];

		}
		else
		{
			$hidden_id_metaproceso=$_POST["hidden_id_metaproceso_$j"];
			$txt_id_subsistema=$_POST["txt_id_subsistema_$j"];
			$txt_fk_id_metaproceso=$_POST["txt_fk_id_metaproceso_$j"];
			$txt_nivel=$_POST["txt_nivel_$j"];
			$txt_nombre=$_POST["txt_nombre_$j"];
			$txt_codigo_procedimiento=$_POST["txt_codigo_procedimiento_$j"];
			$txt_nombre_achivo=$_POST["txt_nombre_achivo_$j"];
			$txt_ruta_archivo=$_POST["txt_ruta_archivo_$j"];
			$txt_fecha_registro=$_POST["txt_fecha_registro_$j"];
			$txt_hora_registro=$_POST["txt_hora_registro_$j"];
			$txt_fecha_ultima_modificacion=$_POST["txt_fecha_ultima_modificacion_$j"];
			$txt_hora_ultima_modificacion=$_POST["txt_hora_ultima_modificacion_$j"];
			$txt_descripcion=$_POST["txt_descripcion_$j"];
			$txt_visible=$_POST["txt_visible_$j"];
			$txt_habilitar_log=$_POST["txt_habilitar_log_$j"];
			$txt_orden_logico=$_POST["txt_orden_logico_$j"];
			$txt_icono=$_POST["txt_icono_$j"];
			$txt_nombre_tabla=$_POST["txt_nombre_tabla_$j"];
			$txt_prefijo=$_POST["txt_prefijo_$j"];
			$txt_codigo_base=$_POST["txt_codigo_base_$j"];
			$txt_tipo_vista=$_POST["txt_tipo_vista_$j"];
			$txt_con_ep=$_POST["txt_con_ep_$j"];
			$txt_con_interfaz=$_POST["txt_con_interfaz_$j"];
			$txt_num_datos_hijo=$_POST["txt_num_datos_hijo_$j"];

		}

		if ($hidden_id_metaproceso == "undefined" || $hidden_id_metaproceso == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarMetaproceso("insert",$hidden_id_metaproceso, $txt_id_subsistema,$txt_fk_id_metaproceso,$txt_nivel,$txt_nombre,$txt_codigo_procedimiento,$txt_nombre_achivo,$txt_ruta_archivo,$txt_fecha_registro,$txt_hora_registro,$txt_fecha_ultima_modificacion,$txt_hora_ultima_modificacion,$txt_descripcion,$txt_visible,$txt_habilitar_log,$txt_orden_logico,$txt_icono,$txt_nombre_tabla,$txt_prefijo,$txt_codigo_base,$txt_tipo_vista,$txt_con_ep,$txt_con_interfaz,$txt_num_datos_hijo);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tsg_metaproceso
			$res = $Custom -> InsertarMetaproceso($hidden_id_metaproceso, $txt_id_subsistema, $txt_fk_id_metaproceso, $txt_nivel, $txt_nombre, $txt_codigo_procedimiento, $txt_nombre_achivo, $txt_ruta_archivo, $txt_fecha_registro, $txt_hora_registro, $txt_fecha_ultima_modificacion, $txt_hora_ultima_modificacion, $txt_descripcion, $txt_visible, $txt_habilitar_log, $txt_orden_logico, $txt_icono, $txt_nombre_tabla, $txt_prefijo, $txt_codigo_base, $txt_tipo_vista, $txt_con_ep, $txt_con_interfaz, $txt_num_datos_hijo);

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
			$res = $Custom->ValidarMetaproceso("update",$hidden_id_metaproceso, $txt_id_subsistema, $txt_fk_id_metaproceso, $txt_nivel, $txt_nombre, $txt_codigo_procedimiento, $txt_nombre_achivo, $txt_ruta_archivo, $txt_fecha_registro, $txt_hora_registro, $txt_fecha_ultima_modificacion, $txt_hora_ultima_modificacion, $txt_descripcion, $txt_visible, $txt_habilitar_log, $txt_orden_logico, $txt_icono, $txt_nombre_tabla, $txt_prefijo, $txt_codigo_base, $txt_tipo_vista, $txt_con_ep, $txt_con_interfaz, $txt_num_datos_hijo);

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

			$res = $Custom->ModificarMetaproceso($hidden_id_metaproceso, $txt_id_subsistema, $txt_fk_id_metaproceso, $txt_nivel, $txt_nombre, $txt_codigo_procedimiento, $txt_nombre_achivo, $txt_ruta_archivo, $txt_fecha_registro, $txt_hora_registro, $txt_fecha_ultima_modificacion, $txt_hora_ultima_modificacion, $txt_descripcion, $txt_visible, $txt_habilitar_log, $txt_orden_logico, $txt_icono, $txt_nombre_tabla, $txt_prefijo, $txt_codigo_base, $txt_tipo_vista, $txt_con_ep, $txt_con_interfaz, $txt_num_datos_hijo);

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
	if($sortcol == "") $sortcol = "id_metaproceso";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "SUBSIS.id_subsistema=''$m_id_subsistema''";

	$res = $Custom->ContarMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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