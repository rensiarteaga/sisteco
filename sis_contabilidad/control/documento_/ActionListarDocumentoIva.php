<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarRubro.php
Propósito:				Permite realizar el listado en tct_rubro
Tabla:					t_tct_rubro
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-10-02 11:34:34
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarDocumentoIva .php';

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

	if($sort == '') $sortcol = 'DOC.fecha_documento';
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
    /*$cond->add_criterio_extra("MON.id_moneda",$m_id_moneda);
	$criterio_filtro = $cond -> obtener_criterio_filtro();
    $criterio_filtro=$criterio_filtro." AND COM.fecha_cbte >= ''".$m_fecha_inicio."'' AND COM.fecha_cbte <= ''".$m_fecha_fin."''";*/
/*echo $criterio_filtro;
exit;*/
$sortcol ='DOC.fecha_documento';
	if($sw_debito_credito==1){$sortcol ='DOC.fecha_documento'; }
	if($sw_debito_credito==2){$sortcol ='DOC.nro_documento'; }
	
	
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarDocumentoIva($cant,$puntero,$sortcol,$sortdir,'0=0',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_fecha_inicio,$m_fecha_fin,$m_id_moneda,$sw_debito_credito,$m_id_depto);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ActionListarDocumentoIva($cant,$puntero,$sortcol,$sortdir,'0=0',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_fecha_inicio,$m_fecha_fin,$m_id_moneda,$sw_debito_credito,$m_id_depto);
	//echo $Custom->query; exit();
	if($res)
	{ 
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('desc_comprobante',$f["desc_comprobante"]);
			$xml->add_nodo('fecha_documento',$f["fecha_documento"]);
			$xml->add_nodo('nro_nit',$f["nro_nit"]);
			$xml->add_nodo('nro_documento',$f["nro_documento"]);
			$xml->add_nodo('nro_autorizacion',$f["nro_autorizacion"]);
			$xml->add_nodo('codigo_control',$f["codigo_control"]);
			$xml->add_nodo('razon_social',$f["razon_social"]);
			$xml->add_nodo('importe_total',$f["importe_total"]);
			$xml->add_nodo('importe_ice',$f["importe_ice"]);
			$xml->add_nodo('importe_no_gravado',$f["importe_no_gravado"]);
			$xml->add_nodo('importe_sujeto',$f["importe_sujeto"]);
			$xml->add_nodo('importe_credito',$f["importe_credito"]);
			$xml->add_nodo('importe_debito',$f["importe_debito"]);
			
			
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