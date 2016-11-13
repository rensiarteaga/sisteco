<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPlanPago.php
Propósito:				Permite insertar y modificar datos en la tabla tad_plan_pago
Tabla:					tad_tad_plan_pago
Parámetros:				$id_plan_pago
						$tipo_pago
						$nro_cuota
						$fecha_pago
						$monto
						$estado
						$id_cotizacion

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-28 17:32:19
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarPlanPago.php";

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
			$id_plan_pago= $_GET["id_plan_pago_$j"];
			$tipo_pago= $_GET["tipo_pago_$j"];
			$nro_cuota= $_GET["nro_cuota_$j"];
			$fecha_pago= $_GET["fecha_pago_$j"];
			$monto= $_GET["monto_$j"];
			$estado= $_GET["estado_$j"];
			$id_cotizacion= $_GET["id_cotizacion_$j"];
			$fecha_pagado= $_GET["fecha_pagado_$j"];
			$num_factura= $_GET["num_factura_$j"];
			$observaciones= $_GET["observaciones_$j"];
			
			$boleta_garantia=$_GET["boleta_garantia_$j"];
			$num_autoriza_factura=$_GET["num_autoriza_factura_$j"];
			$cod_control_factura=$_GET["cod_control_factura_$j"];
			$fecha_factura=$_GET["fecha_factura_$j"];
			$multas=$_GET["multas_$j"];
			$tipo_plantilla=$_GET["tipo_plantilla_$j"];
			$monto_original=$_GET["monto_original_$j"];
			$id_gestion=$_GET["id_gestion_$j"];
			$id_cuenta_doc=$_GET["id_cuenta_doc_$j"];
			$por_anticipo=$_GET["por_anticipo_$j"];
			$por_retgar=$_GET["por_retgar_$j"];
			$descuento_anticipo=$_GET["descuento_anticipo_$j"];
			$monto_no_pagado=$_GET["monto_no_pagado_$j"];
			$fecha_devengado=$_GET["fecha_devengado_$j"];
			$accion=$_GET["accion_$j"];
			
			$descuentos=$_GET["descuentos_$j"];
			$obs_descuentos=$_GET["obs_descuentos_$j"];
		}
		else
		{
			$id_plan_pago=$_POST["id_plan_pago_$j"];
			$tipo_pago=$_POST["tipo_pago_$j"];
			$nro_cuota=$_POST["nro_cuota_$j"];
			$fecha_pago=$_POST["fecha_pago_$j"];
			$monto=$_POST["monto_$j"];
			$estado=$_POST["estado_$j"];
			$id_cotizacion=$_POST["id_cotizacion_$j"];
			$fecha_pagado= $_POST["fecha_pagado_$j"];
			$num_factura= $_POST["num_factura_$j"];
			$observaciones= $_POST["observaciones_$j"];
			$boleta_garantia=$_POST["boleta_garantia_$j"];
			$num_autoriza_factura=$_POST["num_autoriza_factura_$j"];
			$cod_control_factura=$_POST["cod_control_factura_$j"];
			$fecha_factura=$_POST["fecha_factura_$j"];
			$multas=$_POST["multas_$j"];
			$tipo_plantilla=$_POST["tipo_plantilla_$j"];
			$monto_original=$_POST["monto_original_$j"];
			$id_gestion=$_POST["id_gestion_$j"];
			$id_cuenta_doc=$_POST["id_cuenta_doc_$j"];
			$por_anticipo=$_POST["por_anticipo_$j"];
			$por_retgar=$_POST["por_retgar_$j"];
			$descuento_anticipo=$_POST["descuento_anticipo_$j"];
			$monto_no_pagado=$_POST["monto_no_pagado_$j"];
			$fecha_devengado=$_POST["fecha_devengado_$j"];
			$accion=$_POST["accion_$j"];
			
			$descuentos=$_POST["descuentos_$j"];
			$obs_descuentos=$_POST["obs_descuentos_$j"];
		}
		

		if ($id_plan_pago == "undefined" || $id_plan_pago == "")
		{
			if($revertir!=''){
				
				$res=$Custom->RevertirPlanPago($id_plan_pago,$m_id_cotizacion);
				   if(!$res){
				   	    $resp= new cls_manejo_mensajes(true,"406");
				   	 	$resp->mensaje_error = $Custom->salida[1];
				   	 	$resp->origen = $Custom->salida[2];
						$resp->proc = $Custom->salida[3];
						$resp->nivel = $Custom->salida[4];
						echo $resp->get_mensaje();
						exit;
				   }
			}else{
				   if($terminado!=''){
				
						$res=$Custom->FinalizarPlanPago($id_plan_pago,$m_id_cotizacion);
				   		    if(!$res){
				   	    		$resp= new cls_manejo_mensajes(true,"406");
						   	 	$resp->mensaje_error = $Custom->salida[1];
						   	 	$resp->origen = $Custom->salida[2];
								$resp->proc = $Custom->salida[3];
								$resp->nivel = $Custom->salida[4];
								echo $resp->get_mensaje();
								exit;
						   }
					}else{
			
							////////////////////Inserción/////////////////////

						//Validación de datos (del lado del servidor)
						  $res = $Custom->ValidarPlanPago("insert",$id_plan_pago, $tipo_pago,$nro_cuota,$fecha_pago,$monto,$estado,$id_cotizacion);
			
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
							
									
							//Validación satisfactoria, se ejecuta la inserción en la tabla tad_plan_pago
							$res = $Custom -> InsertarPlanPago($id_plan_pago, $tipo_pago, $nro_cuota, $fecha_pago, $monto_original, $estado, $id_cotizacion,$id_gestion,$id_cuenta_doc,$por_anticipo,$por_retgar);
			
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
			   }
		}
			
		else
		{	///////////////////////Modificación////////////////////
			//Validación de datos (del lado del servidor)
				$res = $Custom->ValidarPlanPago("update",$id_plan_pago, $tipo_pago, $nro_cuota, $fecha_pago, $monto, $estado, $id_cotizacion);
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

		$res = $Custom->ModificarPlanPago($id_plan_pago, $tipo_pago, $nro_cuota, $fecha_pago, $monto_original, $estado, $id_cotizacion,$fecha_pagado,$num_factura,$observaciones,$boleta_garantia,$num_autoriza_factura,$cod_control_factura,$fecha_factura,$multas,$tipo_plantilla,$id_gestion,$id_cuenta_doc,$por_anticipo,$por_retgar,$descuento_anticipo,$monto_no_pagado,$fecha_devengado,$accion,$descuentos,$obs_descuentos);
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
	if($sortcol == "") $sortcol = "id_plan_pago";
	if($sortdir == "") $sortdir = "desc";
	
	
	if($criterio_filtro == "") $criterio_filtro = "cotiza.id_cotizacion=$m_id_cotizacion";

	$res = $Custom->ContarPlanPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_cotizacion);
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