<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarServicio.php
Propósito:				Permite insertar y modificar datos en la tabla tad_servicio
Tabla:					tad_tad_servicio
Parámetros:				$id_servicio
						$nombre
						$descripcion
						$fecha_reg
						$id_tipo_servicio

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-16 14:58:49
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarServicio.php";

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
			$id_servicio= $_GET["id_servicio_$j"];
			$nombre= $_GET["nombre_$j"];
			$descripcion= $_GET["descripcion_$j"];
			$fecha_reg= $_GET["fecha_reg_$j"];
			$id_tipo_servicio= $_GET["id_tipo_servicio_$j"];
            $codigo= $_GET["codigo_$j"];
            $continuo= $_GET["continuo_$j"];
            $estado= $_GET["estado_$j"];
		}
		else
		{
			$id_servicio=$_POST["id_servicio_$j"];
			$nombre=$_POST["nombre_$j"];
			$descripcion=$_POST["descripcion_$j"];
			$fecha_reg=$_POST["fecha_reg_$j"];
			$id_tipo_servicio=$_POST["id_tipo_servicio_$j"];
			$codigo=$_POST["codigo_$j"];
			$continuo= $_POST["continuo_$j"];
			$estado= $_POST["estado_$j"];

		}
/*echo "muestra el id_tipo servicio".$id_tipo_servicio;
exit;*/
	if ($id_servicio == "undefined" || $id_servicio == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarServicio("insert",$id_servicio, $nombre,$descripcion,$fecha_reg,$id_tipo_servicio,$m_codigo.'.'.$codigo,$estado);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tad_servicio
			$res = $Custom -> InsertarServicio($id_servicio, $nombre, $descripcion, $fecha_reg, $id_tipo_servicio,strtoupper($m_codigo.'.'.$codigo),$continuo,$estado);

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
			$res = $Custom->ValidarServicio("update",$id_servicio, $nombre, $descripcion, $fecha_reg, $id_tipo_servicio,$m_codigo.'.'.$codigo,$estado);

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

			$res = $Custom->ModificarServicio($id_servicio, $nombre, $descripcion, $fecha_reg, $id_tipo_servicio,strtoupper($m_codigo.'.'.$codigo),$continuo,$estado);

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
	if($sortcol == "") $sortcol = "id_servicio";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "TIPSER.id_tipo_servicio=''$m_id_tipo_servicio''";

	$res = $Custom->ContarServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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