<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarSolicitudCompra.php
Propósito:				Permite insertar y modificar datos en la tabla tad_solicitud_compra
Tabla:					tad_tad_solicitud_compra
Parámetros:				$id_solicitud_compra
						$precio_total
						$observaciones
						$fecha_venc
						$fecha_reg
						$hora_reg
						$localidad
						$num_solicitud
						$estado_reg
						$estado_vigente_solicitud
						$tipo_adjudicacion
						$modalidad
						$id_solicitud_compra_ant
						$id_tipo_categoria_adq
						$id_empleado_frppa_solicitante
						$id_moneda
						$id_rpa
						$id_empleado_frppa_transcriptor
						
						$id_unidad_organizacional
						$id_empleado_frppa_pre_aprobacion
						$id_empleado_frppa_aprobacion
						$id_empleado_frppa_gfa
						$id_estado_compra_categoria_adq
						$codigo_sicoes
						$periodo
						$gestion
						$num_solicitud_sis
						$id_fina_regi_prog_proy_acti

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-12 10:00:30
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarSolicitudCompra.php";

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
			$id_solicitud_compra= $_GET["id_solicitud_compra_$j"];
			$precio_total= $_GET["precio_total_$j"];
			$observaciones= $_GET["observaciones_$j"];
			$fecha_venc= $_GET["fecha_venc_$j"];
			$fecha_reg= $_GET["fecha_reg_$j"];
			$hora_reg= $_GET["hora_reg_$j"];
			$localidad= $_GET["localidad_$j"];
			$num_solicitud= $_GET["num_solicitud_$j"];
			$estado_reg= $_GET["estado_reg_$j"];
			$estado_vigente_solicitud= $_GET["estado_vigente_solicitud_$j"];
			$tipo_adjudicacion= $_GET["tipo_adjudicacion_$j"];
			$modalidad= $_GET["modalidad_$j"];
			
			$id_tipo_categoria_adq= $_GET["id_tipo_categoria_adq_$j"];
			//$id_empleado_frppa_solicitante= $_GET["id_empleado_frppa_solicitante_$j"];
			$id_empleado_frppa_solicitante= $_GET["id_emp_$j"];
			$id_moneda= $_GET["id_moneda_$j"];
			$id_rpa= $_GET["id_rpa_$j"];
			$id_empleado_frppa_transcriptor= $_GET["id_usuario_transcriptor_$j"];
			$id_unidad_organizacional= $_GET["id_unidad_organizacional_$j"];
			$id_empleado_frppa_pre_aprobacion= $_GET["id_empleado_frppa_pre_aprobacion_$j"];
			$id_empleado_aprobacion= $_GET["id_empleado_aprobacion_$j"];
			$id_empleado_frppa_gfa= $_GET["id_empleado_frppa_gfa_$j"];
			
			//$siguiente_estado= $_GET["siguiente_estado_$j"];
			$periodo= $_GET["periodo_$j"];
			$gestion= $_GET["gestion_$j"];
			//$num_solicitud_sis= $_GET["num_solicitud_sis_$j"];
			
			$id_tipo_adq= $_GET["id_tipo_adq_$j"];
			
			
			
			$id_orden_trabajo=$_GET["id_orden_trabajo_$j"];
			$id_almacen_logico=$_GET["id_almacen_logico_$j"];
			$modificacion=$_GET["es_modificacion_$j"];
			$id_uo_gerencia=$_GET["id_uo_gerencia_$j"];
			$id_depto=$_GET["id_depto_$j"];
			$proveedores_propuestos=$_GET["proveedores_propuestos_$j"];
			$comite_calificacion=$_GET["comite_calificacion_$j"];
			$comite_recepcion=$_GET["comite_recepcion_$j"];
			$avance=$_GET["avance_$j"];
			$id_presupuesto=$_GET["id_presupuesto_$j"];
			$id_correspondencia=$_GET["id_correspondencia_$j"];
			
		}
		else
		{
			$id_solicitud_compra=$_POST["id_solicitud_compra_$j"];
			$precio_total=$_POST["precio_total_$j"];
			$observaciones=$_POST["observaciones_$j"];
			$fecha_venc=$_POST["fecha_venc_$j"];
			$fecha_reg=$_POST["fecha_reg_$j"];
			$hora_reg=$_POST["hora_reg_$j"];
			$localidad=$_POST["localidad_$j"];
			$num_solicitud=$_POST["num_solicitud_$j"];
			$estado_reg=$_POST["estado_reg_$j"];
			$estado_vigente_solicitud=$_POST["estado_vigente_solicitud_$j"];
			$tipo_adjudicacion=$_POST["tipo_adjudicacion_$j"];
			$modalidad=$_POST["modalidad_$j"];
			
			$id_tipo_categoria_adq=$_POST["id_tipo_categoria_adq_$j"];
			//$id_empleado_frppa_solicitante=$_POST["id_empleado_frppa_solicitante_$j"];
			$id_empleado_frppa_solicitante= $_POST["id_emp_$j"];
			$id_moneda=$_POST["id_moneda_$j"];
			$id_rpa=$_POST["id_rpa_$j"];
			$id_empleado_frppa_transcriptor=$_POST["id_usuario_transcriptor_$j"];
			$id_unidad_organizacional=$_POST["id_unidad_organizacional_$j"];
			$id_empleado_frppa_pre_aprobacion=$_POST["id_empleado_frppa_pre_aprobacion_$j"];
			$id_empleado_aprobacion=$_POST["id_empleado_aprobacion_$j"];
			$id_empleado_frppa_gfa=$_POST["id_empleado_frppa_gfa_$j"];
			
			
			//$siguiente_estado=$_POST["siguiente_estado_$j"];
			$periodo=$_POST["periodo_$j"];
			$gestion=$_POST["gestion_$j"];
			//$num_solicitud_sis=$_POST["num_solicitud_sis_$j"];
			
			
				
			$id_tipo_adq= $_POST["id_tipo_adq_$j"];
			
			$id_orden_trabajo=$_POST["id_orden_trabajo_$j"];
			$id_almacen_logico=$_POST["id_almacen_logico_$j"];
			$modificacion=$_POST["es_modificacion_$j"];
			$id_uo_gerencia=$_POST["id_uo_gerencia_$j"];
			$id_depto=$_POST["id_depto_$j"];
			$proveedores_propuestos=$_POST["proveedores_propuestos_$j"];
			$comite_calificacion=$_POST["comite_calificacion_$j"];
			$comite_recepcion=$_POST["comite_recepcion_$j"];
			$avance=$_POST["avance_$j"];
			$id_presupuesto=$_POST["id_presupuesto_$j"];
			$id_correspondencia=$_POST["id_correspondencia_$j"];
		}
		
	//echo explode(',',$id_correspondencia); exit; //'--'.$id_correspondencia; exit;
        $id_empresa=$_SESSION["ss_id_empresa"];
		/*if($id_empresa =='undefined'){
			$id_empresa='NULL';
		}*/
		
		
		if(isset($id_correspondencia) && $id_correspondencia>0){
										$vec_id_corr=explode(',',$id_correspondencia);
										//elimina los calores repetidos
										
										$vec_id_corr=array_unique($vec_id_corr);								
								    }
		
          
		if ($id_solicitud_compra == "undefined" || $id_solicitud_compra == "")
		{
			////////////////////Inserción/////////////////////
			$hora_reg=date("H:i:s");
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarSolicitudCompra("insert",$id_solicitud_compra,$precio_total,$observaciones,$fecha_venc,$fecha_reg,$hora_reg,$localidad,$num_solicitud,$estado_reg,$estado_vigente_solicitud,$tipo_adjudicacion,$modalidad,$id_solicitud_compra_ant,$id_tipo_categoria_adq,$id_empleado_frppa_solicitante,$id_moneda,$id_rpa,$id_empleado_frppa_transcriptor,$id_unidad_organizacional,$id_empleado_frppa_pre_aprobacion,$id_empleado_aprobacion,$id_empleado_frppa_gfa,$periodo,$gestion,$id_presupuesto);

			
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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tad_solicitud_compra
			$res = $Custom -> InsertarSolicitudCompra($id_solicitud_compra, $precio_total, $observaciones, $fecha_venc, $fecha_reg, $hora_reg, $localidad, $num_solicitud, $estado_reg, $estado_vigente_solicitud, $tipo_adjudicacion, $modalidad,  $id_tipo_categoria_adq, $id_empleado_frppa_solicitante, $id_moneda, $id_rpa, $id_empleado_frppa_transcriptor,  $id_unidad_organizacional, $id_empleado_frppa_pre_aprobacion, $id_empleado_aprobacion, $id_empleado_frppa_gfa, $periodo, $gestion, $id_presupuesto,$id_tipo_adq,$id_empresa,$id_orden_trabajo,$id_almacen_logico,$id_uo_gerencia,$id_depto,$proveedores_propuestos,$comite_calificacion,$comite_recepcion,$avance,$vec_id_corr);
			//

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
			
		
			if($modificacion==''){
				//echo $vec_id_corr; exit;
					/*  echo $id_solicitud_compraacion;
         exit;		*/
				$res = $Custom->ModificarSolicitudCompraRPA($id_solicitud_compra, $vec_id_corr,$comite_calificacion,$id_tipo_categoria_adq,$id_empleado_aprobacion);

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
			}else{
			
			//Validación de datos (del lado del servidor)
				$res = $Custom->ValidarSolicitudCompra("update",$id_solicitud_compra,$precio_total,$observaciones,$fecha_venc,$fecha_reg,$hora_reg,$localidad,$num_solicitud,$estado_reg,$estado_vigente_solicitud,$tipo_adjudicacion,$modalidad,$id_solicitud_compra_ant,$id_tipo_categoria_adq,$id_empleado_frppa_solicitante,$id_moneda,$id_rpa,$id_empleado_frppa_transcriptor,$id_unidad_organizacional,$id_empleado_frppa_pre_aprobacion,$id_empleado_aprobacion,$id_empleado_frppa_gfa,$periodo,$gestion,$id_presupuesto);

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

				$res = $Custom->ModificarSolicitudCompra($id_solicitud_compra, $precio_total, $observaciones, $fecha_venc, $fecha_reg, $hora_reg, $localidad, $num_solicitud, $estado_reg, $estado_vigente_solicitud, $tipo_adjudicacion, $modalidad,  $id_tipo_categoria_adq, $id_empleado_frppa_solicitante, $id_moneda, $id_rpa, $id_empleado_frppa_transcriptor,  $id_unidad_organizacional, $id_empleado_frppa_pre_aprobacion, $id_empleado_aprobacion, $id_empleado_frppa_gfa, $periodo, $gestion,  $id_presupuesto,$id_tipo_adq,$id_empresa,$id_orden_trabajo,$id_almacen_logico,$id_uo_gerencia,$id_depto,$proveedores_propuestos,$comite_calificacion,$comite_recepcion,$avance,$vec_id_corr);
				//
                                                      
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
		}

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_solicitud_compra";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0 AND (SOLADQ.estado_vigente_solicitud =''borrador'' OR (SOLADQ.estado_vigente_solicitud=''pendiente_pre_aprobacion'' AND SOLADQ.id_rpa is null))";

	$id_empresa=$_SESSION["ss_id_empresa"];
	$res = $Custom->ContarSolicitudCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empresa);
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