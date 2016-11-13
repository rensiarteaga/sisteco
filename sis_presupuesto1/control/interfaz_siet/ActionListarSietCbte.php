<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarSietCbte.php
Propósito:				Permite realizar el listado en tsi_siet_cbte
Tabla:					tsi_siet_cbte
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		01/11/2015
Versión:				1.0.0
Autor:					A.V.Q
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarSietCbte .php';

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

	if($sort == '') $sortcol = 'sc.id_siet_cbte';
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
	
	if ($get)
	{
		$id_siet_declara= $_GET["m_id_siet_declara"];
		$tipo_declara= $_GET["m_tipo_declara"];
		$id_siet_cbte= $_GET["id_siet_cbte"];
			
	}
	else
	{
		$id_siet_declara= $_POST["m_id_siet_declara"];
		$tipo_declara= $_POST["m_tipo_declara"];
		$id_siet_cbte= $_POST["id_siet_cbte"];
			
	}
	/*echo $id_siet_declara;
	exit;*/
	if ($id_siet_declara ==''){
		$criterio_filtro=$criterio_filtro." AND sc.id_siet_cbte=$id_siet_cbte";
	}else{
		$criterio_filtro=$criterio_filtro." ";
	}

	
	/*if ($vista=='categoria'){
		$criterio_filtro=$criterio_filtro." AND CATEGO.estado ilike ''%'' ";
	}else{
	    $criterio_filtro=$criterio_filtro." AND CATEGO.estado=''activo'' ";
	}
	//Filtramos solo las categorias en estado activo
	*/	
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'SietCbte');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarSietCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_siet_declara);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarSietCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_siet_declara);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
						
			$xml->add_rama('ROWS');
		
			$xml->add_nodo('id_comprobante',$f["id_comprobante"]);
			$xml->add_nodo('nro_cbte',$f["nro_cbte"]);
			$xml->add_nodo('fecha_salida_cb',$f["fecha_salida_cb"]);
			$xml->add_nodo('concepto_cbte',$f["concepto_cbte"]);
			/*$xml->add_nodo('nombre_cuenta',$f["nombre_cuenta"]);
			$xml->add_nodo('nro_cuenta_banco',$f["nro_cuenta_banco"]);
			$xml->add_nodo('nombre_auxiliar',$f["nombre_auxiliar"]);
			$xml->add_nodo('nro_cheque',$f["nro_cheque"]);*/
			$xml->add_nodo('nombre_largo',$f["nombre_largo"]);
			$xml->add_nodo('id_siet_cbte',$f["id_siet_cbte"]);
			$xml->add_nodo('id_siet_declara',$f["id_siet_declara"]);
			$xml->add_nodo('id_subsistema',$f["id_subsistema"]);
			$xml->add_nodo('periodo_lite',$f["periodo_lite"]);	
            $xml->add_nodo('sw_ingresa_declaracion',$f["sw_ingresa_declaracion"]);	
       		$xml->add_nodo('id_extracto_bancario',$f["id_extracto_bancario"]);	
            $xml->add_nodo('id_periodo_dec',$f["id_periodo_dec"]);	
            $xml->add_nodo('tipo_declara',$f["tipo_declara"]);	
       		$xml->add_nodo('id_cuenta_bancaria',$f["id_cuenta_bancaria"]);
            $xml->add_nodo('nro_cuenta_banco',$f["nro_cuenta_banco"]);
            $xml->add_nodo('importe',$f["importe"]);
            $xml->add_nodo('sw_fa',$f["sw_fa"]);
            $xml->add_nodo('estado',$f["estado"]);
            $xml->add_nodo('id_cbte_ant_rev',$f["id_cbte_ant_rev"]);
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