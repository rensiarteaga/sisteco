<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarDocsNit.php
Propósito:				Permite insertar y modificar datos en la tabla tct_documento
Tabla:					tct_tct_documento
Parámetros:				$id_documento
						$razon_social
						$nro_nit
Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-09-16 17:57:13
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = "ActionGuardarDocsNit.php";

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
			$id_documento = $_GET["id_documento_$j"];
			$razon_social = $_GET["razon_social_$j"];
			$nro_nit = $_GET["nro_nit_$j"];
			$sw_lcv = $_GET["sw_lcv_$j"];
		}
		else
		{
			$id_documento = $_POST["id_documento_$j"];
			$razon_social = $_POST["razon_social_$j"];
			$nro_nit = $_POST["nro_nit_$j"];
			$sw_lcv = $_POST["sw_lcv_$j"];
		}
	
		////////////////////Inserción/////////////////////
		if ($id_documento == "undefined" || $id_documento == ""){
		}
		else{
			//Modificación
			$res = $Custom ->ModificarDocsNit($id_documento,$nro_nit,$razon_social,$sw_lcv);
		
			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
			//$mensaje_exito = "Documento modificado con éxito.";
		}
		
	 }//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];
	
	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 15;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_documento";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "nro_nit = ".$nro_nit;
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarDocsNitDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res) $total_registros= $Custom->salida;
	
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