<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarOrdenTrabajo.php
Propósito:				Permite insertar y modificar datos en la tabla tct_orden_trabajo
Tabla:					tct_tct_orden_trabajo
Parámetros:				$id_orden_trabajo
						$desc_orden
						$motivo_orden
						$fecha_inicio
						$fecha_final
						$estado_orden
						$id_usuario

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-08-27 09:14:44
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = "ActionGuardarOrdenTrabajo.php";

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
			$id_orden_trabajo= $_GET["id_orden_trabajo_$j"];
			$desc_orden= $_GET["desc_orden_$j"];
			$motivo_orden= $_GET["motivo_orden_$j"];
			$fecha_inicio= $_GET["fecha_inicio_$j"];
			$fecha_final= $_GET["fecha_final_$j"];
			$estado_orden= $_GET["estado_orden_$j"];
			$id_usuario= $_GET["id_usuario_$j"];
			$fecha_activa= $_GET["fecha_activa_$j"];
		}
		else
		{
			$id_orden_trabajo=$_POST["id_orden_trabajo_$j"];
			$desc_orden=$_POST["desc_orden_$j"];
			$motivo_orden=$_POST["motivo_orden_$j"];
			$fecha_inicio=$_POST["fecha_inicio_$j"];
			$fecha_final=$_POST["fecha_final_$j"];
			$estado_orden=$_POST["estado_orden_$j"];
			$id_usuario=$_POST["id_usuario_$j"];
			$fecha_activa= $_POST["fecha_activa_$j"];
		}

		if ($id_orden_trabajo == "undefined" || $id_orden_trabajo == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarOrdenTrabajo("insert",$id_orden_trabajo,$desc_orden,$motivo_orden,$fecha_inicio,$fecha_final,$estado_orden,$id_usuario,$fecha_activa);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tct_orden_trabajo
			$res = $Custom -> InsertarOrdenTrabajo($id_orden_trabajo,$desc_orden,$motivo_orden,$fecha_inicio,$fecha_final,$estado_orden,$id_usuario,$fecha_activa);

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
			$res = $Custom->ValidarOrdenTrabajo("update",$id_orden_trabajo,$desc_orden,$motivo_orden,$fecha_inicio,$fecha_final,$estado_orden,$id_usuario,$fecha_activa);

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

			$res = $Custom->ModificarOrdenTrabajo($id_orden_trabajo,$desc_orden,$motivo_orden,$fecha_inicio,$fecha_final,$estado_orden,$id_usuario,$fecha_activa);

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
	if($sortcol == "") $sortcol = "id_orden_trabajo";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarOrdenTrabajo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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