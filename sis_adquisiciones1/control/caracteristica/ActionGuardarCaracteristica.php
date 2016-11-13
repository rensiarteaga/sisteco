<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCaracteristica.php
Propósito:				Permite insertar y modificar datos en la tabla tad_caracteristica
Tabla:					tad_tad_caracteristica
Parámetros:				$_id_caracteristica
						$caracteristica
						$descripcion
						$fecha_reg
						$id_solicitud_compra_det
						$id_item_propuesto
						$id_servicio_propuesto

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-13 09:57:27
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarCaracteristica.php";

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
			$id_caracteristica= $_GET["id_caracteristica_$j"];
			$caracteristica= $_GET["caracteristica_$j"];
			$descripcion= $_GET["descripcion_$j"];
			$fecha_reg= $_GET["fecha_reg_$j"];
			$id_solicitud_compra_det= $_GET["m_id_solicitud_compra_det"];
			$id_item_propuesto= $_GET["m_id_item_propuesto"];
			$id_servicio_propuesto= $_GET["m_id_servicio_propuesto"];

		}
		else
		{
			$id_caracteristica=$_POST["id_caracteristica_$j"];
			$caracteristica=$_POST["caracteristica_$j"];
			$descripcion=$_POST["descripcion_$j"];
			$fecha_reg=$_POST["fecha_reg_$j"];
			$id_solicitud_compra_det=$_POST["m_id_solicitud_compra_det"];
			$id_item_propuesto=$_POST["m_id_item_propuesto"];
			$id_servicio_propuesto=$_POST["m_id_servicio_propuesto"];

		}


		if ($id_caracteristica == "undefined" || $id_caracteristica == "")
		{
		
			////////////////////Inserción/////////////////////
			if($id_servicio_propuesto=='undefined'||$id_servicio_propuesto=='-1'||$id_servicio_propuesto==''){
				$id_servicio_propuesto=null;
			}
			if($id_item_propuesto=='undefined'||$id_item_propuesto=='-1'||$id_item_propuesto==''){
				$id_item_propuesto=null;
			}
			if($id_solicitud_compra_det=='-1'||$id_solicitud_compra_det=='undefined'||$id_solicitud_compra_det==''){
				$id_solicitud_compra_det=null;
			}
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarCaracteristica("insert",$id_caracteristica, $caracteristica,$descripcion,$fecha_reg,$id_solicitud_compra_det,$id_item_propuesto,$id_servicio_propuesto);

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
			
			//Validación satisfactoria, se ejecuta la inserción en la tabla tad_caracteristica
			$res = $Custom -> InsertarCaracteristica($id_caracteristica, $caracteristica, $descripcion, $fecha_reg, $id_solicitud_compra_det, $id_item_propuesto, $id_servicio_propuesto);

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
		{
			
			///////////////////////Modificación////////////////////
			if($id_servicio_propuesto=='-1'){
				$id_servicio_propuesto=NULL;
			}
			if($id_item_propuesto=='-1'){
				$id_item_propuesto=NULL;
			}
			if($id_solicitud_compra_det=='-1'){
				$id_solicitud_compra_det=NULL;
			}
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarCaracteristica("update",$id_caracteristica, $caracteristica, $descripcion, $fecha_reg, $id_solicitud_compra_det, $id_item_propuesto, $id_servicio_propuesto);

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
		
			$res = $Custom->ModificarCaracteristica($id_caracteristica, $caracteristica, $descripcion, $fecha_reg, $id_solicitud_compra_det, $id_item_propuesto, $id_servicio_propuesto);

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
	if($sortcol == "") $sortcol = "id_caracteristica";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == ""){ 
		if($m_id_servicio_propuesto!='-1')
		$criterio_filtro = "SERPRO.id_servicio_propuesto=''$m_id_servicio_propuesto''";
		if($m_id_item_propuesto!='-1')
		$criterio_filtro = "IPROPU.id_item_propuesto=''$m_id_item_propuesto''";
		if($m_id_solicitud_compra_det!='-1')
		$criterio_filtro = "SOLDET.id_solicitud_compra_det=''$m_id_solicitud_compra_det''";
	}

	$res = $Custom->ContarCaracteristica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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