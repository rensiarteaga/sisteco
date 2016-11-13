<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarTransferencia.php
Propósito:				Permite realizar el listado en tal_transferencia
Tabla:					t_tal_transferencia
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2007-11-21 08:58:58
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAlmacenes.php');

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = 'ActionListarTransferencia .php';

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

	if($sort == '') $sortcol = 'id_transferencia';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
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
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Transferencia');
	$sortcol = $crit_sort->get_criterio_sort();


	//Obtiene el total de los registros
	$res = $Custom -> ContarTransfPrestamoPend($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarTransfPrestamoPend($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_transferencia',$f["id_transferencia"]);
			$xml->add_nodo('prestamo',$f["prestamo"]);
			$xml->add_nodo('estado_transferencia',$f["estado_transferencia"]);
			$xml->add_nodo('motivo',$f["motivo"]);
			$xml->add_nodo('descripcion',$f["descripcion"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('fecha_pendiente_sal',$f["fecha_pendiente_sal"]);
			$xml->add_nodo('fecha_pendiente_ing',$f["fecha_pendiente_ing"]);
			$xml->add_nodo('fecha_finalizado_anulado',$f["fecha_finalizado_anulado"]);
			$xml->add_nodo('id_empleado',$f["id_empleado"]);

			$xml->add_nodo('desc_empleado',$f["desc_empleado"]);
			$xml->add_nodo('id_firma_autorizada_transf',$f["id_firma_autorizada_transf"]);
			$xml->add_nodo('desc_firma_autorizada',$f["desc_firma_autorizada"]);
			$xml->add_nodo('id_almacen_logico',$f["id_almacen_logico"]);
			$xml->add_nodo('desc_almacen_logico_orig',$f["desc_almacen_logico_orig"]);
			$xml->add_nodo('id_almacen_logico_destino',$f["id_almacen_logico_destino"]);
			$xml->add_nodo('desc_almacen_logico_dest',$f["desc_almacen_logico_dest"]);
			$xml->add_nodo('id_motivo_ingreso_cuenta',$f["id_motivo_ingreso_cuenta"]);
			$xml->add_nodo('desc_motivo_ingreso_cuenta',$f["desc_motivo_ingreso_cuenta"]);
			$xml->add_nodo('desc_almacen_orig',$f["desc_almacen_orig"]);

			$xml->add_nodo('nombre_financiador',$f["nombre_financiador"]);
			$xml->add_nodo('nombre_regional',$f["nombre_regional"]);
			$xml->add_nodo('nombre_programa',$f["nombre_programa"]);
			$xml->add_nodo('nombre_proyecto',$f["nombre_proyecto"]);
			$xml->add_nodo('nombre_actividad',$f["nombre_actividad"]);
			$xml->add_nodo('id_financiador',$f["id_financiador"]);
			$xml->add_nodo('id_regional',$f["id_regional"]);
			$xml->add_nodo('id_programa',$f["id_programa"]);
			$xml->add_nodo('id_proyecto',$f["id_proyecto"]);
			$xml->add_nodo('id_actividad',$f["id_actividad"]);

			$xml->add_nodo('codigo_financiador',$f["codigo_financiador"]);
			$xml->add_nodo('codigo_regional',$f["codigo_regional"]);
			$xml->add_nodo('codigo_programa',$f["codigo_programa"]);
			$xml->add_nodo('codigo_proyecto',$f["codigo_proyecto"]);
			$xml->add_nodo('codigo_actividad',$f["codigo_actividad"]);
			$xml->add_nodo('desc_almacen_dest',$f["desc_almacen_dest"]);
			$xml->add_nodo('nombre_financiador_dest',$f["nombre_financiador_dest"]);
			$xml->add_nodo('nombre_regional_dest',$f["nombre_regional_dest"]);
			$xml->add_nodo('nombre_programa_dest',$f["nombre_programa_dest"]);
			$xml->add_nodo('nombre_proyecto_dest',$f["nombre_proyecto_dest"]);

			$xml->add_nodo('nombre_actividad_dest',$f["nombre_actividad_dest"]);
			$xml->add_nodo('id_financiador_dest',$f["id_financiador_dest"]);
			$xml->add_nodo('id_regional_dest',$f["id_regional_dest"]);
			$xml->add_nodo('id_programa_dest',$f["id_programa_dest"]);
			$xml->add_nodo('id_proyecto_dest',$f["id_proyecto_dest"]);
			$xml->add_nodo('id_actividad_dest',$f["id_actividad_dest"]);
			$xml->add_nodo('codigo_financiador_dest',$f["codigo_financiador_dest"]);
			$xml->add_nodo('codigo_regional_dest',$f["codigo_regional_dest"]);
			$xml->add_nodo('codigo_programa_dest',$f["codigo_programa_dest"]);
			$xml->add_nodo('codigo_proyecto_dest',$f["codigo_proyecto_dest"]);

			$xml->add_nodo('codigo_actividad_dest',$f["codigo_actividad_dest"]);
			$xml->add_nodo('fecha_borrador',$f["fecha_borrador"]);
			$xml->add_nodo('fecha_pendiente',$f["fecha_pendiente"]);
			$xml->add_nodo('fecha_rechazado',$f["fecha_rechazado"]);
			$xml->add_nodo('id_ingreso',$f["id_ingreso"]);
			$xml->add_nodo('id_salida',$f["id_salida"]);
			$xml->add_nodo('id_tipo_material',$f["id_tipo_material"]);
			$xml->add_nodo('desc_tipo_material',$f["desc_tipo_material"]);
			$xml->add_nodo('id_motivo_salida_cuenta',$f["id_motivo_salida_cuenta"]);
			$xml->add_nodo('desc_motivo_salida_cuenta',$f["desc_motivo_salida_cuenta"]);

			$xml->add_nodo('desc_motivo_ingreso',$f["desc_motivo_ingreso"]);
			$xml->add_nodo('desc_motivo_salida',$f["desc_motivo_salida"]);
			$xml->add_nodo('id_ingreso_prestamo',$f["id_ingreso_prestamo"]);
			$xml->add_nodo('id_salida_prestamo',$f["id_salida_prestamo"]);
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