<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarTipoDescuentoBono.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_TipoDescuentoBono
Tabla:					tkp_TipoDescuentoBono
Parámetros:				$tkp_id_TipoDescuentoBono, nombre, fecha_reg, estado_reg
						

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2010-08-11
Versión:				1.0.0
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarTipoDescuentoBono.php";

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
			$id_tipo_descuento_bono=$_GET["id_tipo_descuento_bono_$j"];
			$codigo=$_GET["codigo_$j"];
			$nombre=$_GET["nombre_$j"];
			$descripcion=$_GET["descripcion_$j"];
			$tipo=$_GET["tipo_$j"];
			$fecha_reg= $_GET["fecha_reg_$j"];
			$estado_reg= $_GET["estado_reg_$j"];
		
			$modalidad= $_GET["modalidad_$j"];
			$valor_modalidad_porcentual= $_GET["valor_modalidad_porcentual_$j"];
			$forma_asignacion= $_GET["forma_asignacion_$j"];
		}
		else
		{
			
			$id_tipo_descuento_bono=$_POST["id_tipo_descuento_bono_$j"];
			$codigo=$_POST["codigo_$j"];
			$nombre=$_POST["nombre_$j"];
			$descripcion=$_POST["descripcion_$j"];
			$tipo=$_POST["tipo_$j"];
			$fecha_reg= $_POST["fecha_reg_$j"];
			$estado_reg= $_POST["estado_reg_$j"];
			
			
			$modalidad= $_POST["modalidad_$j"];
			$valor_modalidad_porcentual= $_POST["valor_modalidad_porcentual_$j"];
			$forma_asignacion= $_POST["forma_asignacion_$j"];
		}
	    
               
		if ($id_tipo_descuento_bono == "undefined" || $id_tipo_descuento_bono== "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarTipoDescuentoBono("insert",$id_tipo_descuento_bono,$codigo,$nombre,$descripcion,$tipo,$fecha_reg,$estado_reg);

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
			
			//Validación satisfactoria, se ejecuta la inserción en la tabla tsg_persona y tkp_relacion_familiar
			$res = $Custom -> InsertarTipoDescuentoBono($id_tipo_descuento_bono,$codigo,$nombre,$descripcion,$tipo,$fecha_reg,$estado_reg,$modalidad,$valor_modalidad_porcentual,$forma_asignacion);
			
				if(!$res){
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
			$res = $Custom->ValidarTipoDescuentoBono("update",$id_tipo_descuento_bono,$codigo,$nombre,$descripcion,$tipo,$fecha_reg,$estado_reg);

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

			$res = $Custom->ModificarTipoDescuentoBono($id_tipo_descuento_bono,$codigo,$nombre,$descripcion,$tipo,$fecha_reg,$estado_reg,$modalidad,$valor_modalidad_porcentual,$forma_asignacion);

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
	if($sortcol == "") $sortcol = "id_tipo_descuento_bono";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarTipoDescuentoBono($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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