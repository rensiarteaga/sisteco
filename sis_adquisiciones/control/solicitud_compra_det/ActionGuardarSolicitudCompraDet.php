<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarSolicitudCompraDet.php
Propósito:				Permite insertar y modificar datos en la tabla tad_solicitud_compra_det
Tabla:					tad_tad_solicitud_compra_det
Parámetros:				$id_solicitud_compra_det
						$id_item_antiguo
						$cantidad
						$precio_referencial_estimado
						$fecha_reg
						$fecha_inicio_serv
						$fecha_fin_serv
						$descripcion
						$partida_presupuestaria
						$estado_reg
						$pac_verificado
						$id_solicitud_compra
						$id_servicio
						$id_item
						$monto_aprobado
						$mat_bajo_responsabilidad

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-16 09:53:33
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarSolicitudCompraDet.php";

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
			$id_item_antiguo= $_GET["id_item_antiguo_$j"];
			$cantidad= $_GET["cantidad_$j"];
			$precio_referencial_estimado= $_GET["precio_referencial_moneda_seleccionada_$j"];
			$fecha_reg= $_GET["fecha_reg_$j"];
			$fecha_inicio_serv= $_GET["fecha_inicio_serv_$j"];
			$fecha_fin_serv= $_GET["fecha_fin_serv_$j"];
			$descripcion= $_GET["descripcion_$j"];
			$partida_presupuestaria= $_GET["partida_presupuestaria_$j"];
			$estado_reg= $_GET["estado_reg_$j"];
			$pac_verificado= $_GET["pac_verificado_$j"];
			$id_solicitud_compra= $_GET["id_solicitud_compra_$j"];
			$id_servicio= $_GET["id_servicio_$j"];
			$id_item= $_GET["id_item_$j"];
			$monto_aprobado= $_GET["monto_aprobado_$j"];
			$mat_bajo_responsabilidad= $_GET["mat_bajo_responsabilidad_$j"];
			$especificaciones_tecnicas= $_GET["especificaciones_tecnicas_$j"];
			$almacenable=$_GET["txt_almacenable_$j"];
			$id_unidad_medida_base=$_GET["id_unidad_medida_base_$j"];
			$precio_total_as=$_GET["precio_referencial_total_as_$j"];

		}
		else
		{
			$id_solicitud_compra_det=$_POST["id_solicitud_compra_det_$j"];
			$id_item_antiguo=$_POST["id_item_antiguo_$j"];
			$cantidad=$_POST["cantidad_$j"];
			$precio_referencial_estimado=$_POST["precio_referencial_moneda_seleccionada_$j"];
			$fecha_reg=$_POST["fecha_reg_$j"];
			$fecha_inicio_serv=$_POST["fecha_inicio_serv_$j"];
			$fecha_fin_serv=$_POST["fecha_fin_serv_$j"];
			$descripcion=$_POST["descripcion_$j"];
			$partida_presupuestaria=$_POST["partida_presupuestaria_$j"];
			$estado_reg=$_POST["estado_reg_$j"];
			$pac_verificado=$_POST["pac_verificado_$j"];
			$id_solicitud_compra=$_POST["id_solicitud_compra_$j"];
			$id_servicio=$_POST["id_servicio_$j"];
			$id_item=$_POST["id_item_$j"];
			$monto_aprobado=$_POST["monto_aprobado_$j"];
			$mat_bajo_responsabilidad=$_POST["mat_bajo_responsabilidad_$j"];
			$especificaciones_tecnicas= $_POST["especificaciones_tecnicas_$j"];
			$almacenable=$_POST["txt_almacenable_$j"];
			$id_unidad_medida_base=$_POST["id_unidad_medida_base_$j"];
			$precio_total_as=$_POST["precio_referencial_total_as_$j"];
		}

		$txt_id_empresa=$_SESSION["ss_id_empresa"];
		
		if($id_item=="undefined"){
			$id_item='NULL';
		}
		
		if ($id_solicitud_compra_det == "undefined" || $id_solicitud_compra_det == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarSolicitudCompraDet("insert",$id_solicitud_compra_det, $id_item_antiguo,$cantidad,$precio_referencial_estimado,$fecha_reg,$fecha_inicio_serv,$fecha_fin_serv,$descripcion,$partida_presupuestaria,$estado_reg,$pac_verificado,$id_solicitud_compra,$id_servicio,$id_item,$monto_aprobado,$mat_bajo_responsabilidad);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tad_solicitud_compra_det
			$res = $Custom -> InsertarSolicitudCompraDet($id_solicitud_compra_det, $id_item_antiguo, $cantidad, $precio_referencial_estimado, $fecha_reg, $fecha_inicio_serv, $fecha_fin_serv, $descripcion, $partida_presupuestaria, $estado_reg, $pac_verificado, $id_solicitud_compra, $id_servicio, $id_item, $monto_aprobado, $mat_bajo_responsabilidad,$especificaciones_tecnicas,$almacenable,$txt_id_empresa, $id_unidad_medida_base,$precio_total_as);

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
			$res = $Custom->ValidarSolicitudCompraDet("update",$id_solicitud_compra_det, $id_item_antiguo, $cantidad, $precio_referencial_estimado, $fecha_reg, $fecha_inicio_serv, $fecha_fin_serv, $descripcion, $partida_presupuestaria, $estado_reg, $pac_verificado, $id_solicitud_compra, $id_servicio, $id_item, $monto_aprobado, $mat_bajo_responsabilidad);

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

			$res = $Custom->ModificarSolicitudCompraDet($id_solicitud_compra_det, $id_item_antiguo, $cantidad, $precio_referencial_estimado, $fecha_reg, $fecha_inicio_serv, $fecha_fin_serv, $descripcion, $partida_presupuestaria, $estado_reg, $pac_verificado, $id_solicitud_compra, $id_servicio, $id_item, $monto_aprobado, $mat_bajo_responsabilidad,$especificaciones_tecnicas,$almacenable,$txt_id_empresa,$id_unidad_medida_base,$precio_total_as);

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
	if($sortcol == "") $sortcol = "id_solicitud_compra_det";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "SEGSOL.id_solicitud_compra=''$m_id_solicitud_compra''";

	$res = $Custom->ContarSolicitudCompraDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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