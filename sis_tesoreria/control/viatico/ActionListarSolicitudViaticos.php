<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarSolicitudViaticos.php
Propósito:				Permite realizar el listado en tts_viatico
Tabla:					tts_tts_viatico
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-11-12 11:42:20
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloTesoreria.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionListarSolicitudViaticos.php';

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

	if($sort == '') $sortcol = 'id_viatico';
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
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	//$cond->add_criterio_extra("VIATIC.fk_viatico",$filtro_fk_viatico);
	$cond->add_criterio_extra("VIATIC.fk_viatico",$id_viatico);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	
	/*if(value == 0)
	{return "Verificación"}
	if(value == 1)
	{return "Cálculo"}
	if(value == 2)
	{return "Pago Cheque"}
	if(value == 3)
	{return "Pago Efectivo"}
	if(value == 4)
	{return "Solicitud Contabilizada"}
	if(value == 5)
	{return "Solicitud Validada"}
	if(value == 6)
	{return "Pendiente Rendición"}
	if(value == 7)
	{return "Concluido"}
	if(value == 8)
	{return "Descargo"}
	if(value == 9)
	{return "Comprometido"}
	if(value == 10)
	{return "Rendición Contabilizada"}		
	if(value == 11)
	{return "Rendición Validada"}
	if(value == 15)
	{return "Finalización Parcial"}
	if(value == 12)
	{return "Finalización Contabilizada"}
	if(value == 13)
	{return "Finalización Validada"}
	if(value == 14)
	{return "Finalización por Caja"}
	return 'Otro';*/
	
	
	if($filtro_tipo_viatico=='1') //solicitud
	{		 
		$criterio_filtro=$criterio_filtro." and VIATIC.tipo_viatico in (1) and VIATIC.estado_viatico not in (7) ";	//filtramos solamente las solicitudes de viatico
		
		
		
		
		if($filtro_tipo_vista=='1') //Vista Registro de Solicitudes
		{		 
			$criterio_filtro=$criterio_filtro." and VIATIC.estado_viatico in (0,1,2,3,4,5,6) ";	//filtramos solamente los es
		}
		if($filtro_tipo_vista=='2')//Vista Pago de Viaticos
		{		 
			$criterio_filtro=$criterio_filtro." and VIATIC.estado_viatico in (5,12,13,14,15) ";	//filtramos solamente las reformulaciones
		}
	}
	if($filtro_tipo_viatico=='2')	//Ampliacion
	{		 
		$criterio_filtro=$criterio_filtro." and VIATIC.tipo_viatico in (2) ";	//filtramos solamente las apliaciones de viatico
	}	
	if($filtro_tipo_viatico=='3')	//Agrupador rendicion
	{		 
		$criterio_filtro=$criterio_filtro." and VIATIC.tipo_viatico in (3) ";	//filtramos solamente los agrupadores de rendicion
	}

	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Viatico');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarSolicitudViaticos($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarSolicitudViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_viatico',$f["id_viatico"]);			
			
			$xml->add_nodo('id_unidad_organizacional',$f["id_unidad_organizacional"]);
			$xml->add_nodo('desc_unidad_organizacional',$f["desc_unidad_organizacional"]);
			$xml->add_nodo('id_empleado',$f["id_empleado"]);
			$xml->add_nodo('desc_empleado',$f["desc_empleado"]);
			$xml->add_nodo('apellido_paterno_persona',$f["apellido_paterno_persona"]);
			$xml->add_nodo('apellido_materno_persona',$f["apellido_materno_persona"]);
			$xml->add_nodo('nombre_persona',$f["nombre_persona"]);
			$xml->add_nodo('id_categoria',$f["id_categoria"]);
			$xml->add_nodo('desc_categoria',$f["desc_categoria"]);			
						
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);					
			
			$xml->add_nodo('id_cuenta_bancaria',$f["id_cuenta_bancaria"]);
			$xml->add_nodo('desc_cuenta_bancaria',$f["desc_cuenta_bancaria"]);
			$xml->add_nodo('nombre_institucion',$f["nombre_institucion"]);
			$xml->add_nodo('nro_cuenta_banco_cuenta_bancaria',$f["nro_cuenta_banco_cuenta_bancaria"]);
			$xml->add_nodo('nombre_cheque',$f["nombre_cheque"]);
			$xml->add_nodo('total_general',$f["total_general"]);			
			
			$xml->add_nodo('estado_viatico',$f["estado_viatico"]);			
			$xml->add_nodo('fecha_solicitud',$f["fecha_solicitud"]);
			$xml->add_nodo('num_solicitud',$f["num_solicitud"]);
		
			$xml->add_nodo('detalle_viaticos',$f["detalle_viaticos"]);
			$xml->add_nodo('motivo_viaje',$f["motivo_viaje"]);
			$xml->add_nodo('id_entidad',$f["id_entidad"]);
			$xml->add_nodo('nombre_entidad',$f["nombre_entidad"]);			
			$xml->add_nodo('detalle_otros',$f["detalle_otros"]);
			$xml->add_nodo('sw_retencion',$f["sw_retencion"]);
			$xml->add_nodo('tipo_pago',$f["tipo_pago"]);
			$xml->add_nodo('id_cheque',$f["id_cheque"]);
			$xml->add_nodo('id_comprobante',$f["id_comprobante"]);
			
			$xml->add_nodo('id_caja',$f["id_caja"]);
			$xml->add_nodo('desc_caja',$f["desc_caja"]);
			$xml->add_nodo('id_cajero',$f["id_cajero"]);
			$xml->add_nodo('desc_cajero',$f["desc_cajero"]);
			$xml->add_nodo('importe_regis',$f["importe_regis"]);
			$xml->add_nodo('concepto_regis',$f["concepto_regis"]);			
			$xml->add_nodo('obs_viatico',$f["obs_viatico"]);
			
			$xml->add_nodo('tipo_viatico',$f["tipo_viatico"]);			
			$xml->add_nodo('fk_viatico',$f["fk_viatico"]);
			$xml->add_nodo('observacion',$f["observacion"]);
			
			$xml->add_nodo('fecha_inicio',$f["fecha_inicio"]);
			$xml->add_nodo('fecha_fin',$f["fecha_fin"]);
			$xml->add_nodo('saldo_viatico',$f["saldo_viatico"]);
			$xml->add_nodo('id_depto',$f["id_depto"]);
			$xml->add_nodo('nombre_depto',$f["nombre_depto"]);
			
			$xml->add_nodo('resp_registro',$f["resp_registro"]);
			$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
			$xml->add_nodo('desc_presupuesto',$f["desc_presupuesto"]);
			
			$xml->add_nodo('id_responsable_rendicion',$f["id_responsable_rendicion"]);
			$xml->add_nodo('desc_responsable_rendicion',$f["desc_responsable_rendicion"]);
			$xml->add_nodo('id_autorizacion',$f["id_autorizacion"]);
			$xml->add_nodo('desc_autorizacion',$f["desc_autorizacion"]);
			$xml->add_nodo('id_aprobacion',$f["id_aprobacion"]);
			$xml->add_nodo('desc_aprobacion',$f["desc_aprobacion"]);
			
			$xml->fin_rama();
		}
		$xml->mostrar_xml();
	}
	else
	{
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