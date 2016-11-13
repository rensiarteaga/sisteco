<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPartidaTraspaso.php
Propósito:				Permite insertar y modificar datos en la tabla tpr_partida_traspaso
Tabla:					tpr_tpr_partida_traspaso
Parámetros:				$id_partida_traspaso
						$id_partida_presupuesto_origen
						$id_partida_presupuesto_destino
						$id_partida_ejecucion_origen
						$id_partida_ejecucion_destino
						$id_usu_autorizado_origen
						$id_usu_autorizado_destino
						$id_usu_autorizado_registro
						$id_moneda
						$importe_traspaso
						$estado_traspaso
						$fecha_traspaso
						$fecha_conclusion
						$justificacion

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2009-02-04 19:45:09
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarPartidaTraspaso.php";

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
			$id_partida_traspaso= $_GET["id_partida_traspaso_$j"];
			$id_partida_presupuesto_origen= $_GET["id_partida_presupuesto_origen_$j"];
			$id_partida_presupuesto_destino= $_GET["id_partida_presupuesto_destino_$j"];
			$id_partida_ejecucion_origen= $_GET["id_partida_ejecucion_origen_$j"];
			$id_partida_ejecucion_destino= $_GET["id_partida_ejecucion_destino_$j"];
			$id_usu_autorizado_origen= $_GET["id_usu_autorizado_origen_$j"];
			//$desc_usuario_origen= $_GET["desc_usuario_origen_$j"];
			$id_usu_autorizado_destino= $_GET["id_usu_autorizado_destino_$j"];
			//$desc_usuario_destino= $_GET["desc_usuario_destino_$j"];
			$id_usu_autorizado_registro= $_GET["id_usu_autorizado_registro_$j"];
			//$desc_usuario_registro= $_GET["desc_usuario_registro_$j"];
			$id_moneda= $_GET["id_moneda_$j"];
			//$desc_moneda= $_GET["desc_moneda_$j"];
			$importe_traspaso= $_GET["importe_traspaso_$j"];
			$estado_traspaso= $_GET["estado_traspaso_$j"];
			$fecha_traspaso= $_GET["fecha_traspaso_$j"];
			$fecha_conclusion= $_GET["fecha_conclusion_$j"];
			$justificacion= $_GET["justificacion_$j"];
			
			$id_parametro= $_GET["id_parametro_$j"];
			//$desc_parametro= $_GET["desc_parametro_$j"];
			$tipo_pres= $_GET["tipo_pres_$j"];
			
			$id_partida_origen= $_GET["id_partida_origen_$j"];
			//$desc_partida_origen= $_GET["desc_partida_origen_$j"];
			$id_partida_destino= $_GET["id_partida_destino_$j"];
			//$desc_partida_destino= $_GET["desc_partida_destino_$j"];
			
			$id_presupuesto_origen= $_GET["id_presupuesto_origen_$j"];
			//$desc_presupuesto_origen= $_GET["desc_presupuesto_origen_$j"];
			$id_presupuesto_destino= $_GET["id_presupuesto_destino_$j"];
			//$desc_presupuesto_destino= $_GET["desc_presupuesto_destino_$j"];
			$tipo_traspaso= $_GET["tipo_traspaso_$j"];
		}
		else
		{
			$id_partida_traspaso=$_POST["id_partida_traspaso_$j"];
			$id_partida_presupuesto_origen=$_POST["id_partida_presupuesto_origen_$j"];
			$id_partida_presupuesto_destino=$_POST["id_partida_presupuesto_destino_$j"];
			$id_partida_ejecucion_origen=$_POST["id_partida_ejecucion_origen_$j"];
			$id_partida_ejecucion_destino=$_POST["id_partida_ejecucion_destino_$j"];
			$id_usu_autorizado_origen=$_POST["id_usu_autorizado_origen_$j"];
			$id_usu_autorizado_destino=$_POST["id_usu_autorizado_destino_$j"];
			$id_usu_autorizado_registro=$_POST["id_usu_autorizado_registro_$j"];
			$id_moneda=$_POST["id_moneda_$j"];
			$importe_traspaso=$_POST["importe_traspaso_$j"];
			$estado_traspaso=$_POST["estado_traspaso_$j"];
			$fecha_traspaso=$_POST["fecha_traspaso_$j"];
			$fecha_conclusion=$_POST["fecha_conclusion_$j"];
			$justificacion=$_POST["justificacion_$j"];
			
			$id_parametro= $_POST["id_parametro_$j"];
			//$desc_parametro= $_POST["desc_parametro_$j"];
			$tipo_pres= $_POST["tipo_pres_$j"];
			
			$id_partida_origen= $_POST["id_partida_origen_$j"];
			//$desc_partida_origen= $_POST["desc_partida_origen_$j"];
			$id_partida_destino= $_POST["id_partida_destino_$j"];
			//$desc_partida_destino= $_POST["desc_partida_destino_$j"];
			
			$id_presupuesto_origen= $_POST["id_presupuesto_origen_$j"];
			//$desc_presupuesto_origen= $_POST["desc_presupuesto_origen_$j"];
			$id_presupuesto_destino= $_POST["id_presupuesto_destino_$j"];
			//$desc_presupuesto_destino= $_POST["desc_presupuesto_destino_$j"];
			$tipo_traspaso= $_POST["tipo_traspaso_$j"];
		}

		if ($id_partida_traspaso == "undefined" || $id_partida_traspaso == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarPartidaTraspaso("insert",$id_partida_traspaso,$id_partida_presupuesto_origen,$id_partida_presupuesto_destino,$id_partida_ejecucion_origen,$id_partida_ejecucion_destino,$id_usu_autorizado_origen,$id_usu_autorizado_destino,$id_usu_autorizado_registro,$id_moneda,$importe_traspaso,$estado_traspaso,$fecha_traspaso,$fecha_conclusion,$justificacion);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_partida_traspaso
			$res = $Custom -> InsertarPartidaTraspaso($id_partida_traspaso,$id_partida_presupuesto_origen,$id_partida_presupuesto_destino,$id_partida_ejecucion_origen,$id_partida_ejecucion_destino,$id_usu_autorizado_origen,$id_usu_autorizado_destino,$id_usu_autorizado_registro,$id_moneda,$importe_traspaso,$estado_traspaso,$fecha_traspaso,$fecha_conclusion,$justificacion,$id_parametro,$tipo_pres,$id_partida_origen,$id_partida_destino,$id_presupuesto_origen,$id_presupuesto_destino,$tipo_traspaso);

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
			$res = $Custom->ValidarPartidaTraspaso("update",$id_partida_traspaso,$id_partida_presupuesto_origen,$id_partida_presupuesto_destino,$id_partida_ejecucion_origen,$id_partida_ejecucion_destino,$id_usu_autorizado_origen,$id_usu_autorizado_destino,$id_usu_autorizado_registro,$id_moneda,$importe_traspaso,$estado_traspaso,$fecha_traspaso,$fecha_conclusion,$justificacion);

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

			$res = $Custom->ModificarPartidaTraspaso($id_partida_traspaso,$id_partida_presupuesto_origen,$id_partida_presupuesto_destino,$id_partida_ejecucion_origen,$id_partida_ejecucion_destino,$id_usu_autorizado_origen,$id_usu_autorizado_destino,$id_usu_autorizado_registro,$id_moneda,$importe_traspaso,$estado_traspaso,$fecha_traspaso,$fecha_conclusion,$justificacion,$id_parametro,$tipo_pres,$id_partida_origen,$id_partida_destino,$id_presupuesto_origen,$id_presupuesto_destino,$tipo_traspaso);

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
	if($sortcol == "") $sortcol = "id_partida_traspaso";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarPartidaTraspaso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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