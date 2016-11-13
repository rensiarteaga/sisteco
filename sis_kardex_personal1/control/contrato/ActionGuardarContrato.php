<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarContrato.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_Contrato
Tabla:					tkp_Contrato
Parámetros:				$tkp_id_Contrato, nombre, fecha_reg, estado_reg
						

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2010-08-11
Versión:				1.0.0
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarContrato.php";

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
			$id_contrato=$_GET["id_contrato_$j"];
			$nro_contrato=$_GET["nro_contrato_$j"];
			$tipo_contrato=$_GET["tipo_contrato_$j"];
			$sueldo=$_GET["sueldo_$j"];
			$id_moneda=$_GET["id_moneda_$j"];
			$fecha_ini=$_GET["fecha_ini_$j"];
			$fecha_fin=$_GET["fecha_fin_$j"];
			$fecha_reg= $_GET["fecha_reg_$j"];
			$estado_reg= $_GET["estado_reg_$j"];
			$id_empleado=$_GET["id_empleado_$j"];
			
			$forma_pago=$_GET["forma_pago_$j"];
			$tiene_quincena=$_GET["tiene_quincena_$j"];
			$porcen_quincena=$_GET["porcen_quincena_$j"];
			$socio_cooperativa=$_GET["socio_cooperativa_$j"];
			$monto_fijo=$_GET["monto_fijo_$j"];
			$porcen_fijo_cooperativa=$_GET["porcen_fijo_cooperativa_$j"];
			$fecha_inicio_quincena= $_GET["fecha_inicio_quincena_$j"];
			$fecha_inicio_socio= $_GET["fecha_inicio_socio_$j"];
		$tipo_registro_contrato= $_GET["tipo_registro_contrato_$j"];
		}
		else
		{
			
			
			$id_contrato=$_POST["id_contrato_$j"];
			$nro_contrato=$_POST["nro_contrato_$j"];
			$tipo_contrato=$_POST["tipo_contrato_$j"];
			$sueldo=$_POST["sueldo_$j"];
			$id_moneda=$_POST["id_moneda_$j"];
			$fecha_ini=$_POST["fecha_ini_$j"];
			$fecha_fin=$_POST["fecha_fin_$j"];
			$fecha_reg= $_POST["fecha_reg_$j"];
			$estado_reg= $_POST["estado_reg_$j"];
			$id_empleado=$_POST["id_empleado_$j"];
			
			$forma_pago=$_POST["forma_pago_$j"];
			$tiene_quincena=$_POST["tiene_quincena_$j"];
			$porcen_quincena=$_POST["porcen_quincena_$j"];
			$socio_cooperativa=$_POST["socio_cooperativa_$j"];
			$monto_fijo=$_POST["monto_fijo_$j"];
			$porcen_fijo_cooperativa=$_POST["porcen_fijo_cooperativa_$j"];
			
			$fecha_inicio_quincena= $_POST["fecha_inicio_quincena_$j"];
			$fecha_inicio_socio= $_POST["fecha_inicio_socio_$j"];
			$tipo_registro_contrato= $_POST["tipo_registro_contrato_$j"];
		}
	   
             
		if ($id_contrato == "undefined" || $id_contrato== "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarContrato("insert",$id_contrato,$nro_contrato,$tipo_contrato,$sueldo,$id_moneda,$fecha_ini,$fecha_fin,$fecha_reg,$estado_reg,$id_empleado);

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
			$res = $Custom -> InsertarContrato($id_contrato,$nro_contrato,$tipo_contrato,$sueldo,$id_moneda,$fecha_ini,$fecha_fin,$fecha_reg,$estado_reg,$id_empleado,
			$forma_pago,$tiene_quincena,$porcen_quincena,$socio_cooperativa,$monto_fijo,$porcen_fijo_cooperativa,$fecha_inicio_quincena,$tipo_registro_contrato);
			
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
			$res = $Custom->ValidarContrato("update",$id_contrato,$nro_contrato,$tipo_contrato,$sueldo,$id_moneda,$fecha_ini,$fecha_fin,$fecha_reg,$estado_reg,$id_empleado);

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

			$res = $Custom->ModificarContrato($id_contrato,$nro_contrato,$tipo_contrato,$sueldo,$id_moneda,$fecha_ini,$fecha_fin,$fecha_reg,$estado_reg,$id_empleado,
			$forma_pago,$tiene_quincena,$porcen_quincena,$socio_cooperativa,$monto_fijo,$porcen_fijo_cooperativa,$fecha_inicio_quincena,$tipo_registro_contrato);

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
	if($sortcol == "") $sortcol = "CONTRA.fecha_ini";
	if($sortdir == "") $sortdir = "desc";
	if($criterio_filtro == "") $criterio_filtro = "CONTRA.id_empleado=$id_empleado";

	$res = $Custom->ContarContrato($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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