<?php
/*
**********************************************************
Nombre de archivo:	    ActionGuardarProcesoTipoCuenta.php
Propósito:				Permite insertar y modificarProcesoTipoCuenta

Parámetros:										

Valores de Retorno:    	Número de registros
Fecha de Creación:		06-06-2007
Versión:				
Autor:					
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");


$CustomActivos = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionGuardarProcesoTipoCuenta.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	//Verifica si los datos vienen por post o get
	if (sizeof($_GET) >0)
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
	elseif(sizeof($_POST) >0)
	{
		$get=false;
		$cont =  $_POST['cantidad_ids'];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar";
		$resp->origen = "ORIGEN= $nombre_archivo";
		$resp->proc = "PROC =$nombre_archivo";
		$resp->nivel = 'NIVEL = 4';
		echo $resp->get_mensaje();
		exit;
	}
	
	//Envia al Custom la bandera que indica si se decodificará o no
	$CustomActivos->decodificar = $decodificar;

	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$id_proceso_tipo_cuenta = $_GET["id_proceso_tipo_cuenta_$j"];
			$txt_des_proceso = $_GET["txt_des_proceso_$j"];
			$hidden_id_proceso = $_GET["hidden_id_proceso_$j"];
			$maestro_id_proceso=$_GET["maestro_id_proceso"];
			$debe_haber=$_GET["debe_haber_$j"];
		}
		else
		{
			$id_proceso_tipo_cuenta = $_POST["id_proceso_tipo_cuenta_$j"];
			$txt_des_proceso = $_POST["txt_des_proceso_$j"];
			$hidden_id_proceso = $_POST["hidden_id_proceso_$j"];
			$maestro_id_proceso=$_POST["maestro_id_proceso"];
			$debe_haber=$_POST["debe_haber_$j"];
		}


		if ($id_proceso_tipo_cuenta == "undefined" || $id_proceso_tipo_cuenta=="")
		{
			
			///////////////////Inserción
			//Validación de datos (del lado del servidor)
			$res = $CustomActivos->ValidarProcesoTipoCuenta("insert",$id_proceso_tipo_cuenta,$txt_des_proceso,$hidden_id_proceso);
			
			if(!$res)
			{
				///Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $CustomActivos->salida[1];
				$resp->origen = $CustomActivos->salida[2];
				$resp->proc = $CustomActivos->salida[3];
				$resp->nivel = $CustomActivos->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			$res = $CustomActivos ->InsertarProcesoTipoCuenta($txt_des_proceso,$hidden_id_proceso,$debe_haber);
				
			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $CustomActivos->salida[1];
				$resp->origen = $CustomActivos->salida[2];
				$resp->proc = $CustomActivos->salida[3];
				$resp->nivel = $CustomActivos->salida[4];
				$resp->query = $CustomActivos->query;
				echo $resp->get_mensaje();
				exit;
			}
			
		}
		else
		{	
			//Modificación
			//Validación de datos (del lado del servidor)
			$res = $CustomActivos->ValidarProcesoTipoCuenta("update",$id_proceso_tipo_cuenta,$txt_des_proceso,$maestro_id_proceso);
			
			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $CustomActivos->salida[1];
				$resp->origen = $CustomActivos->salida[2];
				$resp->proc = $CustomActivos->salida[3];
				$resp->nivel = $CustomActivos->salida[4];
				echo $resp->get_mensaje();
				exit;
			}
				
			$res = $CustomActivos->ModificarProcesoTipoCuenta($id_proceso_tipo_cuenta,$txt_des_proceso,$maestro_id_proceso,$debe_haber);
			/*echo "**".$hidden_id_activo_fijo_proceso."    mon_an:".$txt_monto_vigente_anterior."    mon_Act:".$txt_monto_vigente_actual."    vu_ant:".$txt_vida_util_anterior."    vu_act:".$txt_vida_util_actual."    comprob:".$txt_comprobante_id."    aplica:".$txt_aplicado."    estad:".$txt_estado."    fecha:".$txt_fecha_reg."    f_apro:".$txt_fecha_aprobacion."    f_aplic:".$txt_fecha_aplicacion."    id_".$hidden_id_activo_fijo."    id_proc:".$hidden_id_proceso."    id_moti:".$hidden_id_motivo;
			exit;
			*///echo $hidden_id_activo_fijo_proceso;
			if(!$res)
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $CustomActivos->salida[1];
				$resp->origen = $CustomActivos->salida[2];
				$resp->proc = $CustomActivos->salida[3];
				$resp->nivel = $CustomActivos->salida[4];
				$resp->query = $CustomActivos->query;
				echo $resp->get_mensaje();
				exit;
			}
		}

	}//END FOR

	/***************no entra aqui cuando es $_GET*************/
	///Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = 'Se guardaron todos los datos.';
	else $mensaje_exito = $CustomActivos->salida[1];
	
	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'nombres';
	if($sortdir == "") $sortdir = 'asc';
	//if($criterio_filtro == "") $criterio_filtro = '0=0';
	
	if($criterio_filtro=="") $criterio_filtro=" prot.id_proceso = $hidden_id_proceso";
 
	$res = $CustomActivos->ContarProcesoTipoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	if($res) $total_registros = $CustomActivos->salida;

	
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