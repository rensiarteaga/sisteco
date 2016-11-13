<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarDetallePropuesta.php
Propósito:				Permite insertar y modificar datos en la tabla tad_detalle_propuesta
Tabla:					tad_tad_detalle_propuesta
Parámetros:				$id_detalle_propuesta
						$id_cotizacion_det
						$id_item
						$id_servicio
						$precio
						$cantidad
						$nombre
						$descripcion
						$fecha_reg
						$id_item_solicitado
						$id_servicio_solicitado

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2009-02-03 11:26:27
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarDetallePropuesta.php";

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
			$id_detalle_propuesta= $_GET["id_detalle_propuesta_$j"];
			$id_cotizacion_det=$_GET["id_cotizacion_det"];
			$id_item= $_GET["id_item_$j"];
			$id_servicio= $_GET["id_servicio_$j"];
			$precio= $_GET["precio_$j"];
			$cantidad= $_GET["cantidad_$j"];
			$nombre= $_GET["nombre_$j"];
			$descripcion= $_GET["descripcion_$j"];
			$fecha_reg= $_GET["fecha_reg_$j"];
			$id_item_solicitado= $_GET["id_item_solicitado_$j"];
			$id_servicio_solicitado= $_GET["id_servicio_solicitado_$j"];
			
			
			$clasificado = $_GET["clasificado_$j"];
			$garantia = $_GET["garantia_$j"];
			$observaciones = $_GET["observaciones_$j"];
            $id_unidad_medida_base = $_GET["id_unidad_medida_base_$j"];
		}
		else
		{
			$id_detalle_propuesta=$_POST["id_detalle_propuesta_$j"];
			$id_cotizacion_det=$_POST["id_cotizacion_det"];
			$id_item=$_POST["id_item_$j"];
			$id_servicio=$_POST["id_servicio_$j"];
			$precio=$_POST["precio_$j"];
			$cantidad=$_POST["cantidad_$j"];
			$nombre=$_POST["nombre_$j"];
			$descripcion=$_POST["descripcion_$j"];
			$fecha_reg=$_POST["fecha_reg_$j"];
			$id_item_solicitado=$_POST["id_item_solicitado_$j"];
			$id_servicio_solicitado=$_POST["id_servicio_solicitado_$j"];
			$clasificado = $_POST["clasificado_$j"];
			$garantia = $_POST["garantia_$j"];
			$observaciones = $_POST["observaciones_$j"];
			$id_unidad_medida_base = $_POST["id_unidad_medida_base_$j"];

		}
		
		if($clasificado=='si'){
			$estado="clasificado";
		}
		else{
			
			$estado="registrado";
		}
		

		if ($id_detalle_propuesta == "undefined" || $id_detalle_propuesta == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarDetallePropuesta("insert",$id_detalle_propuesta, $id_cotizacion_det,$id_item,$id_servicio,$precio,$cantidad,$nombre,$descripcion,$fecha_reg,$id_item_solicitado,$id_servicio_solicitado);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tad_detalle_propuesta
			$res = $Custom -> InsertarDetallePropuesta($id_detalle_propuesta, $id_cotizacion_det,$id_item,$id_servicio,$precio,$cantidad,$nombre,$descripcion,$fecha_reg,$id_item_solicitado,$id_servicio_solicitado,$estado,$garantia,$observaciones,$id_unidad_medida_base);

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
			$res = $Custom->ValidarDetallePropuesta("update",$id_detalle_propuesta, $id_cotizacion_det,$id_item,$id_servicio,$precio,$cantidad,$nombre,$descripcion,$fecha_reg,$id_item_solicitado,$id_servicio_solicitado);

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

			$res = $Custom->ModificarDetallePropuesta($id_detalle_propuesta, $id_cotizacion_det,$id_item,$id_servicio,$precio,$cantidad,$nombre,$descripcion,$fecha_reg,$id_item_solicitado,$id_servicio_solicitado,$estado,$garantia,$observaciones,$id_unidad_medida_base);

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
	if($sortcol == "") $sortcol = "id_detalle_propuesta";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "id_cotizacion_det=''$id_cotizacion_det''";

	$res = $Custom->ContarDetallePropuesta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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