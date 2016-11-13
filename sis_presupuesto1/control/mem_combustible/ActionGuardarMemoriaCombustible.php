<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarMemoriaCombustible.php
Propósito:				Permite insertar y modificar datos en la tabla tpr_mem_combustible
Tabla:					tpr_tpr_mem_combustible
Parámetros:				$id_mem_combustible
						$id_memoria_calculo
						$id_moneda
						$id_combustible
						$periodo_pres
						$cantidad_combustible
						$cantidad_preferencial
						$cantidad_mercado
						$precio_mercado
						$costo_preferencial
						$costo_mercado
						$costo_total
						$porcentaje
						$total_general

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-11-04 19:39:13
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarMemoriaCombustible.php";

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
			$id_mem_combustible= $_GET["id_mem_combustible_$j"];
			$id_memoria_calculo= $_GET["id_memoria_calculo_$j"];
			$id_moneda= $_GET["id_moneda_$j"];
			$id_combustible= $_GET["id_combustible_$j"];
			$periodo_pres= $_GET["periodo_pres_$j"];
			$cantidad_combustible= $_GET["cantidad_combustible_$j"];
			$cantidad_preferencial= $_GET["cantidad_preferencial_$j"];
			$precio_preferencial= $_GET["precio_preferencial_$j"];
			$cantidad_mercado= $_GET["cantidad_mercado_$j"];
			$precio_mercado= $_GET["precio_mercado_$j"];
			$costo_preferencial= $_GET["costo_preferencial_$j"];
			$costo_mercado= $_GET["costo_mercado_$j"];
			$costo_total= $_GET["costo_total_$j"];
			$porcentaje= $_GET["porcentaje_$j"];
			$total_general= $_GET["total_general_$j"];
			$tipo_insercion=$_GET["tipo_insercion_$j"];

		}
		else
		{
			$id_mem_combustible=$_POST["id_mem_combustible_$j"];
			$id_memoria_calculo=$_POST["id_memoria_calculo_$j"];
			$id_moneda=$_POST["id_moneda_$j"];
			$id_combustible=$_POST["id_combustible_$j"];
			$periodo_pres=$_POST["periodo_pres_$j"];
			$cantidad_combustible=$_POST["cantidad_combustible_$j"];
			$cantidad_preferencial=$_POST["cantidad_preferencial_$j"];
			$precio_preferencial=$_POST["precio_preferencial_$j"];
			$cantidad_mercado=$_POST["cantidad_mercado_$j"];
			$precio_mercado=$_POST["precio_mercado_$j"];
			$costo_preferencial=$_POST["costo_preferencial_$j"];
			$costo_mercado=$_POST["costo_mercado_$j"];
			$costo_total=$_POST["costo_total_$j"];
			$porcentaje=$_POST["porcentaje_$j"];
			$total_general=$_POST["total_general_$j"];
			$tipo_insercion=$_POST["tipo_insercion_$j"];

		}

		if ($id_mem_combustible == "undefined" || $id_mem_combustible == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarMemoriaCombustible("insert",$id_mem_combustible,$id_memoria_calculo,$id_moneda,$id_combustible,$periodo_pres,$cantidad_combustible,$cantidad_preferencial,$precio_preferencial,$cantidad_mercado,$precio_mercado,$costo_preferencial,$costo_mercado,$costo_total,$porcentaje,$total_general);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_mem_combustible
			$res = $Custom -> InsertarMemoriaCombustible($id_mem_combustible,$id_memoria_calculo,$id_moneda,$id_combustible,$periodo_pres,$cantidad_combustible,$cantidad_preferencial,$precio_preferencial,$cantidad_mercado,$precio_mercado,$costo_preferencial,$costo_mercado,$costo_total,$porcentaje,$total_general,$tipo_insercion);

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
			$res = $Custom->ValidarMemoriaCombustible("update",$id_mem_combustible,$id_memoria_calculo,$id_moneda,$id_combustible,$periodo_pres,$cantidad_combustible,$cantidad_preferencial,$precio_preferencial,$cantidad_mercado,$precio_mercado,$costo_preferencial,$costo_mercado,$costo_total,$porcentaje,$total_general);

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

			$res = $Custom->ModificarMemoriaCombustible($id_mem_combustible,$id_memoria_calculo,$id_moneda,$id_combustible,$periodo_pres,$cantidad_combustible,$cantidad_preferencial,$precio_preferencial,$cantidad_mercado,$precio_mercado,$costo_preferencial,$costo_mercado,$costo_total,$porcentaje,$total_general,$tipo_insercion);

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
	if($sortcol == "") $sortcol = "id_mem_combustible";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarMemoriaCombustible($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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