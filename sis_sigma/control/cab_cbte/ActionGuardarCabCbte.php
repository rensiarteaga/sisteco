<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCabCbte.php
Propósito:				Permite insertar y modificar datos en la tabla tct_Declaracion
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
			$id_cab_cbte = $_GET["id_cab_cbte_$j"];
			$compromiso = $_GET["compromiso_$j"];
			$devengado = $_GET["devengado_$j"];
			$pagado = $_GET["pagado_$j"];
			$cbte_depto=$_GET["cbte_depto_$j"];
			$cbte1_depto=$_GET["cbte1_depto_$j"];
			$id_cbte=$_GET["id_cbte_$j"];
			$id_cbte_orig=$_GET["id_cbte_orig_$j"];
			$nro_cbte=$_GET["nro_cbte_$j"];
			$operacion=$_GET["operacion_$j"];
			$pagado=$_GET["pagado_$j"];
			$tipo=$_GET["tipo_$j"];
			$tipo_mov=$_GET["tipo_mov_$j"];
			$tipo_pago=$_GET["tipo_pago_$j"];
			$observaciones=$_GET["observaciones_$j"];
		} else{
			$id_cab_cbte = $_POST["id_cab_cbte_$j"];
			$compromiso = $_POST["compromiso_$j"];
			$devengado = $_POST["devengado_$j"];
			$pagado = $_POST["pagado_$j"];
			$cbte_depto=$_POST["cbte_depto_$j"];
			$cbte1_depto=$_POST["cbte1_depto_$j"];
			$id_cbte=$_POST["id_cbte_$j"];
			$id_cbte_orig=$_POST["id_cbte_orig_$j"];
			$nro_cbte=$_POST["nro_cbte_$j"];
			$operacion=$_POST["operacion_$j"];
			$pagado=$_POST["pagado_$j"];
			$tipo=$_POST["tipo_$j"];
			$tipo_mov=$_POST["tipo_mov_$j"];
			$tipo_pago=$_POST["tipo_pago_$j"];
			$observaciones=$_POST["observaciones_$j"];
		}
$id_declaracion=$m_id_declaracion;


		if ($id_cab_cbte == "undefined" || $id_cab_cbte == ""){
			$res = $Custom -> InsertarCabCbte($id_cab_cbte,$nro_cbte,$id_cbte,$compromiso,$devengado,$pagado,$operacion,$id_cbte_orig,$tipo_mov,$tipo_pago,$tipo,$id_declaracion,$observaciones);

			if(!$res){
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

		} else{
			///////////////////////Modificación////////////////////
			$res = $Custom->ModificarCabCbte($id_cab_cbte,$nro_cbte,$id_cbte,$compromiso,$devengado,$pagado,$operacion,$id_cbte_orig,$tipo_mov,$tipo_pago,$tipo,$id_declaracion,$observaciones);

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
	if($sortcol == "") $sortcol = "id_cab_cbte";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarCabCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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