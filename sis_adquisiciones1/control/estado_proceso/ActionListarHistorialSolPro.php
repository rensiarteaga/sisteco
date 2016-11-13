<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarHistorialSolicitud.php
Propósito:				Permite realizar el listado en tad_estado_proceso
Tabla:					t_tad_estado_proceso
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-23 09:21:03
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarHistorialSolicitud .php';

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

	if($sort == '') $sortcol = 'id_proceso_compra';
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

	$cond->add_criterio_extra("SOLPRO.id_solicitud_compra",$m_id_solicitud_compra);

	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'HistorialSolPro');
	$sortcol = $crit_sort->get_criterio_sort();


	//Obtiene el total de los registros
	$res = $Custom -> ContarHistorialSolPro($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarHistorialSolPro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	$llave=0;
	$id_proceco_compra_anterior=0;
	$sw=0;

	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');


		$count=0;

		foreach ($Custom->salida as $f)
		{

	     	if($id_proceo_compra_anterior==0){
				//armamos un proceso
				$id_proceo_compra_anterior=$f["id_proceso_compra"];

				$count++;


				$xml->add_rama('ROWS');
				$xml->add_nodo('id_histo',$count);
				$xml->add_nodo('tipo','Proceso');
				$xml->add_nodo('id_proceso_compra',$f["id_proceso_compra"]);
				$xml->add_nodo('id_cotizacion',$f["id_cotizacion"]);
				$xml->add_nodo('codigo_proceso',$f["codigo_proceso"]);
				$xml->add_nodo('num_doc',$f["periodo"].'/'.$f["num_proceso"]);
				$xml->add_nodo('observaciones',$f["observaciones"]);
				$xml->add_nodo('fecha_ini',$f["fecha_ini"]);
				$xml->add_nodo('estado_vigente',$f["estado_vigente"]);
				$xml->add_nodo('num_convocatoria',$f["num_convocatoria"]);
				$xml->add_nodo('id_proveedor',$f['id_proveedor']);
				$xml->add_nodo('desc_proveedor','----');
				if($f['compra_simplificada']==0){

					$xml->add_nodo('compra_simplificada','Regular');
				}
				else{
					$xml->add_nodo('compra_simplificada','Simplificado');
				}
				$xml->add_nodo('num_cotizacion_proc',$f['num_cotizacion_proc']);
				$xml->add_nodo('id_tipo_categoria_adq',$f['id_tipo_categoria_adq']);
				$xml->add_nodo('num_convocatoria',$f['num_convocatoria']);
                $xml->add_nodo('falta_adjudicar',$f['falta_adjudicar']);

				$xml->fin_rama();



				if($f["id_cotizacion"]!=''){
					$count++;

					$xml->add_rama('ROWS');
					$xml->add_nodo('id_histo',$count);
					$xml->add_nodo('tipo','Cotización');
					$xml->add_nodo('id_proceso_compra',$f["id_proceso_compra"]);
					$xml->add_nodo('id_cotizacion',$f["id_cotizacion"]);
					$xml->add_nodo('codigo_proceso','----');
					$xml->add_nodo('num_doc',$f["periodo"].'/'.$f["num_cotizacion"]);
					$xml->add_nodo('observaciones',$f["observaciones_cot"]);
					$xml->add_nodo('fecha_ini',$f["fecha_ini_cot"]);
					$xml->add_nodo('estado_vigente',$f["estado_vigente_cot"]);
					$xml->add_nodo('num_convocatoria','-');
					$xml->add_nodo('id_proveedor',$f['id_proveedor']);
					$xml->add_nodo('desc_proveedor',$f["desc_proveedor"]);
					if($f['compra_simplificada']==0){

						$xml->add_nodo('compra_simplificada','Regular');
					}
					else{
						$xml->add_nodo('compra_simplificada','Factura');
					}
					$xml->add_nodo('num_cotizacion_proc',$f['num_cotizacion_proc']);
					$xml->add_nodo('id_tipo_categoria_adq',$f['id_tipo_categoria_adq']);
					$xml->add_nodo('num_convocatoria','-');
					$xml->add_nodo('falta_adjudicar',$f['falta_adjudicar']);

					$xml->fin_rama();
				}
			}
			else{

				if($id_proceo_compra_anterior == $f["id_proceso_compra"]){

					//armamos una cotizacion

					$count++;

					$xml->add_rama('ROWS');
					$xml->add_nodo('id_histo',$count);
					$xml->add_nodo('tipo','Cotización');
					$xml->add_nodo('id_proceso_compra',$f["id_proceso_compra"]);
					$xml->add_nodo('id_cotizacion',$f["id_cotizacion"]);
					$xml->add_nodo('codigo_proceso','----');
					$xml->add_nodo('num_doc',$f["periodo"].'/'.$f["num_cotizacion"]);
					$xml->add_nodo('observaciones',$f["observaciones_cot"]);
					$xml->add_nodo('fecha_ini',$f["fecha_ini_cot"]);
					$xml->add_nodo('estado_vigente',$f["estado_vigente_cot"]);
					$xml->add_nodo('num_convocatoria','-');
					$xml->add_nodo('id_proveedor',$f['id_proveedor']);
					$xml->add_nodo('desc_proveedor',$f["desc_proveedor"]);
					if($f['compra_simplificada']==0){

						$xml->add_nodo('compra_simplificada','Regular');
					}
					else{
						$xml->add_nodo('compra_simplificada','Factura');
					}
					$xml->add_nodo('num_cotizacion_proc',$f['num_cotizacion_proc']);
					$xml->add_nodo('id_tipo_categoria_adq',$f['id_tipo_categoria_adq']);
					$xml->add_nodo('num_convocatoria','-');
					$xml->add_nodo('falta_adjudicar',$f['falta_adjudicar']);
					$xml->fin_rama();






				}
				else{


					$id_proceo_compra_anterior=$f["id_proceso_compra"];

					$count++;


					$xml->add_rama('ROWS');
					$xml->add_nodo('id_histo',$count);
					$xml->add_nodo('tipo','Proceso');
					$xml->add_nodo('id_proceso_compra',$f["id_proceso_compra"]);
					$xml->add_nodo('id_cotizacion',$f["id_cotizacion"]);
					$xml->add_nodo('codigo_proceso',$f["codigo_proceso"]);
					$xml->add_nodo('num_doc',$f["periodo"].'/'.$f["num_proceso"]);
					$xml->add_nodo('observaciones',$f["observaciones"]);
					$xml->add_nodo('fecha_ini',$f["fecha_ini"]);
					$xml->add_nodo('estado_vigente',$f["estado_vigente"]);
					$xml->add_nodo('num_convocatoria',$f["num_convocatoria"]);
					$xml->add_nodo('id_proveedor',$f['id_proveedor']);
					$xml->add_nodo('desc_proveedor','----');
					
					if($f['compra_simplificada']==0){

						$xml->add_nodo('compra_simplificada','Regular');
					}
					else{
						$xml->add_nodo('compra_simplificada','Simplificado');
					}
					$xml->add_nodo('num_cotizacion_proc',$f['num_cotizacion_proc']);
					$xml->add_nodo('id_tipo_categoria_adq',$f['id_tipo_categoria_adq']);
					$xml->add_nodo('num_convocatoria',$f['num_convocatoria']);
					$xml->add_nodo('falta_adjudicar',$f['falta_adjudicar']);
					$xml->fin_rama();


					if($f["id_cotizacion"]!=''){
						$count++;

						$xml->add_rama('ROWS');
						$xml->add_nodo('id_histo',$count);
						$xml->add_nodo('tipo','Cotización');
						$xml->add_nodo('id_proceso_compra',$f["id_proceso_compra"]);
						$xml->add_nodo('id_cotizacion',$f["id_cotizacion"]);
						$xml->add_nodo('codigo_proceso','----');
						$xml->add_nodo('num_doc',$f["periodo"].'/'.$f["num_cotizacion"]);
						$xml->add_nodo('observaciones',$f["observaciones_cot"]);
						$xml->add_nodo('fecha_ini',$f["fecha_ini_cot"]);
						$xml->add_nodo('estado_vigente',$f["estado_vigente_cot"]);
						$xml->add_nodo('num_convocatoria','-');
						$xml->add_nodo('id_proveedor',$f['id_proveedor']);
						$xml->add_nodo('desc_proveedor',$f["desc_proveedor"]);
						if($f['compra_simplificada']==0){

							$xml->add_nodo('compra_simplificada','Regular');
						}
						else{
							$xml->add_nodo('compra_simplificada','Factura');
						}
						$xml->add_nodo('num_cotizacion_proc',$f['num_cotizacion_proc']);
						$xml->add_nodo('id_tipo_categoria_adq',$f['id_tipo_categoria_adq']);
						$xml->add_nodo('num_convocatoria','-');
						$xml->add_nodo('falta_adjudicar',$f['falta_adjudicar']);
						$xml->fin_rama();
					}

				}

			}

		}
		$xml->add_nodo('TotalCount',$count);
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