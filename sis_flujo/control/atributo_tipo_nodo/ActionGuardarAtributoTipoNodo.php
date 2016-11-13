<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarTipoCircuito.php
Propósito:				Permite insertar y modificar datos en la tabla tfl_tipo_circuito
Tabla:					tfl_tipo_circuito
Parámetros:				$id_tipo_circuito
						$id_tipo_nodo_inicio
						$id_tipo_nodo_fin

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2010-12-27 16:20:47
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloFlujo.php");

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = "ActionAtributoGuardarTipoCircuito.php";

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
			$id_atributo_tipo_nodo= $_GET["id_atributo_tipo_nodo_$j"];
			$id_atributo= $_GET["id_atributo_$j"];
			$id_tipo_nodo= $_GET["id_tipo_nodo_$j"];
			$visible = $_GET["visible_$j"];
			$editable = $_GET["editable_$j"];
			$orden = $_GET["orden_$j"];
		}
		else
		{
			$id_atributo_tipo_nodo= $_POST["id_atributo_tipo_nodo_$j"];
			$id_atributo= $_POST["id_atributo_$j"];
			$id_tipo_nodo= $_POST["id_tipo_nodo_$j"];
			$visible = $_POST["visible_$j"];
			$editable = $_POST["editable_$j"];
			$orden = $_POST["orden_$j"];
		}

		if ($id_atributo_tipo_nodo == "undefined" || $id_atributo_tipo_nodo == "")
		{
			////////////////////Inserción/////////////////////
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarAtributoTipoNodo("insert",$id_atributo_tipo_nodo,$id_atributo,$id_tipo_nodo,$orden);
			if(!$res){
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			//Validación satisfactoria, se ejecuta la inserción en la tabla tfl_tipo_nodo
			$res = $Custom -> InsertarAtributoTipoNodo($id_atributo,$id_tipo_nodo);
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
			$res = $Custom->ValidarAtributoTipoNodo("update",$id_atributo_tipo_nodo,$id_atributo,$id_tipo_nodo,$orden);

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

			$res = $Custom->ModificarAtributoTipoNodo($id_atributo_tipo_nodo,$visible,$editable,$orden);

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
	if($sortcol == "") $sortcol = "id_atributo_tipo_nodo";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "")
	{
		$criterio_filtro = "0=0";
		
	}
	
	if(isset($m_id_tipo_nodo)){
			$criterio_filtro .= " and ATRTIPNOD.id_tipo_nodo =$m_id_tipo_nodo";//cuenta solo los hijos del ide padre
		}
	$res = $Custom->ContarAtributoTipoNodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
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