<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarProcesoCompraMulDet.php
Prop�sito:				Permite insertar y modificar datos en la tabla tad_proceso_compra_det
Tabla:					tad_tad_proceso_compra_det
Par�metros:				$id_proceso_compra_det
						$id_servicio
						$id_item
						$cantidad
						$precio_referencial_total
						$id_proceso_compra
						$estado_reg

Valores de Retorno:    	N�mero de registros guardados
Fecha de Creaci�n:		2008-05-20 17:42:42
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarProcesoCompraMulDet.php";

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
		
		//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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
	
	//Envia al Custom la bandera que indica si se decodificar� o no
	$Custom->decodificar = $decodificar;

	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$id_proceso_compra_det= $_GET["id_proceso_compra_det_$j"];
			$id_servicio= $_GET["id_servicio_$j"];
			$id_item= $_GET["id_item_$j"];
			$cantidad= $_GET["cantidad_$j"];
			$precio_referencial_total= $_GET["precio_referencial_total_$j"];
			$id_proceso_compra= $_GET["id_proceso_compra_$j"];
			$estado_reg= $_GET["estado_reg_$j"];

		}
		else
		{
			$id_proceso_compra_det=$_POST["id_proceso_compra_det_$j"];
			$id_servicio=$_POST["id_servicio_$j"];
			$id_item=$_POST["id_item_$j"];
			$cantidad=$_POST["cantidad_$j"];
			$precio_referencial_total=$_POST["precio_referencial_total_$j"];
			$id_proceso_compra=$_POST["id_proceso_compra_$j"];
			$estado_reg=$_POST["estado_reg_$j"];

		}

		if ($id_proceso_compra_det == "undefined" || $id_proceso_compra_det == "")
		{
			////////////////////Inserci�n/////////////////////

			//Validaci�n de datos (del lado del servidor)
			$res = $Custom->ValidarProcesoCompraMulDet("insert",$id_proceso_compra_det, $id_servicio,$id_item,$cantidad,$precio_referencial_total,$id_proceso_compra,$estado_reg);

			if(!$res)
			{
				//Error de validaci�n
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			//Validaci�n satisfactoria, se ejecuta la inserci�n en la tabla tad_proceso_compra_det
			$res = $Custom -> InsertarProcesoCompraMulDet($id_proceso_compra_det, $id_servicio, $id_item, $cantidad, $precio_referencial_total, $id_proceso_compra, $estado_reg);

			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteraci�n $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
		else
		{	///////////////////////Modificaci�n////////////////////
			
			//Validaci�n de datos (del lado del servidor)
			$res = $Custom->ValidarProcesoCompraMulDet("update",$id_proceso_compra_det, $id_servicio, $id_item, $cantidad, $precio_referencial_total, $id_proceso_compra, $estado_reg);

			if(!$res)
			{
				//Error de validaci�n
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			$res = $Custom->ModificarProcesoCompraMulDet($id_proceso_compra_det, $id_servicio, $id_item, $cantidad, $precio_referencial_total, $id_proceso_compra, $estado_reg);

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

	//Guarda el mensaje de �xito de la operaci�n realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Par�metros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_proceso_compra_det";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "PROCOMDET.id_proceso_compra=''$m_id_proceso_compra''";

	$res = $Custom->ContarProcesoCompraMulDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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