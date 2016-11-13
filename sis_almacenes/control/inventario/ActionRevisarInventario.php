<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarInventario.php
Propósito:				Permite insertar y modificar datos en la tabla tal_inventario
Tabla:					tal_tal_inventario
Parámetros:				$hidden_id_inventario
						$txt_observaciones
						$txt_fecha_fin
						$txt_fecha_reg
						$txt_id_almacen
						$txt_id_responsable_almacen
						$txt_id_almacen_ep
						$txt_id_almacen_logico

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-30 18:41:53
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../scg_LibModeloAlmacenes.php");
$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = "ActionRevisarInventario.php";

if (!isset($_SESSION["autentificado"]))
{	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{	//Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0)
	{	$get=true;
		$cont=1;
		
		//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
		//valores permitidos de $cod -> "si", "no"
		switch ($cod)
		{	case "si":
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
	{	$get = false;
		$cont =  $_POST["cantidad_ids"];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{	$resp = new cls_manejo_mensajes(true, "406");
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
		{	$hidden_id_inventario= $_GET["hidden_id_inventario_$j"];
			$txt_observaciones= $_GET["txt_observaciones_$j"];
			$txt_fecha_inicio= $_GET["txt_fecha_inicio_$j"];
			$txt_fecha_fin= $_GET["txt_fecha_fin_$j"];
			$txt_fecha_reg= $_GET["txt_fecha_reg_$j"];
			$txt_tipo_inventario= $_GET["txt_tipo_inventario_$j"];
			$txt_id_almacen= $_GET["txt_id_almacen_$j"];
			$txt_id_responsable_almacen= $_GET["txt_id_responsable_almacen_$j"];
			$txt_id_almacen_ep= $_GET["txt_id_almacen_ep_$j"];
			$txt_id_almacen_logico= $_GET["txt_id_almacen_logico_$j"];
			$txt_estado= $_GET["txt_estado_$j"];
			$txt_id_almacenero= $_GET["txt_id_almacenero_$j"];
		}
		else
		{   $hidden_id_inventario=$_POST["hidden_id_inventario_$j"];
			$txt_observaciones=$_POST["txt_observaciones_$j"];
			$txt_fecha_inicio=$_POST["txt_fecha_inicio_$j"];
			$txt_fecha_fin=$_POST["txt_fecha_fin_$j"];
			$txt_fecha_reg=$_POST["txt_fecha_reg_$j"];
			$txt_tipo_inventario=$_POST["txt_tipo_inventario_$j"];
			$txt_id_almacen=$_POST["txt_id_almacen_$j"];
			$txt_id_responsable_almacen=$_POST["txt_id_responsable_almacen_$j"];
			$txt_id_almacen_ep=$_POST["txt_id_almacen_ep_$j"];
			$txt_id_almacen_logico=$_POST["txt_id_almacen_logico_$j"];
            $txt_estado=$_POST["txt_estado_$j"];
			$txt_id_almacenero=$_POST["txt_id_almacenero_$j"];
		}
				
		///////////////////////Modificación////////////////////
		//Validación de datos (del lado del servidor)
			$res = $Custom->RevisarInventario($hidden_id_inventario, $txt_observaciones, $txt_fecha_inicio, $txt_fecha_fin, $txt_fecha_reg,$txt_tipo_inventario, $txt_id_almacen, $txt_id_responsable_almacen, $txt_id_almacen_ep, $txt_id_almacen_logico,$txt_estado,$txt_id_almacenero);
			if(!$res)
			{	//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
	}//END FOR
	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];
	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_inventario";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";
	$res = $Custom->ContarInventarioResultado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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
{	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit;
}
?>