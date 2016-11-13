<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCargo.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_cargo
Tabla:					tkp_tkp_cargo
Parámetros:				$hidden_id_cargo
						

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2014-05-10 09:06:57
Versión:				1.0.0
Autor:					
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarCargo.php";

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
			$hidden_id_cargo= $_GET["hidden_id_cargo_$j"];
			$id_escala_salarial= $_GET["id_escala_salarial_$j"];
			$numero_item= $_GET["numero_item_$j"];
			$tipo_item= $_GET["tipo_item_$j"];
			$codigo_cargo= $_GET["codigo_cargo_$j"];
			$nombre_cargo= $_GET["nombre_cargo_$j"];
			$id_tipo_contrato= $_GET["id_tipo_contrato_$j"];
			$estado_reg= $_GET["estado_reg_$j"];
			
		}
		else
		{
			$hidden_id_cargo= $_POST["hidden_id_cargo_$j"];
			$id_escala_salarial= $_POST["id_escala_salarial_$j"];
			$numero_item= $_POST["numero_item_$j"];
			$tipo_item= $_POST["tipo_item_$j"];
			$codigo_cargo= $_POST["codigo_cargo_$j"];
			$nombre_cargo= $_POST["nombre_cargo_$j"];
			$id_tipo_contrato= $_POST["id_tipo_contrato_$j"];
			$estado_reg= $_POST["estado_reg_$j"];

		}

		if ($hidden_id_cargo == "undefined" || $hidden_id_cargo == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarCargo("insert",$hidden_id_cargo,$id_escala_salarial,$numero_item,$tipo_item,$codigo_cargo,$nombre_cargo, $id_tipo_contrato);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tkp_empleado
			$res = $Custom -> InsertarCargo($hidden_id_cargo,$id_escala_salarial,$numero_item,$tipo_item,$codigo_cargo,$nombre_cargo, $id_tipo_contrato);

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
			$res = $Custom->ValidarCargo("update",$hidden_id_cargo,$id_escala_salarial,$numero_item,$tipo_item,$codigo_cargo,$nombre_cargo, $id_tipo_contrato);

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

			$res = $Custom->ModificarCargo($hidden_id_cargo,$id_escala_salarial,$numero_item,$tipo_item,$codigo_cargo,$nombre_cargo, $id_tipo_contrato, $estado_reg);

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
	if($sortcol == "") $sortcol = "CARGO.nombre_cargo";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarCargo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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