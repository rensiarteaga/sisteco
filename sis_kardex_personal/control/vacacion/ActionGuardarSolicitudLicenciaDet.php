<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarSolicitudLicenciaDet.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_vacacion
Tabla:					tkp_tkp_vacacion
Parámetros:				$id_vacacion
						$id_gestion
						$id_empleado
						$id_categoria_vacacion
						$total_dias

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2010-08-17 09:25:59
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarSolicitudLicenciaDet.php";

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
			$id_horario= $_GET["id_horario_$j"];
			$id_tipo_horario= $_GET["id_tipo_horario_$j"];
			$id_vacacion=$_GET["m_id_vacacion"];
			$fecha_inicio= $_GET["fecha_inicio_$j"];
			$fecha_fin= $_GET["fecha_fin_$j"];
			$tipo_periodo= $_GET["tipo_periodo_$j"];
			$observaciones= $_GET["observaciones_$j"];
		}
		else
		{
			$id_horario=$_POST["id_horario_$j"];
			$id_tipo_horario=$_POST["id_tipo_horario_$j"];
			$id_vacacion=$_POST["m_id_vacacion"];
			$fecha_inicio=$_POST["fecha_inicio_$j"];
			$fecha_fin=$_POST["fecha_fin_$j"];
			$tipo_periodo=$_POST["tipo_periodo_$j"];
			$observaciones=$_POST["observaciones_$j"];
		}		

		if ($id_horario == "undefined" || $id_horario == "")
		{
			////////////////////Inserción/////////////////////

			//Validación satisfactoria, se ejecuta la inserción en la tabla tkp_vacacion
			$res = $Custom -> InsertarSolicitudLicenciaDet($id_horario,$id_tipo_horario,$id_vacacion,$fecha_inicio,$fecha_fin,$tipo_periodo,$observaciones);

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

			$res = $Custom->ModificarSolicitudLicenciaDet($id_horario,$id_tipo_horario,$id_vacacion,$fecha_inicio,$fecha_fin,$tipo_periodo,$observaciones);

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
	if($sortcol == "") $sortcol = "id_vacacion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "HORARI.id_vacacion=''$id_vacacion''";
	
	$res = $Custom->ContarSolicitudLicenciaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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