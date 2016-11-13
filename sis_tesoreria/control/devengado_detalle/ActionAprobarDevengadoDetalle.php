<?php
/**
**********************************************************
Nombre de archivo:	    ActionAprobarDevengadoDetalle.php
Propósito:				Permite insertar y modificar datos en la tabla tts_devengado_detalle
Tabla:					tts_tts_devengado_detalle
Parámetros:				$id_devengado_detalle
						$id_devengado
						$id_fina_regi_prog_proy_acti
						$id_unidad_organizacional
						$porcentaje_devengado
						$importe_devengado

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-10-21 15:43:29
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = "ActionAprobarDevengadoDetalle.php";

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
			$id_devengado_detalle = $_GET["id_devengado_detalle_$j"];
			$aprobado = $_GET["aprobado_$j"];
			
			if($aprobado=='true'){
				$aprobado='1';
			}else{
				$aprobado='0';
			}
		}
		else
		{
			$id_devengado_detalle =$_POST["id_devengado_detalle_$j"];
			$aprobado	= $_POST["aprobado_$j"];
			
			if($aprobado=='true'){
				$aprobado='1';
			}else{
				$aprobado='0';
			}
		}


		if ($id_devengado_detalle == "undefined" || $id_devengado_detalle == "")
		{
			////////////////////Inserción/////////////////////

			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "MENSAJE ERROR = Prorrateo inexistente";
			$resp->origen = "ORIGEN = ";
			$resp->proc = "PROC = ";
			$resp->nivel = "NIVEL = 4";
			echo $resp->get_mensaje();
			exit;
		}
		else
		{	///////////////////////Aprobación////////////////////
			
			//echo "control aprobado:".$aprobado;

			$res = $Custom->AprobarDevengadoDetalle($id_devengado_detalle,$aprobado);

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
	if($cont > 1) $mensaje_exito = "Aprobación realizada.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_devengado_detalle";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "DEVENG.id_devengado=''$m_id_devengado''";

	//$res = $Custom->ContarDevengadoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = 1;//$Custom->salida;

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