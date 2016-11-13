<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCartaRegistro.php
Propósito:				Permite insertar y modificar datos en la tabla tts_carta
Tabla:					tts_tts_carta
Parámetros:				$id_carta
						$id_fina_regi_prog_proy_acti
						$id_unidad_organizacional
						$id_moneda
						$clase_carta
						$tipo_carta
						$estado_carta
						$id_cuenta_bancaria
						$id_institucion
						$id_proveedor
						$fecha_inicio
						$fecha_vence
						$obs_carta
						$importe_carta
						$importe_pagado
						$id_cheque
						$id_comprobante
						$fk_carta

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-11-18 20:39:05
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = "ActionGuardarCartaAmortizacionDetalle.php";

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
		{	$id_carta= $_GET["id_carta_$j"];
			$fecha_inicio= $_GET["fecha_inicio_$j"];
			$importe_pagado= $_GET["importe_pagado_$j"];
			$fk_carta= $_GET["fk_carta_$j"];
         }
		else
		{	$id_carta=$_POST["id_carta_$j"];
			$fecha_inicio=$_POST["fecha_inicio_$j"];
			$importe_pagado=$_POST["importe_pagado_$j"];
			$fk_carta=$_POST["fk_carta_$j"];
         	}

		if ($id_carta == "undefined" || $id_carta == "")
		{
			
			//Validación satisfactoria, se ejecuta la inserción en la tabla tts_carta
			$res = $Custom -> InsertarCartaAmortizacionDetalle($id_carta,$fecha_inicio,$importe_pagado,$fk_carta);

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
						
			$res = $Custom->ModificarCartaAmortizacionDetalle($id_carta,$fecha_inicio,$importe_pagado,$fk_carta);

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
	if($sortcol == "") $sortcol = "id_carta";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "CARTA.fk_carta=''$fk_carta''";

	$res = $Custom->ContarCartaRegistro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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