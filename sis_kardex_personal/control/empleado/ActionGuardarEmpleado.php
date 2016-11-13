<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarEmpleado.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_empleado
Tabla:					tkp_tkp_empleado
Parámetros:				$hidden_id_empleado
						$txt_id_persona
						$txt_codigo_empleado

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-18 09:06:57
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarEmpleado.php";

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
			$hidden_id_empleado= $_GET["hidden_id_empleado_$j"];
			$txt_id_persona= $_GET["txt_id_persona_$j"];
			$txt_codigo_empleado= $_GET["txt_codigo_empleado_$j"];
			$id_cuenta= $_GET["id_cuenta_$j"];
			$id_auxiliar= $_GET["id_auxiliar_$j"];
			$estado_reg= $_GET["estado_reg_$j"];
		//	$fecha_reg= $_GET["fecha_reg_$j"];
			$id_depto=$_GET["id_depto_$j"];
			$id_lugar=$_GET["id_lugar_$j"];
			$fecha_ingreso=$_GET["fecha_ingreso_$j"];
			$antiguedad_ant=$_GET["antiguedad_ant_$j"];
			$id_escala_salarial=$_GET["id_escala_salarial_$j"];
			$compensa=$_GET["compensa_$j"];
			$marca=$_GET["marca_$j"];
			$mail=$_GET["txt_email1_$j"];
			$nivel_academico=$_GET["nivel_academico_$j"];
			$cambio_mail=$_GET["cambio_mail_$j"];
			$tiene_descuentos=$_GET["tiene_descuento_$j"];
			//2016
			$nro_interno=$_GET["nro_interno_$j"];
			$nro_celular_empresa=$_GET["nro_celular_empresa_$j"];
		}
		else
		{
			$hidden_id_empleado=$_POST["hidden_id_empleado_$j"];
			$txt_id_persona=$_POST["txt_id_persona_$j"];
			$txt_codigo_empleado=$_POST["txt_codigo_empleado_$j"];
			$id_cuenta= $_POST["id_cuenta_$j"];
			$id_auxiliar= $_POST["id_auxiliar_$j"];
			$estado_reg= $_POST["estado_reg_$j"];
			$fecha_reg= $_POST["fecha_reg_$j"];
			$id_depto=$_POST["id_depto_$j"];
			$id_lugar=$_POST["id_lugar_$j"];
			$fecha_ingreso=$_POST["fecha_ingreso_$j"];
			$antiguedad_ant=$_POST["antiguedad_ant_$j"];
			$id_escala_salarial=$_POST["id_escala_salarial_$j"];
			$compensa=$_POST["compensa_$j"];
			$marca=$_POST["marca_$j"];
			$mail=$_POST["txt_email1_$j"];
			$nivel_academico=$_POST["nivel_academico_$j"];
			$cambio_mail=$_POST["cambio_mail_$j"];
			$tiene_descuento=$_POST["tiene_descuento_$j"];
			//2016
			$nro_interno=$_POST["nro_interno_$j"];
			$nro_celular_empresa=$_POST["nro_celular_empresa_$j"];
		}
		$marca=$marca.'-'.$mail;
		

		if ($hidden_id_empleado == "undefined" || $hidden_id_empleado == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarEmpleado("insert",$hidden_id_empleado, $txt_id_persona,$txt_codigo_empleado,$id_cuenta,$id_auxiliar,$estado_reg,$fecha_reg);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tkp_empleado
			$res = $Custom -> InsertarEmpleado($hidden_id_empleado, $txt_id_persona, $txt_codigo_empleado,$id_cuenta,$id_auxiliar,$estado_reg,$fecha_reg,$id_depto,$id_lugar,$fecha_ingreso,$antiguedad_ant,$id_escala_salarial,$compensa,$marca,$nivel_academico
			,$tiene_descuento
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
			$res = $Custom->ValidarEmpleado("update",$hidden_id_empleado, $txt_id_persona, $txt_codigo_empleado,$id_cuenta,$id_auxiliar,$estado_reg,$fecha_reg);

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

			if($cambio_mail=='si'){
				   $res = $Custom->ModificarEmpleadoCorreo($hidden_id_empleado,$mail,$nro_interno, $nro_celular_empresa);

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
				
				
			}else{
			
					$res = $Custom->ModificarEmpleado($hidden_id_empleado, $txt_id_persona, $txt_codigo_empleado,$id_cuenta,$id_auxiliar,$estado_reg,$fecha_reg,$id_depto,$id_lugar,$fecha_ingreso,$antiguedad_ant,$id_escala_salarial,$compensa,$marca,$nivel_academico
					,$tiene_descuento
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
		}

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_empleado";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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