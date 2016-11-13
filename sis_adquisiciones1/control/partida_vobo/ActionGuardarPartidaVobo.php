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
$nombre_archivo = "ActionGuardarPartidaVobo.php";

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
			$id_partida_vobo=$_GET["id_partida_vobo_$j"];
			$id_partida=$_GET["id_partida_$j"];
			$id_parametro_adquisicion=$_GET["id_parametro_adquisicion_$j"];
			$estado_reg=$_GET["estado_reg_$j"];
			$id_vobo_detalle=$_GET["id_vobo_detalle_$j"];

		}
		else
		{
			$id_partida_vobo=$_POST["id_partida_vobo_$j"];
			$id_partida=$_POST["id_partida_$j"];
			$id_parametro_adquisicion=$_POST["id_parametro_adquisicion_$j"];
			$estado_reg=$_POST["estado_reg_$j"];
			$id_vobo_detalle=$_POST["id_vobo_detalle_$j"];
		}

		if($id_vobo_detalle>0){
			
		}else{
			$id_vobo_detalle=$m_id_vobo_detalle;
		}
		if ($id_partida_vobo == "undefined" || $id_partida_vobo== "")
		{
			////////////////////Inserción/////////////////////

			$res = $Custom -> InsertarPartidaVobo($id_partida,$id_parametro_adquisicion,$estado_reg,$id_vobo_detalle);

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
			
			$res = $Custom->ModificarPartidaVobo($id_partida_vobo,$id_partida,$id_parametro_adquisicion,$estado_reg,$id_vobo_detalle);

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
	if($sortcol == "") $sortcol = "id_partida_vobo";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = " 0=0 AND PARTVB.id_vobo_detalle=$id_vobo_detalle";
//echo $sortcol."---".$sortdir."crit_".$criterio_filtro;
//exit;
	$res = $Custom->ContarPartidaVobo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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