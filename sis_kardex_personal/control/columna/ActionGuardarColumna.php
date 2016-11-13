<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarColumna.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_columna
Tabla:					tkp_tkp_columna
Parámetros:				$id_columna
						$id_tipo_planilla
						$id_columna_tipo
						$formula
						$valor_defecto
						$estado_reg
						$fecha_reg
						$id_usuario

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2010-08-19 10:28:40
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarColumna.php";

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
			$id_columna= $_GET["id_columna_$j"];
			$id_tipo_planilla=$_GET["id_tipo_planilla"];
			$id_columna_tipo= $_GET["id_columna_tipo_$j"];
			$formula= $_GET["formula_$j"];
			$valor_defecto= $_GET["valor_defecto_$j"];
			$estado_reg= $_GET["estado_reg_$j"];
			$en_reporte= $_GET["en_reporte_$j"];
			$orden_reporte= $_GET["orden_reporte_$j"];
			$total= $_GET["total_$j"];
			$orden_ejecucion=$_GET["orden_ejecucion_$j"];
			$fecha_inicio=$_GET["fecha_inicio_$j"];
		}
		else
		{
			$id_columna=$_POST["id_columna_$j"];
			$id_tipo_planilla=$_POST["id_tipo_planilla"];
			$id_columna_tipo=$_POST["id_columna_tipo_$j"];
			$formula=$_POST["formula_$j"];
			$valor_defecto=$_POST["valor_defecto_$j"];
			$estado_reg=$_POST["estado_reg_$j"];
			$en_reporte= $_POST["en_reporte_$j"];
			$orden_reporte= $_POST["orden_reporte_$j"];
			$total= $_POST["total_$j"];
			$orden_ejecucion=$_POST["orden_ejecucion_$j"];
			$fecha_inicio=$_POST["fecha_inicio_$j"];
		}

		if ($id_columna == "undefined" || $id_columna == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarColumna("insert",$id_columna, $id_tipo_planilla,$id_columna_tipo,$formula,$valor_defecto,$estado_reg);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tkp_columna
			$res = $Custom -> InsertarColumna($id_columna, $id_tipo_planilla,$id_columna_tipo,$formula,$valor_defecto,$estado_reg,$en_reporte,$orden_reporte,$total,$orden_ejecucion,$fecha_inicio);

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
			$res = $Custom->ValidarColumna("update",$id_columna, $id_tipo_planilla,$id_columna_tipo,$formula,$valor_defecto,$estado_reg);

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

			$res = $Custom->ModificarColumna($id_columna, $id_tipo_planilla,$id_columna_tipo,$formula,$valor_defecto,$estado_reg,$en_reporte,$orden_reporte,$total,
			$orden_ejecucion,$fecha_inicio);

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
	if($sortcol == "") $sortcol = "id_columna";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "COLUMNA.id_tipo_planilla=''$id_tipo_planilla''";

	$res = $Custom->ContarColumna($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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