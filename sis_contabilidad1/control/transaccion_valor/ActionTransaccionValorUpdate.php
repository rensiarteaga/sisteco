<?php
/**
**********************************************************
Nombre de archivo:	    ActionTransaccionValorUpdate.php
Propósito:				Permite modificar datos en la tabla tct_Transaccion_valor
Tabla:					tct_transaccion_valor
Parámetros:				$id_comprobante
						$id_transaccion
						$id_moneda
						$importe
						$valor

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2011-03-11 10:50:35
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = "ActionTransaccionValorUpdate.php";

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
		{   $id_comprobante=$_GET["id_comprobante_$j"];
			$id_transaccion=$_GET["id_transaccion_$j"];
			$$id_moneda=$_GET["id_moneda_$j"];
			$importe_debe= $_GET["importe_debe_$j"];
			$importe_haber=$_GET["importe_haber_$j"];			
		}
		else
		{
			$id_comprobante=$_POST["id_comprobante_$j"];
			$id_transaccion=$_POST["id_transaccion_$j"];
			$id_moneda=$_POST["id_moneda_$j"];
			$importe_debe= $_POST["importe_debe_$j"];
			$importe_haber = $_POST["importe_haber_$j"];			
		}	
	 	
	    
			$res = $Custom -> ValidarTransaccionValor("update",$id_comprobante,$id_transaccion,$id_moneda,$importe_debe,$importe_haber);

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
			$res = $Custom -> ModificarTransaccionValor($id_comprobante,$id_transaccion,$id_moneda,$importe_debe,$importe_haber);

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
	//	Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "tc.id_comprobante";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom -> ContarTransValor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_comprobante,$id_transaccion,$id_moneda);
	//var_dump($Custom->salida[0]["total"]);
	if($res) $total_registros = $Custom->salida[0]["total"];

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