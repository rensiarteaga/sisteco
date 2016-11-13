<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPartidaVobo.php
Propósito:				Permite insertar y modificar datos en la tabla tad_partida_vobo
Tabla:					tad_partida_vobo

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		201-02-05
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarVoboDetalle.php";

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
			
			$id_vobo_detalle=$_GET["id_vobo_detalle_$j"];
			$id_depto=$_GET["id_depto_$j"];
			$id_empleado=$_GET["id_usuario_$j"];
			$desc_empleado=$_GET["desc_empleado_$j"];
			$id_partida_vobo=$_GET["id_partida_vobo_$j"];
			$estado_reg=$_GET["estado_reg_$j"];

		}
		else
		{
			$id_vobo_detalle=$_POST["id_vobo_detalle_$j"];
			$id_depto=$_POST["id_depto_$j"];
			$id_empleado=$_POST["id_usuario_$j"];
			$desc_empleado=$_POST["desc_empleado_$j"];
			$id_partida_vobo=$_POST["id_partida_vobo_$j"];
			$estado_reg=$_POST["estado_reg_$j"];
		}
		if ($id_vobo_detalle == "undefined" || $id_vobo_detalle== "")
		{
			////////////////////Inserción/////////////////////

			$res = $Custom -> InsertarDetalleVobo($id_depto,$id_empleado,$id_partida_vobo,$estado_reg);

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
			
			$res = $Custom->ModificarDetalleVobo($id_vobo_detalle,$id_depto,$id_empleado,$id_partida_vobo,$estado_reg);

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

//	echo "---".$criterio_filtro;
//	exit;
	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_vobo_detalle";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "VBDET.id_depto=$m_id_depto";
//echo $sortcol."---".$sortdir."crit_".$criterio_filtro;
//exit;
	$res = $Custom->ContarDetalleVobo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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