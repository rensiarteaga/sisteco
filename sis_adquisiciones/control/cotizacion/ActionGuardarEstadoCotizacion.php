<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarEstadoCotizacion.php
Propósito:				Permite modificar el estado de la cotizacion teniendo como informacion el proceso_compra
Tabla:					tad_tad_cotizacion
						$id_proceso_compra

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-28 16:58:42
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarEstadoCotizacion.php";

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
			$id_proceso_compra= $_GET["id_proceso_compra_$j"];
			$id_cotizacion=$_GET["id_cotizacion_$j"];
			$figura_acta=$_GET["figura_acta_$j"];
			$observaciones_acta=$_GET["observaciones_acta_$j"];
			$estado_vigente=$_GET["estado_vigente_$j"];
		}
		else{
			$id_proceso_compra=$_POST["id_proceso_compra_$j"];
			$id_cotizacion=$_POST["id_cotizacion_$j"];
			$figura_acta=$_POST["figura_acta_$j"];
			$observaciones_acta=$_POST["observaciones_acta_$j"];
			$estado_vigente=$_POST["estado_vigente_$j"];
		}

	 if($estado_vigente=='anterior'){// volver un estado anterior a la cotizacion
	     $res = $Custom->CambiarEstadoCot($id_cotizacion,$id_cotizacion,$figura_acta,$observaciones_acta);
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
	 		
	 }else{
		$res = $Custom->ModificarEstadoCotizacion($id_proceso_compra,$id_cotizacion,$figura_acta,$observaciones_acta);
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
	$mensaje_exito = $Custom -> salida[1];
		if($cont > 0){
			echo "{success:true,agrupar:'NO',mensaje:'$mensaje_exito'}";
			exit;
		}
		else{
			echo "{success:false,agrupar:'NO',mensaje:'$mensaje_exito'}";
			exit;
		}

	$res = $Custom->ContarProcesoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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