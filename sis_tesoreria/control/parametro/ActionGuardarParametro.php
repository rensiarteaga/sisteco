<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarParametro.php
Propósito:				Permite insertar y modificar datos en la tabla tts_parametro
Tabla:					tts_parametro
Parámetros:				$id_parametro
						$gestion_pres
						$estado_gral
						$cod_institucional
						$porcentaje_sobregiro
						$cantidad_niveles

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-07-02 22:23:50
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = "ActionGuardarParametro.php";

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
		if ($get){
			$id_parametro= $_GET["id_parametro_$j"];
			$id_gestion= $_GET["id_gestion_$j"];
			$cantidad_nivel= $_GET["cantidad_nivel_$j"];
			$estado_gestion= $_GET["estado_gestion_$j"];
			$gestion_tesoro= $_GET["gestion_tesoro_$j"];
			
			$max_sol_pendientes_viatico= $_GET["max_sol_pendientes_viatico_$j"];
			$max_sol_pendientes_fa= $_GET["max_sol_pendientes_fa_$j"];
			$sw_descuento_viaticos= $_GET["sw_descuento_viaticos_$j"];
			$dias_aplica_descuentos= $_GET["dias_aplica_descuentos_$j"];
			$porcentaje_descuento= $_GET["porcentaje_descuento_$j"];
			$max_sol_pendientes_efe= $_GET["max_sol_pendientes_efe_$j"];
			
			$sw_detiene = $_GET["sw_detiene_$j"];
			$fecha_del = $_GET["fecha_del_$j"];
			$fecha_al = $_GET["fecha_al_$j"];
			$fecha_fin_viaje = $_GET["fecha_fin_viaje_$j"];
			$fecha_fin_viaje_al = $_GET["fecha_fin_viaje_al_$j"];
		}else{
			$id_parametro= $_POST["id_parametro_$j"];
			$id_gestion= $_POST["id_gestion_$j"];
			$cantidad_nivel= $_POST["cantidad_nivel_$j"];
			$estado_gestion= $_POST["estado_gestion_$j"];
			$gestion_tesoro= $_POST["gestion_tesoro_$j"];
			
			$max_sol_pendientes_viatico= $_POST["max_sol_pendientes_viatico_$j"];
			$max_sol_pendientes_fa= $_POST["max_sol_pendientes_fa_$j"];
			$sw_descuento_viaticos= $_POST["descuento_viaticos_$j"];
			$dias_aplica_descuento= $_POST["dias_aplica_descuento_$j"];
			$porcentaje_descuento= $_POST["porcentaje_descuento_$j"];
			$max_sol_pendientes_efe= $_POST["max_sol_pendientes_efe_$j"];
			
			$sw_detiene = $_POST["sw_detiene_$j"];
			$fecha_del = $_POST["fecha_del_$j"];
			$fecha_al = $_POST["fecha_al_$j"];
			$fecha_fin_viaje = $_POST["fecha_fin_viaje_$j"];
			$fecha_fin_viaje_al = $_POST["fecha_fin_viaje_al_$j"];
		}

		if ($id_parametro == "undefined" || $id_parametro == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarParametro("insert",$id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_tesoro);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_parametro
			$res = $Custom -> InsertarParametro($id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_tesoro,$max_sol_pendientes_viatico,$max_sol_pendientes_fa,$sw_descuento_viaticos,$dias_aplica_descuento,$porcentaje_descuento,$max_sol_pendientes_efe,$sw_detiene,$fecha_del,$fecha_al,$fecha_fin_viaje,$fecha_fin_viaje_al);

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
			$res = $Custom->ValidarParametro("update",$id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_tesoro);

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

			$res = $Custom->ModificarParametro($id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_tesoro,$max_sol_pendientes_viatico,$max_sol_pendientes_fa,$sw_descuento_viaticos,$dias_aplica_descuento,$porcentaje_descuento,$max_sol_pendientes_efe,$sw_detiene,$fecha_del,$fecha_al,$fecha_fin_viaje,$fecha_fin_viaje_al);

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
	if($sortcol == "") $sortcol = "GESTIO.gestion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarParametro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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