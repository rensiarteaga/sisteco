<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarSalida.php
Prop�sito:				Permite realizar el listado en tal_salida
Tabla:					t_tal_salida
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		2007-10-25 15:08:04
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../fpc_LibModeloAlmacenes.php');

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = 'ActionListarSalida .php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Par�metros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_salida';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	$id_emp = $_SESSION["ss_id_empleado"];
	
	/*if($id_emp!="null"){
	$criterio_filtro= $criterio_filtro." AND SALIDA.id_empleado=$id_emp";
	}*/
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Salida');
	$sortcol = $crit_sort->get_criterio_sort();
	
 	
	//Obtiene el total de los registros
	$res = $Custom -> ContarSalidaPendiente($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarSalidaPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_salida',$f["id_salida"]);
			$xml->add_nodo('correlativo_sal',$f["correlativo_sal"]);
			$xml->add_nodo('correlativo_vale',$f["correlativo_vale"]);
			$xml->add_nodo('fecha_aprobado_rechazado',$f["fecha_aprobado_rechazado"]);
			$xml->add_nodo('descripcion',$f["descripcion"]);
			$xml->add_nodo('contabilizar',$f["contabilizar"]);
			$xml->add_nodo('contabilizado',$f["contabilizado"]);
			$xml->add_nodo('estado_salida',$f["estado_salida"]);
			$xml->add_nodo('estado_registro',$f["estado_registro"]);
			$xml->add_nodo('motivo_cancelacion',$f["motivo_cancelacion"]);
			$xml->add_nodo('id_responsable_almacen',$f["id_responsable_almacen"]);
			$xml->add_nodo('desc_responsable_almacen',$f["desc_responsable_almacen"]);
			$xml->add_nodo('id_almacen_logico',$f["id_almacen_logico"]);
			$xml->add_nodo('desc_almacen_logico',$f["desc_almacen_logico"]);
			$xml->add_nodo('id_empleado',$f["id_empleado"]);
			$xml->add_nodo('desc_empleado',$f["desc_empleado"]);
			$xml->add_nodo('id_firma_autorizada',$f["id_firma_autorizada"]);
			$xml->add_nodo('desc_firma_autorizada',$f["desc_firma_autorizada"]);
			$xml->add_nodo('id_contratista',$f["id_contratista"]);
			$xml->add_nodo('desc_contratista',$f["desc_contratista"]);
			$xml->add_nodo('id_tipo_material',$f["id_tipo_material"]);
			$xml->add_nodo('desc_tipo_material',$f["desc_tipo_material"]);
			$xml->add_nodo('id_institucion',$f["id_institucion"]);
			$xml->add_nodo('desc_institucion',$f["desc_institucion"]);
			$xml->add_nodo('id_subactividad',$f["id_subactividad"]);
			$xml->add_nodo('desc_subactividad',$f["desc_subactividad"]);
			$xml->add_nodo('id_motivo_salida_cuenta',$f["id_motivo_salida_cuenta"]);
			$xml->add_nodo('desc_motivo_salida_cuenta',$f["desc_motivo_salida_cuenta"]);
			$xml->add_nodo('nro_cuenta',$f["nro_cuenta"]);
			$xml->add_nodo('emergencia',$f["emergencia"]);	
			$xml->add_nodo('desc_motivo_salida',$f["desc_motivo_salida"]);	
			$xml->add_nodo('tipo_pedido',$f["tipo_pedido"]);
			$xml->add_nodo('tipo_entrega',$f["tipo_entrega"]);
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