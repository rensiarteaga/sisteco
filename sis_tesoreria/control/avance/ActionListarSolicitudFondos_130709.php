<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarSolicitudFondos.php
Propósito:				Permite realizar el listado en tts_avance
Tabla:					tts_tts_avance
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-10-17 10:39:24
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloTesoreria.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionListarSolicitudFondos.php';

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

	if($sort == '') $sortcol = 'id_avance';
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
	$cond->add_criterio_extra("AVANCE.fk_avance",$m_id_avance);
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	if($filtro_tipo_solicitud=='1')
	{		 
		$criterio_filtro=$criterio_filtro." AND AVANCE.tipo_avance IN (1) AND AVANCE.estado_avance IN(1,4,5,9,10) ";	//filtramos solamente las solicitudes de fondos
	}
	if($filtro_tipo_solicitud=='2')
	{		 
		$criterio_filtro=$criterio_filtro." AND AVANCE.tipo_avance IN (1,3) AND AVANCE.estado_avance IN(6,11,12,13) ";	//filtramos solamente las solicitudes de fondos
	}
	if($filtro_tipo_solicitud=='3')
	{		 
		$criterio_filtro=$criterio_filtro." AND AVANCE.tipo_avance IN (3) AND AVANCE.estado_avance IN(1,4,5,9) ";	//filtramos solamente las ampliaciones de fondos
	}
//	if($tipo=='plan_pago')
//	{		 
//		$criterio_filtro=$criterio_filtro." AND AVANCE.tipo_avance=1 AND AVANCE.estado_avance=4 and AVANCE.id_depto=$id_depto 
//		and AVANCE.id_avance NOT IN(select id_avance from compro.tad_plan_pago where id_cotizacion=$id_cotizacion and estado!=''anulado'')";	//filtramos solamente las solicitudes de fondos
//	}

	if($tipo=='plan_pago')
	{		 
		$criterio_filtro=$criterio_filtro." AND AVANCE.tipo_avance=1 AND AVANCE.estado_avance=4 and AVANCE.id_depto=$id_depto ";
	
	}
	if($solicitud_caja=='si'){
		$criterio_filtro=$criterio_filtro." AND AVANCE.id_depto IN (SELECT DEPUSU.id_depto 
                                                                FROM param.tpm_depto_usuario DEPUSU
                                                                INNER JOIN param.tpm_depto DEP ON DEP.id_depto=DEPUSU.id_depto AND DEP.id_subsistema=12
                                                                WHERE DEPUSU.id_usuario=".$_SESSION['ss_id_usuario'].")"; 
	}
	else{
		$criterio_filtro=$criterio_filtro." AND (AVANCE.id_usr_reg=".$_SESSION['ss_id_usuario']." OR AVANCE.id_empleado=".$_SESSION['ss_id_empleado'].")";
	}
	
	/*echo $criterio_filtro;
	exit;*/
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Avance');
	$sortcol = $crit_sort->get_criterio_sort();
	
$id_usuario=$_SESSION["ss_id_usuario"];
	//Obtiene el total de los registros
	$res = $Custom -> ContarSolicitudFondos($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_usuario);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarSolicitudFondos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_usuario);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_avance',$f["id_avance"]);
			$xml->add_nodo('id_empleado',$f["id_empleado"]);
			$xml->add_nodo('desc_empleado',$f["desc_empleado"]);
			$xml->add_nodo('tipo_avance',$f["tipo_avance"]);
			$xml->add_nodo('fecha_avance',$f["fecha_avance"]);
			$xml->add_nodo('importe_avance',$f["importe_avance"]);
			$xml->add_nodo('estado_avance',$f["estado_avance"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('nombre_moneda',$f["nombre_moneda"]);
			$xml->add_nodo('id_cheque',$f["id_cheque"]);
			$xml->add_nodo('nro_cheque',$f["nro_cheque"]);
			$xml->add_nodo('id_documento',$f["id_documento"]);
			$xml->add_nodo('nro_documento',$f["nro_documento"]);
			$xml->add_nodo('id_comprobante',$f["id_comprobante"]);
			$xml->add_nodo('nro_comprobante',$f["nro_comprobante"]);
			$xml->add_nodo('fk_avance',$f["fk_avance"]);
			$xml->add_nodo('id_depto',$f["id_depto"]);
			$xml->add_nodo('desc_depto',$f["desc_depto"]);
			$xml->add_nodo('id_caja',$f["id_caja"]);
			$xml->add_nodo('desc_unidad_organizacional',$f["desc_unidad_organizacional"]);
			$xml->add_nodo('id_subsistema',$f["id_subsistema"]);
			$xml->add_nodo('desc_subsistema',$f["desc_subsistema"]);
			$xml->add_nodo('avance_solicitud',$f["avance_solicitud"]);
			$xml->add_nodo('id_cajero',$f["id_cajero"]);
			$xml->add_nodo('desc_cajero',$f["desc_cajero"]);
			$xml->add_nodo('saldo',$f["saldo"]);
			$xml->add_nodo('nro_avance',$f["nro_avance"]);
			$xml->add_nodo('concepto_avance',$f["concepto_avance"]);
			$xml->add_nodo('observacion_avance',$f["observacion_avance"]);
			$xml->add_nodo('observacion_conta',$f["observacion_conta"]);
			$xml->add_nodo('id_usr_reg',$f["id_usr_reg"]);
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