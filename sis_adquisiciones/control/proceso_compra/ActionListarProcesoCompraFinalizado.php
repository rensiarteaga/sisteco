<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarProcesoCompra.php
Propósito:				Permite realizar el listado en tad_proceso_compra
Tabla:					t_tad_proceso_compra
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-13 18:03:04
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarProcesoCompraFin.php';

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

	if($sort == '') $sortcol = 'prodet.id_proceso_compra';
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

	$criterio_filtro = $cond -> obtener_criterio_filtro();
    if($m_id_gestion>0){
    	$criterio_filtro=$criterio_filtro ."AND PROCOM.gestion=$m_id_gestion ";
    }
   
   // $tipo_filtro='';

	if($estado!='')//para filtrar los procesos por estado_vigente
	{ 
        if($estado=='finalizado'){
	       $criterio_filtro=$criterio_filtro." AND (PROCOM.estado_vigente=''finalizado'' OR PROCOM.estado_vigente=''anulado'' or cotiza.estado_vigente in (''finalizado'',''orden_compra'',''formulacion_pp'',''en_pago''))";	
	   }else{
		    $criterio_filtro=$criterio_filtro." AND (PROCOM.estado_vigente=''$estado'')";
	   }
	   
	   //	$tipo_filtro.=$estado;
	   
	}
	
	 if($tipo=='bien'){//para separar en la vista los procesos de bienes y los de servicios
       $criterio_filtro=$criterio_filtro. " AND  PROCOM.id_tipo_adq =4 ";
    } elseif($tipo=='servicio'){
		$criterio_filtro=$criterio_filtro. " AND  PROCOM.id_tipo_adq !=4 ";  
	} 
  
	
	if($sort=='numeracion_periodo_proceso'){
		$sortcol="periodo $sortdir, num_proceso $sortdir";
	}
	if($sort=='num_sol_por_proc'){
		$sortcol="num_sol_por_proc, $sortdir";
	}
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'ProcesoCompra');
	$sortcol = $crit_sort->get_criterio_sort();
//	
	//Obtiene el total de los registros
	$res = $Custom ->ContarProcesoFinalizado($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_proceso_compra);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarProcesoFinalizado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_proceso_compra);
	

	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			 /*varchar,proveedor text,impuestos varchar,num_factura integer,fecha_factura date,cantidad_sol numeric,cant_total numeric,id_moneda int4,
			 simbolo varchar,estado_vigente varchar,id_cotizacion int4*/
			
			$xml->add_nodo('id_proceso_compra',$f["id_proceso_compra"]);
			$xml->add_nodo('codigo_proceso',$f["codigo_proceso"]);
			$xml->add_nodo('proveedor',$f["proveedor"]);
			$xml->add_nodo('total_adj',$f["total_adj"]);
			$xml->add_nodo('nro_contrato',$f["nro_contrato"]);
			$xml->add_nodo('estado_vigente',$f["estado_vigente"]);
			$xml->add_nodo('orden_compra',$f["orden_compra"]);
			$xml->add_nodo('num_sol_por_proc',$f["num_sol_por_proc"]);
			$xml->add_nodo('categoria',$f["categoria"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('moneda',$f["moneda"]);
			$xml->add_nodo('gestion',$f["gestion"]);
			$xml->add_nodo('id_cotizacion',$f["id_cotizacion"]);
			$xml->add_nodo('por_adelanto',$f["por_adelanto"]);
			$xml->add_nodo('depto',$f["depto"]);
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