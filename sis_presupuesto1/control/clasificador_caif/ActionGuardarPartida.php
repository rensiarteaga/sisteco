<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPartida.php
Propósito:				Permite insertar y modificar datos en la tabla tpr_partida
Tabla:					tpr_tpr_partida
Parámetros:				$id_partida
						$codigo_partida
						$nombre_partida
						$nivel_partida
						$sw_transaccional
						$tipo_partida
						$id_parametro
						$id_partida_padre
						$tipo_memoria
						$desc_partida

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-07-07 11:38:59
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarPartida.php";

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
			$id_partida= $_GET["id_partida_$j"];
			$codigo_partida= $_GET["codigo_partida_$j"];
			$nombre_partida= $_GET["nombre_partida_$j"];
			$nivel_partida= $_GET["nivel_partida_$j"];
			$sw_transaccional= $_GET["sw_transaccional_$j"];
			$tipo_partida= $_GET["tipo_partida_$j"];
			$id_parametro= $_GET["id_parametro_$j"];
			$id_partida_padre= $_GET["id_partida_padre_$j"];
			$tipo_memoria= $_GET["tipo_memoria_$j"];
			$desc_partida= $_GET["desc_partida_$j"];

		}
		else
		{
			$id_partida=$_POST["id_partida_$j"];
			$codigo_partida=$_POST["codigo_partida_$j"];
			$nombre_partida=$_POST["nombre_partida_$j"];
			$nivel_partida=$_POST["nivel_partida_$j"];
			$sw_transaccional=$_POST["sw_transaccional_$j"];
			$tipo_partida=$_POST["tipo_partida_$j"];
			$id_parametro=$_POST["id_parametro_$j"];
			$id_partida_padre=$_POST["id_partida_padre_$j"];
			$tipo_memoria=$_POST["tipo_memoria_$j"];
			$desc_partida=$_POST["desc_partida_$j"];

		}

		if ($id_partida == "undefined" || $id_partida == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarPartida("insert",$id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_partida
			$res = $Custom -> InsertarPartida($id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida);

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
			$res = $Custom->ValidarPartida("update",$id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida);

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

			$res = $Custom->ModificarPartida($id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida);

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
	if($sortcol == "") $sortcol = "id_partida";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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