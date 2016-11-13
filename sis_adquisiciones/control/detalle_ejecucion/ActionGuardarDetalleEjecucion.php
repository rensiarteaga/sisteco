<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarComprador.php
Propósito:				Permite insertar y modificar datos en la tabla tad_comprador
Tabla:					tad_tad_comprador
Parámetros:				$id_comprador
						$id_empleado
						$fecha_asignacion
						$estado

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-11-17 11:14:48
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarDetalleEjecucion.php";

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
			$id_solicitud_compra_det= $_GET["id_solicitud_compra_det_$j"];
			$id_partida_ejecucion= $_GET["id_partida_ejecucion_$j"];
			$id_adjudicacion= $_GET["id_adjudicacion_$j"];
			$saldo= $_GET["saldo_$j"];
			$importe_eje_rev= $_GET["importe_eje_rev_$j"];
			

		}
		else
			{ 	//ago2015
			if($_POST['vista']=='reprogramar'){
					$id_solicitud_compra_det= $_POST["id_plan_pago_$j"];
					$saldo= $_POST["monto_$j"];
					$importe_eje_rev= $_POST["nuevo_monto_$j"];
			}else{
			
					$id_solicitud_compra_det= $_POST["id_solicitud_compra_det_$j"];
					$id_partida_ejecucion= $_POST["id_partida_ejecucion_$j"];
					$id_adjudicacion= $_POST["id_adjudicacion_$j"];
					$saldo= $_POST["saldo_$j"];
					$importe_eje_rev= $_POST["importe_eje_rev_$j"];
			}
		}
		
		
			
			

			$res = $Custom->ModificarDetalleEjecucion($id_solicitud_compra_det,$id_partida_ejecucion,$id_adjudicacion,$saldo,$importe_eje_rev,$_POST['vista'],$_POST['id']);

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
		

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_partida_ejecucion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarDetalleEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$_POST['id'],$_POST['vista']);
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