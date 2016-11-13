<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCheque.php
Propósito:				Permite insertar y modificar datos en la tabla tct_cheque
Tabla:					tct_tct_cheque
Parámetros:				$id_cheque
						$id_transaccion
						$nro_cheque
						$nro_deposito
						$nro_deposito
						$fecha_cheque
						$nombre_cheque
						$estado_cheque
						$id_cuenta_bancaria

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-10-17 11:24:35
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = "ActionModificarCheque.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
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
    if ($get){
    	$m_fecha_inicio= $_GET["m_fecha_inicio"];
		$m_fecha_fin= $_GET["m_fecha_fin"];
		$m_id_cuenta_bancaria= $_GET["m_id_cuenta_bancaria"];
		$m_id_moneda= $_GET["m_id_moneda"];
		$vista_cheque= $_GET["vista_cheque"];
    }
    else{
    	$m_fecha_inicio= $_POST["m_fecha_inicio"];
		$m_fecha_fin= $_POST["m_fecha_fin"];
		$m_id_cuenta_bancaria= $_POST["m_id_cuenta_bancaria"];
		$m_id_moneda= $_POST["m_id_moneda"];
		$vista_cheque= $_POST["vista_cheque"];
    }
	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{   $nro_cheque= $_GET["nro_cheque_$j"];
		    $fecha_cheque= $_GET["fecha_cheque_$j"];
		    $nombre_cheque=$_GET["nombre_cheque_$j"];
			$id_cheque= $_GET["id_cheque_$j"];
			$estado_cheque= $_GET["estado_cheque_$j"];
			$fecha_cobro= $_GET["fecha_cobro_$j"];
		}
		else
		{   $nro_cheque= $_POST["nro_cheque_$j"];
		    $fecha_cheque= $_POST["fecha_cheque_$j"];
		    $nombre_cheque=$_POST["nombre_cheque_$j"];
		    $id_cheque= $_POST["id_cheque_$j"];
			$estado_cheque= $_POST["estado_cheque_$j"];
			$fecha_cobro= $_POST["fecha_cobro_$j"];
		}
       if($estado_cheque=='true'){
       	  if($vista_cheque==1){
       	  	$estado_cheque=1;
       	  }
       	  else{
       	  	$estado_cheque=2;
       	  }
       }
       else{
       	  $estado_cheque=0;
       	  }

	if ($id_cheque == "undefined" || $id_cheque == ""){
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "MENSAJE ERROR = El Cheque no existe.";
			$resp->origen = "ORIGEN = $nombre_archivo";
			$resp->proc = "PROC = $nombre_archivo";
			$resp->nivel = "NIVEL = 4";
			echo $resp->get_mensaje();
			exit;
		}
		else{
			///////////////////////Modificación////////////////////
			$res = $Custom->ModificarCheque($id_cheque,$estado_cheque,$fecha_cobro,$nro_cheque,$fecha_cheque,$nombre_cheque);
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
	if($sortcol == "") $sortcol = "id_cuenta";
	if($sortdir == "") $sortdir = "asc";
	$criterio_filtro="CUEBAN.id_cuenta_bancaria=".$m_id_cuenta_bancaria;
	$criterio_filtro=$criterio_filtro."  AND CHEVAL.id_moneda=".$m_id_moneda;
	if($vista_cheque==1) $criterio_filtro=$criterio_filtro." AND CHEQUE.nro_deposito is NULL";
	if($vista_cheque==2) $criterio_filtro=$criterio_filtro." AND CHEQUE.nro_cheque is NULL";
	$criterio_filtro=$criterio_filtro." AND CHEQUE.fecha_cheque >= ''".$m_fecha_inicio."'' AND CHEQUE.fecha_cheque <= ''".$m_fecha_fin."''";


	$res = $Custom->ContarCheque($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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