<?php
/**
**********************************************************
Nombre de archivo:	    ActionAnularCheque.php
Propósito:				Permite insertar y modificar datos en la tabla tts_devengado
Tabla:					tts_tts_devengado
Parámetros:				$id_devengado
						$id_concepto_ingas
						$id_moneda
						$importe_devengado
						$estado_devengado
						$id_proveedor
						$tipo_devengado

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		11/02/2009
Versión:				1.0.0
Autor:					RCM
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBcontabilidad();
$nombre_archivo = "ActionAnularCheque.php";

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
			$id_cheque= $_GET["id_cheque"];
			$id_tabla= $_GET["id_tabla"];
			$tipo_cheque= $_GET["tipo_cheque"];
		}
		else
		{
			$id_cheque= $_POST["id_cheque"];
			$id_tabla= $_POST["id_tabla"];
			$tipo_cheque= $_POST["tipo_cheque"];
		}
		
		//echo "cheque:".$id_tabla;
		//exit;

		if ($id_cheque == "undefined" || $id_cheque == "")
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "Cheque inexistente";
			$resp->origen = $nombre_archivo;
			$resp->proc = "";
			$resp->nivel = "3";
			echo $resp->get_mensaje();
			exit;
		}
		else
		{	///////////////////////Modificación////////////////////
			
			/*//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarDevengarServicios("update",$id_devengado,$id_concepto_ingas,$id_moneda,$importe_devengado,$estado_devengado,$id_proveedor,$tipo_devengado);

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
			}*/

			$res = $Custom->AnularCheque($id_cheque,$id_tabla,$tipo_cheque);

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
	if($sortcol == "") $sortcol = "CHEQUE.nro_cheque";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarChequeAnulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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