<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarNivelOrganizacional.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_nivel_organizacional
Tabla:					tkp_tkp_nivel_organizacional
Parámetros:				$hidden_id_nivel_organizacional
						$txt_nombre_nivel
						$txt_numero_nivel
						
Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-12 09:24:17
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarHistoricoAsignacion.php";

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
			$hidden_id_historico_asignacion= $_GET["hidden_id_historico_asignacion_$j"];
			$txt_fecha_asignacion= $_GET["txt_fecha_asignacion_$j"];
			$txt_estado= $_GET["txt_estado_$j"];
			$txt_id_unidad_organizacional= $_GET["id_unidad_organizacional_$j"];
			$txt_id_empleado= $_GET["txt_id_empleado_$j"];
			$txt_fecha_finalizacion= $_GET["txt_fecha_finalizacion_$j"];
			$txt_id_empleado_suplente= $_GET["txt_id_empleado_suplente_$j"];
			$id_lugar= $_GET["id_lugar_$j"];
			//19.05.2014
			$id_cargo=$_GET["id_cargo_$j"];
			$id_tipo_contrato=$_GET["id_tipo_contrato_$j"];
			$tipo_registro=$_GET["tipo_registro_$j"];
		}
		else
		{
			$hidden_id_historico_asignacion= $_POST["hidden_id_historico_asignacion_$j"];
			$txt_fecha_asignacion= $_POST["txt_fecha_asignacion_$j"];
			$txt_estado= $_POST["txt_estado_$j"];
			$txt_id_unidad_organizacional= $_POST["id_unidad_organizacional_$j"];
			$txt_id_empleado= $_POST["txt_id_empleado_$j"];
			$txt_fecha_finalizacion= $_POST["txt_fecha_finalizacion_$j"];
			$txt_id_empleado_suplente= $_POST["txt_id_empleado_suplente_$j"];
			$id_lugar= $_POST["id_lugar_$j"];
			//19.05.2014
			$id_cargo=$_POST["id_cargo_$j"];
			$id_tipo_contrato=$_POST["id_tipo_contrato_$j"];
			$tipo_registro=$_POST["tipo_registro_$j"];
		}
//echo $txt_fecha_asignacion; exit;

		if ($hidden_id_historico_asignacion == "undefined" || $hidden_id_historico_asignacion == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarHistoricoAsignacion("insert",$hidden_id_historico_asignacion, $txt_fecha_asignacion,$txt_estado,$txt_id_unidad_organizacional,$txt_id_empleado,$txt_fecha_finalizacion);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tkp_nivel_organizacional
			$res = $Custom -> InsertarHistoricoAsignacion($hidden_id_historico_asignacion, $txt_fecha_asignacion,$txt_estado,$txt_id_unidad_organizacional,$txt_id_empleado,$txt_fecha_finalizacion,$txt_id_empleado_suplente
			,$id_lugar
			//19.05.2014
			,$id_cargo,$id_tipo_contrato,$tipo_registro
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
			$res = $Custom->ValidarHistoricoAsignacion("update",$hidden_id_historico_asignacion, $txt_fecha_asignacion,$txt_estado,$txt_id_unidad_organizacional,$txt_id_empleado,$txt_fecha_finalizacion);

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

			$res = $Custom->ModificarHistoricoAsignacion($hidden_id_historico_asignacion, $txt_fecha_asignacion,$txt_estado,$txt_id_unidad_organizacional,$txt_id_empleado,$txt_fecha_finalizacion,$txt_id_empleado_suplente
			,$id_lugar
			//19.05.2014
			,$id_cargo,$id_tipo_contrato,$tipo_registro
			);
			
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
	if($sortcol == "") $sortcol = "fecha_asignacion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarHistoricoAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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