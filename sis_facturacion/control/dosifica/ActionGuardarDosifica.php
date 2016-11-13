<?php
/*
**********************************************************
Nombre de archivo:	    ActionGuardarDosifica.php
Propósito:				Permite insertar y modificar a dosifica
Tabla:					tfv_dosifica
Parámetros:				$hidden_id_dosifica	--> id de dosifica
$txt_descripcion
$txt_flag_comprobante
$txt_tipo_comprobante

Valores de Retorno:    	Número de registros
Fecha de Creación:		15-08-2007
Versión:				1.0.0
Autor:					Julio Guarachi López
**********************************************************
*/
session_start();
include_once("../LibModeloFactur.php");

$Custom = new cls_CustomDBFactur();
$nombre_archivo = 'ActionGuardarDosifica.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
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
		$cont =  $_POST['cantidad_ids'];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = 'NIVEL = 4';
		echo $resp->get_mensaje();
		exit;
	}
	
	//Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;

	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get){
			$hidden_id_dosifica = $_GET["hidden_id_dosifica_$j"];
			$txt_tipo_fac = $_GET["txt_tipo_fac_$j"];
			$txt_nro_inicial = $_GET["txt_nro_inicial_$j"];
			$txt_nro_actual = $_GET["txt_nro_actual_$j"];
			$txt_fecha_vence = $_GET["txt_fecha_vence_$j"];
			$txt_clave_activa = $_GET["txt_clave_activa_$j"];
			$txt_nro_autoriza = $_GET["txt_nro_autoriza_$j"];
			$txt_actividad = $_GET["txt_actividad_$j"];
			$txt_leyenda = $_GET["txt_leyenda_$j"];
			$txt_estado = $_GET["txt_estado_$j"];
			$txt_sw_debito = $_GET["txt_sw_debito_$j"];		
		}
		else{
			$hidden_id_dosifica =$_POST["hidden_id_dosifica_$j"];
			$txt_tipo_fac = $_POST["txt_tipo_fac_$j"];
			$txt_nro_inicial = $_POST["txt_nro_inicial_$j"];
			$txt_nro_actual = $_POST["txt_nro_actual_$j"];
			$txt_fecha_vence = $_POST["txt_fecha_vence_$j"];
			$txt_clave_activa = $_POST["txt_clave_activa_$j"];
			$txt_nro_autoriza =$_POST["txt_nro_autoriza_$j"];
			$txt_actividad = $_POST["txt_actividad_$j"];
			$txt_leyenda = $_POST["txt_leyenda_$j"];
			$txt_estado = $_POST["txt_estado_$j"];
			$txt_sw_debito = $_POST["txt_sw_debito_$j"];			
		}

		//Estas lineas remplazan los caracteres especiales de la llave de dosificación
		$txt_clave_activa=str_replace('?mas;','+',$txt_clave_activa);
		$txt_clave_activa=str_replace('?amp;','&amp;',$txt_clave_activa);
		$txt_clave_activa=str_replace('<','&lt;',$txt_clave_activa);
		$txt_clave_activa=str_replace('>','&gt;',$txt_clave_activa);
		
		if ($hidden_id_dosifica == "undefined" || $hidden_id_dosifica == "")
		{
			////////////////////Inserción/////////////////////
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarDosifica("insert",$hidden_id_dosifica,$txt_tipo_fac,$txt_nro_autoriza,$txt_fecha_vence,$txt_clave_activa,$txt_sw_debito,$txt_nro_inicial,$txt_nro_actual,$txt_actividad,$txt_leyenda,$txt_estado);
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

			//Validación satisfactoria, se ejecuta la inserción del cambio de lectura
			$res = $Custom -> InsertarDosifica($hidden_id_dosifica,$txt_tipo_fac,$txt_nro_autoriza,$txt_fecha_vence,$txt_clave_activa,$txt_sw_debito,$txt_nro_inicial,$txt_nro_actual,$txt_actividad,$txt_leyenda,$txt_estado);
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
			//echo $txt_clave_activa;
			
			$res = $Custom->ValidarDosifica("update",$hidden_id_dosifica,$txt_tipo_fac,$txt_nro_autoriza,$txt_fecha_vence,$txt_clave_activa,$txt_sw_debito,$txt_nro_inicial,$txt_nro_actual,$txt_actividad,$txt_leyenda,$txt_estado);
			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel =$Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			$res = $Custom->ModificarDosifica($hidden_id_dosifica,$txt_tipo_fac,$txt_nro_autoriza,$txt_fecha_vence,$txt_clave_activa,$txt_sw_debito,$txt_nro_inicial,$txt_nro_actual,$txt_actividad,$txt_leyenda,$txt_estado);
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
	if($cont > 1) $mensaje_exito = 'Se guardaron todos los datos.';
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'dos.id_dosifica';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $Custom->ContarDosifica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo('TotalCount', $total_registros);
	$resp->add_nodo('mensaje', $mensaje_exito);
	$resp->add_nodo('tiempo_resp', '200');
	echo $resp->get_mensaje();
	exit;
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 1';
	echo $resp->get_mensaje();
	exit;
}
?>