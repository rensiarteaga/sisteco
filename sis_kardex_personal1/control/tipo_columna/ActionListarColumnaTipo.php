<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarColumnaTipo.php
Propósito:				Permite realizar el listado en tkp_tipo_columna
Tabla:					tkp_tkp_tipo_columna
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2010-08-10 17:59:45
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloKardexPersonal.php');

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionListarColumnaTipo.php';

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

	if($sort == '') $sortcol = 'COLTIP.estado_reg,COLTIP.id_columna_tipo';
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
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'TipoColumna');
	$sortcol = $crit_sort->get_criterio_sort();
	
	if($estado!=''){
		$criterio_filtro=$criterio_filtro." AND COLTIP.estado_reg=''$estado'' ";
	}
	if($compromete!=''){//en vista tipo_columna_base de KARD
		$criterio_filtro=$criterio_filtro." AND COLTIP.compromete=''$compromete'' ";
	}
	// 30MAR11 -> filtro en vista tipo_columna de KARD
	if($m_id_gestion!=''){
		$criterio_filtro=$criterio_filtro." AND GESTIO.gestion=''$m_id_gestion'' ";
	}
	// 17MAY11 -> filtro en vista parametro_cuenta_auxiliar de KARD
	if($m_id_gestion_parametro!=''){
		$criterio_filtro=$criterio_filtro." AND GESTIO.id_gestion=''$m_id_gestion_parametro'' ";
	}
	//Obtiene el total de los registros 
    $res = $Custom -> ContarColumnaTipo($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarColumnaTipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_columna_tipo',$f["id_columna_tipo"]);
			$xml->add_nodo('id_parametro_kardex',$f["id_parametro_kardex"]);
			$xml->add_nodo('desc_parametro_kardex',$f["desc_parametro_kardex"]);
			$xml->add_nodo('id_partida',$f["id_partida"]);
			$xml->add_nodo('desc_partida',$f["desc_partida"]);
			$xml->add_nodo('nombre',$f["nombre"]);
			$xml->add_nodo('valor',$f["valor"]);
			$xml->add_nodo('tipo_dato',$f["tipo_dato"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			$xml->add_nodo('tipo_aporte',$f["tipo_aporte"]);
			$xml->add_nodo('estado_reg',$f["estado_reg"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('cotizable',$f["cotizable"]);
			$xml->add_nodo('descripcion',$f["descripcion"]);
			$xml->add_nodo('descuento_incremento',$f["descuento_incremento"]);
			$xml->add_nodo('observacion',$f["observacion"]);
			$xml->add_nodo('formula',$f["formula"]);
			
			$xml->add_nodo('id_tipo_descuento_bono',$f["id_tipo_descuento_bono"]);
			$xml->add_nodo('desc_tipo_descuento_bono',$f["desc_tipo_descuento_bono"]);
			$xml->add_nodo('codigo',$f["codigo"]);
			
			$xml->add_nodo('compromete',$f["compromete"]);
			//$xml->add_nodo('id_tipo_columna_base',$f["id_tipo_columna_base"]);
			$xml->add_nodo('id_cuenta_pasivo',$f["id_cuenta_pasivo"]);
			$xml->add_nodo('id_auxiliar_pasivo',$f["id_auxiliar_pasivo"]);
			//$xml->add_nodo('desc_tipo_columna_base',$f["desc_tipo_columna_base"]);
			$xml->add_nodo('desc_cuenta_pasivo',$f["desc_cuenta_pasivo"]);
			$xml->add_nodo('desc_auxiliar_pasivo',$f["desc_auxiliar_pasivo"]);
			$xml->add_nodo('id_gestion',$f["id_gestion"]);
			
			$xml->add_nodo('id_tipo_obligacion',$f["id_tipo_obligacion"]);
			$xml->add_nodo('desc_tipo_obligacion',$f["desc_tipo_obligacion"]);
			
			$xml->add_nodo('movimiento_contable',$f["movimiento_contable"]);
			$xml->add_nodo('prorratea',$f["prorratea"]);
			
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