<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarModificacion.php
Propósito:				Permite insertar y modificar datos en la tabla tpr_modificacion
Tabla:					tpr_tpr_modificacion
Parámetros:				$id_modificacion
						$id_gestion
						$tipo_modificacion
						$justificacion
						$tipo_presupuesto
						$nro_traspaso
						$estado_modificacion
						$fecha_regis
						$fecha_conclusion
						$id_usuario_reg

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2010-05-10 18:01:22
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarModificacion.php";

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
			$id_modificacion= $_GET["id_modificacion_$j"];
			$id_parametro= $_GET["id_parametro_$j"];
			$tipo_modificacion= $_GET["tipo_modificacion_$j"];
			$justificacion= $_GET["justificacion_$j"];
			$tipo_presupuesto= $_GET["tipo_presupuesto_$j"];
			$nro_modificacion= $_GET["nro_modificacion_$j"];
			$estado_modificacion= $_GET["estado_modificacion_$j"];
			$fecha_regis= $_GET["fecha_regis_$j"];
			$fecha_conclusion= $_GET["fecha_conclusion_$j"];
			$id_usuario_reg= $_GET["id_usuario_reg_$j"];
		}
		else
		{
			$id_modificacion=$_POST["id_modificacion_$j"];
			$id_parametro=$_POST["id_parametro_$j"];
			$tipo_modificacion=$_POST["tipo_modificacion_$j"];
			$justificacion=$_POST["justificacion_$j"];
			$tipo_presupuesto=$_POST["tipo_presupuesto_$j"];
			$nro_modificacion=$_POST["nro_modificacion_$j"];
			$estado_modificacion=$_POST["estado_modificacion_$j"];
			$fecha_regis=$_POST["fecha_regis_$j"];
			$fecha_conclusion=$_POST["fecha_conclusion_$j"];
			$id_usuario_reg=$_POST["id_usuario_reg_$j"];
		}

		if ($id_modificacion == "undefined" || $id_modificacion == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarModificacion("insert",$id_modificacion,$id_parametro,$tipo_modificacion,$justificacion,$tipo_presupuesto,$nro_modificacion,$estado_modificacion,$fecha_regis,$fecha_conclusion,$id_usuario_reg);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_modificacion
			$res = $Custom -> InsertarModificacion($id_modificacion,$id_parametro,$tipo_modificacion,$justificacion,$tipo_presupuesto,$nro_modificacion,$estado_modificacion,$fecha_regis,$fecha_conclusion,$id_usuario_reg);

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
			$res = $Custom->ValidarModificacion("update",$id_modificacion,$id_parametro,$tipo_modificacion,$justificacion,$tipo_presupuesto,$nro_modificacion,$estado_modificacion,$fecha_regis,$fecha_conclusion,$id_usuario_reg);

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

			$res = $Custom->ModificarModificacion($id_modificacion,$id_parametro,$tipo_modificacion,$justificacion,$tipo_presupuesto,$nro_modificacion,$estado_modificacion,$fecha_regis,$fecha_conclusion,$id_usuario_reg);

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
	if($sortcol == "") $sortcol = "id_modificacion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarModificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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