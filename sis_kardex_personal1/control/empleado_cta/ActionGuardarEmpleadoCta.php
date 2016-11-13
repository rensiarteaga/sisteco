<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarEmpleadoCta.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_empleado_cta
Tabla:					tkp_tkp_empleado_cta
Parámetros:				$hidden_id_empleado_cta
						
Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-18 09:06:57
Versión:				1.0.0
Autor:					Grover Velasquez Colque
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarEmpleadoCta.php";

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
			$hidden_id_empleado_cta= $_GET["hidden_id_empleado_cta_$j"];
			$id_empleado = $_GET["id_empleado"];
			$id_gestion= $_GET["id_gestion_$j"];
			$id_cuenta= $_GET["id_cuenta_$j"];
			$id_auxiliar= $_GET["id_auxiliar_$j"];
			$estado_reg= $_GET["estado_reg_$j"];
			$id_cuenta_cobrar= $_GET["id_cuenta_cobrar_$j"];
		}
		else
		{
			$hidden_id_empleado_cta=$_POST["hidden_id_empleado_cta_$j"];
			$id_empleado=$_POST["id_empleado"];
			$id_gestion=$_POST["id_gestion_$j"];
			$id_cuenta= $_POST["id_cuenta_$j"];
			$id_auxiliar= $_POST["id_auxiliar_$j"];
			$estado_reg= $_POST["estado_reg_$j"];
			$id_cuenta_cobrar= $_POST["id_cuenta_cobrar_$j"];
		}

		if ($hidden_id_empleado_cta == "undefined" || $hidden_id_empleado_cta == "")
		{
			////////////////////Inserción/////////////////////
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarEmpleadoCta("insert",$hidden_id_empleado_cta, $id_empleado,$id_gestion,$id_cuenta,$id_auxiliar,$estado_reg);

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
			$res = $Custom -> InsertarEmpleadoCta($hidden_id_empleado_cta, $id_empleado, $id_gestion,$id_cuenta,$id_auxiliar,$estado_reg
					, $id_cuenta_cobrar
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
			$res = $Custom->ValidarEmpleadoCta("update",$hidden_id_empleado_cta, $id_empleado, $id_gestion,$id_cuenta,$id_auxiliar,$estado_reg);

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

			$res = $Custom->ModificarEmpleadoCta($hidden_id_empleado_cta, $id_empleado, $id_gestion,$id_cuenta,$id_auxiliar,$estado_reg
					, $id_cuenta_cobrar
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
	if($sortcol == "") $sortcol = "id_empleado_cta";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";
	//if($criterio_filtro == "") $criterio_filtro = "EMPCTA.id_empleado=''$id_empleado''";

	$res = $Custom->ContarEmpleadoCta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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