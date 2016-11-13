<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCotizacionDet.php
Propósito:				Permite insertar y modificar datos en la tabla tad_cotizacion_det
Tabla:					tad_tad_cotizacion_det
Parámetros:				$id_cotizacion_det
						$tiempo_entrega
						$precio
						$cantidad
						$garantia
						$observaciones
						$observado
						$id_cotizacion
						$id_item_aprobado
						$id_servicio
						$id_proceso_compra_det
						$estado_reg
						$estado

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-28 17:32:13
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarCotizacionDet.php";

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
			$id_cotizacion_det= $_GET["id_cot_det_$j"];
			$tiempo_entrega= $_GET["tiempo_entrega_$j"];
			$precio= $_GET["precio_$j"];
			$cantidad= $_GET["cantidad_$j"];
			$garantia= $_GET["garantia_$j"];
			$observaciones= $_GET["observaciones_$j"];
			$observado= $_GET["observado_$j"];
			$id_cotizacion= $_GET["id_cotizacion_$j"];
			$id_item_aprobado= $_GET["id_item_aprobado_$j"];
			$id_servicio= $_GET["id_servicio_$j"];
			$id_proceso_compra_det= $_GET["id_proceso_compra_det_$j"];
			$estado_reg= $_GET["estado_reg_$j"];
			$estado= $_GET["estado_$j"];
			$cantidad_adjudicada= $_GET["cantidad_adjudicada_$j"];
			$id_item_cotizado= $_GET["id_item_cotizado_$j"];
			$id_servicio_cotizado= $_GET["id_servicio_cotizado_$j"];
			$id_solicitud_compra_det = $_GET["id_solicitud_compra_det_$j"];
				

		
		}
		else
		{
			$id_cotizacion_det=$_POST["id_cot_det_$j"];
			$tiempo_entrega=$_POST["tiempo_entrega_$j"];
			$precio=$_POST["precio_$j"];
			$cantidad=$_POST["cantidad_$j"];
			$garantia=$_POST["garantia_$j"];
			$observaciones=$_POST["observaciones_$j"];
			$observado=$_POST["observado_$j"];
			$id_cotizacion=$_POST["id_cotizacion_$j"];
			$id_item_aprobado=$_POST["id_item_aprobado_$j"];
			$id_servicio=$_POST["id_servicio_$j"];
			$id_proceso_compra_det=$_POST["id_proceso_compra_det_$j"];
			$estado_reg=$_POST["estado_reg_$j"];
			$estado=$_POST["estado_$j"];
			$cantidad_adjudicada= $_POST["cantidad_adjudicada_$j"];
			$id_item_cotizado= $_POST["id_item_cotizado_$j"];
			$id_servicio_cotizado= $_POST["id_servicio_cotizado_$j"];
			$id_solicitud_compra_det = $_POST["id_solicitud_compra_det_$j"];
			
		}

		$retencion=$_SESSION["ss_retencion"];
//		if($id_item_cotizado>0 ||$id_servicio_cotizado>0) {
//			
//				if($reformular!=''){
//					
//					$res= $Custom->ModificarItseReformulado($id_cotizacion_det,$id_cotizacion, $id_item_aprobado,$id_servicio,$id_proceso_compra_det,$cantidad_adjudicada,$id_item_cotizado,$id_servicio_cotizado, $cantidad,$precio,$tiempo_entrega,$garantia,$observaciones,$id_solicitud_compra_det);
//				
//				    if(!$res)
//					{
//						//Se produjo un error
//						$resp = new cls_manejo_mensajes(true, "406");
//						$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
//						$resp->origen = $Custom->salida[2];
//						$resp->proc = $Custom->salida[3];
//						$resp->nivel = $Custom->salida[4];
//						$resp->query = $Custom->query;
//						echo $resp->get_mensaje();
//						exit;
//					}
//					
//				}else{
//				  
//					$res= $Custom->ModificarItseCotizado($id_cotizacion_det,$id_cotizacion, $id_item_aprobado,$id_servicio,$id_proceso_compra_det,$cantidad_adjudicada,$id_item_cotizado,$id_servicio_cotizado, $cantidad,$precio,$tiempo_entrega,$garantia,$observaciones,$id_solicitud_compra_det);
//				
//				    if(!$res)
//					{
//						//Se produjo un error
//						$resp = new cls_manejo_mensajes(true, "406");
//						$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
//						$resp->origen = $Custom->salida[2];
//						$resp->proc = $Custom->salida[3];
//						$resp->nivel = $Custom->salida[4];
//						$resp->query = $Custom->query;
//						echo $resp->get_mensaje();
//						exit;
//					}
//				}
//
//		}else{
					
			$res = $Custom->ModificarCotizacionDet($id_cotizacion_det, $tiempo_entrega, $precio, $cantidad, $garantia, $observaciones, $observado, $id_cotizacion, $id_item_aprobado, $id_servicio, $id_proceso_compra_det, $estado_reg, $estado,$id_item_cotizado,$id_servicio_cotizado,$retencion);

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
	    //}
	//	}

	//}//END FOR

	

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 0) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_cotizacion_det";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "cotdet.id_cotizacion=''$m_id_cotizacion''";

	if($id_item_aprobado>0){
		$res = $Custom->ContarCotizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		if($res) $total_registros = $Custom->salida;
	}
	else {
		$res = $Custom->ContarCotizacionServDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		if($res) $total_registros = $Custom->salida;
	}

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