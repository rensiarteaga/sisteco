<?php
/**
**********************************************************
Nombre de archivo:	    ActionFinalizarSolicitudDevengado.php
Propósito:				Permite Finalizar Devengado
Tabla:					tts_tts_devengado
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		09/02/2009
Versión:				1.0.0
Autor:					RCM
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = "ActionFinalizarSolicitudDevengado.php";

//echo "hola";
//exit;

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
		$cont =  1;

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

	$respuesta='0';

	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$id_devengado= $_GET["id_devengado_$j"];
			$id_empleado=$_GET["id_empleado_aprobacion_$j"];
		}
		else
		{
			$id_devengado=$_POST["id_devengado_$j"];
			$id_empleado=$_POST["id_empleado_aprobacion_$j"];
		}


		if ($id_devengado == "undefined" || $id_devengado == "")
		{
			$respuesta='0';
		}
		else
		{
			/*//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarDevengarServicios("insert",$id_devengado,$id_concepto_ingas,$id_moneda,$importe_devengado,$estado_devengado,$id_proveedor,$tipo_devengado);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tts_devengado
			$res = $Custom -> FinalizarSolicitudDevengado($id_devengado,$id_empleado);
			/*echo "<pre>";
			print_r($Custom->salida);
			echo "</pre>";
			echo "resp:".$resp;
			exit;*/

			if(!$res)
			{
				//Se produjo un error
				/*echo "<pre>";
				print_r($Custom->salida);
				echo "</pre>";
				exit;
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;*/

				//Devuelve el XML de respueta
				$xml = new cls_manejo_xml('ROOT');
				$xml->add_nodo('TotalCount',1);
				$xml->add_rama('ROWS');
				$xml->add_nodo('error',1);
				$xml->add_nodo('mensaje_error',$Custom->salida[1]);
				$xml->add_nodo('origen',$Custom->salida[2]);
				$xml->add_nodo('proc',$Custom->salida[3]);
				$xml->add_nodo('nivel',$Custom->salida[4]);
				$xml->add_nodo('query',$Custom->query);
				$xml->fin_rama();
				$xml->mostrar_xml();
				exit;
			}

			$respuesta=$Custom->salida[1];
		}

	}//END FOR

	//echo "termina";
	//exit;

	//Devuelve el XML de respueta
	$xml = new cls_manejo_xml('ROOT');
	$xml->add_nodo('TotalCount',1);
	$xml->add_rama('ROWS');
	$xml->add_nodo('error',0);
	$xml->add_nodo('mensaje',$Custom->salida[1]);
	$xml->fin_rama();
	$xml->mostrar_xml();

	//Arma el xml para desplegar el mensaje
	/*$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", $total_registros);
	$resp->add_nodo("mensaje", $respuesta);
	$resp->add_nodo("tiempo_resp", "200");
	echo $resp->get_mensaje();
	exit;*/


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