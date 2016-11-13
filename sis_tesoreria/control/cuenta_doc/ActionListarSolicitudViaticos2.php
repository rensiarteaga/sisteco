<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarSolicitudViaticos2.php
Propósito:				Permite realizar el listado en tts_cuenta_doc
Tabla:					tts_tts_cuenta_doc
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2009-10-27 10:40:41
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloTesoreria.php');
include_once('../../../lib/lib_control/GestionarExcel.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionListarSolicitudViaticos2.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_cuenta_doc';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'desc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod)
	{
		case 'si':
			$decodificar = true;
			break;
		case 'no':
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;
	
	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{  
		if ($reporte_excel=='si'){	
			$cond->add_condicion_filtro($_GET["filterCol_$i"], $_GET["filterValue_$i"], $_GET["filterAvanzado_$i"]);
	    }else{
	    	$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);	
	    }
	}	
	
	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	
	if($tipo_cuenta_doc){
		
		//RCM: 06/10/2011 para consulta de los fondos en avance finalizados
		if($tipo_cuenta_doc=='fin_avance'){
			$criterio_filtro=$criterio_filtro." AND CUDOC.tipo_cuenta_doc like ''solicitud_avance''";
		} else if($tipo_cuenta_doc=='fin_viatico'){
			 $criterio_filtro=$criterio_filtro." AND CUDOC.tipo_cuenta_doc like ''solicitud_viatico''";
		} else if($tipo_cuenta_doc!='autorizacion_solicitud'){
			$criterio_filtro=$criterio_filtro." AND CUDOC.tipo_cuenta_doc like ''$tipo_cuenta_doc''";	
		}
		
		if($tipo_cuenta_doc=='solicitud_avance'||$tipo_cuenta_doc=='ampliacion_avance'||$tipo_cuenta_doc=='solicitud_viatico'||$tipo_cuenta_doc=='ampliacion_viatico'||$tipo_cuenta_doc=='solicitud_efectivo'){
			$criterio_filtro=$criterio_filtro." AND CUDOC.estado != ''finalizado'' AND CUDOC.estado != ''anulado''";
		}
		if($tipo_cuenta_doc=='rendicion_caja'){
			$criterio_filtro=$criterio_filtro." AND CUDOC.estado != ''anulado''";
		}
		if ($tipo_cuenta_doc=='solicitud_efectivo'){
			if($estado=='recibo_caja'){
				$criterio_filtro=$criterio_filtro." AND CUDOC.estado != ''comprometido'' ";
			} else if($estado=='recibo_rendido'){
				$criterio_filtro=$criterio_filtro." AND CUDOC.estado != ''borrador'' AND CUDOC.estado != ''pago_efectivo'' AND CUDOC.estado != ''pagado'' ";
			} else{
				$criterio_filtro=$criterio_filtro." AND CUDOC.id_subsistema is null AND CUDOC.fk_id_cuenta_doc is null AND CUDOC.estado != ''comprometido'' AND CUDOC.estado!=''pagado'' ";
			}
		}
		//RCM: 06/10/2011 para consulta de los fondos en avance y viaticos finalizados
		if($tipo_cuenta_doc=='fin_avance'||$tipo_cuenta_doc=='fin_viatico'){
			$criterio_filtro=$criterio_filtro." AND CUDOC.estado IN (''finalizado'', ''anulado'') ";
		}
	}
	
	if($tipo_cuenta_doc2){
		$criterio_filtro=$criterio_filtro." AND CUDOC.tipo_cuenta_doc like ''$tipo_cuenta_doc2''";
		
		if($tipo_cuenta_doc2=='solicitud_efectivo'||$tipo_cuenta_doc2=='rendicion_caja'){
			$criterio_filtro=$criterio_filtro." AND (CUDOC.estado = ''borrador'' OR CUDOC.estado = ''pago_efectivo'' OR CUDOC.estado = ''pagado'')";
		}
	}
	
	if($id_cuenta_doc){
		$criterio_filtro=$criterio_filtro." AND CUDOC.fk_id_cuenta_doc=$id_cuenta_doc";
	}
	if($id_caja){
		$criterio_filtro=$criterio_filtro." AND CUDOC.id_caja=$id_caja";
	}
	if($estado_fa){
		$criterio_filtro=$criterio_filtro." AND CUDOC.estado=''$estado_fa''";
	}
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'CuentaDoc_aeiou');
	$sortcol = $crit_sort->get_criterio_sort();
	
	//if($_SESSION["ss_id_usuario"]==120) {echo $criterio_filtro;
	//exit;}
	
	//--Grover Excel inicio
	$titulo_reporte_excel = 'LISTADO DE SOLICITUDES DE VIAJE CON RENDICIONES VENCIDAS.xls';
	
	if ($reporte_excel=='si')
	{	//recupera los valores de las columnas
		
		for($i=0;$i<$nro_columnas;$i++)
		{
			$datosCabecera['valor'][$i]=$_GET["valor_$i"];
			$datosCabecera['columna'][$i]=$_GET["columna_$i"];
			$datosCabecera['align'][$i]=$_GET["align_$i"];
			$datosCabecera['width'][$i]=$_GET["width_$i"];		
		}	
		
		$Excel = new GestionarExcel();
		$Excel->SetNombreReporte($titulo_reporte_excel);
		//echo $titulo_reporte_excel; exit();
		$Excel->SetHoja("Hoja 1 Datos");
		$Excel->SetFila(3);
		$cant=100000000;
		$puntero=0;
	
		$Excel->SetTitulo($titulo_reporte_excel,0,3,$nro_columnas); //Colocamos el titulo al reporte
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas		
		$pos = strpos($tipo_cuenta_doc, '?', 1);
		$tipo_cuenta_doc =substr($tipo_cuenta_doc,0,$pos);
		
		/*echo $tipo_cuenta_doc;
		exit;*/
	if($tipo_cuenta_doc=='autorizacion_solicitud'){ //GVC 17/feb/12
			//$criterio_filtro2=$criterio_filtro." AND CUDOC.estado not in  (''finalizado'')  AND CUDOC.tipo_cuenta_doc in (''solicitud_viatico'', ''solicitud_avance'') "; //and (select tesoro.f_ts_get_num_dias_para_rendir(CUDOC.id_cuenta_doc) ) < 0
			
			$criterio_filtro=$criterio_filtro." AND CUDOC.tipo_cuenta_doc in (''solicitud_viatico'', ''solicitud_avance'',''ampliacion_viatico'')  AND CUDOC.estado  in  (''pagado'')  and CUDOC.num_dias_para_rendir < 0 AND CUDOC.fecha_aut_rendicion is null and CUDOC.fecha_sol>=''2016-01-01'' "; //and (select tesoro.f_ts_get_num_dias_para_rendir(CUDOC.id_cuenta_doc) ) < 0
			$res = $Custom->ListarSolicitudAutorizar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_cuenta_doc,$estado);
			
				
		}else{
			
			$res = $Custom->ListarSolicitudViaticos2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_cuenta_doc,$estado);
			
		}
		/*print_r($Custom->salida);
		exit;*/
		$Excel->setDetalle($Custom->salida);
		$Excel->setFin();		
	}else{	
		//Obtiene el total de los registros
		$res = $Custom -> ContarSolicitudViaticos2($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_cuenta_doc,$estado);

		if($res) $total_registros= $Custom->salida;

		//Obtiene el conjunto de datos de la consulta
		if($tipo_cuenta_doc=='autorizacion_solicitud'){ //GVC 17/feb/12
			//$criterio_filtro2=$criterio_filtro." AND CUDOC.estado not in  (''finalizado'')  AND CUDOC.tipo_cuenta_doc in (''solicitud_viatico'', ''solicitud_avance'') "; //and (select tesoro.f_ts_get_num_dias_para_rendir(CUDOC.id_cuenta_doc) ) < 0
			//$criterio_filtro= " CUDOC.tipo_cuenta_doc in (''solicitud_viatico'', ''solicitud_avance'')  AND CUDOC.estado  in  (''pagado'')  and CUDOC.num_dias_para_rendir < 0 AND CUDOC.fecha_aut_rendicion is null "; //and (select tesoro.f_ts_get_num_dias_para_rendir(CUDOC.id_cuenta_doc) ) < 0
			//$criterio_filtro=$criterio_filtro." and CUDOC.estado  in  (''pagado'')  and CUDOC.num_dias_para_rendir < 0 AND CUDOC.fecha_aut_rendicion is null "; //and (select tesoro.f_ts_get_num_dias_para_rendir(CUDOC.id_cuenta_doc) ) < 0
			$res = $Custom->ListarSolicitudAutorizar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_cuenta_doc,$estado);
				
		}else{

			$res = $Custom->ListarSolicitudViaticos2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_cuenta_doc,$estado);
			
		}   
		//echo $Custom->query;
		//exit;
		if($res){
			$xml = new cls_manejo_xml('ROOT');
			$xml->add_nodo('TotalCount',$total_registros);

			foreach ($Custom->salida as $f){
				$xml->add_rama('ROWS');
				$xml->add_nodo('id_cuenta_doc',$f["id_cuenta_doc"]);
				$xml->add_nodo('fk_id_cuenta_doc',$f["fk_id_cuenta_doc"]);
				$xml->add_nodo('id_depto',$f["id_depto"]);
				$xml->add_nodo('desc_depto',$f["desc_depto"]);
				$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
				$xml->add_nodo('desc_presupuesto',$f["desc_presupuesto"]);
				$xml->add_nodo('id_empleado',$f["id_empleado"]);
				$xml->add_nodo('desc_empleado',$f["desc_empleado"]);
				$xml->add_nodo('apellido_paterno_persona',$f["apellido_paterno_persona"]);
				$xml->add_nodo('apellido_materno_persona',$f["apellido_materno_persona"]);
				$xml->add_nodo('nombre_persona',$f["nombre_persona"]);
				$xml->add_nodo('codigo_empleado_empleado',$f["codigo_empleado_empleado"]);
				$xml->add_nodo('id_categoria',$f["id_categoria"]);
				$xml->add_nodo('desc_categoria',$f["desc_categoria"]);
				$xml->add_nodo('fecha_ini',$f["fecha_ini"]);
				$xml->add_nodo('fecha_fin',$f["fecha_fin"]);
				$xml->add_nodo('tipo_pago',$f["tipo_pago"]);
				$xml->add_nodo('tipo_contrato',$f["tipo_contrato"]);
				$xml->add_nodo('id_usuario_reg',$f["id_usuario_reg"]);
				$xml->add_nodo('desc_usuario',$f["desc_usuario"]);
				$xml->add_nodo('apellido_paterno_persona',$f["apellido_paterno_persona"]);
				$xml->add_nodo('apellido_materno_persona',$f["apellido_materno_persona"]);
				$xml->add_nodo('nombre_persona',$f["nombre_persona"]);
				$xml->add_nodo('apellido_paterno_usuario',$f["apellido_paterno_usuario"]);
				$xml->add_nodo('apellido_materno_usuario',$f["apellido_materno_usuario"]);
				$xml->add_nodo('nombre_usuario',$f["nombre_usuario"]);
				$xml->add_nodo('estado',$f["estado"]);
				$xml->add_nodo('nro_documento',$f["nro_documento"]);
				$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
				$xml->add_nodo('motivo',$f["motivo"]);
				$xml->add_nodo('recorrido',$f["recorrido"]);
				$xml->add_nodo('observaciones',$f["observaciones"]);
				$xml->add_nodo('id_moneda',$f["id_moneda"]);
				$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
				$xml->add_nodo('fecha_sol',$f["fecha_sol"]);
				$xml->add_nodo('fa_solicitud',$f["fa_solicitud"]);
				$xml->add_nodo('id_caja',$f["id_caja"]);
				$xml->add_nodo('desc_caja',$f["desc_caja"]);
				$xml->add_nodo('id_cajero',$f["id_cajero"]);
				$xml->add_nodo('desc_cajero',$f["desc_cajero"]);
				$xml->add_nodo('saldo_solicitante',$f["saldo_solicitante"]);
				$xml->add_nodo('importe',$f["importe"]);
				$xml->add_nodo('importe_entregado',$f["importe_entregado"]);
				$xml->add_nodo('id_proveedor',$f["id_proveedor"]);
				$xml->add_nodo('desc_proveedor',$f["desc_proveedor"]);
				$xml->add_nodo('id_subsistema',$f["id_subsistema"]);
				$xml->add_nodo('tipo_pago_fin',$f["tipo_pago_fin"]);
				$xml->add_nodo('id_cuenta_bancaria',$f["id_cuenta_bancaria"]);
				$xml->add_nodo('id_cuenta_bancaria_fin',$f["id_cuenta_bancaria_fin"]);
				$xml->add_nodo('id_caja_fin',$f["id_caja_fin"]);
				$xml->add_nodo('id_cajero_fin',$f["id_cajero_fin"]);
				$xml->add_nodo('nro_deposito',$f["nro_deposito"]);
				$xml->add_nodo('desc_cuenta_bancaria_fin',$f["desc_cuenta_bancaria_fin"]);
				$xml->add_nodo('desc_caja_fin',$f["desc_caja_fin"]);
				$xml->add_nodo('desc_cajero_fin',$f["desc_cajero_fin"]);
				$xml->add_nodo('tipo_recibo',$f["tipo_recibo"]);
				
				$xml->add_nodo('resp_registro',$f["resp_registro"]);
				$xml->add_nodo('id_autorizacion',$f["id_autorizacion"]);
				$xml->add_nodo('desc_autorizacion',$f["desc_autorizacion"]);
				$xml->add_nodo('nombre_cheque',$f["nombre_cheque"]);
				
				$xml->add_nodo('id_parametro',$f["id_parametro"]);
				$xml->add_nodo('desc_parametro',$f["desc_parametro"]);
				$xml->add_nodo('id_comprobante',$f["id_comprobante"]);
				$xml->add_nodo('nro_dias_para_rendir',$f["nro_dias_para_rendir"]);
				
				$xml->add_nodo('cant_rend_registradas',$f["cant_rend_registradas"]);
				$xml->add_nodo('cant_rend_finalizadas',$f["cant_rend_finalizadas"]);
				$xml->add_nodo('cant_rend_contabilizadas',$f["cant_rend_contabilizadas"]);
				
				$xml->add_nodo('codigo_caja',$f["codigo_caja"]);
				
				$xml->fin_rama();
			}
			$xml->mostrar_xml();
		}else{
			//Se produjo un error
			$resp = new cls_manejo_mensajes(true,'406');
			$resp->mensaje_error = $Custom->salida[1];
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit;
		}
	
	}  //Grover Excel Fin
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;

}?>