<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCbteClase.php
Propósito:				Permite insertar y modificar datos en la tabla tct_cbte_clase
Tabla:					tct_tct_cbte_clase
Parámetros:				$id_clase_cbte
						$desc_clase
						$estado_clase
						$id_documento

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-09-18 09:21:11
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = "ActionGuardarChequeRegTra.php";

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
//	echo 'llega '; exit();
	

 
	
	
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{		$id_cheque = $_GET["id_cheque_$j"];
				$estado_cheque = $_GET["estado_cheque_$j"];
				$nombre_cheque = $_GET["nombre_cheque_$j"];
				$observaciones_anulacion = $_GET["observaciones_anulacion_$j"];
				$tipo_cheque = $_GET["tipo_cheque_$j"];
				$id_cuenta_bancaria = $_GET["id_cuenta_bancaria_$j"];
		}
		else
		{
				$id_cheque = $_POST["id_cheque_$j"];
				$estado_cheque = $_POST["estado_cheque_$j"];
				$nombre_cheque = $_POST["nombre_cheque_$j"];
				$observaciones_anulacion = $_POST["observaciones_anulacion_$j"];
				$tipo_cheque = $_POST["tipo_cheque_$j"];
				$id_cuenta_bancaria = $_POST["id_cuenta_bancaria_$j"];
				
		}

		if ($id_cheque == "undefined" || $id_cheque == "")
		{	
				echo "No se puede insertar";
				exit;
			
		}
		else
		{	///////////////////////Modificación////////////////////
	 
			$res = $Custom->ModificarChequeAnula($id_cheque,$estado_cheque,$nombre_cheque,$observaciones_anulacion,$tipo_cheque,$id_cuenta_bancaria);

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
	if($sortcol == "") $sortcol = "che.id_cheque";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarChequeCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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