<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarTipoServicioCuentaPartida.php
Propósito:				Permite insertar y modificar datos en la tabla tad_tipo_servicio_cuenta_partida
Tabla:					tad_tad_tipo_servicio_cuenta_partida
Parámetros:				$id_tipo_servicio_cuenta_partida
						$id_cuenta
						$id_partida
						$id_gestion
						$gestion
						$fecha_reg
						$id_servicio

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-12-10 09:59:08
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarTipoServicioCuentaPartida.php";

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
			$id_tipo_servicio_cuenta_partida= $_GET["id_tipo_servicio_cuenta_partida_$j"];
			$id_cuenta= $_GET["id_cuenta_$j"];
			$id_partida= $_GET["id_partida_$j"];
			$id_gestion= $_GET["id_gestion_$j"];
			$gestion= $_GET["gestion_$j"];
			$fecha_reg= $_GET["fecha_reg_$j"];
			$id_servicio= $_GET["id_servicio_$j"];
            $id_auxiliar= $_GET["id_auxiliar_$j"];
            $id_presupuesto= $_GET["id_presupuesto_$j"];
           
		}
		else
		{
			$id_tipo_servicio_cuenta_partida=$_POST["id_tipo_servicio_cuenta_partida_$j"];
			$id_cuenta=$_POST["id_cuenta_$j"];
			$id_partida=$_POST["id_partida_$j"];
			$id_gestion=$_POST["id_gestion_$j"];
			$gestion=$_POST["gestion_$j"];
			$fecha_reg=$_POST["fecha_reg_$j"];
			$id_servicio=$_POST["id_servicio_$j"];
			$id_auxiliar= $_POST["id_auxiliar_$j"];
			$id_presupuesto= $_POST["id_presupuesto_$j"];

		}

		if ($id_tipo_servicio_cuenta_partida == "undefined" || $id_tipo_servicio_cuenta_partida == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarTipoServicioCuentaPartida("insert",$id_tipo_servicio_cuenta_partida,$id_cuenta,$id_partida,$id_gestion,$gestion,$fecha_reg,$id_servicio);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tad_tipo_servicio_cuenta_partida
			$res = $Custom -> InsertarTipoServicioCuentaPartida($id_tipo_servicio_cuenta_partida,$id_cuenta,$id_partida,$id_gestion,$gestion,$fecha_reg,$id_servicio,$id_auxiliar,$id_presupuesto);

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
			$res = $Custom->ValidarTipoServicioCuentaPartida("update",$id_tipo_servicio_cuenta_partida,$id_cuenta,$id_partida,$id_gestion,$gestion,$fecha_reg,$id_servicio);

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

			$res = $Custom->ModificarTipoServicioCuentaPartida($id_tipo_servicio_cuenta_partida,$id_cuenta,$id_partida,$id_gestion,$gestion,$fecha_reg,$id_servicio,$id_auxiliar,$id_presupuesto);

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
	if($sortcol == "") $sortcol = "id_tipo_servicio_cuenta_partida";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarTipoServicioCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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