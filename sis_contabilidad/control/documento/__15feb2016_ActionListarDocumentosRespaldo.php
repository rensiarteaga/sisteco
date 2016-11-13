<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDocumentoImporte.php
Propósito:				Permite realizar el listado en tct_documento
Tabla:					t_tct_documento
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-09-16 17:57:14
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarDocumentoImporte.php';

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

	if($sort == '') $sortcol = 'docval.fecha_documento';
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
	
	/*$cond->add_criterio_extra(".id_documento",$id_documento);
	$cond->add_criterio_extra("DOCVAL.id_moneda",$id_moneda);*/
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	/*	echo $criterio_filtro;
	exit;*/
//	$criterio_filtro= $criterio_filtro ." AND COMPROB.id_comprobante=$id_comprobante";
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'DocumentoValor');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el conjunto de datos de la consulta
	//$res = $Custom->ListarDocumentoImporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
      $res = $Custom->ContarRepDocumentosDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_comprobante,$m_id_moneda);
      if($res) $total_registros= $Custom->salida;
       
      $res = $Custom->ListarRepDocumentosDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_comprobante,$m_id_moneda);
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
	
		
		
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			
		$xml->add_nodo('nro_documento',$f["nro_documento"]);
		$xml->add_nodo('tipo_documento',$f["tipo_documento"]);
        $xml->add_nodo('razon_social',$f["razon_social"]);
        $xml->add_nodo('nro_nit',$f["nro_nit"]);
        $xml->add_nodo('nro_autorizacion',$f["nro_autorizacion"]);
        $xml->add_nodo('codigo_control',$f["codigo_control"]);
        $xml->add_nodo('poliza_dui',$f["poliza_dui"]);
        $xml->add_nodo('formulario',$f["formulario"]);
        $xml->add_nodo('fecha_documento',$f["fecha_documento"]);
        $xml->add_nodo('importe_total',$f["importe_total"]);
        $xml->add_nodo('importe_ice',$f["importe_ice"]);
        $xml->add_nodo('importe_no_gravado',$f["importe_no_gravado"]);
        $xml->add_nodo('importe_sujeto',$f["importe_sujeto"]);
        $xml->add_nodo('importe_credito',$f["importe_credito"]);
        $xml->add_nodo('importe_iue',$f["importe_iue"]);
        $xml->add_nodo('importe_it',$f["importe_it"]);
        $xml->add_nodo('importe_debito',$f["importe_debito"]);
        $xml->add_nodo('id_documento',$f["id_documento"]);
        $xml->add_nodo('id_transaccion',$f["id_transaccion"]);
        $xml->add_nodo('id_documento_valor',$f["id_documento_valor"]);
        $xml->add_nodo('id_moneda',$f["id_moneda"]);
        $xml->add_nodo('tipo_retencion',$f["tipo_retencion"]);
        $xml->add_nodo('estado_documento ',$f["estado_documento"]);
	
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