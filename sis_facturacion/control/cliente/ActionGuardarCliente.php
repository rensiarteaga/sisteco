<?php
/*
**********************************************************
Nombre de archivo:	    ActionGuardarCliente.php
Propósito:				Permite insertar y modificar a cliente
Tabla:					tfv_cliente
Fecha de Creación:		2014.05
Versión:				1.0.0
Autor:					MTSL
**********************************************************
*/
session_start();
include_once("../LibModeloFactur.php");

$Custom = new cls_CustomDBFactur();
$nombre_archivo = 'ActionGuardarCliente.php';

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
			$id_cliente = $_GET["id_cliente_$j"];
			$razon_social = $_GET["razon_social_$j"];
			$nro_nit = $_GET["nro_nit_$j"];
			$direccion = $_GET["direccion_$j"];
			$telefono = $_GET["telefono_$j"];
			$repre_legal = $_GET["repre_legal_$j"];
			$docid_legal = $_GET["docid_legal_$j"];
			$nomb_fact = $_GET["nomb_fact_$j"];	
		}
		else{
			$id_cliente = $_POST["id_cliente_$j"];
			$razon_social = $_POST["razon_social_$j"];
			$nro_nit = $_POST["nro_nit_$j"];
			$direccion = $_POST["direccion_$j"];
			$telefono = $_POST["telefono_$j"];
			$repre_legal = $_POST["repre_legal_$j"];
			$docid_legal = $_POST["docid_legal_$j"];
			$nomb_fact = $_POST["nomb_fact_$j"];			
		}

		if ($id_cliente == "undefined" || $id_cliente == "")
		{
			////////////////////Inserción/////////////////////
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarCliente("insert", $id_cliente, $razon_social, $nro_nit, $direccion, $telefono, $repre_legal, $docid_legal, $nomb_fact);
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
			$res = $Custom -> InsertarCliente($id_cliente, $razon_social, $nro_nit, $direccion, $telefono, $repre_legal, $docid_legal, $nomb_fact);
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
			
			$res = $Custom->ValidarCliente("update", $id_cliente, $razon_social, $nro_nit, $direccion, $telefono, $repre_legal, $docid_legal, $nomb_fact);
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

			$res = $Custom->ModificarCliente($id_cliente, $razon_social, $nro_nit, $direccion, $telefono, $repre_legal, $docid_legal, $nomb_fact);
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
	if($sortcol == "") $sortcol = 'dos.id_cliente';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $Custom->ContarCliente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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