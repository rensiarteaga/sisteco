<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarDepartamentoContaConta.php
Propósito:				Permite insertar y modificar datos en la tabla tpm_depto_conta
Tabla:					tpm_depto_conta
Parámetros:				$id_depto_conta
						$id_depto
						$id_epe
						$id_uo
						$sw_central
						$sw_estado
						

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2009-06-17 10:2:13
Versión:				1.0.0
Autor:					avq
**********************************************************
*/
session_start();
include_once("../LibModeloParametros.php");

$Custom = new cls_CustomDBParametros();
$nombre_archivo = "ActionGuardarDepartamentoConta.php";

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
			$id_depto_conta= $_GET["id_depto_conta_$j"];
			$id_depto= $_GET["id_depto_$j"];
			$id_presupuesto= $_GET["id_presupuesto_$j"];
			$sw_central= $_GET["sw_central_$j"];
			$sw_estado= $_GET["sw_estado_$j"];
			$id_cuenta_auxiliar= $_GET["id_cuenta_auxiliar_$j"];
			$sw_rendicion= $_GET["sw_rendicion_$j"];
			$sw_documento= $_GET["sw_documento_$j"];
			$id_depto_conta_central= $_GET["id_depto_conta_central_$j"];
			$id_depto_tesoro= $_GET["id_depto_tesoro_$j"];
			
			$id_partida_sueldos= $_GET["id_partida_sueldos_$j"];
			$id_cuenta_auxiliar_sueldos= $_GET["id_cuenta_auxiliar_sueldos_$j"];
			$id_sucursal= $_GET["id_sucursal_$j"];
		}
		else
		{
			$id_depto_conta= $_POST["id_depto_conta_$j"];
			$id_depto= $_POST["id_depto_$j"];
			$id_presupuesto= $_POST["id_presupuesto_$j"];
			$sw_central= $_POST["sw_central_$j"];
			$sw_estado= $_POST["sw_estado_$j"];
			$id_cuenta_auxiliar= $_POST["id_cuenta_auxiliar_$j"];
            $sw_rendicion= $_POST["sw_rendicion_$j"];
            $sw_documento= $_POST["sw_documento_$j"];
            $id_depto_conta_central= $_POST["id_depto_conta_central_$j"];
			$id_depto_tesoro= $_POST["id_depto_tesoro_$j"];
			
			$id_partida_sueldos= $_POST["id_partida_sueldos_$j"]; 
			$id_cuenta_auxiliar_sueldos= $_POST["id_cuenta_auxiliar_sueldos_$j"];
			$id_sucursal= $_POST["id_sucursal_$j"];
		}

		if ($id_depto_conta == "undefined" || $id_depto_conta == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
	
			$res = $Custom->ValidarDepartamentoConta("insert",$id_depto_conta,$id_depto,$id_presupuesto,$sw_central,$sw_estado,$id_cuenta_auxiliar,$sw_rendicion,$sw_documento,$id_depto_tesoro,$id_depto_conta_central,$id_partida_sueldos,$id_cuenta_auxiliar_sueldos,$id_sucursal);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpm_depto_conta
			
			$res = $Custom -> InsertarDepartamentoConta($id_depto_conta,$id_depto,$id_presupuesto,$sw_central,$sw_estado,$id_cuenta_auxiliar,$sw_rendicion,$sw_documento,$id_depto_tesoro,$id_depto_conta_central,$id_partida_sueldos,$id_cuenta_auxiliar_sueldos,$id_sucursal);

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
			$res = $Custom->ValidarDepartamentoConta("update",$id_depto_conta,$id_depto,$id_presupuesto,$sw_central,$sw_estado,$id_cuenta_auxiliar,$sw_rendicion,$sw_documento,$id_depto_tesoro,$id_depto_conta_central,$id_partida_sueldos,$id_cuenta_auxiliar_sueldos,$id_sucursal);;

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

			$res = $Custom->ModificarDepartamentoConta($id_depto_conta,$id_depto,$id_presupuesto,$sw_central,$sw_estado,$id_cuenta_auxiliar,$sw_rendicion,$sw_documento,$id_depto_tesoro,$id_depto_conta_central,$id_partida_sueldos,$id_cuenta_auxiliar_sueldos,$id_sucursal);

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
	if($sortcol == "") $sortcol = "id_depto_conta";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarDepartamentoConta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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