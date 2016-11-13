<?php
/*
**********************************************************
Nombre de archivo:	    ActionGuardarContraCuenta.php
Propósito:				modificar y registrar en actif.taf_contra_cuenta
Tabla:					actif.taf_contra_cuenta
Parámetros:				
						

Valores de Retorno:    	Número de registros
Fecha de Creación:		
Versión:			
Autor:					
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionGuardarContraCuenta.php';

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
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para el registro.";
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
		if ($get)
		{
			$id_contra_cuenta=$_GET["id_contra_cuenta_$j"];
			$id_gestion=$_GET["hidden_id_gestion_$j"];
			$id_regional=$_GET["hidden_id_regional_$j"];
			$id_cuenta=$_GET["hidden_id_cuenta_$j"];
			$id_cuenta_aux=$_GET["hidden_id_cuenta_aux_$j"];
			$id_proceso=$_GET["hidden_id_proceso_$j"];
			$id_importe=$_GET["id_importe_$j"];
		}
		else
		{
			$id_contra_cuenta=$_POST["id_contra_cuenta_$j"];
			$id_gestion=$_POST["hidden_id_gestion_$j"];
			$id_regional=$_POST["hidden_id_regional_$j"];
			$id_cuenta=$_POST["hidden_id_cuenta_$j"];
			$id_cuenta_aux=$_POST["hidden_id_cuenta_aux_$j"];
			$id_proceso=$_POST["hidden_id_proceso_$j"];
			$id_importe=$_POST["id_importe_$j"];
				
		} 
		
		if ($id_contra_cuenta== "undefined" || $id_contra_cuenta== "")
		{ 
			//no es necesario validar los datos q se registraran pues los mismos se obtienen apartir desde combos listados desde otro esquema de la BD
			$res = $Custom ->InsertarContraCuenta($id_contra_cuenta,$id_gestion,$id_regional,$id_cuenta,$id_cuenta_aux,$id_proceso,$id_importe);
	
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
		{	
//	
			$res = $Custom->ModificarContraCuenta($id_contra_cuenta,$id_gestion,$id_regional,$id_cuenta,$id_cuenta_aux,$id_proceso,$id_importe);
			
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
	if($sortcol == "") $sortcol = '';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $Custom->CountContraCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
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