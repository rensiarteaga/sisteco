<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarGrupoProcComMul.php
Propósito:				Permite insertar y modificar datos en la tabla tad_grupo_sp_det
Tabla:					tad_tad_grupo_sp_det
Parámetros:				$id_grupo_sp_det
						$id_proceso_compra_det
						$id_solicitud_compra_det
						$cantidad_adjudicada
						$id_cotizacion_det
						$estado_reg

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-20 17:42:55
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarGrupoProcComMul.php";

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
			$id_grupo_sp_det= $_GET["id_grupo_sp_det_$j"];
			$id_proceso_compra_det= $_GET["id_proceso_compra_det_$j"];
			$id_solicitud_compra_det= $_GET["id_solicitud_compra_det_$j"];
			$cantidad_adjudicada= $_GET["cantidad_adjudicada_$j"];
			$id_cotizacion_det= $_GET["id_cotizacion_det_$j"];
			$estado_reg= $_GET["estado_reg_$j"];

		}
		else
		{
			$id_grupo_sp_det=$_POST["id_grupo_sp_det_$j"];
			$id_proceso_compra_det=$_POST["id_proceso_compra_det_$j"];
			$id_solicitud_compra_det=$_POST["id_solicitud_compra_det_$j"];
			$cantidad_adjudicada=$_POST["cantidad_adjudicada_$j"];
			$id_cotizacion_det=$_POST["id_cotizacion_det_$j"];
			$estado_reg=$_POST["estado_reg_$j"];

		}

		if ($id_grupo_sp_det == "undefined" || $id_grupo_sp_det == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarGrupoProcComMul("insert",$id_grupo_sp_det, $id_proceso_compra_det,$id_solicitud_compra_det,$cantidad_adjudicada,$id_cotizacion_det,$estado_reg);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tad_grupo_sp_det
			$res = $Custom -> InsertarGrupoProcComMul($id_grupo_sp_det, $id_proceso_compra_det, $id_solicitud_compra_det, $cantidad_adjudicada, $id_cotizacion_det, $estado_reg);

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
			$res = $Custom->ValidarGrupoProcComMul("update",$id_grupo_sp_det, $id_proceso_compra_det, $id_solicitud_compra_det, $cantidad_adjudicada, $id_cotizacion_det, $estado_reg);

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

			$res = $Custom->ModificarGrupoProcComMul($id_grupo_sp_det, $id_proceso_compra_det, $id_solicitud_compra_det, $cantidad_adjudicada, $id_cotizacion_det, $estado_reg);

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
	if($sortcol == "") $sortcol = "id_grupo_sp_det";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "PRCOMULDET.id_proceso_compra_det=''$m_id_proceso_compra_det''";

	$res = $Custom->ContarGrupoProcComMul($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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