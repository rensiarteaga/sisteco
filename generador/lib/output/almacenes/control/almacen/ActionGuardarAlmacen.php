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
						$txt_bloquear
						$txt_cerrado
						$txt_nro_prest_pendientes
						$txt_nro_ing_no_finalizados
						$txt_nro_sal_no_finalizadas
						$txt_observaciones
						$txt_fecha_ultimo_inventario
						$txt_fecha_reg
						$txt_id_regional
	
Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-11 16:16:55
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = "ActionGuardarAlmacen.php";

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
			$hidden_id_almacen						= $_GET["hidden_id_almacen_$j"];
			$txt_codigo						= $_GET["txt_codigo_$j"];
			$txt_nombre						= $_GET["txt_nombre_$j"];
			$txt_descripcion						= $_GET["txt_descripcion_$j"];
			$txt_direccion						= $_GET["txt_direccion_$j"];
			$txt_via_fil_max						= $_GET["txt_via_fil_max_$j"];
			$txt_via_col_max						= $_GET["txt_via_col_max_$j"];
			$txt_bloqueado						= $_GET["txt_bloqueado_$j"];
			$txt_bloquear						= $_GET["txt_bloquear_$j"];
			$txt_cerrado						= $_GET["txt_cerrado_$j"];
			$txt_nro_prest_pendientes						= $_GET["txt_nro_prest_pendientes_$j"];
			$txt_nro_ing_no_finalizados						= $_GET["txt_nro_ing_no_finalizados_$j"];
			$txt_nro_sal_no_finalizadas						= $_GET["txt_nro_sal_no_finalizadas_$j"];
			$txt_observaciones						= $_GET["txt_observaciones_$j"];
			$txt_fecha_ultimo_inventario						= $_GET["txt_fecha_ultimo_inventario_$j"];
			$txt_fecha_reg						= $_GET["txt_fecha_reg_$j"];
			$txt_id_regional						= $_GET["txt_id_regional_$j"];
							
		}
		else
		{
			$hidden_id_almacen						= $_POST["hidden_id_almacen_$j"];
			$txt_codigo						= $_POST["txt_codigo_$j"];
			$txt_nombre						= $_POST["txt_nombre_$j"];
			$txt_descripcion						= $_POST["txt_descripcion_$j"];
			$txt_direccion						= $_POST["txt_direccion_$j"];
			$txt_via_fil_max						= $_POST["txt_via_fil_max_$j"];
			$txt_via_col_max						= $_POST["txt_via_col_max_$j"];
			$txt_bloqueado						= $_POST["txt_bloqueado_$j"];
			$txt_bloquear						= $_POST["txt_bloquear_$j"];
			$txt_cerrado						= $_POST["txt_cerrado_$j"];
			$txt_nro_prest_pendientes						= $_POST["txt_nro_prest_pendientes_$j"];
			$txt_nro_ing_no_finalizados						= $_POST["txt_nro_ing_no_finalizados_$j"];
			$txt_nro_sal_no_finalizadas						= $_POST["txt_nro_sal_no_finalizadas_$j"];
			$txt_observaciones						= $_POST["txt_observaciones_$j"];
			$txt_fecha_ultimo_inventario						= $_POST["txt_fecha_ultimo_inventario_$j"];
			$txt_fecha_reg						= $_POST["txt_fecha_reg_$j"];
			$txt_id_regional						= $_POST["txt_id_regional_$j"];
			
		}

		if ($hidden_id_almacen == "undefined" || $hidden_id_almacen == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarAlmacen("insert",$hidden_id_almacen, $txt_codigo, $txt_nombre, $txt_descripcion, $txt_direccion, $txt_via_fil_max, $txt_via_col_max, $txt_bloqueado, $txt_bloquear, $txt_cerrado, $txt_nro_prest_pendientes, $txt_nro_ing_no_finalizados, $txt_nro_sal_no_finalizadas, $txt_observaciones, $txt_fecha_ultimo_inventario, $txt_fecha_reg, $txt_id_regional);
			
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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tal_almacen
			$res = $Custom -> InsertarAlmacen($hidden_id_almacen, $txt_codigo, $txt_nombre, $txt_descripcion, $txt_direccion, $txt_via_fil_max, $txt_via_col_max, $txt_bloqueado, $txt_bloquear, $txt_cerrado, $txt_nro_prest_pendientes, $txt_nro_ing_no_finalizados, $txt_nro_sal_no_finalizadas, $txt_observaciones, $txt_fecha_ultimo_inventario, $txt_fecha_reg, $txt_id_regional);

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
			$res = $Custom->ValidarAlmacen("update",$hidden_id_almacen, $txt_codigo, $txt_nombre, $txt_descripcion, $txt_direccion, $txt_via_fil_max, $txt_via_col_max, $txt_bloqueado, $txt_bloquear, $txt_cerrado, $txt_nro_prest_pendientes, $txt_nro_ing_no_finalizados, $txt_nro_sal_no_finalizadas, $txt_observaciones, $txt_fecha_ultimo_inventario, $txt_fecha_reg, $txt_id_regional);

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

			$res = $Custom->ModificarAlmacen($hidden_id_almacen, $txt_codigo, $txt_nombre, $txt_descripcion, $txt_direccion, $txt_via_fil_max, $txt_via_col_max, $txt_bloqueado, $txt_bloquear, $txt_cerrado, $txt_nro_prest_pendientes, $txt_nro_ing_no_finalizados, $txt_nro_sal_no_finalizadas, $txt_observaciones, $txt_fecha_ultimo_inventario, $txt_fecha_reg, $txt_id_regional);

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
	if($sortcol == "") $sortcol = "id_almacen";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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