<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarAlmacen.php
Propósito:				Permite insertar y modificar datos en la tabla tal_almacen
Tabla:					tal_tal_almacen
Parámetros:				$hidden_id_almacen
						$txt_codigo
						$txt_nombre
						$txt_descripcion
						$txt_direccion
						$txt_via_fil_max
						$txt_via_col_max
						$txt_bloqueado
						$txt_cerrado
						$txt_nro_prest_pendientes
						$txt_nro_ing_no_finalizados
						$txt_nro_sal_no_finalizadas
						$txt_observaciones
						$txt_fecha_ultimo_inventario
						$txt_fecha_reg
						$txt_id_regional
	
Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-11 09:24:52
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = "ActionActualizacionValor.php";

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
	
		if ($get)
		{
			$txt_id_almacen   			    = $_GET["txt_id_almacen"];
			$txt_id_almacen_logico			= $_GET["txt_id_almacen_logico"];
			$txt_fecha						= $_GET["txt_fecha_actualizacion"];
			
										
		}
		else
		{
			$txt_id_almacen   			    = $_POST["txt_id_almacen"];
			$txt_id_almacen_logico			= $_POST["txt_id_almacen_logico"];
			$txt_fecha						= $_POST["txt_fecha_actualizacion"];
			
			

		}

			//Validación de datos (del lado del servidor)
			$res = $Custom->ActualizacionValor($txt_id_almacen,$txt_id_almacen_logico,$txt_fecha);

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
		

	

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_almacen";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	/*$res = $Custom->ContarAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;
*/
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