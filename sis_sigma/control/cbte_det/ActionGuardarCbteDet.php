<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCbteDet.php
Propósito:				Permite insertar y modificar datos en la tabla tct_cbte_det
Tabla:					tct_tct_Declaracion
Parámetros:				$id_Declaracion
						$tipo_Declaracion
						$nro_linea

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-10-16 12:20:40
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloSigma.php");

$Custom = new cls_CustomDBSigma();
$nombre_archivo = __FILE__;

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
			$id_cbte_det= $_GET["id_cbte_det_$j"];
			$tipo= $_GET["tipo_$j"];
			$tipo_dato= $_GET["tipo_dato_$j"];
			$reportar= $_GET["reportar_$j"];
			$ent_trf= $_GET["ent_trf_$j"];
			$id_cab_cbte= $_GET["id_cab_cbte_$j"];
			$id_cuenta_bancaria= $_GET["id_cuenta_bancaria_$j"];
			$id_partida= $_GET["id_partida_$j"];
			$id_presupuesto= $_GET["id_presupuesto_$j"];
			$importe= $_GET["importe_$j"];
			$libreta= $_GET["libreta_$j"];
			$cuenta_sigma= $_GET["cuenta_sigma_$j"];
			$id_transaccion= $_GET["id_transaccion_$j"];
			$modificado= $_GET["modificado_$j"];

		} else{
			$id_cbte_det= $_POST["id_cbte_det_$j"];
			$tipo= $_POST["tipo_$j"];
			$tipo_dato= $_POST["tipo_dato_$j"];
			$reportar= $_POST["reportar_$j"];
			$ent_trf= $_POST["ent_trf_$j"];
			$id_cab_cbte= $_POST["id_cab_cbte_$j"];
			$id_cuenta_bancaria= $_POST["id_cuenta_bancaria_$j"];
			$id_partida= $_POST["id_partida_$j"];
			$id_presupuesto= $_POST["id_presupuesto_$j"];
			$importe= $_POST["importe_$j"];
			$libreta= $_POST["libreta_$j"];
			$id_transaccion= $_POST["id_transaccion_$j"];
			$modificado= $_POST["modificado_$j"];
		}

		if ($id_cbte_det == "undefined" || $id_cbte_det == ""){
           $res = $Custom->InsertarCbteDet($id_cbte_det,$tipo,$tipo_dato,$reportar,$ent_trf,$id_cab_cbte,$id_cuenta_bancaria,$id_partida,$id_presupuesto,$importe,$libreta,$cuenta_sigma,$id_transaccion,$modificado);

			if(!$res){
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			};
		} else{
			///////////////////////Modificación////////////////////
			$res = $Custom->ModificarCbteDet($id_cbte_det,$tipo,$tipo_dato,$reportar,$ent_trf,$id_cab_cbte,$id_cuenta_bancaria,$id_partida,$id_presupuesto,$importe,$libreta,$cuenta_sigma,$modificado);

			if(!$res){
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
	if($sortcol == "") $sortcol = "id_cbte_det";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarCbteDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", $total_registros);
	$resp->add_nodo("mensaje", $mensaje_exito);
	$resp->add_nodo("tiempo_resp", "200");
	echo $resp->get_mensaje();
	exit;
} else{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit;
}

?>