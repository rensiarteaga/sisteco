<?php
/**
 * Nombre del archivo:	ActionSaveActivoFijo.php
 * Propósito:			Permite insertar y modificar registros deActivos Fijos
 * Tabla:				taf_activo_fijo
 * Parámetros:			
 * Valores de Retorno:	
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		12-06-2007
 */
session_start();
include_once("../LibModeloActivoFijo.php");
$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionSaveActivoFijo.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
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
		$cont =  $_POST['cantidad_ids'];

		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "503");
		$resp->mensaje_error = "No existen datos para almacenar.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = 'NIVEL = 4';
		echo $resp->get_mensaje();
		exit;
	}

	//Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;
	
	//Variable para devolver el código del activo
	$cod='';

	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$id_activo_fijo = $_GET["id_activo_fijo_$j"];
			$codigo = $_GET["codigo_$j"];
			$descripcion = $_GET["descripcion_$j"];
			$descripcion_larga = $_GET["descripcion_larga_$j"];
			$vida_util_original = $_GET["vida_util_original_$j"];
			$vida_util_restante = $_GET["vida_util_restante_$j"];
			$tasa_depreciacion = $_GET["tasa_depreciacion_$j"];
			$fecha_ultima_deprec = $_GET["fecha_ultima_deprec_$j"];
			$depreciacion_acum_ant = $_GET["depreciacion_acum_ant_$j"];
			$depreciacion_acum = $_GET["depreciacion_acum_$j"];
			
			$depreciacion_periodo = $_GET["depreciacion_periodo_$j"];
			$flag_revaloriz = $_GET["flag_revaloriz_$j"];
			$valor_rescate = $_GET["valor_rescate_$j"];
			$fecha_compra = $_GET["fecha_compra_$j"];
			$monto_compra_mon_orig = $_GET["monto_compra_mon_orig_$j"];
			$monto_compra = $_GET["monto_compra_$j"];
			$monto_actual = $_GET["monto_actual_$j"];
			$con_garantia = $_GET["con_garantia_$j"];
			$num_poliza_garantia = $_GET["num_poliza_garantia_$j"];
			$fecha_fin_gar = $_GET["fecha_fin_gar_$j"];
			
			$fecha_reg = $_GET["fecha_reg_$j"];
			$foto_activo = $_GET["foto_activo_$j"];
			$num_factura = $_GET["num_factura_$j"];
			$tipo_cambio = $_GET["tipo_cambio_$j"];
			$estado = $_GET["estado_$j"];
			$observaciones = $_GET["observaciones_$j"];
			$id_sub_tipo_activo = $_GET["id_sub_tipo_activo_$j"];
			$id_institucion = $_GET["id_institucion_$j"];
			$id_moneda = $_GET["id_moneda_$j"];
			$id_moneda_original = $_GET["id_moneda_original_$j"];
			
			$id_unidad_constructiva = $_GET["id_unidad_constructiva_$j"];
			$fecha_ini_dep = $_GET["fecha_ini_dep_$j"];
			$ubicacion_fisica = $_GET["ubicacion_fisica_$j"];
			$orden_compra = $_GET["orden_compra_$j"];
			$id_estado_funcional = $_GET["id_estado_funcional_$j"];
			$monto_compra_2 = $_GET["monto_compra_2_$j"];
			$monto_actual_2 = $_GET["monto_actual_2_$j"];
			$depreciacion_acum_2 = $_GET["depreciacion_acum_2_$j"];
			$depreciacion_acum_ant_2 = $_GET["depreciacion_acum_ant_2_$j"];
			$depreciacion_periodo_2 = $_GET["depreciacion_periodo_2_$j"];
			
			$vida_util_2 = $_GET["vida_util_2_$j"];
			$vida_util_restante_2 = $_GET["vida_util_restante_2_$j"];
			$fecha_alta = $_GET["fecha_alta_$j"];
			$id_depto= $_GET["id_depto_$j"];
			$id_cotizacion=$_GET["id_cotizacion_$j"];
			$id_cotizacion_det=$_GET["id_cotizacion_det_$j"];
			$origen=$_GET["origen_$j"];
			$id_presupuesto=$_GET["id_ppto_$j"];
			$id_lugar=$_GET["id_lugar_$j"];
			$id_gestion=$_GET["id_gestion_$j"];
			
			$id_solicitud_compra=$_GET["id_solicitud_compra_$j"];

			$clonacion=$_GET["clonacion_$j"];
			$id_clon=$_GET["id_clon_$j"];
			$num_clones=$_GET["num_clones_$j"];
			$id_deposito=$_GET["id_deposito_$j"];//añadido en fecha 10 de enero 2011
			$tipo_af_bien=$_GET["tipo_af_bien_$j"];//añadido en fecha 10 de enero 2011
			$proyecto=$_GET["proyecto_$j"];//añadido en fecha 10 de enero 2011
		}
		else
		{
			$id_activo_fijo = $_POST["id_activo_fijo_$j"];
			$codigo = $_POST["codigo_$j"];
			$descripcion = $_POST["descripcion_$j"];
			$descripcion_larga = $_POST["descripcion_larga_$j"];
			$vida_util_original = $_POST["vida_util_original_$j"];
			$vida_util_restante = $_POST["vida_util_restante_$j"];
			$tasa_depreciacion = $_POST["tasa_depreciacion_$j"];
			$fecha_ultima_deprec = $_POST["fecha_ultima_deprec_$j"];
			$depreciacion_acum_ant = $_POST["depreciacion_acum_ant_$j"];
			$depreciacion_acum = $_POST["depreciacion_acum_$j"];
			
			$depreciacion_periodo = $_POST["depreciacion_periodo_$j"];
			$flag_revaloriz = $_POST["flag_revaloriz_$j"];
			$valor_rescate = $_POST["valor_rescate_$j"];
			$fecha_compra = $_POST["fecha_compra_$j"];
			$monto_compra_mon_orig = $_POST["monto_compra_mon_orig_$j"];
			$monto_compra = $_POST["monto_compra_$j"];
			$monto_actual = $_POST["monto_actual_$j"];
			$con_garantia = $_POST["con_garantia_$j"];
			$num_poliza_garantia = $_POST["num_poliza_garantia_$j"];
			$fecha_fin_gar = $_POST["fecha_fin_gar_$j"];
			
			$fecha_reg = $_POST["fecha_reg_$j"];
			$foto_activo = $_POST["foto_activo_$j"];
			$num_factura = $_POST["num_factura_$j"];
			$tipo_cambio = $_POST["tipo_cambio_$j"];
			$estado = $_POST["estado_$j"];
			$observaciones = $_POST["observaciones_$j"];
			$id_sub_tipo_activo = $_POST["id_sub_tipo_activo_$j"];
			$id_institucion = $_POST["id_institucion_$j"];
			$id_moneda = $_POST["id_moneda_$j"];
			$id_moneda_original = $_POST["id_moneda_original_$j"];
			
			$id_unidad_constructiva = $_POST["id_unidad_constructiva_$j"];
			$fecha_ini_dep = $_POST["fecha_ini_dep_$j"];
			$ubicacion_fisica = $_POST["ubicacion_fisica_$j"];
			$orden_compra = $_POST["orden_compra_$j"];
			$id_estado_funcional = $_POST["id_estado_funcional_$j"];
			$monto_compra_2 = $_POST["monto_compra_2_$j"];
			$monto_actual_2 = $_POST["monto_actual_2_$j"];
			$depreciacion_acum_2 = $_POST["depreciacion_acum_2_$j"];
			$depreciacion_acum_ant_2 = $_POST["depreciacion_acum_ant_2_$j"];
			$depreciacion_periodo_2 = $_POST["depreciacion_periodo_2_$j"];
			
			$vida_util_2 = $_POST["vida_util_2_$j"];
			$vida_util_restante_2 = $_POST["vida_util_restante_2_$j"];
			$fecha_alta = $_POST["fecha_alta_$j"];///
			
			$id_depto= $_POST["id_depto_$j"];
			$id_cotizacion=$_POST["id_cotizacion_$j"];
			$id_cotizacion_det=$_POST["id_cotizacion_det_$j"];
			$origen=$_POST["origen_$j"];
			$id_presupuesto=$_POST["id_ppto_$j"];
			$id_lugar=$_POST["id_lugar_$j"];
			$id_gestion=$_POST["id_gestion_$j"];
			$id_solicitud_compra=$_POST["id_solicitud_compra_$j"];
			$clonacion=$_POST["clonacion_$j"];
			$id_clon=$_POST["id_clon_$j"];
			$num_clones=$_POST["num_clones_$j"];
			$id_deposito=$_POST["id_deposito_$j"]; //añadido en fecha 10 de enero 2011
			$tipo_af_bien=$_POST["tipo_af_bien_$j"];//añadido en fecha 10 de enero 2011
			$proyecto=$_POST["proyecto_$j"];//añadido en fecha 10 de enero 2011
		}
		//En la fecha de inicio de depreciación, se coloca el último día del mes solicitado
		/*$fech = explode('-',$txt_fecha_ini_dep);
		$time = mktime(0,0,0,$fech[0] +1,0,$fech[2]);
		$dia_mes = date("d",$time);

		// Obtenemos la fecha
		$fecha_ini_dep = $fech[0]."-".$dia_mes."-".$fech[2];*/

		if($num_clones>0){ 
			$res = $Custom -> ClonarActivoFijo($id_activo_fijo,$num_clones);
				if(!$res)
				{
					//Se produjo un error
					$resp = new cls_manejo_mensajes(true, "503");
					$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
					$resp->origen = $Custom->salida[2];
					$resp->proc = $Custom->salida[3];
					$resp->nivel = $Custom->salida[4];
					$resp->query = $Custom->query;
					echo $resp->get_mensaje();
					exit;
				}
		}else{
			if ($id_activo_fijo == "undefined" || $id_activo_fijo == "")
			{	
				////////////////////Inserción/////////////////////
				//Validación de datos (del lado del servidor)
				$res = $Custom->ValidarActivoFijo("insert", $id_activo_fijo, $codigo, $descripcion, $descripcion_larga, $vida_util_original, $vida_util_restante, $tasa_depreciacion, $fecha_ultima_deprec, $depreciacion_acum_ant, $depreciacion_acum, $depreciacion_periodo, $flag_revaloriz, $valor_rescate, $fecha_compra, $monto_compra_mon_orig, $monto_compra, $monto_actual, $con_garantia, $num_poliza_garantia, $fecha_fin_gar, $fecha_reg, $foto_activo, $num_factura, $tipo_cambio, $estado, $observaciones, $id_sub_tipo_activo, $id_institucion, $id_moneda, $id_moneda_original, $id_unidad_constructiva, $fecha_ini_dep, $ubicacion_fisica, $orden_compra, $id_estado_funcional,$monto_compra_2,$monto_actual_2,$depreciacion_acum_2,$depreciacion_acum_ant_2,$depreciacion_periodo_2,$vida_util_2,$vida_util_restante_2,$fecha_alta,$id_deposito);
				if(!$res)
				{
					//Error de validación
					$resp = new cls_manejo_mensajes(true, "503");
					$resp->mensaje_error = $Custom->salida[1];
					$resp->origen = $Custom->salida[2];
					$resp->proc = $Custom->salida[3];
					$resp->nivel = $Custom->salida[4];
					echo $resp->get_mensaje();
					exit;
				}
				
				//Validación satisfactoria, se ejecuta la inserción
				$res = $Custom -> CrearActivoFijo($id_activo_fijo, $codigo, $descripcion, $descripcion_larga, $vida_util_original, $vida_util_restante, $tasa_depreciacion, $fecha_ultima_deprec, $depreciacion_acum_ant, $depreciacion_acum, $depreciacion_periodo, $flag_revaloriz, $valor_rescate, $fecha_compra, $monto_compra_mon_orig, $monto_compra, $monto_actual, $con_garantia, $num_poliza_garantia, $fecha_fin_gar, $fecha_reg, $foto_activo, $num_factura, $tipo_cambio, $estado, $observaciones, $id_sub_tipo_activo, $id_institucion, $id_moneda, $id_moneda_original, $id_unidad_constructiva, $fecha_ini_dep, $ubicacion_fisica, $orden_compra, $id_estado_funcional,$monto_compra_2,$monto_actual_2,$depreciacion_acum_2,$depreciacion_acum_ant_2,$depreciacion_periodo_2,$vida_util_2,$vida_util_restante_2,$id_depto,$id_cotizacion,$id_cotizacion_det,$origen,
				//$id_frppa,$id_unidad_organizacional,
				$id_presupuesto,$id_lugar,$id_gestion,$id_solicitud_compra, $clonacion,$id_clon,$id_deposito,$tipo_af_bien,$proyecto);
				if(!$res)
				{
					//Se produjo un error
					$resp = new cls_manejo_mensajes(true, "503");
					$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
					$resp->origen = $Custom->salida[2];
					$resp->proc = $Custom->salida[3];
					$resp->nivel = $Custom->salida[4];
					$resp->query = $Custom->query;
					echo $resp->get_mensaje();
					exit;
				}
				
				//Código del Activo Nuevo
				$cod='Código del Activo Fijo: '.$Custom->salida[2];
	
			}
			else
			{	 
				///////////////////////Modificación////////////////////
				//Validación de datos (del lado del servidor)
				
				$res = $Custom->ValidarActivoFijo("update", $id_activo_fijo, $codigo, $descripcion, $descripcion_larga, $vida_util_original, $vida_util_restante, $tasa_depreciacion, $fecha_ultima_deprec, $depreciacion_acum_ant, $depreciacion_acum, $depreciacion_periodo, $flag_revaloriz, $valor_rescate, $fecha_compra, $monto_compra_mon_orig, $monto_compra, $monto_actual, $con_garantia, $num_poliza_garantia, $fecha_fin_gar, $fecha_reg, $foto_activo, $num_factura, $tipo_cambio, $estado, $observaciones, $id_sub_tipo_activo, $id_institucion, $id_moneda, $id_moneda_original, $id_unidad_constructiva, $fecha_ini_dep, $ubicacion_fisica, $orden_compra, $id_estado_funcional,$monto_compra_2,$monto_actual_2,$depreciacion_acum_2,$depreciacion_acum_ant_2,$depreciacion_periodo_2,$vida_util_2,$vida_util_restante_2,$fecha_alta,$id_deposito);
				if(!$res)		
				{
					//Error de validación
					$resp = new cls_manejo_mensajes(true, "503");
					$resp->mensaje_error = $Custom->salida[1];
					$resp->origen = $Custom->salida[2];
					$resp->proc = $Custom->salida[3];
					$resp->nivel =$Custom->salida[4];
					echo $resp->get_mensaje();
					exit;
				}
	
	
				$res = $Custom -> ModificarActivoFijo($id_activo_fijo, $codigo, $descripcion, $descripcion_larga, $vida_util_original, $vida_util_restante, $tasa_depreciacion, $fecha_ultima_deprec, $depreciacion_acum_ant, $depreciacion_acum, $depreciacion_periodo, $flag_revaloriz, $valor_rescate, $fecha_compra, $monto_compra_mon_orig, $monto_compra, $monto_actual, $con_garantia, $num_poliza_garantia, $fecha_fin_gar, $fecha_reg, $foto_activo, $num_factura, $tipo_cambio, $estado, $observaciones, $id_sub_tipo_activo, $id_institucion, $id_moneda, $id_moneda_original, $id_unidad_constructiva, $fecha_ini_dep, $ubicacion_fisica, $orden_compra, $id_estado_funcional,$monto_compra_2,$monto_actual_2,$depreciacion_acum_2,$depreciacion_acum_ant_2,$depreciacion_periodo_2,$vida_util_2,$vida_util_restante_2,$id_depto,$id_cotizacion,$id_cotizacion_det,$origen,
				//$id_frppa,$id_unidad_organizacional,
				$id_presupuesto,$id_lugar,$id_gestion,$id_solicitud_compra,$clonacion,$id_clon,$id_deposito,$tipo_af_bien,$proyecto); 
				if(!$res)
				{
					//Se produjo un error
					$resp = new cls_manejo_mensajes(true, "503");
					$resp->mensaje_error = $Custom->salida[1];
					$resp->origen = $Custom->salida[2];
					$resp->proc = $Custom->salida[3];
					$resp->nivel = $Custom->salida[4];
					$resp->query = $Custom->query;
					echo $resp->get_mensaje();
					exit;
				}
			
			}
		}

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = 'Se guardaron todos los datos.';
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'nombres';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $Custom->ContarListaActivoFijo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo('TotalCount', $total_registros);
	$resp->add_nodo('mensaje', $mensaje_exito);
	$resp->add_nodo('tiempo_resp', '200');
	if($cod!='')
	{
		$resp->add_nodo('alert', $cod);
	}
	else 
	{
		$resp->add_nodo('alert', '');
	}
	echo $resp->get_mensaje();
	exit;
}
else
{	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = ' Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 1';
	echo $resp->get_mensaje();
	exit;
}
?>