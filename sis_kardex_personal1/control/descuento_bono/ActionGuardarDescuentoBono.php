<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarDescuentoBono.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_descuento_bono
Tabla:					tkp_tkp_descuento_bono
Parámetros:				$id_descuento_bono
						$id_empleado
						$id_afp
						$nro_afp
						$fecha_reg, estado_reg

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		12-08-2010
Versión:				1.0.0
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarDescuentoBono.php";

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
			$id_descuento_bono= $_GET["id_descuento_bono_$j"];
			$id_tipo_descuento_bono=$_GET["id_tipo_descuento_bono_$j"];
			$id_empleado= $_GET["id_empleado_$j"];
			$id_moneda=$_GET["id_moneda_$j"];
			$monto_total=$_GET["monto_total_$j"];
			$num_cuotas=$_GET["num_cuotas_$j"];
			$monto_faltante=$_GET["monto_faltante_$j"];
			$valor_por_cuota=$_GET["valor_por_cuota_$j"];
			$fecha_ini=$_GET["fecha_ini_$j"];
			$txt_fecha_reg= $_GET["txt_fecha_reg_$j"];
			$estado_reg= $_GET["estado_reg_$j"];
			$cuotas= $_GET["cuotas_$j"];
			$fecha_fin= $_GET["fecha_fin_$j"];
		}
		else
		{
			
			$id_descuento_bono= $_POST["id_descuento_bono_$j"];
			$id_tipo_descuento_bono=$_POST["id_tipo_descuento_bono_$j"];
			$id_empleado= $_POST["id_empleado_$j"];
			$id_moneda=$_POST["id_moneda_$j"];
			$monto_total=$_POST["monto_total_$j"];
			$num_cuotas=$_POST["num_cuotas_$j"];
			$monto_faltante=$_POST["monto_faltante_$j"];
			$valor_por_cuota=$_POST["valor_por_cuota_$j"];
			$fecha_ini=$_POST["fecha_ini_$j"];
			$txt_fecha_reg= $_POST["txt_fecha_reg_$j"];
			$estado_reg= $_POST["estado_reg_$j"];
			$cuotas= $_POST["cuotas_$j"];
			$fecha_fin= $_POST["fecha_fin_$j"];
		}

		if ($id_descuento_bono == "undefined" || $id_descuento_bono== "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarDescuentoBono("insert",$id_descuento_bono, $id_tipo_descuento_bono,$id_empleado,$id_moneda,$monto_total,$num_cuotas,$monto_faltante,$valor_por_cuota,$fecha_ini,$fecha_reg,$estado_reg);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tkp_empleado_tpm_frppa
			$res = $Custom -> InsertarDescuentoBono($id_descuento_bono, $id_tipo_descuento_bono,$id_empleado,$id_moneda,$monto_total,$num_cuotas,$monto_faltante,$valor_por_cuota,$fecha_ini,$fecha_reg,$estado_reg,$cuotas
			,$fecha_fin
			);

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
			$res = $Custom->ValidarDescuentoBono("update",$id_descuento_bono, $id_tipo_descuento_bono,$id_empleado,$id_moneda,$monto_total,$num_cuotas,$monto_faltante,$valor_por_cuota,$fecha_ini,$fecha_reg,$estado_reg);

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

			$res = $Custom->ModificarDescuentoBono($id_descuento_bono, $id_tipo_descuento_bono,$id_empleado,$id_moneda,$monto_total,$num_cuotas,$monto_faltante,$valor_por_cuota,$fecha_ini,$fecha_reg,$estado_reg,$cuotas
			,$fecha_fin
			);

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
	if($sortcol == "") $sortcol = "id_descuento_bono";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "EMPLEA.id_empleado=''$m_id_empleado''";

	$res = $Custom->ContarDescuentoBono($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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